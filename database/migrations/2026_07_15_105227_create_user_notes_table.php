<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('document_type')->default('constitution'); // constitution, pre_1992, post_1992, judgment
            $table->unsignedBigInteger('document_id');
            $table->string('document_title');
            $table->text('highlighted_text')->nullable();
            $table->text('note_content');
            $table->string('note_color')->default('yellow'); // yellow, blue, green, pink, purple
            $table->string('article_section')->nullable();
            $table->string('page_url');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'document_type', 'document_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_notes');
    }
}
