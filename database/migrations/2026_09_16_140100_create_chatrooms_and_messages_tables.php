<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatroomsAndMessagesTables extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('chatrooms')) {
            Schema::create('chatrooms', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('category', 50)->default('general')->index(); // general, student, lawyer, researcher
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->boolean('is_premium')->default(false)->index();
                $table->boolean('is_pinned')->default(false)->index();
                $table->boolean('is_locked')->default(false);
                $table->unsignedInteger('views_count')->default(0);
                $table->unsignedInteger('replies_count')->default(0);
                $table->timestamp('last_activity_at')->nullable()->index();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }

        if (!Schema::hasTable('chatroom_messages')) {
            Schema::create('chatroom_messages', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('chatroom_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('guest_name', 100)->nullable();
                $table->text('message');
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->timestamps();

                $table->foreign('chatroom_id')->references('id')->on('chatrooms')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('parent_id')->references('id')->on('chatroom_messages')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('chatroom_presences')) {
            Schema::create('chatroom_presences', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('session_id', 100)->index();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('category', 50)->index(); // general, student, lawyer, researcher
                $table->timestamp('last_seen_at')->index();
                $table->timestamps();

                $table->unique(['session_id', 'category']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('chatroom_presences');
        Schema::dropIfExists('chatroom_messages');
        Schema::dropIfExists('chatrooms');
    }
}
