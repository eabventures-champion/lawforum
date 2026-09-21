<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestNameToChatroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('chatrooms') && !Schema::hasColumn('chatrooms', 'guest_name')) {
            Schema::table('chatrooms', function (Blueprint $table) {
                $table->string('guest_name', 100)->nullable()->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('chatrooms') && Schema::hasColumn('chatrooms', 'guest_name')) {
            Schema::table('chatrooms', function (Blueprint $table) {
                $table->dropColumn('guest_name');
            });
        }
    }
}