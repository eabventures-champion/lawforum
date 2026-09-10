<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddNewsBadgeSettingsToHomepageSettings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $settings = [
            [
                'key' => 'slide_1_news_badge',
                'value' => 'COMING SOON',
                'label' => 'Legal News Coming Soon Badge Text',
                'type' => 'text',
                'group' => 'slide_1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_1_news_btn_text',
                'value' => 'Coming Soon',
                'label' => 'Legal News Coming Soon Action Text',
                'type' => 'text',
                'group' => 'slide_1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($settings as $setting) {
            $exists = DB::table('homepage_settings')->where('key', $setting['key'])->exists();
            if (!$exists) {
                DB::table('homepage_settings')->insert($setting);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::table('homepage_settings')
            ->whereIn('key', ['slide_1_news_badge', 'slide_1_news_btn_text'])
            ->delete();
    }
}
