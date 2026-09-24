<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payment_settings')) {
            Schema::create('payment_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });

            $now = now();
            $currentPub = env('FLUTTERWAVE_PUBLIC_KEY', '');
            $currentSec = env('FLUTTERWAVE_SECRET_KEY', '');
            $currentEnc = env('FLUTTERWAVE_ENCRYPTION_KEY', '');

            $mode = env('FLUTTERWAVE_MODE');
            if (!$mode) {
                $mode = (strpos($currentPub, 'TEST') !== false) ? 'test' : 'live';
            }

            $testPub = env('FLUTTERWAVE_TEST_PUBLIC_KEY') ?: ((strpos($currentPub, 'TEST') !== false) ? $currentPub : '');
            $testSec = env('FLUTTERWAVE_TEST_SECRET_KEY') ?: ((strpos($currentSec, 'TEST') !== false) ? $currentSec : '');
            $testEnc = env('FLUTTERWAVE_TEST_ENCRYPTION_KEY') ?: ((strpos($currentEnc, 'TEST') !== false) ? $currentEnc : '');

            $livePub = env('FLUTTERWAVE_LIVE_PUBLIC_KEY') ?: ((strpos($currentPub, 'TEST') === false && strpos($currentPub, 'FLWPUBK') !== false) ? $currentPub : '');
            $liveSec = env('FLUTTERWAVE_LIVE_SECRET_KEY') ?: ((strpos($currentSec, 'TEST') === false && strpos($currentSec, 'FLWSECK') !== false) ? $currentSec : '');
            $liveEnc = env('FLUTTERWAVE_LIVE_ENCRYPTION_KEY') ?: ((strpos($currentEnc, 'TEST') === false && !empty($currentEnc)) ? $currentEnc : '');

            DB::table('payment_settings')->insert([
                ['key' => 'flutterwave_mode', 'value' => $mode ?: 'test', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'flutterwave_test_public_key', 'value' => $testPub, 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'flutterwave_test_secret_key', 'value' => $testSec, 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'flutterwave_test_encryption_key', 'value' => $testEnc, 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'flutterwave_live_public_key', 'value' => $livePub, 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'flutterwave_live_secret_key', 'value' => $liveSec, 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'flutterwave_live_encryption_key', 'value' => $liveEnc, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_settings');
    }
}
