<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function choosePlan()
    {
        $user = auth()->user();
        
        // If user already has an active subscription, redirect to dashboard
        if ($user->hasActiveSubscription()) {
            return redirect('/home');
        }

        // If user already has an active demo running, redirect to home if verified, else email verify
        if ($user->is_demo_mode && $user->demo_started_at) {
            return redirect($user->hasVerifiedEmail() ? '/home' : '/email/verify');
        }

        // If user already used demo, redirect to subscription
        if ($user->demo_used) {
            return redirect('/subscription')->with('info', 'You have already used your free demo period.');
        }

        $demoDurationDays = (int) \App\DemoSetting::get('demo_duration_days', 60);
        $demoExtensionDays = (int) \App\DemoSetting::get('demo_extension_days', 15);

        // Dynamic texts
        $headerTitle = \App\DemoSetting::get('choose_plan_header_title', 'Welcome to Legals Forum!');
        $headerSubtitle = \App\DemoSetting::get('choose_plan_header_subtitle', 'Choose how you\'d like to get started');

        // Demo card
        $demoTitle = \App\DemoSetting::get('choose_plan_demo_title', 'Start Free Demo');
        $rawDemoSubtitle = \App\DemoSetting::get('choose_plan_demo_subtitle', 'Full access for {days} days');
        $demoSubtitle = str_replace(
            ['{days}', '{extension_days}'],
            [$demoDurationDays, $demoExtensionDays],
            $rawDemoSubtitle
        );
        $demoIcon = \App\DemoSetting::get('choose_plan_demo_icon', 'fa-solid fa-rocket');
        $rawDemoFeatures = \App\DemoSetting::get('choose_plan_demo_features', "Access all sections & content\nDownload legal books\nSearch case laws\n{extension_days}-day extension available");
        $demoFeaturesText = str_replace(
            ['{days}', '{extension_days}'],
            [$demoDurationDays, $demoExtensionDays],
            $rawDemoFeatures
        );
        $demoFeatures = array_values(array_filter(array_map('trim', explode("\n", $demoFeaturesText))));
        $demoButtonText = \App\DemoSetting::get('choose_plan_demo_button_text', 'Continue with Demo');

        // Subscribe card
        $subscribeTitle = \App\DemoSetting::get('choose_plan_subscribe_title', 'Subscribe Now');
        $rawSubscribeSubtitle = \App\DemoSetting::get('choose_plan_subscribe_subtitle', 'Unlimited premium access');
        $subscribeSubtitle = str_replace(
            ['{days}', '{extension_days}'],
            [$demoDurationDays, $demoExtensionDays],
            $rawSubscribeSubtitle
        );
        $subscribeIcon = \App\DemoSetting::get('choose_plan_subscribe_icon', 'fa-solid fa-crown');
        $rawSubscribeFeatures = \App\DemoSetting::get('choose_plan_subscribe_features', "Everything in Demo\nNo time restrictions\nPriority support\nEarly access to new features");
        $subscribeFeaturesText = str_replace(
            ['{days}', '{extension_days}'],
            [$demoDurationDays, $demoExtensionDays],
            $rawSubscribeFeatures
        );
        $subscribeFeatures = array_values(array_filter(array_map('trim', explode("\n", $subscribeFeaturesText))));
        $subscribeButtonText = \App\DemoSetting::get('choose_plan_subscribe_button_text', 'Coming Soon');
        $subscribeButtonTooltip = \App\DemoSetting::get('choose_plan_subscribe_button_tooltip', 'Subscription plans will be available shortly');
        $subscribeButtonAction = \App\DemoSetting::get('choose_plan_subscribe_button_action', 'coming_soon');
        $subscribeButtonUrl = \App\DemoSetting::get('choose_plan_subscribe_button_url', '/subscription');

        return view('auth.choose-plan', compact(
            'user',
            'headerTitle',
            'headerSubtitle',
            'demoTitle',
            'demoSubtitle',
            'demoIcon',
            'demoFeatures',
            'demoButtonText',
            'subscribeTitle',
            'subscribeSubtitle',
            'subscribeIcon',
            'subscribeFeatures',
            'subscribeButtonText',
            'subscribeButtonTooltip',
            'subscribeButtonAction',
            'subscribeButtonUrl',
            'demoDurationDays',
            'demoExtensionDays'
        ));
    }

    public function activateDemo(Request $request)
    {
        $user = auth()->user();
        
        // Check if user has already used demo
        if ($user->demo_used) {
            return redirect('/subscription')->with('error', 'You have already used your free demo period.');
        }
        
        $user->startDemo();
        
        $demoDurationDays = (int) \App\DemoSetting::get('demo_duration_days', 60);

        session()->flash('demo_activated', true);

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('success', "Free Demo activated! You now have full access to all platform features for {$demoDurationDays} days.");
        }

        return redirect('/email/verify');
    }
}
