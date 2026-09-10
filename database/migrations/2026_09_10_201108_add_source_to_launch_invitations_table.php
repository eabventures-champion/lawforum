<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('launch_invitations', function (Blueprint $table) {
            $table->string('source', 50)->default('launch')->after('email');
            $table->dropUnique('launch_invitations_email_unique');
            $table->unique(['email', 'source']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('launch_invitations', function (Blueprint $table) {
            $table->dropUnique(['email', 'source']);
            $table->unique('email');
            $table->dropColumn('source');
        });
    }
};
