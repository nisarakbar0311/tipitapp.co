<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\Api\Send_Money_Event;
use App\Events\Api\User_Toupop_Event;
use App\Http\Resources\Api\Transaction_Listing_Resource;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ResponseController;
use App\RequestMoney;
use App\UserBank;
use App\Wallet;
use App\WithdrawRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Stripe\Stripe;


class PaymentController extends ResponseController
{

    public function requestMoney(Request $request)
    {

        $userdata = $request->user();

        $this->directValidation([
            'user_id' => ['required'],
            'amount' => ['required', 'Numeric', 'min:0.50'],
        ], ['amount.min' => __('api.err_amount_must_be_greater_then_min')]);

        $transaction_number = genUniqueStr('tr_', 10, 'transactions', 'transaction_number', true); //temp number it will  get from paymentgateway


        $requestMoney  = [
            'sender_id' => $userdata->id,
            'receiver_id' => $request->user_id,
            'status' => 'pending',
            'transaction_number' => $transaction_number,
            'amount' => $request->amount,
        ];
        $transaction = RequestMoney::Create($requestMoney);

        $message = $userdata->username . " has requested $" . number_to_dec($request->amount, 2) . " money. Tap for approve or decline.";
        $notificaion = [
            'push_type' => 1,
            'push_message' => $message,
            'from_user_id' => $userdata->id,
            'push_title' => get_constants('app_name'),
            'object_id' => $transaction->id,

        ];
        send_push($request->user_id, $notificaion, true);

        $this->sendResponse(200, __('api.succ_requested'), $transaction);
    }

    public function sendMoney(Request $request)
    {


        $userdata = $request->user();
        $this->directValidation([
            'to_user_id' => ['required', 'Numeric'],
            'amount' => ['required', 'Numeric'],
            'current_pin' => ['required'],

        ]);
        $message = $request->message ?? '';

        if (Hash::check($request->current_pin, $userdata->pin)) {

            $balance = walletBalance($userdata->id);
            if ($balance < $request->amount) {
                $this->sendError(__('api.err_no_balance'), false);
            }
            $transaction_number = genUniqueStr('tr_', 10, 'transactions', 'transaction_number', true); //temp number it will  get from paymentgateway

            //transaction entry
            $transaction  = [
                'user_id' => $userdata->id,
                'transaction_number' => $transaction_number,
                'amount' => -$request->amount,
                'payment_status' => 'success',
                'transaction_type' => 'user',

            ];
            $transaction = Transaction::Create($transaction);
            //transaction entry end

            //user to user transaction end
            $requestMoney  = [
                'sender_id' => $request->to_user_id,
                'receiver_id' =>  $userdata->id,
                'status' => 'approved',
                'message' => $message,
                'transaction_number' => $transaction_number,
                'amount' => $request->amount,
            ];
            $RequestTransaction = RequestMoney::Create($requestMoney);

            //user to user transaction end


            //money cut
            $wallet  = [
                'user_id' => $userdata->id,
                'transaction_no' => $transaction_number,
                'amount' => -$request->amount,
                'message' => ($message) ? $message : "money transfer to " . getUsername($request->to_user_id),
                'status' => 'success',
            ];
            $senderWallet =   Wallet::Create($wallet);
            //money cut end


            //money deposit
            $wallet  = [
                'user_id' => $request->to_user_id,
                'transaction_no' => $transaction_number,
                'amount' => $request->amount,
                'message' => $message,
                'status' => 'success',

            ];
            Wallet::Create($wallet);
            //money deposit end


            //notificion start
            $notificaion = [
                'push_type' => 3,
                'push_message' => "Money receive from " . getUsername($userdata->id),
                'from_user_id' => $userdata->id,
                'push_title' => get_constants('app_name'),
                'object_id' =>   $userdata->id,
            ];
            send_push($request->to_user_id, $notificaion, true);
            //notificion end


            $this->sendResponse(200, __('api.succ_trans'), $senderWallet);
        } else {
            $this->sendError(__('api.err_current_pin_mismatch'), null);
        }
    }

