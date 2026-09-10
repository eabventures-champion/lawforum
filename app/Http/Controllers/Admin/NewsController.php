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

        $categories = NewsCategory::all()->map(function($cat) {
            $cat->articles_count = NewsContent::where('news_category', $cat->name)->count();
            return $cat;
        });

        return view('admin.news.index', compact('news', 'categories'));
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

    /**
     * Toggle a News Category navigation tab (enable/disable).
     */
    public function toggleCategoryStatus(Request $request, $id)
    {
        $category = NewsCategory::findOrFail($id);
        $newStatus = $request->has('status') 
            ? (bool)$request->input('status') 
            : !$category->is_enabled;

        $category->is_enabled = $newStatus;
        $category->save();

        $cleanName = str_replace('-', ' ', $category->name);
        $message = $newStatus 
            ? "Category '{$cleanName}' is now ENABLED and visible in the newsroom tabs."
            : "Category '{$cleanName}' is now DISABLED and hidden from the newsroom tabs.";

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'category_id' => $category->id,
                'is_enabled' => $category->is_enabled,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Update or reset the countdown timer target date for the Coming Soon page.
     */
    public function updateCountdownTarget(Request $request)
    {
        $targetDate = null;

        if ($request->filled('preset_days')) {
            $days = (int) $request->input('preset_days');
            if ($days > 0) {
                $targetDate = now()->addDays($days)->format('Y-m-d\TH:i');
            }
        } elseif ($request->input('action') === 'reset_default') {
            $targetDate = now()->addDays(28)->addHours(14)->format('Y-m-d\TH:i');
        } elseif ($request->filled('countdown_target')) {
            $request->validate([
                'countdown_target' => 'required|date|after:now',
            ]);
            $targetDate = \Carbon\Carbon::parse($request->input('countdown_target'))->format('Y-m-d\TH:i');
        } else {
            return back()->with('error', 'Please choose a preset or pick a valid date/time in the future.');
        }

        $setting = \App\HomepageSetting::firstOrCreate(
            ['key' => 'slide_1_news_countdown_target'],
            [
                'label' => 'Coming Soon Countdown Target Date',
                'type' => 'string',
                'group' => 'slide_1',
                'value' => '',
            ]
        );

        $setting->update(['value' => $targetDate]);

        $formatted = \Carbon\Carbon::parse($targetDate)->format('M j, Y g:i A');
        $message = "Countdown timer successfully updated! Target date is now {$formatted}.";

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'countdown_target' => $targetDate,
                'formatted' => $formatted,
            ]);
        }

        return back()->with('success', $message);
    }
}
