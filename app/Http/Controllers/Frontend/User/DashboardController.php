<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Entities\Currency;
use App\Entities\Transaction;
use App\Models\Auth\User;
use App\Entities\Offerings;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    protected $userWallet;

    public function __construct(UserWallet $wallet)
    {
        $this->userWallet = $wallet;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $userWallet = $this->userWallet->getUserWallet(Auth::id());
        $bitcoinRate = Currency::getBitcoinRate();
        $currentRound = Offerings::getCurrentRound();
        if ($currentRound) {
            $localRate = $bitcoinRate / $currentRound->getRate();
        } else {
            $localRate = 0;
        }


        return view('frontend.user.dashboard', [
            'userWallet' => $userWallet,
            'bitcoinRate' => $bitcoinRate,
            'localRate' => $localRate,
            'currentRound' => $currentRound,
            'refLink' => User::simpleEncode(Auth::id())
        ]);
    }

    public function deposit(Request $request)
    {
        $amount = $request->input('deposit_amount');
        $transaction = Transaction::createNewDepositTransaction(Auth::id(), $amount);

        $options = array(
            "public_key"  => env('GOURL_PUBLIC'),
            "private_key" => env('GOURL_SECRET'),
            "webdev_key"  => "",
            "orderID"     => $transaction->id,
            "userID"      => Auth::id(),
            "userFormat"  => "COOKIE",
            "amount"   	  => $amount,
            "period"      => "NOEXPIRY",
            "language"	  => "en"
        );
        require_once(base_path('libs/cryptobox.class.php'));
        $box = new \Cryptobox ($options);


        return view('frontend.user.deposit', [
            'amount' => $amount,
            'cryptoBox' => $box
        ]);
    }
}