    public function approveDecline(Request $request)
    {
        $userdata = $request->user();

        $this->directValidation([
            'request_id' => ['required', 'Numeric'],
            'status' => ['required', 'in:approve,decline'],

        ]);

        $requestMoney = RequestMoney::where('id', $request->request_id)->where('receiver_id', $userdata->id)->first();
        if ($requestMoney) {
            if ($request->status == 'approve') {
                 $this->directValidation([
                    'current_pin' => ['required'],
                 ]);

                if (Hash::check($request->current_pin, $userdata->pin)) {
                   //  $this->sendResponse(200, __('api.succ_pin'));
              


                $requestMoney->status = 'success';
                $requestMoney->save();

                $balance = walletBalance($requestMoney->receiver_id);
                if ($balance < $requestMoney->amount) {
                    $this->sendError(__('api.err_no_balance'), false);
                }

                $transaction  = [
                    'user_id' => $requestMoney->receiver_id,
                    'transaction_number' => $requestMoney->transaction_number,
                    'amount' => -$requestMoney->amount,
                    'payment_status' => 'success',
                    'transaction_type' => 'user',

                ];
                $transaction = Transaction::Create($transaction);


                $wallet  = [
                    'user_id' => $requestMoney->receiver_id,
                    'transaction_no' => $requestMoney->transaction_number,
                    'amount' => -$requestMoney->amount,
                    'message' => "money transfer",
                    'status' => 'success',

                ];
                Wallet::Create($wallet);


                $wallet  = [
                    'user_id' => $requestMoney->sender_id,
                    'transaction_no' => $requestMoney->transaction_number,
                    'amount' => $requestMoney->amount,
                    'message' => "money transfer from " . @$requestMoney->receiverUser->name,
                    'status' => 'success',

                ];
                Wallet::Create($wallet);


                $message = $userdata->username . " approved your money request of $" . $requestMoney->amount;

                $notificaion = [
                    'push_type' => 6,
                    'push_message' =>  $message,
                    'from_user_id' => $userdata->id,
                    'push_title' =>  get_constants('app_name'),
                    'object_id' => $requestMoney->id,
                ];
                send_push($requestMoney->sender_id, $notificaion, true);


                $this->sendResponse(200, __('api.succ_approve'));

            } else {
                $this->sendError(__('api.err_current_pin_mismatch'), null);
            }



            } else if ($request->status == 'decline') {
              
                $requestMoney->status = 'decline';
                $requestMoney->save();

                $message = $userdata->username . " decline your money request of $" . $requestMoney->amount;
                $notificaion = [
                    'push_type' => 2,
                    'push_message' => $message,
                    'from_user_id' => $userdata->id,
                    'push_title' =>  get_constants('app_name'),
                    'object_id' => $requestMoney->id,
                ];
                send_push($requestMoney->sender_id, $notificaion, true);


                $this->sendResponse(200, __('api.succs_decline'));
            }
        }

        $this->sendError(__('api.err_no_request_found'), false);
    }

    public function addMoney(Request $request)
    {
        $user = $request->user();

        $this->directValidation([
            'amount' => ['required', 'Numeric', 'min:0.50'],
            'transaction_id' => ['required'],
            //'nonceFromTheClient' => ['required'],
        ], ['amount.min' => __('api.err_amount_must_be_greater_then_min')]);

       // $transaction_number = genUniqueStr('tr_', 10, 'transactions', 'transaction_number', true); //temp number it will  get from paymentgateway
       $transaction_number = $request->transaction_id ?? '';
        $amount = $request->amount;
        $nonse = $request->nonceFromTheClient;

        //$result = Brain_tree_charge($amount, $nonse);
       
        //if ($result->success) {
           // $transaction_number = $result->transaction->id;
            $transaction  = [
                'user_id' => $user->id,
                'transaction_number' => $transaction_number,
                'amount' => $request->amount,
                'payment_status' => 'success',
                'transaction_type' => 'admin',

            ];
            $transaction = Transaction::Create($transaction);

            $wallet  = [
                'user_id' => $user->id,
                'transaction_no' => $transaction_number,
                'amount' => $request->amount,
                'message' => $request->amount,
                'transaction_type' => 'admin',
                'trans_type' => 'add',
                'message' => __('api.succs_add_money'),
                'status' => 'success',

            ];
            Wallet::Create($wallet);

            $this->sendResponse(200, __('api.succ_amount_added_in_wallet'), $wallet);
            
        // }else if($result->success == false){
        //     $this->sendError($result->message, null);
        // }else{
        //     $this->sendError("Something wend wrong", null);
        // }
    }



