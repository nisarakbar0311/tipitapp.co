<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WebController;
use App\Mail\RejectWithdrawRequest;
use App\RequestMoney;
use App\Transaction;
use App\User;
use App\Wallet;
use App\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentController extends WebController
{

    public function custSave()
    {
        $user = Auth::user();


        $response = \Braintree\Customer::create([
            'id' => 'admis' . $user->id
        ]);

        // save your braintree customer id
        if ($response->success) {
            $response->customer->id;
            $user->braintree_customer_id = $response->customer->id;
            $user->save();
        }
    }

    public function checkout(Request $request)
    {
        // get your logged in customer
        $customer = Auth::user();
        $gateway = new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'ryzzh22rvj3ddfhh',
            'publicKey' => "b4gyk9fvn2kwzdv9",
            'privateKey' => "a9c9c9d93c3749f8640052f372b775bd"
        ]);

        $token = $gateway->ClientToken()->generate();

        // when client hit checkout button
        if ($request->isMethod('post')) {
            // brain tree customer payment nouce
            $payment_method_nonce = $request->get('payment_method_nonce');

            // make sure that if we do not have customer nonce already
            // then we create nonce and save it to our database
            if (!$customer->braintree_nonce) {
                // once we recieved customer payment nonce
                // we have to save this nonce to our customer table
                // so that next time user does not need to enter his credit card details
                $result = \Braintree\PaymentMethod::create([
                    'customerId' => $customer->braintree_customer_id,
                    'paymentMethodNonce' => $payment_method_nonce
                ]);

                // save this nonce to customer table
                $customer->braintree_nonce = $result->paymentMethod->token;
                $customer->save();
            }

            // process the customer payment



            $client_nonce = \Braintree\PaymentMethodNonce::create($customer->braintree_nonce);
            $result = \Braintree\Transaction::sale([
                'amount' => 100,
                'options' => ['submitForSettlement' => True],
                'paymentMethodNonce' => $client_nonce->paymentMethodNonce->nonce
            ]);

            // check to see if braintree has processed
            // our client purchase transaction
            if (!empty($result->transaction)) {
                // your customer payment is done successfully  
            }
        }

        return view('admin.checkout', [
            'token' => $token
        ]);
    }

    public function settlement()
    {
        return view('admin.wallet.index', [
            'title' => 'Withdraw Request',
            'breadcrumb' => breadcrumb([
                'Withdraw Request' => route('admin.wallet.settlement'),
            ]),
        ]);
    }

    public function settlement_listing(Request $request)
    {
        $datatable_filter = datatable_filters();
        $offset = $datatable_filter['offset'];
        $search = $datatable_filter['search'];
        $return_data = array(
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        );
        $userId = $request->user_id;
        $main = WithdrawRequest::select('*')->where('withdraw_status', 'pending');
        $return_data['recordsTotal'] = $main->count();
        if (!empty($search)) {
            $main->where(function($query) use($search){
                $query->whereHas('getMetaInfo',function($mainquery)use($search){
                    $mainquery->where('bank_routing_no', 'like', '%' . $search . '%')
                    ->Orwhere('account_no', 'like', '%' . $search . '%')
                    ->Orwhere('account_holder_name', 'like', '%' . $search . '%');
                });
            });    
            
        }
        $return_data['recordsFiltered'] = $main->count();
        $all_data = $main->orderBy($datatable_filter['sort'], $datatable_filter['order'])
            ->offset($offset)
            ->limit($datatable_filter['limit'])
            ->get();
        if (!empty($all_data)) {
            foreach ($all_data as $key => $value) {
                // $param = [
                //     'id' => $value->id,
                //     'url' => [
                //         'status' => route('admin.user.status_update', $value->id),
                //         //'edit' => route('admin.user.edit', $value->id),
                //         //'delete' => route('admin.user.destroy', $value->id),
                //         'view' => route('admin.user.userDetail', $value->id),
                //     ],
                //     'checked' => ($value->status == 'active') ? 'checked' : ''
                // ];

                $action = '<a title="View" href="javascrip:;" data-id="' . $value->id . '" data-type="view" class="btn btn-sm btn-clean btn-icon btn-icon-md btnView transaction_settlment_btn" data-bs-toggle="modal" data-bs-target="#myModal"> <i class="fa fa-check" aria-hidden="true"></i> </a>
                 <a title="View" href="javascrip:;" data-id="' . $value->id . '" data-type="view" class="btn btn-sm btn-clean btn-icon btn-icon-md btnView reject_settlment_btn" data-bs-toggle="modal" data-bs-target="#rejectModal"> <i class="fa fa-window-close" aria-hidden="true"></i> </a>'
                
                ;



                $return_data['data'][] = array(
                    'id' => $offset + $key + 1,
                    'user_id' => $value->getUserName->name,
                    'email' => $value->getUserName->email,
                    'bank_name' => @$value->getMetaInfo->bank_name,
                    'account_holder_name' =>  @$value->getMetaInfo->account_holder_name,
                    'account_no' =>  @$value->getMetaInfo->account_no,
                    'bank_routing_no' =>  @$value->getMetaInfo->bank_routing_no,
                    
                    'withdraw_amount' => $value->amount,
                    'admin_commision' => $value->admin_commision,
                    'withdraw_status' => withdrawStatus($value->withdraw_status),
                    'withdraw_date' => general_datetime($value->request_date),
                    'action' => $action,
                );
            }
        }
        return $return_data;
    }


    
    public function settlementReject(Request $request)
    {

        $inputs = $request->validate([
            'wallet_settlemnt_id_reject' => ['required'],
            'reason' => ['required'],
           
        ], []);


        $transactionCheck = WithdrawRequest::where('id', $request->wallet_settlemnt_id_reject)->first();
        if ($transactionCheck) {
            $transaction = [
                'reason' => $request->reason ?? "",
                "withdraw_status" => "decline",
            ];
            WithdrawRequest::where('id', $request->wallet_settlemnt_id_reject)->update($transaction);
            $wallet = Wallet::where('user_id', $transactionCheck->user_id)->where('transaction_no', $transactionCheck->transaction_no)->first();
            if($wallet){
                $amount = abs($wallet->amount);
                Wallet::where('user_id', $transactionCheck->user_id)->where('transaction_no', $transactionCheck->transaction_no)->update(['amount' => $amount ,'message'=>'Withdrawal rejected' ,'status' => 'fail']);
            }

            
           //Transaction::where('user_id', $transactionCheck->user_id)->where('transaction_number', $transactionCheck->transaction_no)->update(['payment_status' => 'success']);

            
            $notificaion = [
                'push_type' => 5,
                'push_message' => "Oops !! Your withdrawal request is declined. Please check your email.",
                'from_user_id' => 1,
                'push_title' => get_constants('app_name'),
                'object_id' =>   $transactionCheck->id,
            ];
            send_push($transactionCheck->user_id, $notificaion, true);

            

            // $messagedata = 'Admin has been approve withdraw request. Transaction No '.$request->transaction ;

            $user = User::where('id',$transactionCheck->user_id)->first();
            if($user){
                Mail::to( $user->email)->send(new RejectWithdrawRequest($user,$request->reason));
            }

            $data = ['status' => true, "msg" => "Updated successfully"];
            return Response()->json($data);
        } else {
            $data = ['status' => false, "msg" => "No record found"];
            return Response()->json($data);
        }
    }

    public function settlementPost(Request $request)
    {

        $inputs = $request->validate([
            'wallet_settlemnt_id' => ['required'],
            'transaction' => ['required'],
            'transaction_date' => ['required'],
        ], []);


        $transactionCheck = WithdrawRequest::where('id', $request->wallet_settlemnt_id)->first();
        if ($transactionCheck) {
            $transaction = [
                'transaction_number' => $request->transaction ?? 0,
                'transaction_date' => saveFormat($request->transaction_date),
                "withdraw_status" => "approve",
            ];
            WithdrawRequest::where('id', $request->wallet_settlemnt_id)->update($transaction);
            Wallet::where('user_id', $transactionCheck->user_id)->where('transaction_no',$transactionCheck->transaction_no)->update(['message'=>'Withdrawal completed' ,'status' => 'success']);
            Transaction::where('user_id', $transactionCheck->user_id)->where('transaction_number', $transactionCheck->transaction_no)->update(['payment_status' => 'success']);

            
            $notificaion = [
                'push_type' => 4,
                'push_message' => "Yay !! Your withdrawal request is processed successfully.",
                'from_user_id' => 1,
                'push_title' => get_constants('app_name'),
                'object_id' =>   $transactionCheck->id,
            ];
            send_push($transactionCheck->user_id, $notificaion, true);

            

            // $messagedata = 'Admin has been approve withdraw request. Transaction No '.$request->transaction ;

            // $user = User::where('id',$transactionCheck->user_id)->first();
            // if($user){
            //     Mail::to( $user->email)->send(new TransactionMail($user,$messagedata));
            // }

            $data = ['status' => true, "msg" => "Added successfully"];
            return Response()->json($data);
        } else {
            $data = ['status' => false, "msg" => "No record found"];
            return Response()->json($data);
        }
    }

    function transactionSettle(){
        return view('admin.wallet_settle.index', [
            'title' => 'Wallet Settlement',
            'breadcrumb' => breadcrumb([
                'Wallet Settlement' => route('admin.wallet.transactionSettle'),
            ]),
        ]);
    }

    public function wallet_transaction_settlement_listing(Request $request)
    {
        $datatable_filter = datatable_filters();
        $offset = $datatable_filter['offset'];
        $search = $datatable_filter['search'];
        $return_data = array(
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        );
        $userId = $request->user_id;
        $main = WithdrawRequest::select('*')->wherein('withdraw_status',['approve','decline']);
        $return_data['recordsTotal'] = $main->count();
        if (!empty($search)) {
            $main->where(function($query) use($search){
                $query->whereHas('getMetaInfo',function($mainquery)use($search){
                    $mainquery->where('bank_routing_no', 'like', '%' . $search . '%')
                    ->Orwhere('account_no', 'like', '%' . $search . '%')
                    ->Orwhere('account_holder_name', 'like', '%' . $search . '%');
                });
            });    
            
        }
        $return_data['recordsFiltered'] = $main->count();
        $all_data = $main->orderBy($datatable_filter['sort'], $datatable_filter['order'])
            ->offset($offset)
            ->limit($datatable_filter['limit'])
            ->get();
        if (!empty($all_data)) {
            foreach ($all_data as $key => $value) {
                


                $return_data['data'][] = array(
                    'id' => $offset + $key + 1,
                    'user_id' => $value->getUserName->name,
                    'email' => $value->getUserName->email,
                    'bank_name' => @$value->getMetaInfo->bank_name,
                    'account_holder_name' =>  @$value->getMetaInfo->account_holder_name,
                    'account_no' =>  @$value->getMetaInfo->account_no,
                    'bank_routing_no' =>  @$value->getMetaInfo->bank_routing_no,
                    'withdraw_amount' => $value->amount,
                    'admin_commision' => $value->admin_commision,
                    'withdraw_status' => withdrawStatus($value->withdraw_status),
                    'withdraw_date' => general_datetime($value->request_date),
                    'transaction_number' => $value->transaction_number,
                    'transaction_date' => general_datetime($value->transaction_date),
                    'reason' =>  $value->reason,
                    
                 
                );
            }
        }
        return $return_data;
    }

    function requestlist(){
        return view('admin.wallet_request.index', [
            'title' => 'Transactions',
            'breadcrumb' => breadcrumb([
                'Transactions' => route('admin.wallet.requestlist'),
            ]),
        ]);
    }

    public function requestlisting(Request $request)
    {
        $datatable_filter = datatable_filters();
        $offset = $datatable_filter['offset'];
        $search = $datatable_filter['search'];
        $return_data = array(
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        );
        $userId = $request->user_id;
        $sender_name = $request->sender_name;
        $receiver_name = $request->receiver_name;
        $date_filter = $request->date_filter;
        $startdate = "";
        $enddate = "";
        if(!empty($date_filter)){
            $date = explode('-',$date_filter);
            $startdate =  isset($date[0]) ? $date[0] : '';
            $enddate =  isset($date[1]) ? $date[1] : '';

        }


        $main = RequestMoney::select('*')->where(function($query){
            $query->where('status','approved')->Orwhere('status','success');
        });
        


        if(!empty($date_filter)){
            $startdate = date('y-m-d',strtotime($startdate));
            $enddate = date('y-m-d',strtotime($enddate));

            $main = $main->whereDate('created_at','>=',$startdate)->wheredate('created_at','<=',$enddate);
        }
        if(!empty($sender_name)){
            $main = $main->whereHas('receiverUser',function($mainquery) use($sender_name){
                $mainquery->where('username','like','%'.$sender_name.'%');
            });
        }
        if(!empty($receiver_name)){
            $main = $main->whereHas('senderUser',function($mainquery) use($receiver_name){
                $mainquery->where('username','like','%'.$receiver_name.'%');
            });
        }

        $return_data['recordsTotal'] = $main->count();
        if (!empty($search)) {
           
           $main->where(function($query) use($search){
                $query->whereHas('senderUser',function($mainquery) use($search){
                    $mainquery->where('username','like','%'.$search.'%');
                })->OrwhereHas('receiverUser',function($mainquery) use($search){
                    $mainquery->where('username','like','%'.$search.'%');
                })->orWhere('transaction_number','like','%'.$search.'%');
            });
            
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
                        'view' => route('admin.wallet.requestview', $value->id),
                    ],
                    'checked' => ($value->status == 'active') ? 'checked' : ''
                ];


                $return_data['data'][] = array(
                    'id' => $offset + $key + 1,
                    'sender_id' =>   @$value->receiverUser->username,
                    'receiver_id' =>@$value->senderUser->username,
                    'transaction_number' => @$value->transaction_number,
                    'created_at' => general_datetime($value->created_at),
                    'status' => transactionStatus($value->status) ,
                    'amount' => @$value->amount,
                    'action' => $this->generate_actions_buttons($param),
                );
            }
        }
        return $return_data;
    }

    public function requestview($id,Request $request){
        $data = RequestMoney::where(['id' => $id])->first();
        if ($data) {
            
            return view('admin.wallet_request.view', [
                'title' => 'Transaction Detail',
                'data' => $data,
                'breadcrumb' => breadcrumb([
                    'Transactions' => route('admin.wallet.requestview'),
                    'Transaction Detail' => route('admin.wallet.requestview', $id)
                ]),
            ]);
        }
        error_session('user not found');
        return redirect()->route('admin.user.index');
    }
}
