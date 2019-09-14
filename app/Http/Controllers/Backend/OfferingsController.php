<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entities\Transaction;
use App\Entities\Offerings;

/**
 * Class OfferingsController.
 */
class OfferingsController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.offerings.index');
    }

    public function search(Request $request)
    {
        $filter = $request->input('filter');
        $completed = $request->input('completed');
        $page = isset($filter['page']) ? $filter['page'] : 1;

        $select = Offerings::select('*');

        $list = $select->paginate(25, ['*'], 'page', $page);

        return response()
            ->json($list);
    }

    public function edit($id = null, Request $request)
    {
        if ($id) {
            $offering = Offerings::findOrFail($id);
        } else {
            $offering = new Offerings();
        }

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'date',
                'coins_total' => 'required|numeric',
                'coins_rate' => 'required|numeric',
            ]);
            $offering->fill($validatedData);
            $offering->save();
            return redirect()->route('admin.offerings');
        }

        return view('backend.offerings.edit')
            ->with('id', $id)
            ->with('offering', $offering);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        Offerings::destroy($id);

        return 'ok';
    }
}
