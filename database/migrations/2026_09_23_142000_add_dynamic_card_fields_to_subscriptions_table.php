<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddDynamicCardFieldsToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'currency')) {
                $table->string('currency', 10)->default('GHS')->after('price');
            }
            if (!Schema::hasColumn('subscriptions', 'duration_text')) {
                $table->string('duration_text', 100)->nullable()->after('duration');
            }
            if (!Schema::hasColumn('subscriptions', 'highlight_text')) {
                $table->string('highlight_text', 191)->nullable()->after('no_downloads');
            }
            if (!Schema::hasColumn('subscriptions', 'button_text')) {
                $table->string('button_text', 100)->default('Subscribe Now')->after('badge');
            }
            if (!Schema::hasColumn('subscriptions', 'features')) {
                $table->text('features')->nullable()->after('specific_notes');
            }
        });

        // Initialize existing subscriptions with their current card contents
        $plans = DB::table('subscriptions')->get();
        foreach ($plans as $plan) {
            $durationDays = (int) $plan->duration;
            $durationText = 'per ' . $durationDays . ' days';
            if ($durationDays >= 365) {
                $durationText = 'per year';
            } elseif ($durationDays >= 180) {
                $durationText = 'for 6 months';
            } elseif ($durationDays >= 90) {
                $durationText = 'for 3 months';
            } elseif ($durationDays >= 30) {
                $durationText = 'per month';
            }

            $highlightText = ((int)$plan->no_downloads >= 10000)
                ? 'Unlimited document downloads'
                : 'Up to ' . number_format($plan->no_downloads) . ' document downloads';

            $features = [];
            if (!empty($plan->general_notes)) {
                $features[] = $plan->general_notes;
            }
            if (!empty($plan->specific_notes)) {
                $features[] = $plan->specific_notes;
            }
            $features[] = 'High-Speed Official PDF Document Downloads';
            $features[] = 'Search Filter & Section Bookmarking';
            $features[] = 'Personal Document Notes & Annotations';

            DB::table('subscriptions')->where('id', $plan->id)->update([
                'currency' => 'GHS',
                'duration_text' => $durationText,
                'highlight_text' => $highlightText,
                'button_text' => 'Subscribe Now',
                'features' => json_encode($features),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('subscriptions', 'currency')) {
                $columnsToDrop[] = 'currency';
            }
            if (Schema::hasColumn('subscriptions', 'duration_text')) {
                $columnsToDrop[] = 'duration_text';
            }
            if (Schema::hasColumn('subscriptions', 'highlight_text')) {
                $columnsToDrop[] = 'highlight_text';
            }
            if (Schema::hasColumn('subscriptions', 'button_text')) {
                $columnsToDrop[] = 'button_text';
            }
            if (Schema::hasColumn('subscriptions', 'features')) {
                $columnsToDrop[] = 'features';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
}
