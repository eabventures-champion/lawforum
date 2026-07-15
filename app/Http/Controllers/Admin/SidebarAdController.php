<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SidebarAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SidebarAdController extends Controller
{
    /**
     * Display a listing of the sidebar ads.
     */
    public function index()
    {
        $ads = SidebarAd::orderBy('id')->get();
        return view('admin.sidebar-ads.index', compact('ads'));
    }

    /**
     * Show the form for editing the specified sidebar ad.
     */
    public function edit($id)
    {
        $ad = SidebarAd::findOrFail($id);
        return view('admin.sidebar-ads.edit', compact('ad'));
    }

    /**
     * Update the specified sidebar ad in storage.
     */
    public function update(Request $request, $id)
    {
        $ad = SidebarAd::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'target_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
        ]);

        $data = [
            'title' => $request->input('title'),
            'target_url' => $request->input('target_url'),
            'button_text' => $request->input('button_text'),
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if it is in uploads directory
            if ($ad->image_path && strpos($ad->image_path, 'uploads/') === 0) {
                $oldPath = public_path($ad->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '', $file->getClientOriginalName());
            
            // Ensure uploads directory exists
            $uploadPath = public_path('uploads');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            $data['image_path'] = 'uploads/' . $filename;
        }

        $ad->update($data);

        return redirect()->route('admin.sidebar-ads.index')
            ->with('success', 'Sidebar ad updated successfully!');
    }
}
