<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const STATUS_NEW = 1;
    const STATUS_PENDING = 2;
    const STATUS_COMPLETED = 5;

    const TYPE_DEPOSIT = 1;
    const TYPE_WITHDRAWAL = 2;
    const TYPE_BUY_COIN = 3;
    const TYPE_REFERRAL_BONUS = 4;

    protected $table = 'user_wallet_transactions';

    protected $fillable = ['user_id', 'deposit_address_id', 'withdrawal_address', 'status', 'transaction_type'];

    public function depositAddress()
    {
        return $this->belongsTo('App\Entities\DepositAddress', 'deposit_address_id');
    }

    public function getStatus()
    {
        $map = [
            self::STATUS_NEW => 'New',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
        ];

        return $map[$this->status];
    }

    public function getType()
    {
        $map = [
            self::TYPE_DEPOSIT => 'Deposit',
            self::TYPE_WITHDRAWAL => 'Withdrawal',
            self::TYPE_BUY_COIN => 'Buy coins',
            self::TYPE_REFERRAL_BONUS => 'Referral bonus',
        ];

        return $map[$this->transaction_type];
    }

    public function getStatusLabel()
    {
        $map = [
            self::STATUS_NEW => 'secondary',
            self::STATUS_PENDING => 'info',
            self::STATUS_COMPLETED => 'primary',
        ];

        return $map[$this->status];
    }

    /**
     * Creates new transaction for user
     * @param $userId
     * @param null|decimal $amount
     * @param int $type
     * @param int $status
     * @param null $withdrawAddress
     * @return Transaction
     */
    public static function createNewDepositTransaction(
        $userId, $amount = null,
        $type = self::TYPE_DEPOSIT, $status = self::STATUS_NEW,
        $withdrawAddress = null)
    {
        $transaction = new self;
        $transaction->user_id = $userId;
        $transaction->status = $status;
        $transaction->transaction_type = $type;
        $transaction->transaction_amount = $amount;
        $transaction->withdrawal_address = $withdrawAddress;
        $transaction->save();

        return $transaction;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function cryptoPayment()
    {
        return $this->HasOne('App\Entities\CryptoPayment', 'orderID');
    }
}
