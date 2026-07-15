<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MaintenanceSetting;
use Illuminate\Http\Request;

class MaintenanceSettingController extends Controller
{
    /**
     * Show the maintenance settings management page.
     */
    public function index()
    {
        $settings = MaintenanceSetting::all()->keyBy('key');
        return view('admin.maintenance-settings.index', compact('settings'));
    }

    /**
     * Update maintenance settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'maintenance_passcode' => 'required|string|min:4|max:64',
            'maintenance_title' => 'required|string|max:200',
            'maintenance_subtitle' => 'required|string|max:1000',
        ]);

        // Update toggle (checkbox)
        MaintenanceSetting::where('key', 'maintenance_enabled')
            ->update(['value' => $request->input('maintenance_enabled') == '1' ? '1' : '0']);

        // Update text fields
        foreach (['maintenance_passcode', 'maintenance_title', 'maintenance_subtitle'] as $key) {
            MaintenanceSetting::where('key', $key)->update(['value' => $request->input($key)]);
        }

        // Update dialogue messages (dynamic JSON array)
        $messages = [];
        if ($request->has('dialogue_messages')) {
            foreach ($request->input('dialogue_messages') as $msg) {
                $text = trim($msg);
                if (!empty($text)) {
                    $messages[] = ['sender' => 'system', 'text' => $text];
                }
            }
        }
        MaintenanceSetting::where('key', 'maintenance_dialogue_messages')
            ->update(['value' => json_encode($messages)]);

        return redirect()->route('admin.maintenance-settings.index')
            ->with('success', 'Maintenance settings updated successfully!');
    }
}
