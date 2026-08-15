<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PlatformUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlatformUpdateController extends Controller
{
    public function index()
    {
        $updates = PlatformUpdate::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.platform_updates.index', compact('updates'));
    }

    public function create()
    {
        return view('admin.platform_updates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_role' => 'required|string|in:all,researcher,lawyer,student',
            'summary' => 'required|string',
        ]);

        $data = $request->except(['_token', 'tour_steps_raw']);
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['is_active'] = $request->has('is_active');
        $data['badge_text'] = $request->badge_text ?: ($request->target_role === 'all' ? 'General Update' : 'Bespoke - ' . ucfirst($request->target_role));

        // Parse tour steps JSON or form inputs if provided
        if ($request->filled('tour_steps_raw')) {
            $parsed = json_decode($request->tour_steps_raw, true);
            $data['tour_steps'] = is_array($parsed) ? $parsed : null;
        }

        PlatformUpdate::create($data);

        return redirect()->route('admin.platform-updates.index')
            ->with('success', 'Feature Update created and published successfully.');
    }

    public function edit($id)
    {
        $update = PlatformUpdate::findOrFail($id);
        return view('admin.platform_updates.edit', compact('update'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_role' => 'required|string|in:all,researcher,lawyer,student',
            'summary' => 'required|string',
        ]);

        $update = PlatformUpdate::findOrFail($id);
        $data = $request->except(['_token', '_method', 'tour_steps_raw']);
        $data['is_active'] = $request->has('is_active');
        $data['badge_text'] = $request->badge_text ?: ($request->target_role === 'all' ? 'General Update' : 'Bespoke - ' . ucfirst($request->target_role));

        if ($request->filled('tour_steps_raw')) {
            $parsed = json_decode($request->tour_steps_raw, true);
            $data['tour_steps'] = is_array($parsed) ? $parsed : null;
        }

        $update->update($data);

        return redirect()->route('admin.platform-updates.index')
            ->with('success', 'Feature Update updated successfully.');
    }

    public function toggleStatus($id)
    {
        $update = PlatformUpdate::findOrFail($id);
        $update->is_active = !$update->is_active;
        $update->save();

        return response()->json([
            'success' => true,
            'is_active' => $update->is_active,
            'message' => 'Status updated to ' . ($update->is_active ? 'Active' : 'Inactive'),
        ]);
    }

    public function destroy($id)
    {
        $update = PlatformUpdate::findOrFail($id);
        $update->delete();

        return redirect()->route('admin.platform-updates.index')
            ->with('success', 'Feature Update deleted successfully.');
    }
}
