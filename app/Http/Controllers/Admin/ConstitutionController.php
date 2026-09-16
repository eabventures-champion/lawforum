<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\GhanaAct;
use App\GhanaArticle;
use App\GhAmendedAct;
use App\GhAmendedArticle;
use App\AllConstitution;
use Illuminate\Http\Request;

class ConstitutionController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'ghana');
        $continent = $request->query('continent', 'all');
        $search = trim($request->query('search', ''));

        // 1. Ghana 1992 Act
        $ghanaAct = GhanaAct::first();
        if (!$ghanaAct) {
            $ghanaAct = GhanaAct::create([
                'title' => 'THE CONSTITUTION OF THE REPUBLIC OF GHANA 1992',
                'preamble' => '',
                'gh_group' => 'Constitution-main',
            ]);
        }
        $ghanaArticlesCount = GhanaArticle::count();
        $ghanaChaptersCount = GhanaArticle::distinct('chapter')->count('chapter');

        // 2. Ghana Amended Act
        $amendedAct = GhAmendedAct::first();
        if (!$amendedAct) {
            $amendedAct = GhAmendedAct::create([
                'title' => '1992 CONSTITUTION (AMENDMENTS) OF THE REPUBLIC OF GHANA',
                'preamble' => '',
                'gh_group' => 'Constitution-amended',
            ]);
        }
        $amendedArticlesCount = GhAmendedArticle::count();

        // 3. Foreign / All Countries Constitutions
        $query = AllConstitution::query();
        if ($continent !== 'all' && !empty($continent)) {
            $query->where('continent', $continent);
        }
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('country', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%")
                  ->orWhere('continent', 'like', "%{$search}%");
            });
        }
        $foreignConstitutions = $query->orderBy('continent')->orderBy('country')->paginate(15);

        // Distinct continents list
        $continents = AllConstitution::select('continent')
            ->distinct()
            ->whereNotNull('continent')
            ->orderBy('continent')
            ->pluck('continent');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.constitutions._foreign_rows', ['constitutions' => $foreignConstitutions])->render(),
                'pagination' => view('admin.constitutions._foreign_pagination', ['constitutions' => $foreignConstitutions, 'continent' => $continent])->render(),
            ]);
        }

        return view('admin.constitutions.index', compact(
            'tab',
            'ghanaAct',
            'ghanaArticlesCount',
            'ghanaChaptersCount',
            'amendedAct',
            'amendedArticlesCount',
            'foreignConstitutions',
            'continents',
            'continent'
        ));
    }

    // Update Ghana or Amended Act details (Title & Preamble)
    public function updateAct(Request $request, $target)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'preamble' => 'nullable|string',
        ]);

        if ($target === 'amended') {
            $act = GhAmendedAct::firstOrFail();
            $act->update([
                'title' => $request->title,
                'preamble' => $request->preamble,
            ]);
            return redirect()->route('admin.constitutions.index', ['tab' => 'amended'])
                ->with('success', 'Amended Constitution details updated successfully.');
        } else {
            $act = GhanaAct::firstOrFail();
            $act->update([
                'title' => $request->title,
                'preamble' => $request->preamble,
            ]);
            return redirect()->route('admin.constitutions.index', ['tab' => 'ghana'])
                ->with('success', 'Ghana Constitution details updated successfully.');
        }
    }

    // Manage Articles for Ghana 1992 or Amended Constitution
    public function articles(Request $request, $target = 'ghana')
    {
        $isAmended = ($target === 'amended');
        $act = $isAmended ? GhAmendedAct::firstOrFail() : GhanaAct::firstOrFail();
        $articleModel = $isAmended ? new GhAmendedArticle() : new GhanaArticle();

        $search = trim($request->input('search', ''));
        $chapterFilter = trim($request->input('chapter', ''));

        $query = $articleModel->query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('section', 'like', "%{$search}%")
                  ->orWhere('chapter', 'like', "%{$search}%")
                  ->orWhere('articles', 'like', "%{$search}%");
            });
        }

        if (!empty($chapterFilter)) {
            $query->where('chapter', $chapterFilter);
        }

        $allArticles = $query->orderBy('priority')->get();

        // Group articles by chapter
        $groupedChapters = [];
        $distinctChapters = [];
        foreach ($allArticles as $art) {
            $chap = trim($art->chapter ?? '');
            if ($chap === '') $chap = 'Unassigned Chapter';
            if (!isset($groupedChapters[$chap])) {
                $groupedChapters[$chap] = [];
            }
            $groupedChapters[$chap][] = $art;
        }

        // Distinct list of chapters from all records
        $distinctChapters = $articleModel->select('chapter')
            ->distinct()
            ->whereNotNull('chapter')
            ->where('chapter', '!=', '')
            ->orderBy('chapter')
            ->pluck('chapter');

        return view('admin.constitutions.articles', compact(
            'act',
            'target',
            'isAmended',
            'groupedChapters',
            'distinctChapters',
            'allArticles',
            'search',
            'chapterFilter'
        ));
    }

    // Store a new Article
    public function storeArticle(Request $request, $target = 'ghana')
    {
        $request->validate([
            'chapter' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'articles' => 'required|string',
            'priority' => 'nullable|integer',
        ]);

        $isAmended = ($target === 'amended');
        $act = $isAmended ? GhAmendedAct::firstOrFail() : GhanaAct::firstOrFail();
        $model = $isAmended ? new GhAmendedArticle() : new GhanaArticle();

        $model->create([
            'chapter' => trim($request->chapter),
            'section' => trim($request->section),
            'articles' => $request->articles,
            'priority' => $request->priority ?: 0,
            'gh_title' => $act->title,
        ]);

        return redirect()->route('admin.constitutions.articles', ['target' => $target])
            ->with('success', 'Article added successfully.');
    }

    // Update an Article
    public function updateArticle(Request $request, $target, $articleId)
    {
        $request->validate([
            'chapter' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'articles' => 'required|string',
            'priority' => 'nullable|integer',
        ]);

        $isAmended = ($target === 'amended');
        $article = $isAmended ? GhAmendedArticle::findOrFail($articleId) : GhanaArticle::findOrFail($articleId);

        $article->update([
            'chapter' => trim($request->chapter),
            'section' => trim($request->section),
            'articles' => $request->articles,
            'priority' => $request->priority ?: 0,
        ]);

        return redirect()->route('admin.constitutions.articles', ['target' => $target])
            ->with('success', 'Article updated successfully.');
    }

    // Delete an Article
    public function destroyArticle($target, $articleId)
    {
        $isAmended = ($target === 'amended');
        $article = $isAmended ? GhAmendedArticle::findOrFail($articleId) : GhanaArticle::findOrFail($articleId);
        $article->delete();

        return redirect()->route('admin.constitutions.articles', ['target' => $target])
            ->with('success', 'Article deleted successfully.');
    }

    // Foreign Constitutions CRUD
    public function createForeign()
    {
        $continents = ['Africa', 'Asia', 'Europe', 'North-America', 'South-America'];
        return view('admin.constitutions.foreign_create', compact('continents'));
    }

    public function storeForeign(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:100',
            'continent' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'year' => 'nullable|string|max:10',
            'preamble' => 'nullable|string',
            'content' => 'required|string',
        ]);

        AllConstitution::create([
            'country' => trim($request->country),
            'continent' => trim($request->continent),
            'title' => trim($request->title),
            'year' => trim($request->year ?? ''),
            'preamble' => $request->preamble ?? '',
            'content' => $request->content,
        ]);

        return redirect()->route('admin.constitutions.index', ['tab' => 'foreign'])
            ->with('success', 'Country Constitution added successfully.');
    }

    public function editForeign($id)
    {
        $constitution = AllConstitution::findOrFail($id);
        $continents = ['Africa', 'Asia', 'Europe', 'North-America', 'South-America'];
        return view('admin.constitutions.foreign_edit', compact('constitution', 'continents'));
    }

    public function updateForeign(Request $request, $id)
    {
        $constitution = AllConstitution::findOrFail($id);

        $request->validate([
            'country' => 'required|string|max:100',
            'continent' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'year' => 'nullable|string|max:10',
            'preamble' => 'nullable|string',
            'content' => 'required|string',
        ]);

        $constitution->update([
            'country' => trim($request->country),
            'continent' => trim($request->continent),
            'title' => trim($request->title),
            'year' => trim($request->year ?? ''),
            'preamble' => $request->preamble ?? '',
            'content' => $request->content,
        ]);

        return redirect()->route('admin.constitutions.index', ['tab' => 'foreign'])
            ->with('success', 'Country Constitution updated successfully.');
    }

    public function destroyForeign($id)
    {
        $constitution = AllConstitution::findOrFail($id);
        $constitution->delete();

        return redirect()->route('admin.constitutions.index', ['tab' => 'foreign'])
            ->with('success', 'Country Constitution deleted successfully.');
    }

    // JSON Preview for Foreign Constitution
    public function previewForeign($id)
    {
        $c = AllConstitution::findOrFail($id);
        $readerUrl = url('/constitution/continent/' . rawurlencode($c->continent) . '/' . rawurlencode($c->country) . '/' . $c->id);

        return response()->json([
            'id' => $c->id,
            'title' => $c->title,
            'country' => $c->country,
            'continent' => $c->continent,
            'year' => $c->year,
            'preamble' => $c->preamble,
            'reader_url' => $readerUrl,
            'content_length' => strlen(strip_tags($c->content ?? '')),
            'edit_url' => route('admin.constitutions.foreign.edit', $c->id),
        ]);
    }
}
