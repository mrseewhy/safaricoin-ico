<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entities\Transaction;

/**
 * Class DashboardController.
 */
class TransactionsController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.transactions.index');
    }

    public function info($id)
    {
        $transaction = Transaction::with('cryptoPayment')
            ->findOrFail($id);
//        dd($transaction->getAttributes());

        $labels = [];

        return view('backend.transactions.info', [
            "transaction" => $transaction,
            "labels" => $labels
        ]);
    }

    public function search(Request $request)
    {
        $searchFilters = [
            'email',
            'txID',
            'addr'
        ];

        $filter = $request->input('filter');
        $page = isset($filter['page']) ? $filter['page'] : 1;

        $el = DB::table('user_wallet_transactions')
            ->leftJoin('users', 'users.id', '=', 'user_wallet_transactions.user_id')
            ->leftJoin('crypto_payments', 'crypto_payments.orderID', '=', 'user_wallet_transactions.id')
            ->orderBy('user_wallet_transactions.id', 'desc')
            ->select(
                'user_wallet_transactions.*',
                'users.id AS user_id',
                'users.email',
                'crypto_payments.*'
            );


        foreach ($searchFilters as $f) {
            if (isset($filter[$f])) {
                $el->where($f, 'like', '%' . $filter[$f] . '%');
            }
        }

        $transactions = $el->paginate(25, ['*'], 'page', $page);

        $subset = $transactions->map(function ($transaction) {
            $c = new Carbon($transaction->created_at);
            return array(
                'id' => $transaction->id,
                'created_at' => $c->toDateTimeString(),
                'user_id' => $transaction->user_id,
                'user' => $transaction->email,
                'transaction_amount' => $transaction->transaction_amount,
                'transaction_id' => $transaction->txID ? $transaction->txID : '-',
                'transaction_address' => $transaction->addr ? $transaction->addr : '-',
                'address' => "",
                'status' => $transaction->status,
                'transaction_type' => $transaction->transaction_type,
                'type' => $transaction->transaction_type,
            );
        });
        return response()
            ->json([
                "data" => $subset,
                "total" => $transactions->count(),
                "currentPage" => $transactions->currentPage(),
                "lastPage" => $transactions->lastPage()
            ]);
    }
}