    function requestList(Request $request)
    {

        $user_data = $request->user();
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;
        $requestdata = RequestMoney::where('receiver_id', $user_data->id)->wherein('status', ['pending', 'decline'])->limit($limit)->offset($offset)->orderby('id', 'desc')->get();

        $currentBalance = walletBalance($user_data->id);
        $data = ['current_balance' => $currentBalance, 'request' => $requestdata];

        if (count($requestdata) > 0) {

            $walletdata = $requestdata->map(function ($item, $key) {



                $detail['id'] =  $item['id'];
                $detail['user_image'] =  $item->senderUser->profile_image;
                $detail['username'] =  @$item->senderUser->username;
                $detail['name'] =  @$item->senderUser->name;
                $detail['status'] =  $item->status;
                $detail['message'] =  $item->message;
                $detail['amount'] =  $item->amount;

                $detail['transaction_number'] =  $item->transaction_number;
                $detail['created_at'] =  date('Y-m-d H:i:s', strtotime($item['created_at']));


                // $detail['transaction_no'] =  $item['transaction_no'];
                // $detail['amount'] =  $item['amount'];
                // $detail['message'] =  $item['message'];
                // $detail['status'] =  $item['status'];
                // $detail['date'] =  date('Y-m-d H:i:s',strtotime($item['created_at'])) ;

                return $detail;
            });
            $data['request'] = $walletdata;


            $this->sendResponse(200, __('api.succ_request_listing'), $data);
        } else {
            $this->sendResponse(200, __('api.errr_no_history'), $data);
            //$this->sendError(__('api.errr_no_history'), false);
        }
    }
    function transactionHistory(Request $request)
    {

        $user_data = $request->user();

        $type = $request->type ?? 'all';
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;
        $transaction = RequestMoney::select("*")->whereIn('status', ['approved', 'success']);

        if ($type == 'all') {
            $transaction = $transaction->where(function ($query) use ($user_data) {
                $query->where('sender_id', $user_data->id)->orWhere('receiver_id', $user_data->id);
            });
        } else if ($type == 'send') {
            $transaction = $transaction->where(function ($query) use ($user_data) {
                $query->where('receiver_id', $user_data->id);
            });
        } else {


            $transaction = $transaction->where(function ($query) use ($user_data) {
                $query->where('sender_id', $user_data->id);
            });
        }

        $transaction = $transaction->limit($limit)->offset($offset)->orderby('id', 'desc')->get();



        if (count($transaction) > 0) {

            $walletdata = $transaction->map(function ($item, $key) use ($user_data) {


                $usertype = 'sender';
                $detail['id'] =  $item->id;
                $message = '';
                $photo = '';
                $name = "";
                $email = "";


                if ($item->sender_id == $user_data->id) {
                    $usertype = 'receiver';
                    $message = 'receive From';
                    $photo = $item->receiverUser->profile_image;
                    $name  =  $item->receiverUser->name;
                    $email  =  $item->receiverUser->email;
                } else if ($item->receiver_id == $user_data->id) {
                    $usertype = 'sender';


                    $message = 'send to';
                    $photo = @$item->senderUser->profile_image;
                    $name  =  @$item->senderUser->name;
                    $email  =  @$item->senderUser->email;
                }
                $detail['usertype'] =  $usertype;
                $detail['message'] =  $message;
                $detail['user_message'] = $item['message'];
                $detail['profile'] =  $photo;
                $detail['name'] =  $name;
                $detail['email'] =  $email;
                $detail['sender_id'] =  $item['sender_id'];
                $detail['receiver_id'] =  $item['receiver_id'];

                $detail['transaction_no'] =  $item['transaction_number'];
                $detail['amount'] =  $item['amount'];

                $detail['status'] =  transactionStatus($item['status']);
                $detail['date'] =  date('Y-m-d H:i:s', strtotime($item['created_at']));

                return $detail;
            });
            // $data['history'] = $walletdata;


            $this->sendResponse(200, __('api.succ_transaction'), $walletdata);
        } else {
            $this->sendResponse(200, __('api.errr_no_history'), []);
        }
    }

