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
        Schema::table('sidebar_ads', function (Blueprint $table) {
            $table->string('placeholder_type')->default('advertise')->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sidebar_ads', function (Blueprint $table) {
            $table->dropColumn('placeholder_type');
        });
    }
};
