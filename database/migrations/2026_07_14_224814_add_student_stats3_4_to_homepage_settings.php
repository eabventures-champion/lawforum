<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update stat 1 and stat 2
        DB::table('homepage_settings')
            ->where('key', 'slide_2_tstat1_num')
            ->update(['value' => '15K+']);
        DB::table('homepage_settings')
            ->where('key', 'slide_2_tstat1_label')
            ->update(['value' => 'Student Users']);

        DB::table('homepage_settings')
            ->where('key', 'slide_2_tstat2_num')
            ->update(['value' => '12']);
        DB::table('homepage_settings')
            ->where('key', 'slide_2_tstat2_label')
            ->update(['value' => 'Universities']);

        // Insert stat 3 and stat 4
        DB::table('homepage_settings')->insert([
            [
                'key' => 'slide_2_tstat3_num',
                'value' => '24/7',
                'label' => 'Testimonial Stat 3 Value',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_tstat3_label',
                'value' => 'Always Available',
                'label' => 'Testimonial Stat 3 Label',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_tstat4_num',
                'value' => 'Free',
                'label' => 'Testimonial Stat 4 Value',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_tstat4_label',
                'value' => 'To Get Started',
                'label' => 'Testimonial Stat 4 Label',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('homepage_settings')
            ->whereIn('key', [
                'slide_2_tstat3_num',
                'slide_2_tstat3_label',
                'slide_2_tstat4_num',
                'slide_2_tstat4_label',
            ])
            ->delete();
    }
};
