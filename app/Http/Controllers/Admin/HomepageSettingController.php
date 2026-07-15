<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\HomepageSetting;
use Illuminate\Http\Request;

class HomepageSettingController extends Controller
{
    /**
     * Display the settings form.
     */
    public function index()
    {
        $settings = HomepageSetting::orderBy('id', 'asc')->get()->groupBy('group');

        return view('admin.homepage-settings.index', compact('settings'));
    }

    /**
     * Bulk update settings.
     */
    public function update(Request $request)
    {
        $allSettings = HomepageSetting::all();
        $submittedSettings = $request->input('settings', []);

        foreach ($allSettings as $setting) {
            if ($setting->type === 'boolean') {
                // If a boolean/checkbox is unchecked, it won't be sent in the request, so we default to 0
                $value = isset($submittedSettings[$setting->key]) ? '1' : '0';
            } else {
                $value = $submittedSettings[$setting->key] ?? '';
            }

            $setting->update([
                'value' => $value,
            ]);
        }

        return redirect()->route('admin.homepage-settings.index')->with('success', 'Homepage settings updated successfully.');
    }
}