    function walletHistory(Request $request)
    {
        $user_data = $request->user();
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;
        //$wallet = Wallet::where('user_id', $user_data->id)->limit($limit)->offset($offset)->orderby('id', 'desc')->get();
        $wallet = Wallet::where('user_id', $user_data->id)->limit($limit)->offset($offset)->orderby('id', 'desc')->get();
        //$wallet = Transaction::where('user_id', $user_data->id)->where('transaction_type')->limit($limit)->offset($offset)->orderby('id', 'desc')->get();

        $currentBalance = walletBalance($user_data->id);
        $data = ['current_balance' => $currentBalance,'admin_commision' => generalsetting('admin_commision'),'history' => $wallet];

        if (count($wallet) > 0) {

            $walletdata = $wallet->map(function ($item, $key) {

               
                $commision = (@$item->getWithDrawTransaction->admin_commision) ? @$item->getWithDrawTransaction->admin_commision : 0;
                $payment =   ($item['amount']);

                $detail['id'] =  $item['id'];
                $detail['user_id'] =  $item['user_id'];
                $detail['transaction_no'] =  $item['transaction_no'];
                $detail['amount'] =  $payment;
               $detail['admin_commision'] =  $commision;
               $detail['message'] =  $item['message'];
                $detail['status'] =  apiwithdrawStatus($item['status']);
                $detail['trans_type'] =  $item['trans_type'];
                $detail['date'] =  date('Y-m-d H:i:s', strtotime($item['created_at']));

                return $detail;
            });
            $data['history'] = $walletdata;


            $this->sendResponse(200, __('api.succ_wallet'), $data);
        } else {
            $this->sendResponse(200, __('api.errr_no_history'), $data);
            //$this->sendError(__('api.errr_no_history'), false);
        }
    }


    public function add_amount(Request $request)
    {
        $user = $request->user();
        $this->directValidation([
            'amount' => ['required', 'Numeric', 'min:0.50'],
        ], ['amount.min' => __('api.err_amount_must_be_greater_then_min')]);
        $default_card = $user->defaultPaymentMethod();
        if ($default_card) {
            try {
                $amount = $request->amount;
                $admin_charge = calculate_percentage($amount, TOPUP_CHARGE);
                $chargeable_amount = ($amount + $admin_charge) * 100;
                $payment = $user->charge($chargeable_amount, $default_card);
                event(new User_Toupop_Event([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'charge' => $admin_charge,
                    'transaction_id' => $payment->id,
                ]));
                $this->sendResponse(200, __('api.succ_amount_added_in_wallet'));
            } catch (\Exception $exception) {
                $this->sendError($exception->getMessage());
            }
        } else {
            $this->sendError(__('api.err_add_card_for_topup'));
        }
    }

