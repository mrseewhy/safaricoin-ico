<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDecimalColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_wallets', function (Blueprint $table) {
            $table->decimal('balance_btc', 22, 8)->default(0)->change();
            $table->decimal('balance_usd', 22, 4)->default(0)->change();
        });

        Schema::table('user_wallet_transactions', function (Blueprint $table) {
            $table->decimal('transaction_amount', 22, 8)->nullable()->change();
        });

        Schema::table('manual_withdraw', function (Blueprint $table) {
            $table->decimal('amount', 22, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
