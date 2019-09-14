<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entities\Transaction;

/**
 * Class WithdrawController.
 */
class WithdrawController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.withdraw.index');
    }

    public function search(Request $request)
    {
        $filter = $request->input('filter');
        $completed = $request->input('completed');
        $page = isset($filter['page']) ? $filter['page'] : 1;

        $select = DB::table('user_wallet_transactions')
            ->leftJoin('users', 'users.id', '=', 'user_wallet_transactions.user_id')
            ->where('transaction_type', Transaction::TYPE_WITHDRAWAL)
            ->orderBy('user_wallet_transactions.id', 'desc')
            ->select(
                'user_wallet_transactions.*',
                'users.id AS user_id',
                'users.email'
            );

        if ($completed !== 'true') {
            $select->where('status', '!=', Transaction::STATUS_COMPLETED);
        }
        $list = $select->paginate(25, ['*'], 'page', $page);

        return response()
            ->json($list);
    }

    public function setStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $record = Transaction::findOrFail($id);
        $record->status = $status;
        $record->save();
        return 'ok';
    }
}