    public function send_money(Request $request)
    {
        $user_ids = $request->user_ids;
        $amounts = $request->amounts;
        $user_data = $request->user();
        if (count($user_ids) == count($amounts)) {
            $total_amount = collect($amounts)->sum();
            if ($user_data->wallet >= $total_amount) {
                $this->directValidation([
                    'user_ids' => ['required', 'array'],
                    'amounts' => ['required', 'array'],
                    'user_ids.*' => ['required', 'integer', Rule::exists('users', 'id')->where('type', 'user')->whereNot('id', $user_data->id)],
                    'amounts.*' => ['required', 'numeric', 'min:0.01'],
                ], [
                    'user_ids.*.exists' => __('api.err_user_not_found'),
                    'amounts.*.numeric' => __('api.err_amount_must_be_greater_then_min_for_sent')
                ]);
                $user_data->update(['wallet' => $user_data->wallet - $total_amount]);
                event(new Send_Money_Event($user_ids, $amounts, $user_data->id));
                $this->sendResponse(200, __('api.succ_amount_send_by_owner'));
            } else {
                $this->sendError(__('api.err_insufficient_wallet_amount'));
            }
        } else {
            $this->sendError('Please pass all the information properly');
        }
    }

    public function transaction_listing(Request $request)
    {
        $type = $request->type;
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;
        $this->directValidation([
            'type' => ['required', 'in:1,2,3'],
        ]);
        $user_data = $request->user();
        //        1==top Up &&2 ==sent && 3== recive
        $listing = Transaction::query();
        if ($type == 1) {
            $listing = $listing->where(['user_id' => $user_data->id, 'type' => 'top_up']);
        } elseif ($type == 2) {
            $listing = $listing->where(['from_user_id' => $user_data->id, 'type' => 'transfer'])->groupBy('transaction_id');
        } elseif ($type == 3) {
            $listing = $listing->where(['user_id' => $user_data->id, 'type' => 'transfer'])->groupBy('transaction_id');
        }
        $listing = $listing->limit($limit)->offset($offset)->latest('id')->get();
        $this->sendResponse(200, __('api.succ_amount_send_by_owner'), Transaction_Listing_Resource::collection($listing));
    }

    public function transaction_detail(Request $request)
    {
        $transaction_id = $request->transaction_id;
        $user_data = $request->user();
        $this->directValidation([
            'transaction_id' => ['required', Rule::exists('transactions', 'transaction_id')],
        ]);
        $transaction = Transaction::where('transaction_id', $transaction_id)->first();
        $data = [
            'id' => $transaction->id,
            'transaction_id' => $transaction->transaction_id,
            'amount' => $transaction->amount,
            'charge' => $transaction->charge,
            'total' => $transaction->total,
            'status' => $transaction->status,
            'type' => $transaction->type,
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at,
            'is_own_transaction' => ($transaction->type == 'top_up' || $transaction->from_user_id == $user_data->id) ? 1 : 0,
            'transactions' => [],
        ];
        if ($transaction->type == 'transfer') {
            $relation_ship_type = ($transaction->user_id == $user_data->id) ? "receiver" : "sender";
            $transactions = Transaction::where(['transaction_id' => $transaction_id]);
            if ($relation_ship_type == "receiver") {
                $transactions = $transactions->where('user_id', $user_data->id);
            }
            $transactions = $transactions->has($relation_ship_type)->with([$relation_ship_type => function ($user) {
                $user->SimpleDetails();
            }])->get();
            foreach ($transactions as $transaction) {
                $data['transactions'][] = [
                    'id' => $transaction->id,
                    'status' => $transaction->status,
                    'amount' => $transaction->amount,
                    'charge' => $transaction->charge,
                    'total' => $transaction->total,
                    'created_at' => $transaction->created_at,
                    'updated_at' => $transaction->updated_at,
                    'user' => $transaction[$relation_ship_type],
                ];
            }
        }
        $this->sendResponse(200, __('api.succ'), $data);
    }


