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

        // Dynamic Choose Plan Page Settings
        $choose_plan_header_title = DemoSetting::get('choose_plan_header_title', 'Welcome to Legals Forum!');
        $choose_plan_header_subtitle = DemoSetting::get('choose_plan_header_subtitle', 'Choose how you\'d like to get started');
        $choose_plan_demo_title = DemoSetting::get('choose_plan_demo_title', 'Start Free Demo');
        $choose_plan_demo_subtitle = DemoSetting::get('choose_plan_demo_subtitle', 'Full access for {days} days');
        $choose_plan_demo_icon = DemoSetting::get('choose_plan_demo_icon', 'fa-solid fa-rocket');
        $choose_plan_demo_features = DemoSetting::get('choose_plan_demo_features', "Access all sections & content\nDownload legal books\nSearch case laws\n{extension_days}-day extension available");
        $choose_plan_demo_button_text = DemoSetting::get('choose_plan_demo_button_text', 'Continue with Demo');

        $choose_plan_subscribe_title = DemoSetting::get('choose_plan_subscribe_title', 'Subscribe Now');
        $choose_plan_subscribe_subtitle = DemoSetting::get('choose_plan_subscribe_subtitle', 'Unlimited premium access');
        $choose_plan_subscribe_icon = DemoSetting::get('choose_plan_subscribe_icon', 'fa-solid fa-crown');
        $choose_plan_subscribe_features = DemoSetting::get('choose_plan_subscribe_features', "Everything in Demo\nNo time restrictions\nPriority support\nEarly access to new features");
        $choose_plan_subscribe_button_text = DemoSetting::get('choose_plan_subscribe_button_text', 'Coming Soon');
        $choose_plan_subscribe_button_tooltip = DemoSetting::get('choose_plan_subscribe_button_tooltip', 'Subscription plans will be available shortly');
        $choose_plan_subscribe_button_action = DemoSetting::get('choose_plan_subscribe_button_action', 'coming_soon');
        $choose_plan_subscribe_button_url = DemoSetting::get('choose_plan_subscribe_button_url', '/subscription');

        return view('admin.demo_settings.index', compact(
            'demo_duration_days',
            'demo_extension_days',
            'choose_plan_header_title',
            'choose_plan_header_subtitle',
            'choose_plan_demo_title',
            'choose_plan_demo_subtitle',
            'choose_plan_demo_icon',
            'choose_plan_demo_features',
            'choose_plan_demo_button_text',
            'choose_plan_subscribe_title',
            'choose_plan_subscribe_subtitle',
            'choose_plan_subscribe_icon',
            'choose_plan_subscribe_features',
            'choose_plan_subscribe_button_text',
            'choose_plan_subscribe_button_tooltip',
            'choose_plan_subscribe_button_action',
            'choose_plan_subscribe_button_url'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'demo_duration_days' => 'required|numeric|min:1',
            'demo_extension_days' => 'required|numeric|min:1',
            'choose_plan_header_title' => 'required|string|max:255',
            'choose_plan_header_subtitle' => 'nullable|string|max:500',
            'choose_plan_demo_title' => 'required|string|max:255',
            'choose_plan_demo_subtitle' => 'nullable|string|max:500',
            'choose_plan_demo_icon' => 'nullable|string|max:100',
            'choose_plan_demo_features' => 'nullable|string',
            'choose_plan_demo_button_text' => 'required|string|max:255',
            'choose_plan_subscribe_title' => 'required|string|max:255',
            'choose_plan_subscribe_subtitle' => 'nullable|string|max:500',
            'choose_plan_subscribe_icon' => 'nullable|string|max:100',
            'choose_plan_subscribe_features' => 'nullable|string',
            'choose_plan_subscribe_button_text' => 'required|string|max:255',
            'choose_plan_subscribe_button_tooltip' => 'nullable|string|max:500',
            'choose_plan_subscribe_button_action' => 'required|string|in:coming_soon,link',
            'choose_plan_subscribe_button_url' => 'nullable|string|max:500',
        ]);

        DemoSetting::set('demo_duration_days', $request->input('demo_duration_days'));
        DemoSetting::set('demo_extension_days', $request->input('demo_extension_days'));

        DemoSetting::set('choose_plan_header_title', $request->input('choose_plan_header_title'));
        DemoSetting::set('choose_plan_header_subtitle', $request->input('choose_plan_header_subtitle'));
        DemoSetting::set('choose_plan_demo_title', $request->input('choose_plan_demo_title'));
        DemoSetting::set('choose_plan_demo_subtitle', $request->input('choose_plan_demo_subtitle'));
        DemoSetting::set('choose_plan_demo_icon', $request->input('choose_plan_demo_icon', 'fa-solid fa-rocket'));
        DemoSetting::set('choose_plan_demo_features', $request->input('choose_plan_demo_features'));
        DemoSetting::set('choose_plan_demo_button_text', $request->input('choose_plan_demo_button_text'));

        DemoSetting::set('choose_plan_subscribe_title', $request->input('choose_plan_subscribe_title'));
        DemoSetting::set('choose_plan_subscribe_subtitle', $request->input('choose_plan_subscribe_subtitle'));
        DemoSetting::set('choose_plan_subscribe_icon', $request->input('choose_plan_subscribe_icon', 'fa-solid fa-crown'));
        DemoSetting::set('choose_plan_subscribe_features', $request->input('choose_plan_subscribe_features'));
        DemoSetting::set('choose_plan_subscribe_button_text', $request->input('choose_plan_subscribe_button_text'));
        DemoSetting::set('choose_plan_subscribe_button_tooltip', $request->input('choose_plan_subscribe_button_tooltip'));
        DemoSetting::set('choose_plan_subscribe_button_action', $request->input('choose_plan_subscribe_button_action', 'coming_soon'));
        DemoSetting::set('choose_plan_subscribe_button_url', $request->input('choose_plan_subscribe_button_url', '/subscription'));

        return redirect()->route('admin.demo-settings.index')
            ->with('success', 'Demo and Choose Plan settings updated successfully.');
    }
}
