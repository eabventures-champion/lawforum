<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRegistrationSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('registration_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        DB::table('registration_settings')->insert([
            ['key' => 'student_registration_enabled', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'lawyer_registration_enabled', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'researcher_registration_enabled', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('registration_settings');
    }
}
