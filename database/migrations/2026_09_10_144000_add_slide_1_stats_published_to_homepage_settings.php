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
        // Check if setting already exists
        $exists = DB::table('homepage_settings')->where('key', 'slide_1_stats_published')->exists();
        if (!$exists) {
            DB::table('homepage_settings')->insert([
                'key' => 'slide_1_stats_published',
                'value' => '1',
                'label' => 'Publish Statistics Counter Bar',
                'type' => 'boolean',
                'group' => 'slide_1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('homepage_settings')
            ->where('key', 'slide_1_stats_published')
            ->delete();
    }
};
