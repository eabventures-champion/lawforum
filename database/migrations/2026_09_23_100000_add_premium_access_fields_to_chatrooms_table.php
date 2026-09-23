<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPremiumAccessFieldsToChatroomsTable extends Migration
{
    public function up()
    {
        Schema::table('chatrooms', function (Blueprint $table) {
            if (!Schema::hasColumn('chatrooms', 'access_type')) {
                $table->string('access_type', 30)->default('public')->after('is_premium')->index(); // 'public', 'security_pass', 'fee'
            }
            if (!Schema::hasColumn('chatrooms', 'security_code')) {
                $table->string('security_code', 60)->nullable()->after('access_type');
            }
            if (!Schema::hasColumn('chatrooms', 'creator_whatsapp')) {
                $table->string('creator_whatsapp', 60)->nullable()->after('security_code');
            }
            if (!Schema::hasColumn('chatrooms', 'creator_email')) {
                $table->string('creator_email', 150)->nullable()->after('creator_whatsapp');
            }
            if (!Schema::hasColumn('chatrooms', 'access_fee')) {
                $table->decimal('access_fee', 10, 2)->nullable()->after('creator_email');
            }
            if (!Schema::hasColumn('chatrooms', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('last_activity_at')->index();
            }
        });
    }

    public function down()
    {
        Schema::table('chatrooms', function (Blueprint $table) {
            $table->dropColumn([
                'access_type',
                'security_code',
                'creator_whatsapp',
                'creator_email',
                'access_fee',
                'expires_at'
            ]);
        });
    }
}