    public function test(Request $request)
    {
        //        $user = $request->user();
        //        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        ////        $account = \Stripe\Account::create([
        ////            'email' => $user->email,
        ////            'type' => 'standard',
        ////        ]);
        //        dd(\Stripe\Account::retrieve('acct_1IIWbaLhmBtAU29d'));

        $account_links = \Stripe\AccountLink::create([
            'account' => 'acct_1IIWbaLhmBtAU29d',
            'refresh_url' => "http://127.0.0.1:8000/api/V1/payment/test",
            'return_url' => "http://127.0.0.1:8000/api/V1/payment/test",
            'type' => 'account_onboarding',
        ]);
        dd($account_links);
    }

    public function Generate_client_token()
    {
        $this->sendResponse(200, __('api.succ'), [
            'token' => Brain_tree_token(),
        ]);
    }

    function withdraw_request(Request $request)
    {

        $user_data = $request->user();
        $valid = $this->directValidation([
            'bank_name' => ['required'],
            'bank_routing_no' => ['required'],
            'account_no' => ['required'],
            'account_holder_name' => ['required'],
        ]);

        $currentDate = date('Y-m-d');

        $userbalance = (!empty($request->amount))?$request->amount:walletBalance($user_data->id);
        
        if ($userbalance > 0) {
            if($userbalance < 20 || $userbalance >walletBalance($user_data->id)){
            $this->sendError('Please check your wallet balance', false);
        }else{
            $transaction_number = genUniqueStr('tr_', 10, 'transactions', 'transaction_number', true); //temp number it will  get from paymentgateway
            $commision = generalsetting('admin_commision');
            $minusAmount = 0;
            $adminComission = $userbalance*$commision / 100;
            $totalAmount = $userbalance - $adminComission;
            $transaction  = [
                'user_id' => $user_data->id,
                'transaction_number' => $transaction_number,
                'amount' => -$userbalance,
                'payment_status' => 'pendding',
                'is_withdraw' =>  1,
                'transaction_type' => 'admin',

            ];
            $transaction = Transaction::Create($transaction);

            $withDrawRequest = [
                'user_id' => $user_data->id,
                'amount' => $totalAmount,
                'admin_commision' => $adminComission,
                'transaction_no' => $transaction_number,
                'withdraw_status' => 'pending',
                'request_date' => date('Y-m-d H:i:s'),
            ];


            $withdraw =  WithdrawRequest::Create($withDrawRequest);
            if ($withdraw) {

                $userbank  = [
                    'user_id' => $user_data->id,
                    'widraw_id' => $withdraw->id,
                    'bank_name' => $request->bank_name,
                    'bank_routing_no' =>  $request->bank_routing_no,
                    'account_no' =>  $request->account_no,
                    'account_holder_name' =>  $request->account_holder_name,
                ];
                UserBank::Create($userbank);


                $wallet  = [
                    'user_id' => $user_data->id,
                    'transaction_no' => $transaction_number,
                    'amount' => -$userbalance,
                    'message' => "Withdrawal Initiated",
                    'status' => 'pendding',
                    'trans_type' => 'withdraw',
                    'transaction_type' => 'admin',

                ];
                Wallet::Create($wallet);
            }
            $this->sendResponse(200, __('api.succ_withdraw'), $withdraw);
        }
        } else {
            $this->sendError(__('api.err_no_balance'), false);
        }

        $lastamount = Wallet::where('user_id', $user_data->id)->where('transaction_type', '!=', 'widraw')->where('is_settle', 0)->orderBy('id', 'desc')->first();
        if ($lastamount) {

            $tranNo = genUniqueStr('tr_', 10, 'wallet', 'tran_order', true);
            $add = Wallet::create([
                'user_id' =>  $user_data->id,
                'tran_order' => $tranNo,
                'amount_plus' => 0,
                'amount_minus' =>  $lastamount->total_amount,
                'wallet_total' => -$lastamount->total_amount,
                'total_amount' => 0,
                'transaction_type' => 'widraw',
                'message' => "Request withdraw",
            ]);

            $addday = 15;
            $schduleDate  = date('Y-m-d', strtotime('+' . $addday . ' days'));
            $day = date("w", strtotime($schduleDate));
            if ($day == 0) {
                $addday = $addday + 1;
                $schduleDate  = date('Y-m-d', strtotime('+' . $addday . ' days'));
            }

            $data = [
                'bank_id' => $request->bank_id ?? 0,
                'user_id' => $user_data->id,
                'account_holder_name' => $request->account_holder_name ?? 0,
                'account_number' => $request->account_number ?? 0,
                'ifsc_code' => $request->ifsc_code ?? 0,
                'withdraw_date' => $currentDate,
                'withdraw_status' => 'pending',
                'wallet_id' => $add->id,
                'withdraw_amount' => $lastamount->total_amount,
                'payout_schedule_date' => $schduleDate,

            ];
            $wallet = WalletWithdraw::create($data);
            Wallet::where('is_request_id', 0)->where('user_id', $user_data->id)->update(['is_request_id' => $wallet->id]);
            $this->sendResponse(200, __('api.succ_withdraw'), $wallet);
        } else {
            $this->sendError(__('api.err_no_amount'), false);
        }
    }
    
    
    function send_payout(Request $request)
    {
        $user_data = $request->user();
        
        // return $user_data;
        
        $currentDate = date('Y-m-d');

        $userbalance = (!empty($request->amount))?$request->amount:walletBalance($user_data->id);
        
        if ($userbalance > 0) {
            if($userbalance < 20 || $userbalance >walletBalance($user_data->id)){
            $this->sendError('Please check your wallet balance', false);
            }else{
                // $transaction_number = genUniqueStr('tr_', 10, 'transactions', 'transaction_number', true); //temp number it will  get from paymentgateway
                $commision = generalsetting('admin_commision');
                $minusAmount = 0;
                $adminComission = $userbalance*$commision / 100;
                $totalAmount = $userbalance - $adminComission;
            
            // "payee" => array(
                        // "country_code" => $request->country_code,
                        // "phone_number" => $request->phone_number
                    // )
                
                $wamount = round($totalAmount*100);
                $postdata = array(
                    "amount" => $wamount
                );
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.senddotssandbox.com/api/v2/payout-links',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => json_encode($postdata),
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic cGtfcHJvZF9Ic0xJN2JtdGpGRWIwanlzMWtkdk9pZUFueWpqQjpza19wcm9kX2g0S3BZWURrUTNIZ0V3NEJlcTB0cUdvcEt3RGo0'
                  ),
                ));
                
