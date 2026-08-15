<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnboardingTourStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onboarding_tour_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('step_number')->default(1);
            $table->string('badge_label')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('icon')->default('fa-compass');
            $table->string('highlight_title')->nullable();
            $table->text('highlight_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('onboarding_tour_settings', function (Blueprint $table) {
            $table->id();
            $table->string('welcome_title')->default('Welcome to Your Workspace!');
            $table->text('welcome_description')->nullable();
            $table->string('welcome_btn_primary')->default('Take Guided Tour');
            $table->string('welcome_btn_secondary')->default('Explore on My Own');
            $table->boolean('auto_prompt_new_users')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onboarding_tour_steps');
        Schema::dropIfExists('onboarding_tour_settings');
    }
}
