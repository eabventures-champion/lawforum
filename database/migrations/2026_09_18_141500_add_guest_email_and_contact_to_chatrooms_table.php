<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestEmailAndContactToChatroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('chatrooms')) {
            Schema::table('chatrooms', function (Blueprint $table) {
                if (!Schema::hasColumn('chatrooms', 'guest_email')) {
                    $table->string('guest_email', 150)->nullable()->after('guest_name');
                }
                if (!Schema::hasColumn('chatrooms', 'guest_contact')) {
                    $table->string('guest_contact', 50)->nullable()->after('guest_email');
                }
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
        if (Schema::hasTable('chatrooms')) {
            Schema::table('chatrooms', function (Blueprint $table) {
                if (Schema::hasColumn('chatrooms', 'guest_contact')) {
                    $table->dropColumn('guest_contact');
                }
                if (Schema::hasColumn('chatrooms', 'guest_email')) {
                    $table->dropColumn('guest_email');
                }
            });
        }
    }
}
