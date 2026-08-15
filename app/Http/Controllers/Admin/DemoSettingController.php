<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DemoSetting;
use Illuminate\Http\Request;

class DemoSettingController extends Controller
{
    public function index()
    {
        $demo_duration_days = DemoSetting::get('demo_duration_days', 60);
        $demo_extension_days = DemoSetting::get('demo_extension_days', 15);
        return view('admin.demo_settings.index', compact('demo_duration_days', 'demo_extension_days'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'demo_duration_days' => 'required|numeric|min:1',
            'demo_extension_days' => 'required|numeric|min:1',
        ]);

        DemoSetting::set('demo_duration_days', $request->input('demo_duration_days'));
        DemoSetting::set('demo_extension_days', $request->input('demo_extension_days'));

        return redirect()->route('admin.demo-settings.index')
            ->with('success', 'Demo settings updated successfully.');
    }
}
