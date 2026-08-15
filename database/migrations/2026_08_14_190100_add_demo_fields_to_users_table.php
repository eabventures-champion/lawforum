<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDemoFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'researcher_type')) {
                $table->string('researcher_type')->nullable()->after('user_type');
            }
            if (!Schema::hasColumn('users', 'researcher_type_other')) {
                $table->string('researcher_type_other')->nullable()->after('researcher_type');
            }
            if (!Schema::hasColumn('users', 'is_demo_mode')) {
                $table->boolean('is_demo_mode')->default(false)->after('researcher_type_other');
            }
            if (!Schema::hasColumn('users', 'demo_started_at')) {
                $table->timestamp('demo_started_at')->nullable()->after('is_demo_mode');
            }
            if (!Schema::hasColumn('users', 'demo_extended')) {
                $table->boolean('demo_extended')->default(false)->after('demo_started_at');
            }
            if (!Schema::hasColumn('users', 'demo_used')) {
                $table->boolean('demo_used')->default(false)->after('demo_extended');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('users', 'researcher_type')) {
                $columns[] = 'researcher_type';
            }
            if (Schema::hasColumn('users', 'researcher_type_other')) {
                $columns[] = 'researcher_type_other';
            }
            if (Schema::hasColumn('users', 'is_demo_mode')) {
                $columns[] = 'is_demo_mode';
            }
            if (Schema::hasColumn('users', 'demo_started_at')) {
                $columns[] = 'demo_started_at';
            }
            if (Schema::hasColumn('users', 'demo_extended')) {
                $columns[] = 'demo_extended';
            }
            if (Schema::hasColumn('users', 'demo_used')) {
                $columns[] = 'demo_used';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
}
