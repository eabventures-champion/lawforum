<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NewsContent;
use App\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsContent::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('extract', 'like', "%{$search}%")
                  ->orWhere('news_category', 'like', "%{$search}%");
            });
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.news.table_data', compact('news'))->render(),
                'total' => $news->total(),
            ]);
        }

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'extract' => 'required|string',
            'news_category' => 'required|string',
            'image' => 'required|image|max:2048', // max 2MB
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        NewsContent::create([
            'title' => $request->title,
            'content' => $request->content,
            'extract' => $request->extract,
            'news_category' => $request->news_category,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'News article created successfully.');
    }

    public function edit($id)
    {
        $newsArticle = NewsContent::findOrFail($id);
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('newsArticle', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $newsArticle = NewsContent::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'extract' => 'required|string',
            'news_category' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'extract' => $request->extract,
            'news_category' => $request->news_category,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($newsArticle->image) {
                Storage::disk('public')->delete($newsArticle->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $newsArticle->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News article updated successfully.');
    }

    public function destroy($id)
    {
        $newsArticle = NewsContent::findOrFail($id);

        if ($newsArticle->image) {
            Storage::disk('public')->delete($newsArticle->image);
        }

        $newsArticle->delete();

        return redirect()->route('admin.news.index')->with('success', 'News article deleted successfully.');
    }

    /**
     * Delete all news articles
     */
    public function destroyAll()
    {
        $articles = NewsContent::all();
        foreach ($articles as $article) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $article->delete();
        }

        return redirect()->route('admin.news.index')->with('success', 'All news articles have been deleted successfully.');
    }

    /**
     * Bulk delete selected news articles
     */
    public function bulkDestroy(Request $request)
    {
        $idsJson = $request->input('ids');
        $ids = json_decode($idsJson, true);

        if (!is_array($ids) || empty($ids)) {
            return redirect()->route('admin.news.index')->with('error', 'No news articles selected for deletion.');
        }

        $articles = NewsContent::whereIn('id', $ids)->get();
        foreach ($articles as $article) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $article->delete();
        }

        return redirect()->route('admin.news.index')->with('success', 'Selected news articles (' . count($articles) . ') deleted successfully.');
    }

    /**
     * Toggle Legal News Coming Soon mode on or off.
     */
    public function toggleComingSoon(Request $request)
    {
        $setting = \App\HomepageSetting::firstOrCreate(
            ['key' => 'slide_1_news_coming_soon'],
            [
                'label' => 'Legal News Coming Soon Mode',
                'type' => 'boolean',
                'group' => 'slide_1',
                'value' => '1',
            ]
        );

        $current = $setting->value == '1';
        $newValue = $request->has('status') ? ($request->input('status') == '1' ? '1' : '0') : ($current ? '0' : '1');
        $setting->update(['value' => $newValue]);

        $message = $newValue === '1'
            ? 'Legal News is now in Coming Soon mode (homepage card disabled, public access blocked).'
            : 'Legal News is now LIVE (homepage card active, public access enabled).';

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'is_coming_soon' => $newValue === '1',
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
