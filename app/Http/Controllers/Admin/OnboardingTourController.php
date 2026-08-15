<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OnboardingTourStep;
use App\OnboardingTourSetting;
use Illuminate\Http\Request;

class OnboardingTourController extends Controller
{
    public function index()
    {
        $settings = OnboardingTourSetting::getSettings();
        $steps = OnboardingTourStep::orderBy('step_number', 'asc')->get();
        return view('admin.onboarding_tour.index', compact('settings', 'steps'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'welcome_title' => 'required|string|max:255',
            'welcome_description' => 'required|string',
            'welcome_btn_primary' => 'required|string|max:100',
            'welcome_btn_secondary' => 'required|string|max:100',
        ]);

        $settings = OnboardingTourSetting::getSettings();
        $settings->update([
            'welcome_title' => $request->welcome_title,
            'welcome_description' => $request->welcome_description,
            'welcome_btn_primary' => $request->welcome_btn_primary,
            'welcome_btn_secondary' => $request->welcome_btn_secondary,
            'auto_prompt_new_users' => $request->has('auto_prompt_new_users'),
        ]);

        return redirect()->route('admin.onboarding-tour.index')
            ->with('success', 'Welcome prompt settings updated successfully.');
    }

    public function updateStep(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
            'step_number' => 'required|integer',
        ]);

        $step = OnboardingTourStep::findOrFail($id);
        $step->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'step_number' => $request->step_number,
            'badge_label' => $request->badge_label,
            'highlight_title' => $request->highlight_title,
            'highlight_text' => $request->highlight_text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.onboarding-tour.index')
            ->with('success', "Step #{$step->step_number} updated successfully.");
    }

    public function storeStep(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
        ]);

        $count = OnboardingTourStep::count();

        OnboardingTourStep::create([
            'step_number' => $request->step_number ?: ($count + 1),
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'badge_label' => $request->badge_label,
            'highlight_title' => $request->highlight_title,
            'highlight_text' => $request->highlight_text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.onboarding-tour.index')
            ->with('success', 'New tour step added successfully.');
    }

    public function destroyStep($id)
    {
        $step = OnboardingTourStep::findOrFail($id);
        $num = $step->step_number;
        $step->delete();

        return redirect()->route('admin.onboarding-tour.index')
            ->with('success', "Tour step #{$num} removed.");
    }

    public function resetDefaults()
    {
        OnboardingTourStep::truncate();

        $defaultSteps = [
            [
                'step_number' => 1,
                'badge_label' => 'Step 1 of 6',
                'title' => 'Welcome & Dashboard',
                'description' => 'Your central hub for legal research. Access the top quick search, switch between Dark & Light themes, and manage your account with ease.',
                'icon' => 'fa-gauge-high',
                'highlight_title' => 'Quick Search & Theme',
                'highlight_text' => 'Use the top navigation bar anytime to quickly search legal statutes or toggle day/night reading themes.',
                'is_active' => true,
            ],
            [
                'step_number' => 2,
                'badge_label' => 'Step 2 of 6',
                'title' => 'Explore Legal Library',
                'description' => 'Browse the 1992 Constitution, modern Acts of Parliament, historic pre-1992 decrees, and high court judgments with complete index filters.',
                'icon' => 'fa-landmark',
                'highlight_title' => 'Four Core Categories',
                'highlight_text' => 'Instantly toggle between Constitution, Acts, Decrees, and Law Reports from the main portal navigation.',
                'is_active' => true,
            ],
            [
                'step_number' => 3,
                'badge_label' => 'Step 3 of 6',
                'title' => 'Smart Reading & Split-Screen',
                'description' => 'Read legal sections in expanded view, play crisp AI audio recitations, or compare statutes side-by-side using horizontal and vertical split views.',
                'icon' => 'fa-book-open-reader',
                'highlight_title' => 'Expanded & Split-Screen Modes',
                'highlight_text' => 'Click the View Mode selector in any statute to split your screen and read two legal articles simultaneously.',
                'is_active' => true,
            ],
            [
                'step_number' => 4,
                'badge_label' => 'Step 4 of 6',
                'title' => 'Save & Organize Bookmarks',
                'description' => 'Bookmark any section with a single tap. Group your bookmarks by category, search by title, and preview full texts inside your dashboard without losing your place.',
                'icon' => 'fa-bookmark',
                'highlight_title' => 'One-Click Quick Preview',
                'highlight_text' => 'In My Bookmarks, click "View Section" on any saved card to pop open an instant reading modal.',
                'is_active' => true,
            ],
            [
                'step_number' => 5,
                'badge_label' => 'Step 5 of 6',
                'title' => 'Highlight Text & Study Notes',
                'description' => 'Highlight statutory text with 5 distinct colors (Yellow, Blue, Green, Pink, Purple). Write study commentary, edit in real time, and export all notes to PDF & Word.',
                'icon' => 'fa-pen-to-square',
                'highlight_title' => '5-Color Annotations & Export',
                'highlight_text' => 'Select any text inside the reader to highlight and save directly to My Notes with bulk PDF export.',
                'is_active' => true,
            ],
            [
                'step_number' => 6,
                'badge_label' => 'Step 6 of 6',
                'title' => 'Subscription & Updates',
                'description' => 'Stay ahead with the new Notifications Bell for platform alerts and feature tours. Check the Subscription menu in the sidebar for upcoming premium upgrades.',
                'icon' => 'fa-circle-check',
                'highlight_title' => 'You Are All Set!',
                'highlight_text' => 'You can restart this tour anytime from your user menu in the sidebar footer or top navbar.',
                'is_active' => true,
            ]
        ];

        foreach ($defaultSteps as $step) {
            OnboardingTourStep::create($step);
        }

        return redirect()->route('admin.onboarding-tour.index')
            ->with('success', 'Onboarding tour steps reset to defaults.');
    }
}
