<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\HomepageCustomSlide;
use Illuminate\Http\Request;

class HomepageCustomSlideController extends Controller
{
    /**
     * Display a listing of custom slides.
     */
    public function index()
    {
        $customSlides = HomepageCustomSlide::orderBy('order', 'asc')->get();
        return view('admin.homepage-custom-slides.index', compact('customSlides'));
    }

    /**
     * Show form to create a custom slide.
     */
    public function create()
    {
        return view('admin.homepage-custom-slides.create');
    }

    /**
     * Store a newly created custom slide in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'btn_text' => 'nullable|string|max:255',
            'btn_link' => 'nullable|string|max:255',
            'icon' => 'required|string|max:255',
            'order' => 'required|integer',
            'is_published' => 'nullable|boolean',
            'is_coming_soon' => 'nullable|boolean',
        ]);

        HomepageCustomSlide::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_link,
            'icon' => $request->icon,
            'order' => $request->order,
            'is_published' => $request->has('is_published'),
            'is_coming_soon' => $request->has('is_coming_soon'),
        ]);

        return redirect()->route('admin.homepage-custom-slides.index')->with('success', 'Custom slide created successfully.');
    }

    /**
     * Show form to edit a custom slide.
     */
    public function edit($id)
    {
        $slide = HomepageCustomSlide::findOrFail($id);
        return view('admin.homepage-custom-slides.edit', compact('slide'));
    }

    /**
     * Update the specified custom slide in storage.
     */
    public function update(Request $request, $id)
    {
        $slide = HomepageCustomSlide::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'btn_text' => 'nullable|string|max:255',
            'btn_link' => 'nullable|string|max:255',
            'icon' => 'required|string|max:255',
            'order' => 'required|integer',
            'is_published' => 'nullable|boolean',
            'is_coming_soon' => 'nullable|boolean',
        ]);

        $slide->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_link,
            'icon' => $request->icon,
            'order' => $request->order,
            'is_published' => $request->has('is_published'),
            'is_coming_soon' => $request->has('is_coming_soon'),
        ]);

        return redirect()->route('admin.homepage-custom-slides.index')->with('success', 'Custom slide updated successfully.');
    }

    /**
     * Remove the specified custom slide from storage.
     */
    public function destroy($id)
    {
        $slide = HomepageCustomSlide::findOrFail($id);
        $slide->delete();

        return redirect()->route('admin.homepage-custom-slides.index')->with('success', 'Custom slide deleted successfully.');
    }
}
