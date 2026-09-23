<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatroomAccessesAndRequestsTables extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('chatroom_accesses')) {
            Schema::create('chatroom_accesses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('chatroom_id');
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('session_id', 100)->nullable()->index();
                $table->string('access_method', 30)->default('security_pass'); // 'security_pass', 'fee', 'author', 'admin'
                $table->timestamp('unlocked_at')->nullable();
                $table->timestamps();

                $table->foreign('chatroom_id')->references('id')->on('chatrooms')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('chatroom_join_requests')) {
            Schema::create('chatroom_join_requests', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('chatroom_id');
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('requester_name', 100);
                $table->string('requester_email', 150);
                $table->string('requester_phone', 60)->nullable();
                $table->text('note')->nullable();
                $table->string('status', 30)->default('pending'); // 'pending', 'approved', 'rejected'
                $table->timestamps();

                $table->foreign('chatroom_id')->references('id')->on('chatrooms')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('chatroom_join_requests');
        Schema::dropIfExists('chatroom_accesses');
    }
}
