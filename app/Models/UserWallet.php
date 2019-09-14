<?php
/**
 * Created by PhpStorm.
 * User: Marius
 * Date: 12/17/2017
 * Time: 6:39 PM
 */

namespace App\Models;

use App\Entities\Wallet;
use App\Entities\Transaction;

class UserWallet
{
    /**
     * Fetches user wallet,
     * if it does not exists - creates and returns empty one.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserWallet($userId)
    {
        $wallet = Wallet
            ::firstOrCreate([
                'user_id' => $userId
            ], [
                'balance' => 0
            ]);
        return $wallet;
    }

    public function getUserTransactions($userId)
    {
        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return $transactions;
    }

}