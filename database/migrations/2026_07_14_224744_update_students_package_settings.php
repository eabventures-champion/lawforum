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
        // Delete old bullets keys
        DB::table('homepage_settings')
            ->whereIn('key', [
                'slide_2_bullet1',
                'slide_2_bullet2',
                'slide_2_bullet3',
                'slide_2_bullet4',
            ])
            ->delete();

        // Update slide_2_desc value
        DB::table('homepage_settings')
            ->where('key', 'slide_2_desc')
            ->update([
                'value' => "Whether you're preparing for exams, writing a thesis, or building practical research skills — Legals Forum gives you the same tools used by practising lawyers, at your fingertips.",
            ]);

        // Insert new bullet titles and descriptions
        DB::table('homepage_settings')->insert([
            [
                'key' => 'slide_2_bullet1_title',
                'value' => 'Exam & Thesis Preparation',
                'label' => 'Bullet 1 Title',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet1_desc',
                'value' => 'Quickly find statutes, case citations, and constitutional provisions to strengthen your academic work.',
                'label' => 'Bullet 1 Description',
                'type' => 'textarea',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet2_title',
                'value' => 'Affordable Access',
                'label' => 'Bullet 2 Title',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet2_desc',
                'value' => 'Student-friendly subscription plans so cost never stands between you and quality legal research.',
                'label' => 'Bullet 2 Description',
                'type' => 'textarea',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet3_title',
                'value' => 'Research Anywhere, Anytime',
                'label' => 'Bullet 3 Title',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet3_desc',
                'value' => 'Access from your phone, tablet, or laptop — in the library, at home, or on campus. No heavy textbooks needed.',
                'label' => 'Bullet 3 Description',
                'type' => 'textarea',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet4_title',
                'value' => 'Career-Ready Skills',
                'label' => 'Bullet 4 Title',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet4_desc',
                'value' => 'Build the digital legal research skills that top law firms and chambers expect from modern graduates.',
                'label' => 'Bullet 4 Description',
                'type' => 'textarea',
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
        // Re-insert old bullet keys
        DB::table('homepage_settings')->insert([
            [
                'key' => 'slide_2_bullet1',
                'value' => 'Discounted premium subscription rates',
                'label' => 'Bullet 1',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet2',
                'value' => 'Access to case briefs, summaries, and exam prep resources',
                'label' => 'Bullet 2',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet3',
                'value' => 'Create personal folders, highlights, and annotations',
                'label' => 'Bullet 3',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_2_bullet4',
                'value' => 'Collaborate and share research with peers',
                'label' => 'Bullet 4',
                'type' => 'text',
                'group' => 'slide_2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Delete new keys
        DB::table('homepage_settings')
            ->whereIn('key', [
                'slide_2_bullet1_title',
                'slide_2_bullet1_desc',
                'slide_2_bullet2_title',
                'slide_2_bullet2_desc',
                'slide_2_bullet3_title',
                'slide_2_bullet3_desc',
                'slide_2_bullet4_title',
                'slide_2_bullet4_desc',
            ])
            ->delete();
    }
};
