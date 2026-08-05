<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates a "Decree" sub-dropdown under "Existing Laws" and re-parents
     * NLC Decree, NRC Decree, SMC Decree, and AFRC Decree under it.
     */
    public function up(): void
    {
        $now = now();

        // Find the "Existing Laws" parent menu (ID 2)
        $existingLawsId = DB::table('navigation_menus')
            ->where('title', 'Existing Laws')
            ->whereNull('parent_id')
            ->value('id');

        if (!$existingLawsId) {
            return; // Safety check
        }

        // Create the "Decree" sub-dropdown as a child of "Existing Laws"
        $decreeId = DB::table('navigation_menus')->insertGetId([
            'title' => 'Decree',
            'url' => '#',
            'order' => 4,
            'is_active' => true,
            'is_dropdown' => true,
            'parent_id' => $existingLawsId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Re-parent the decree items under the new "Decree" sub-dropdown
        // and update their order to be sequential within the sub-group
        DB::table('navigation_menus')
            ->where('parent_id', $existingLawsId)
            ->where('title', 'NLC Decree')
            ->update(['parent_id' => $decreeId, 'order' => 1, 'updated_at' => $now]);

        DB::table('navigation_menus')
            ->where('parent_id', $existingLawsId)
            ->where('title', 'NRC Decree')
            ->update(['parent_id' => $decreeId, 'order' => 2, 'updated_at' => $now]);

        DB::table('navigation_menus')
            ->where('parent_id', $existingLawsId)
            ->where('title', 'SMC Decree')
            ->update(['parent_id' => $decreeId, 'order' => 3, 'updated_at' => $now]);

        DB::table('navigation_menus')
            ->where('parent_id', $existingLawsId)
            ->where('title', 'AFRC Decree')
            ->update(['parent_id' => $decreeId, 'order' => 4, 'updated_at' => $now]);

        // Update PNDC Law order to 5 (after Decree at 4)
        DB::table('navigation_menus')
            ->where('parent_id', $existingLawsId)
            ->where('title', 'PNDC Law')
            ->update(['order' => 5, 'updated_at' => $now]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $now = now();

        $existingLawsId = DB::table('navigation_menus')
            ->where('title', 'Existing Laws')
            ->whereNull('parent_id')
            ->value('id');

        if (!$existingLawsId) {
            return;
        }

        $decreeId = DB::table('navigation_menus')
            ->where('title', 'Decree')
            ->where('parent_id', $existingLawsId)
            ->where('is_dropdown', true)
            ->value('id');

        if ($decreeId) {
            // Move decree children back under Existing Laws
            DB::table('navigation_menus')
                ->where('parent_id', $decreeId)
                ->update(['parent_id' => $existingLawsId, 'updated_at' => $now]);

            // Restore original ordering
            DB::table('navigation_menus')
                ->where('parent_id', $existingLawsId)
                ->where('title', 'NLC Decree')
                ->update(['order' => 4, 'updated_at' => $now]);

            DB::table('navigation_menus')
                ->where('parent_id', $existingLawsId)
                ->where('title', 'NRC Decree')
                ->update(['order' => 5, 'updated_at' => $now]);

            DB::table('navigation_menus')
                ->where('parent_id', $existingLawsId)
                ->where('title', 'SMC Decree')
                ->update(['order' => 6, 'updated_at' => $now]);

            DB::table('navigation_menus')
                ->where('parent_id', $existingLawsId)
                ->where('title', 'AFRC Decree')
                ->update(['order' => 7, 'updated_at' => $now]);

            DB::table('navigation_menus')
                ->where('parent_id', $existingLawsId)
                ->where('title', 'PNDC Law')
                ->update(['order' => 8, 'updated_at' => $now]);

            // Delete the Decree sub-dropdown
            DB::table('navigation_menus')->where('id', $decreeId)->delete();
        }
    }
};
