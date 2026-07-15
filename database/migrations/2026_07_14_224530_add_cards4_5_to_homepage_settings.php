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
        DB::table('homepage_settings')->insert([
            [
                'key' => 'slide_1_card4_title',
                'value' => 'Case Laws',
                'label' => 'Card 4 Title (Case Laws)',
                'type' => 'text',
                'group' => 'slide_1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_1_card4_desc',
                'value' => 'Access decided cases in Ghana including Supreme Court, High Court, and Court of Appeal rulings and judgments.',
                'label' => 'Card 4 Description (Case Laws)',
                'type' => 'textarea',
                'group' => 'slide_1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_1_card5_title',
                'value' => 'Legal News',
                'label' => 'Card 5 Title (Legal News)',
                'type' => 'text',
                'group' => 'slide_1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slide_1_card5_desc',
                'value' => 'Stay updated with relevant legal and business news content from Ghana, Africa, Asia, Europe, and America.',
                'label' => 'Card 5 Description (Legal News)',
                'type' => 'textarea',
                'group' => 'slide_1',
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
                'slide_1_card4_title',
                'slide_1_card4_desc',
                'slide_1_card5_title',
                'slide_1_card5_desc',
            ])
            ->delete();
    }
};
