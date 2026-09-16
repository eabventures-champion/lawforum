<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\GhLawJudgment;
use App\GhLawJudgmentGroup;
use App\GhLawJudgmentCategory;
use Illuminate\Http\Request;

class CaseLawController extends Controller
{
    public function index(Request $request)
    {
        $court = $request->query('court', 'all');
        $category = $request->query('category', 'all');
        $search = trim($request->query('search', ''));

        $query = GhLawJudgment::query();

        if ($court !== 'all' && !empty($court)) {
            $query->where('gh_law_judgment_group_name', $court);
        }

        if ($category !== 'all' && !empty($category)) {
            $query->where('gh_law_judgment_category_name', $category);
        }

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('case_title', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%")
                  ->orWhere('court_name', 'like', "%{$search}%")
                  ->orWhere('coram', 'like', "%{$search}%")
                  ->orWhere('gh_law_judgment_category_name', 'like', "%{$search}%")
                  ->orWhere('gh_law_judgment_group_name', 'like', "%{$search}%");
            });
        }

        $cases = $query->orderBy('year', 'desc')->orderBy('id', 'desc')->paginate(15);

        // Available court groups and categories
        $courtGroups = [
            'Supreme-Court' => 'Supreme Court',
            'Court-of-Appeal' => 'Court of Appeal',
            'High-Court' => 'High Court',
            'Circuit-Court' => 'Circuit Court',
        ];

        $categories = GhLawJudgmentCategory::orderBy('name')->pluck('name');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.case_laws._table_rows', ['cases' => $cases])->render(),
                'pagination' => view('admin.case_laws._pagination', ['cases' => $cases, 'court' => $court, 'category' => $category])->render(),
            ]);
        }

        return view('admin.case_laws.index', compact(
            'cases',
            'court',
            'category',
            'courtGroups',
            'categories',
            'search'
        ));
    }

    public function create()
    {
        $courtGroups = [
            'Supreme-Court' => 'Supreme Court',
            'Court-of-Appeal' => 'Court of Appeal',
            'High-Court' => 'High Court',
            'Circuit-Court' => 'Circuit Court',
        ];
        $categories = GhLawJudgmentCategory::orderBy('name')->pluck('name');

        return view('admin.case_laws.create', compact('courtGroups', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'case_title' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:100',
            'court_group' => 'required|string|max:100',
            'category_name' => 'nullable|string|max:100',
            'year' => 'nullable|string|max:10',
            'date' => 'nullable|string|max:50',
            'coram' => 'nullable|string|max:255',
            'counsellors' => 'nullable|string|max:255',
            'judgement_type' => 'nullable|string|max:100',
            'content' => 'required|string',
        ]);

        $courtDisplayName = str_replace('-', ' ', $request->court_group);

        GhLawJudgment::create([
            'case_title' => trim($request->case_title),
            'reference_number' => trim($request->reference_number ?? ''),
            'gh_law_judgment_group_name' => trim($request->court_group),
            'court_name' => $courtDisplayName,
            'gh_law_judgment_category_name' => trim($request->category_name ?? ''),
            'year' => trim($request->year ?? ''),
            'date' => trim($request->date ?? ''),
            'coram' => trim($request->coram ?? ''),
            'counsellors' => trim($request->counsellors ?? ''),
            'judgement_type' => trim($request->judgement_type ?? 'Judgment'),
            'content' => $request->content,
        ]);

        return redirect()->route('admin.case-laws.index', ['court' => $request->court_group])
            ->with('success', 'Case Law recorded successfully.');
    }

    public function edit($id)
    {
        $case = GhLawJudgment::findOrFail($id);
        $courtGroups = [
            'Supreme-Court' => 'Supreme Court',
            'Court-of-Appeal' => 'Court of Appeal',
            'High-Court' => 'High Court',
            'Circuit-Court' => 'Circuit Court',
        ];
        $categories = GhLawJudgmentCategory::orderBy('name')->pluck('name');

        return view('admin.case_laws.edit', compact('case', 'courtGroups', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $case = GhLawJudgment::findOrFail($id);

        $request->validate([
            'case_title' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:100',
            'court_group' => 'required|string|max:100',
            'category_name' => 'nullable|string|max:100',
            'year' => 'nullable|string|max:10',
            'date' => 'nullable|string|max:50',
            'coram' => 'nullable|string|max:255',
            'counsellors' => 'nullable|string|max:255',
            'judgement_type' => 'nullable|string|max:100',
            'content' => 'required|string',
        ]);

        $courtDisplayName = str_replace('-', ' ', $request->court_group);

        $case->update([
            'case_title' => trim($request->case_title),
            'reference_number' => trim($request->reference_number ?? ''),
            'gh_law_judgment_group_name' => trim($request->court_group),
            'court_name' => $courtDisplayName,
            'gh_law_judgment_category_name' => trim($request->category_name ?? ''),
            'year' => trim($request->year ?? ''),
            'date' => trim($request->date ?? ''),
            'coram' => trim($request->coram ?? ''),
            'counsellors' => trim($request->counsellors ?? ''),
            'judgement_type' => trim($request->judgement_type ?? 'Judgment'),
            'content' => $request->content,
        ]);

        return redirect()->route('admin.case-laws.index', ['court' => $request->court_group])
            ->with('success', 'Case Law updated successfully.');
    }

    public function destroy($id)
    {
        $case = GhLawJudgment::findOrFail($id);
        $court = $case->gh_law_judgment_group_name;
        $case->delete();

        return redirect()->route('admin.case-laws.index', ['court' => $court ?: 'all'])
            ->with('success', 'Case Law deleted successfully.');
    }

    // JSON Preview for Case Law modal
    public function preview($id)
    {
        $case = GhLawJudgment::findOrFail($id);
        $readerUrl = url('/judgement/plain/simple-preview/' . $case->id);

        return response()->json([
            'id' => $case->id,
            'title' => $case->case_title,
            'suit_number' => $case->reference_number,
            'court' => $case->gh_law_judgment_group_name,
            'category' => $case->gh_law_judgment_category_name,
            'year' => $case->year,
            'date' => $case->date,
            'coram' => $case->coram,
            'counsellors' => $case->counsellors,
            'judgement_type' => $case->judgement_type,
            'reader_url' => $readerUrl,
            'edit_url' => route('admin.case-laws.edit', $case->id),
            'snippet' => \Illuminate\Support\Str::limit(strip_tags($case->content ?? ''), 600, '...'),
        ]);
    }
}
