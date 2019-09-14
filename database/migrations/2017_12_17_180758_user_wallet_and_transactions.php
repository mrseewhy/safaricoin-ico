<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserWalletAndTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->decimal('balance_btc', 12, 8)->default(0);
            $table->decimal('balance_usd', 12, 4)->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('deposit_addresses', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('wallet_id')->unsigned();
            $table->string('address', 255);
            $table->string('address_id', 255);
            $table->timestamps();

            $table->index('address');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('wallet_id')->references('id')->on('user_wallets');
        });

        Schema::create('user_wallet_transactions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('deposit_address_id')->unsigned()->nullable();
            $table->string('withdrawal_address', 255)->nullable();
            $table->string('transaction_id', 255)->nullable();
            $table->double('transaction_amount', 12, 8)->nullable();
            $table->integer('status');
            $table->integer('transaction_type');
            $table->timestamps();

            $table->index('status');
            $table->index('transaction_type');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('deposit_address_id')->references('id')->on('deposit_addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wallet_transactions');
        Schema::dropIfExists('deposit_addresses');
        Schema::dropIfExists('user_wallets');
    }
}
