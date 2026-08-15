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
        Schema::table('user_bookmarks', function (Blueprint $table) {
            if (!Schema::hasColumn('user_bookmarks', 'document_type')) {
                $table->string('document_type')->nullable()->after('act_group');
            }
            if (!Schema::hasColumn('user_bookmarks', 'page_url')) {
                $table->text('page_url')->nullable()->after('document_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_bookmarks', function (Blueprint $table) {
            if (Schema::hasColumn('user_bookmarks', 'document_type')) {
                $table->dropColumn('document_type');
            }
            if (Schema::hasColumn('user_bookmarks', 'page_url')) {
                $table->dropColumn('page_url');
            }
        });
    }
};
