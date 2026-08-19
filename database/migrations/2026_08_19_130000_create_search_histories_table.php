<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('search_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id', 120)->nullable();
            $table->string('search_text', 255);
            $table->integer('results_count')->nullable();
            $table->string('category', 50)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('searched_at')->useCurrent();
            $table->timestamps();

            $table->index(['user_id', 'searched_at']);
            $table->index(['session_id', 'searched_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_histories');
    }
}
