<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Entities\Support;
use Illuminate\Http\Request;

/**
 * Class SupportController.
 */
class SupportController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.support.index');
    }

    public function search(Request $request)
    {
        $filter = $request->input('filter');
        $page = isset($filter['page']) ? $filter['page'] : 1;

        $list = Support::orderBy('id', 'desc')
            ->with('user')
            ->paginate(25, ['*'], 'page', $page);

        return response()
            ->json($list);
    }
}
