<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddIsEnabledToNewsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('news_categories') && !Schema::hasColumn('news_categories', 'is_enabled')) {
            DB::statement("SET SESSION sql_mode=''");
            DB::statement("ALTER TABLE news_categories ADD COLUMN is_enabled TINYINT(1) NOT NULL DEFAULT 1 AFTER name");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('news_categories') && Schema::hasColumn('news_categories', 'is_enabled')) {
            DB::statement("SET SESSION sql_mode=''");
            Schema::table('news_categories', function (Blueprint $table) {
                $table->dropColumn('is_enabled');
            });
        }
    }
}
