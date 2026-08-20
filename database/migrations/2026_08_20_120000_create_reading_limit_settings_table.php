<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReadingLimitSettingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('reading_limit_settings')) {
            Schema::create('reading_limit_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        $defaults = [
            ['key' => 'reading_limit_enabled', 'value' => '1'],
            ['key' => 'default_scroll_percentage', 'value' => '10'],
            ['key' => 'constitution_scroll_percentage', 'value' => '50'],
            ['key' => 'case_law_scroll_percentage', 'value' => '20'],
            ['key' => 'free_preview_sections_count', 'value' => '3'],
        ];

        foreach ($defaults as $item) {
            DB::table('reading_limit_settings')->updateOrInsert(
                ['key' => $item['key']],
                ['value' => $item['value'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down()
    {
        Schema::dropIfExists('reading_limit_settings');
    }
}