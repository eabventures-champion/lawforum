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
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

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
}
