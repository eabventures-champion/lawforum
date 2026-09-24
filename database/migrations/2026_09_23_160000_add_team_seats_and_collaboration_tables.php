<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTeamSeatsAndCollaborationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Add max_users (seats) to subscriptions table
        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'max_users')) {
                $table->unsignedInteger('max_users')->default(1)->after('no_downloads');
            }
        });

        // Set default seat allocations based on plan types
        DB::table('subscriptions')->where('type', 'like', '%Starter%')->update(['max_users' => 1]);
        DB::table('subscriptions')->where('type', 'like', '%Essential%')->update(['max_users' => 3]);
        DB::table('subscriptions')->where('type', 'like', '%Professional%')->update(['max_users' => 3]);
        DB::table('subscriptions')->where('type', 'like', '%Premium%')->update(['max_users' => 5]);
        DB::table('subscriptions')->where('type', 'like', '%Business%')->update(['max_users' => 5]);
        DB::table('subscriptions')->where('type', 'like', '%Unlimited%')->update(['max_users' => 10]);

        // 2. Create subscription_team_members table
        if (!Schema::hasTable('subscription_team_members')) {
            Schema::create('subscription_team_members', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('owner_id');
                $table->unsignedBigInteger('member_id')->nullable();
                $table->string('email');
                $table->string('invite_token', 64)->unique();
                $table->enum('status', ['pending', 'accepted', 'revoked'])->default('pending');
                $table->timestamp('accepted_at')->nullable();
                $table->timestamps();

                $table->index('owner_id');
                $table->index('member_id');
                $table->index('email');
            });
        }

        // 3. Create user_note_comments table for collaborative notes discussion
        if (!Schema::hasTable('user_note_comments')) {
            Schema::create('user_note_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_note_id');
                $table->unsignedBigInteger('user_id');
                $table->text('comment');
                $table->timestamps();

                $table->index('user_note_id');
                $table->index('user_id');
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
        Schema::dropIfExists('user_note_comments');
        Schema::dropIfExists('subscription_team_members');

        Schema::table('subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('subscriptions', 'max_users')) {
                $table->dropColumn('max_users');
            }
        });
    }
}
