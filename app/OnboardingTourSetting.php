<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnboardingTourSetting extends Model
{
    protected $table = 'onboarding_tour_settings';

    protected $fillable = [
        'welcome_title',
        'welcome_description',
        'welcome_btn_primary',
        'welcome_btn_secondary',
        'auto_prompt_new_users',
    ];

    protected $casts = [
        'auto_prompt_new_users' => 'boolean',
    ];

    public static function getSettings()
    {
        return self::firstOrCreate([], [
            'welcome_title' => 'Welcome to Your Workspace!',
            'welcome_description' => 'Hi :name, would you like a quick 1-minute walkthrough to discover how to navigate statutes, create bookmarks, take study notes, and use split-screen reading?',
            'welcome_btn_primary' => 'Take Guided Tour',
            'welcome_btn_secondary' => 'Explore on My Own',
            'auto_prompt_new_users' => true,
        ]);
    }
}
