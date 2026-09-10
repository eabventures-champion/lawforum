<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsCategory;
use App\NewsContent;

class NewsController extends Controller
{
    public function news_index($category, $id){
        if (homepage_setting('slide_1_news_coming_soon', '1') == '1') {
            return view('news.coming_soon');
        }

        $newscategoryModel = NewsCategory::find($id) ?? NewsCategory::where('name', $category)->first() ?? NewsCategory::first();

        // If category is disabled by admin, redirect to first active category
        if ($newscategoryModel && !$newscategoryModel->is_enabled) {
            $firstEnabled = NewsCategory::where('is_enabled', true)->first();
            if ($firstEnabled) {
                return redirect('/News/' . $firstEnabled->name . '/' . $firstEnabled->id);
            }
        }

        $newsCategories = NewsCategory::where('is_enabled', true)->get()->map(function($cat) {
            $cat->articles_count = NewsContent::where('news_category', $cat->name)->count();
            return $cat;
        });

        $newscategory = $newscategoryModel ? $newscategoryModel->toArray() : ['id' => $id, 'name' => $category];

        // Search support - if a search query is provided, search globally across all news categories
        $search = request('search');
        if ($search) {
            $query = NewsContent::where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('extract', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('news_category', 'like', "%{$search}%");
            });
        } else {
            $query = NewsContent::where('news_category', $category);
        }

        // Breaking ticker items (latest headlines for dynamic rotating ticker)
        $breakingNews = NewsContent::orderBy('created_at', 'desc')->take(10)->get();

        // Featured lead stories for top showcase
        $featuredNews = NewsContent::where('news_category', $category)->orderBy('created_at', 'desc')->take(4)->get();
        $leadStory = $featuredNews->first();
        $topHighlights = $featuredNews->slice(1, 3);

        // Trending stories for sidebar widget
        $trendingNews = NewsContent::orderBy('created_at', 'desc')->take(5)->get();

        // Paginated articles feed
        $newsSelectors = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();

        // Keep legacy variables for backwards compatibility
        $carouselSelectors = $featuredNews;
        $latestNewsContents = $trendingNews;

        return view('news.ghana_news_homepage', compact(
            'newsCategories',
            'newscategory',
            'newsSelectors',
            'breakingNews',
            'leadStory',
            'topHighlights',
            'trendingNews',
            'search',
            'carouselSelectors',
            'latestNewsContents'
        ));
    }

    // Display of News_Content
    public function news_content($category, $title, $id){
        if (homepage_setting('slide_1_news_coming_soon', '1') == '1') {
            return view('news.coming_soon');
        }

        $newsCategories = NewsCategory::where('is_enabled', true)->get()->map(function($cat) {
            $cat->articles_count = NewsContent::where('news_category', $cat->name)->count();
            return $cat;
        });

        $newsContentModel = NewsContent::find($id);
        if (!$newsContentModel) {
            $newsContentModel = NewsContent::where('title', $title)->where('news_category', $category)->first();
        }

        if (!$newsContentModel) {
            abort(404, 'News article not found.');
        }

        $newsContent = $newsContentModel->toArray();

        // Related stories in same category
        $relatedNews = NewsContent::where('news_category', $category)
            ->where('id', '!=', $newsContentModel->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Trending stories for sidebar
        $trendingNews = NewsContent::orderBy('created_at', 'desc')->take(5)->get();
        $newsContents = $trendingNews;

        // Breaking ticker
        $breakingNews = NewsContent::orderBy('created_at', 'desc')->take(10)->get();

        return view('news.news_content', compact(
            'newsContent',
            'newsContentModel',
            'newsCategories',
            'relatedNews',
            'trendingNews',
            'newsContents',
            'breakingNews'
        ));
    }

    // Ajax Pagination
    public function news_ajax_display(Request $request, $category){
        if (homepage_setting('slide_1_news_coming_soon', '1') == '1') {
            return response()->json(['error' => 'Coming soon'], 403);
        }

        if($request->ajax()){
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query = NewsContent::where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('extract', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('news_category', 'like', "%{$search}%");
                });
            } else {
                $query = NewsContent::where('news_category', $category);
            }
            $newsSelectors = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();
            return view('news.displayed_all_ghana_news', compact('newsSelectors', 'category'))->render();
        }
    }

    /**
     * Store early access / launch day invitation email.
     */
    public function storeLaunchInvitation(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address (e.g. name@domain.com).',
                'errors' => $validator->errors(),
            ], 422);
        }

        $email = strtolower(trim($request->email));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[^@\s]+@[^@\s]+\.[a-zA-Z0-9]{2,}$/', $email)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address with a valid domain (e.g. name@domain.com).',
            ], 422);
        }

        $invitation = \App\LaunchInvitation::firstOrCreate(
            [
                'email' => $email,
                'source' => 'launch',
            ],
            [
                'ip_address' => $request->ip(),
                'user_agent' => substr((string)$request->userAgent(), 0, 500),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Thank you! We have reserved your priority invitation for launch.',
            'email' => $invitation->email,
        ]);
    }

    /**
     * Store newsletter subscriber for Legal Intelligence Digest.
     */
    public function subscribeDigest(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address (e.g. name@domain.com).',
                'errors' => $validator->errors(),
            ], 422);
        }

        $email = strtolower(trim($request->email));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[^@\s]+@[^@\s]+\.[a-zA-Z0-9]{2,}$/', $email)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address with a valid domain (e.g. name@domain.com).',
            ], 422);
        }

        $subscription = \App\LaunchInvitation::firstOrCreate(
            [
                'email' => $email,
                'source' => 'digest',
            ],
            [
                'ip_address' => $request->ip(),
                'user_agent' => substr((string)$request->userAgent(), 0, 500),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing to Legals Forum Legal Intelligence Digest!',
            'email' => $subscription->email,
        ]);
    }
}
