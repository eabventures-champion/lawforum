<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'check_subscription')) {
                $table->boolean('check_subscription')->default(0);
            }
            if (!Schema::hasColumn('users', 'subscription_id')) {
                $table->bigInteger('subscription_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'subscription_expiry')) {
                $table->date('subscription_expiry')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
