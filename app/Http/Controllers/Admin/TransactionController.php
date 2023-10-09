<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.transaction.index', [
            'title' => 'Wallet Transaction',
            'breadcrumb' => breadcrumb([
                'Wallet Transaction' => route('admin.transaction.index'),
            ]),
        ]);
    }

    public function listing(Request $request)
    {
        $datatable_filter = datatable_filters();
        $offset = $datatable_filter['offset'];
        $search = $datatable_filter['search'];
        $return_data = array(
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        );
        $transactionType = $request->transaction_type ?? 'admin';

        $main = Transaction::select("*");
        if (!empty($transactionType)) {
            $main->where('transaction_type', $transactionType);
        }

       
        $return_data['recordsTotal'] = $main->count();
        if (!empty($search)) {
            $main->where(function($q) use($search) {
                $q->whereHas('getUser',function($query) use($search){
                    $query->where('username','like','%'.$search.'%');
                });
            })->orWhere("transaction_number",$search);
        }
        $return_data['recordsFiltered'] = $main->count();
        $all_data = $main->orderBy($datatable_filter['sort'], $datatable_filter['order'])
            ->offset($offset)
            ->limit($datatable_filter['limit'])
            ->get();

        if (!empty($all_data)) {
            foreach ($all_data as $key => $value) {
                $param = [
                    'id' => $value->id,
                    'url' => [
                        // 'status' => route('admin.user.status_update', $value->id),
                        // 'edit' => route('admin.user.edit', $value->id),
                        // 'delete' => route('admin.user.destroy', $value->id),
                        // 'view' => route('admin.user.show', $value->id),
                    ],
                    //'checked' => ($value->status == 'active') ? 'checked' : ''
                ];
                $return_data['data'][] = array(
                    'id' => $offset + $key + 1,
                    'user_id' => @$value->getUser->username,
                    'transaction_number' => $value->transaction_number,
                    'amount' => $value->amount,
                    'payment_status' => $value->payment_status,
                    'created_at' => general_datetime($value->created_at),
                );
            }
        }
        return $return_data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
