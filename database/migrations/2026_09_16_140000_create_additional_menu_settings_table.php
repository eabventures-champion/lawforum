<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAdditionalMenuSettingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('additional_menu_settings')) {
            Schema::create('additional_menu_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('key')->unique();
                $table->string('value');
                $table->timestamps();
            });

            $now = now();
            DB::table('additional_menu_settings')->insert([
                ['key' => 'chatroom_enabled', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'marketplace_enabled', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'jobs_enabled', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'chatroom_general_enabled', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'chatroom_student_enabled', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'chatroom_lawyer_enabled', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'chatroom_researcher_enabled', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('additional_menu_settings');
    }
}
