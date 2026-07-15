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
        Schema::create('sidebar_ads', function (Blueprint $table) {
            $table->id();
            $table->string('slot_name')->unique();
            $table->string('title');
            $table->string('image_path')->nullable();
            $table->string('target_url')->nullable();
            $table->string('button_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default advertisements
        $now = now();
        DB::table('sidebar_ads')->insert([
            [
                'slot_name' => 'slot_1',
                'title' => 'Upper Small Ad',
                'image_path' => 'home_background/2.jpg',
                'target_url' => null,
                'button_text' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slot_name' => 'slot_2',
                'title' => 'Lower Manual Ad',
                'image_path' => 'home_background/sms.jpg',
                'target_url' => 'tel:0503539237',
                'button_text' => "You are specially invited \n Call Us on +233 24 965 5179",
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidebar_ads');
    }
};
