<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NavigationMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NavigationMenuController extends Controller
{
    /**
     * Display a listing of the menu items.
     */
    public function index()
    {
        $menus = NavigationMenu::whereNull('parent_id')
            ->orderBy('order')
            ->with(['children' => function($q) {
                $q->orderBy('order');
            }])
            ->get();

        return view('admin.navigation-menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        // Get only parent items that are marked as dropdowns
        $parentMenus = NavigationMenu::whereNull('parent_id')
            ->where('is_dropdown', true)
            ->get();

        return view('admin.navigation-menus.create', compact('parentMenus'));
    }

    /**
     * Store a newly created menu item in storage.
     */
    public function store(Request $request)
    {
        $isDropdown = $request->has('is_dropdown') && !$request->filled('parent_id');

        $request->validate([
            'title' => 'required|string|max:100',
            'link_type' => 'required|in:url,content',
            'url' => $isDropdown ? 'nullable|string|max:255' : 'nullable|required_if:link_type,url|string|max:255',
            'custom_content' => 'nullable|required_if:link_type,content|string',
            'order' => 'required|integer|min:0',
            'parent_id' => 'nullable|integer|exists:navigation_menus,id',
        ]);

        $slug = null;
        if ($request->input('link_type') === 'content') {
            $slug = Str::slug($request->input('title'));
            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (NavigationMenu::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        }

        NavigationMenu::create([
            'title' => $request->input('title'),
            'url' => $isDropdown ? '#' : ($request->input('link_type') === 'url' ? $request->input('url') : null),
            'slug' => $slug,
            'custom_content' => $request->input('link_type') === 'content' ? $request->input('custom_content') : null,
            'is_dropdown' => $isDropdown,
            'order' => $request->input('order'),
            'parent_id' => $request->input('parent_id') ?: null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('navigation-menus.index')
            ->with('success', 'Menu item created successfully!');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit($id)
    {
        $menu = NavigationMenu::findOrFail($id);
        
        $parentMenus = NavigationMenu::whereNull('parent_id')
            ->where('is_dropdown', true)
            ->where('id', '!=', $menu->id)
            ->get();

        return view('admin.navigation-menus.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update the specified menu item in storage.
     */
    public function update(Request $request, $id)
    {
        $menu = NavigationMenu::findOrFail($id);
        $isDropdown = $request->has('is_dropdown') && !$request->filled('parent_id');

        $request->validate([
            'title' => 'required|string|max:100',
            'link_type' => 'required|in:url,content',
            'url' => $isDropdown ? 'nullable|string|max:255' : 'nullable|required_if:link_type,url|string|max:255',
            'custom_content' => 'nullable|required_if:link_type,content|string',
            'order' => 'required|integer|min:0',
            'parent_id' => 'nullable|integer|exists:navigation_menus,id',
        ]);

        $slug = $menu->slug;
        if ($request->input('link_type') === 'content') {
            if (!$slug || $menu->title !== $request->input('title')) {
                $slug = Str::slug($request->input('title'));
                $originalSlug = $slug;
                $count = 1;
                while (NavigationMenu::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        } else {
            $slug = null;
        }

        $menu->update([
            'title' => $request->input('title'),
            'url' => $isDropdown ? '#' : ($request->input('link_type') === 'url' ? $request->input('url') : null),
            'slug' => $slug,
            'custom_content' => $request->input('link_type') === 'content' ? $request->input('custom_content') : null,
            'is_dropdown' => $isDropdown,
            'order' => $request->input('order'),
            'parent_id' => $request->input('parent_id') ?: null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('navigation-menus.index')
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu item from storage.
     */
    public function destroy($id)
    {
        $menu = NavigationMenu::findOrFail($id);
        $menu->delete();

        return redirect()->route('navigation-menus.index')
            ->with('success', 'Menu item deleted successfully!');
    }
}
