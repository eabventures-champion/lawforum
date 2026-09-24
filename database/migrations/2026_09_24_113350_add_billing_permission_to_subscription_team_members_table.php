<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscription_team_members', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_team_members', 'can_manage_billing')) {
                $table->boolean('can_manage_billing')->default(false)->after('accepted_at');
            }
            if (!Schema::hasColumn('subscription_team_members', 'billing_request_plan_id')) {
                $table->unsignedBigInteger('billing_request_plan_id')->nullable()->after('can_manage_billing');
            }
            if (!Schema::hasColumn('subscription_team_members', 'billing_request_note')) {
                $table->text('billing_request_note')->nullable()->after('billing_request_plan_id');
            }
            if (!Schema::hasColumn('subscription_team_members', 'billing_request_status')) {
                $table->string('billing_request_status', 32)->default('none')->after('billing_request_note');
            }
            if (!Schema::hasColumn('subscription_team_members', 'billing_requested_at')) {
                $table->timestamp('billing_requested_at')->nullable()->after('billing_request_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_team_members', function (Blueprint $table) {
            $table->dropColumn([
                'can_manage_billing',
                'billing_request_plan_id',
                'billing_request_note',
                'billing_request_status',
                'billing_requested_at'
            ]);
        });
    }
};
