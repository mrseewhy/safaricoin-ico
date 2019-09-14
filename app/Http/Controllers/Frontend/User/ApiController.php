<?php

namespace App\Http\Controllers\Frontend\User;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use App\Entities\Transaction;
use App\Entities\Currency;
use App\Entities\ManualWithdraw;
use App\Entities\UserEntity;
use Illuminate\Support\Facades\Log;
use App\Entities\CryptoPayment;
use App\Entities\Offerings;

class ApiController extends Controller
{
    protected $userWallet;

    /**
     * Create a new controller instance.
     *
     * @param UserWallet $wallet
    */
    public function __construct(UserWallet $wallet)
    {
        $this->userWallet = $wallet;
    }

    public function gourlCallback()
    {
        Log::info('GoUrl callback logged: '. json_encode($_POST));

        $paymentID = null;
        $box_status = null;

        require_once(base_path('libs/cryptobox.callback.php'));

        Log::info('Additional info: '. json_encode($paymentID));
        Log::info('Additional info: '. json_encode($box_status));

        if ($paymentID && in_array($box_status, [
                "cryptobox_newrecord",
                "cryptobox_updated"
            ])) {
            $payment = CryptoPayment::findOrFail($paymentID);
            Log::info('Additional info: '. json_encode($payment));

            if ($payment->orderID) {
                $transaction = Transaction::findOrFail($payment->orderID);
                $transaction->transaction_id = $payment->txID;
                if ($payment->txConfirmed) {
                    $transaction->status = Transaction::STATUS_COMPLETED;
                    // update user balance
                    $wallet = $this->userWallet->getUserWallet($transaction->user_id);
                    $wallet->balance_btc = bcadd($wallet->balance_btc, $transaction->transaction_amount, 8);
                    $wallet->save();
                } else {
                    $transaction->status = Transaction::STATUS_PENDING;
                }
                $transaction->save();
            }
        }
    }

    /**
     * Buy site coins
     *
     * @param Request $request
     * @return string
     * @throws \Exception
     */
    public function buyCoins(Request $request)
    {
        $bitcoinRate = Currency::getBitcoinRate();
        $amount = $request->input('amount');

        $userWallet = $this->userWallet->getUserWallet(Auth::id());

        $currentRound = Offerings::getCurrentRound();
        if (!$currentRound || !$currentRound->isActive()) {
            throw new \Exception('No active ICO round!');
        }
        if (!$currentRound || !$currentRound->isActive()) {
            throw new \Exception('No active ICO round!');
        }
        if ($currentRound->coinsLeftInRound() < $amount) {
            throw new \Exception('Can not buy more coins than left in current round!');
        }

        $localRate = $bitcoinRate / $currentRound->getRate();

        $amountBtc = $amount / $localRate;

        // balance_btc
        // balance_usd
        $max = floor($userWallet->balance_btc * $localRate);
        if (bccomp($amount, $max) !== 1) {
            $userWallet->balance_usd += $amount;
            $userWallet->balance_btc -= $amountBtc;
            $userWallet->save();

            Transaction::createNewDepositTransaction(
                Auth::id(),
                $amount,
                Transaction::TYPE_BUY_COIN,
                Transaction::STATUS_COMPLETED
            );
            $currentRound->coins_used += $amount;
            $currentRound->save();
            if (Auth::user()->referral_id && env('REFERRALS_ENABLED')) {
                $referral = UserEntity::find(Auth::user()->referral_id);
                if ($referral != null) {
                    $bonus = $amount / 100 * env('REFERRALS_BONUS_LVL1');
                    $this->addCoinsToReferral($referral, $bonus);

                    // 2nd level
                    if ($referral->referral != null) {
                        $bonus = $amount / 100 * env('REFERRALS_BONUS_LVL2');
                        $this->addCoinsToReferral($referral->referral, $bonus);
                    }
                }
            }

            return 'ok';
        } else {
            throw new \Exception('Amount is too high');
        }
    }

    private function addCoinsToReferral($referral, $bonus)
    {
        $userWallet = $this->userWallet->getUserWallet($referral->id);
        $userWallet->balance_usd += $bonus;
        $userWallet->save();

        Transaction::createNewDepositTransaction(
            $referral->id,
            $bonus,
            Transaction::TYPE_REFERRAL_BONUS,
            Transaction::STATUS_COMPLETED
        );
    }

    /**
     * Get user transactions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransactions()
    {
        $transactions = $this->userWallet->getUserTransactions(Auth::id());

        $subset = $transactions->map(function ($transaction) {
            return array(
                'created_at' => $transaction->created_at->toDateTimeString(),
                'transaction_amount' => $transaction->transaction_amount,
                'transaction_amount' => $transaction->transaction_amount,
                'transaction_id' => $transaction->transaction_id,
                'address' => "",
                'status' => $transaction->getStatus(),
                'status_label' => $transaction->getStatusLabel(),
                'transaction_type' => $transaction->transaction_type,
                'type' => $transaction->getType(),
            );
        });
        return response()
            ->json($subset);
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Exception
     */
    public function manualWithdraw(Request $request)
    {
        $amount = $request->input('amount');
        if ($amount <= env('WITHDRAW_FEE')) {
            abort(400, 'Amount is too low');
        }

        $address = $request->input('address');
        $userWallet = $this->userWallet->getUserWallet(Auth::id());
        if (bccomp($amount, $userWallet->balance_btc) !== 1) {
            /*ManualWithdraw::create([
                'user_id' => Auth::id(),
                'address' => $address,
                'amount' => $amount,
                'status' => ManualWithdraw::STATUS_NEW
            ]);*/

            $userWallet->balance_btc -= $amount;
            $userWallet->save();

            Transaction::createNewDepositTransaction(
                Auth::id(),
                $amount,
                Transaction::TYPE_WITHDRAWAL,
                Transaction::STATUS_NEW,
                $address
            );

            return 'ok';
        } else {
            abort(400, 'Amount is too high');
        }
    }
}
