<?php

namespace App\Http\Controllers;

use App\NavigationMenu;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a custom dynamic page.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $menu = NavigationMenu::where('slug', $slug)
            ->where('is_active', true)
            ->whereNotNull('custom_content')
            ->firstOrFail();

        return view('page.show', compact('menu'));
    }
}