                $response = curl_exec($curl);
                curl_close($curl);
                // return $response;
                $transaction_number = json_decode($response)->id;
                $transaction_status = json_decode($response)->status;
                $payout_link = json_decode($response)->link;
                // return $transaction_number;
                
                
                $transaction  = [
                    'user_id' => $user_data->id,
                    'transaction_number' => $transaction_number,
                    'dots_response' => $response,
                    'amount' => -$userbalance,
                    'payment_status' => 'success',
                    'is_withdraw' =>  1,
                    'transaction_type' => 'user',
    
                ];
                $transaction = Transaction::Create($transaction);
                
                $wallet  = [
                    'user_id' => $user_data->id,
                    'transaction_no' => $transaction_number,
                    'amount' => -$userbalance,
                    'message' => "Withdrawal using Dots",
                    'status' => 'success',
                    'trans_type' => 'withdraw',
                    'transaction_type' => 'user',

                ];
                Wallet::Create($wallet);
    
                // $withDrawRequest = [
                //     'user_id' => $user_data->id,
                //     'amount' => $totalAmount,
                //     'admin_commision' => $adminComission,
                //     'transaction_no' => $transaction_number,
                //     'withdraw_status' => 'approve',
                //     'request_date' => date('Y-m-d H:i:s'),
                // ];
                // $withdraw =  WithdrawRequest::Create($withDrawRequest);
                
                $transaction->link = $payout_link;
    
                $this->sendResponse(200, __('api.succ_withdraw'), $transaction);
            }
            
        } else {
            $this->sendError(__('api.err_no_balance'), false);
        }
    }
}
