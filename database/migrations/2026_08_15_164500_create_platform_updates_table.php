<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_updates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('badge_text')->default('New Feature');
            $table->string('target_role')->default('all'); // all, researcher, lawyer, student
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->json('tour_steps')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('user_platform_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('update_id');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('tour_completed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('update_id')->references('id')->on('platform_updates')->onDelete('cascade');
            $table->unique(['user_id', 'update_id']);
        });

        // Add has_seen_tour column to users table if not present
        if (!Schema::hasColumn('users', 'has_completed_onboarding_tour')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('has_completed_onboarding_tour')->default(false)->after('email');
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
        Schema::dropIfExists('user_platform_updates');
        Schema::dropIfExists('platform_updates');
        if (Schema::hasColumn('users', 'has_completed_onboarding_tour')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('has_completed_onboarding_tour');
            });
        }
    }
}
