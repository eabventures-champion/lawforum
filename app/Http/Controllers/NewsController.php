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

        $newsCategories        = NewsCategory::all();
        $newscategory          = NewsCategory::find(['id' => $id])->toArray()[0];

        //for the 3 diplayed below the carousel
        $latestNewsContents    = NewsContent::where(['news_category' => $category])->orderBy('created_at', 'asc')->paginate(3);
        $carouselSelectors     = NewsContent::where(['news_category' => $category])->orderBy('created_at', 'desc')->paginate(5);
        $newsSelectors         = NewsContent::where(['news_category' => $category])->orderBy('created_at', 'desc')->paginate(7);
        return view('news.ghana_news_homepage', compact('newsCategories','latestNewsContents','newsSelectors','newscategory','carouselSelectors'));
    }

    //Display of News_Content
    public function news_content($category, $title, $id){
        if (homepage_setting('slide_1_news_coming_soon', '1') == '1') {
            return view('news.coming_soon');
        }

        $newsCategories         = NewsCategory::all();
        $newsContents           = NewsContent::where(['news_category' => $category])->orderBy('created_at', 'desc')->paginate(6);
        $newsContent            = NewsContent::find(
            [
                'id' => $id,
                'title' => $title,
                'news_category' => $category
            ])->toArray()[0];

        return view('news.news_content', compact('newsContent','newsContents','newsCategories'));
    }

    // Ajax Pagination
    public function news_ajax_display(Request $request, $category){
        if (homepage_setting('slide_1_news_coming_soon', '1') == '1') {
            return response()->json(['error' => 'Coming soon'], 403);
        }

        if($request->ajax()){
            $newsSelectors     = NewsContent::where(['news_category' => $category])->orderBy('created_at', 'desc')->paginate(7);          
            return view('news.displayed_all_ghana_news', compact('newsSelectors'))->render();
        }
    }
    
}
