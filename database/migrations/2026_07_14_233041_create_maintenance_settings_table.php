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
        Schema::create('maintenance_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label');
            $table->string('type')->default('text'); // text, textarea, boolean, json
            $table->timestamps();
        });

        // Seed default maintenance settings
        $now = now();
        DB::table('maintenance_settings')->insert([
            [
                'key' => 'maintenance_enabled',
                'value' => '0',
                'label' => 'Enable Maintenance Mode',
                'type' => 'boolean',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'maintenance_passcode',
                'value' => 'lawsforum2026',
                'label' => 'Bypass Passcode',
                'type' => 'text',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'maintenance_title',
                'value' => "We're Upgrading Your Experience",
                'label' => 'Maintenance Page Title',
                'type' => 'text',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'maintenance_subtitle',
                'value' => 'Our team is working behind the scenes to bring you a better, faster, and more powerful legal platform. We\'ll be back shortly.',
                'label' => 'Maintenance Page Subtitle',
                'type' => 'textarea',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'maintenance_dialogue_messages',
                'value' => json_encode([
                    ['sender' => 'system', 'text' => 'Hey there! 👋 Welcome to Legals Forum.'],
                    ['sender' => 'system', 'text' => 'We\'re currently performing some important upgrades to our platform.'],
                    ['sender' => 'system', 'text' => 'This includes improvements to our legal database search, user interface, and performance.'],
                    ['sender' => 'system', 'text' => 'Don\'t worry — we\'ll be back online very soon! ⚡'],
                    ['sender' => 'system', 'text' => 'If you have authorized access, enter your passcode below to continue.'],
                ]),
                'label' => 'Interactive Dialogue Messages',
                'type' => 'json',
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
        Schema::dropIfExists('maintenance_settings');
    }
};
