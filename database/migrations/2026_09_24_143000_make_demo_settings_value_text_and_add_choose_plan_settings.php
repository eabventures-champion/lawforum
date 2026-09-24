<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakeDemoSettingsValueTextAndAddChoosePlanSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demo_settings', function (Blueprint $table) {
            $table->text('value')->nullable()->change();
        });

        $defaultSettings = [
            'choose_plan_header_title' => 'Welcome to Legals Forum!',
            'choose_plan_header_subtitle' => 'Choose how you\'d like to get started',
            'choose_plan_demo_title' => 'Start Free Demo',
            'choose_plan_demo_subtitle' => 'Full access for {days} days',
            'choose_plan_demo_icon' => 'fa-solid fa-rocket',
            'choose_plan_demo_features' => "Access all sections & content\nDownload legal books\nSearch case laws\n{extension_days}-day extension available",
            'choose_plan_demo_button_text' => 'Continue with Demo',
            'choose_plan_subscribe_title' => 'Subscribe Now',
            'choose_plan_subscribe_subtitle' => 'Unlimited premium access',
            'choose_plan_subscribe_icon' => 'fa-solid fa-crown',
            'choose_plan_subscribe_features' => "Everything in Demo\nNo time restrictions\nPriority support\nEarly access to new features",
            'choose_plan_subscribe_button_text' => 'Coming Soon',
            'choose_plan_subscribe_button_tooltip' => 'Subscription plans will be available shortly',
            'choose_plan_subscribe_button_action' => 'coming_soon', // coming_soon or link
            'choose_plan_subscribe_button_url' => '/subscription',
        ];

        foreach ($defaultSettings as $key => $val) {
            if (!DB::table('demo_settings')->where('key', $key)->exists()) {
                DB::table('demo_settings')->insert([
                    'key' => $key,
                    'value' => $val,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert value column type if needed
        Schema::table('demo_settings', function (Blueprint $table) {
            $table->string('value', 255)->nullable()->change();
        });
    }
}
