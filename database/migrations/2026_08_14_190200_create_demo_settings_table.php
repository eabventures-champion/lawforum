<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDemoSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('demo_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        DB::table('demo_settings')->insert([
            ['key' => 'demo_duration_days', 'value' => '60', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'demo_extension_days', 'value' => '15', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('demo_settings');
    }
}
