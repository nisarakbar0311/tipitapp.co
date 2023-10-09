<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends WebController
{



    public function test($userid){
           
      $push =   send_push($userid, [
                'push_type' => 1,
                'push_title' => "test push",
                'push_message' => "test push",
                'object_id' => 1,
                'message' => "test push",
                'body' => "test push",
            ], true);

            dd($push);

        //     $config = new \Braintree\Configuration([
        //         'environment' => 'sandbox',
        //         'merchantId' => 'ryzzh22rvj3ddfhh',
        //         'publicKey' => 'b4gyk9fvn2kwzdv9',
        //         'privateKey' => 'a9c9c9d93c3749f8640052f372b775bd'
        //     ]);
        //     $gateway = new \Braintree\Gateway($config);
            
        //   //  echo($clientToken = $gateway->clientToken()->generate());
        //     $result = $gateway->transaction()->sale([
        //         'amount' => '10.00',
        //         'paymentMethodNonce' => 'fake-valid-nonce',
        //         'options' => [
        //           'submitForSettlement' => True
        //         ]
        //       ]);
        //       dd($result);
        //     die;

            // Then, create a transaction:
            // $result = $gateway->transaction()->sale([
            //     'amount' => '10.00',
            //     'paymentMethodToken' => $nonceFromTheClient,
            //     'deviceData' => $deviceDataFromTheClient,
            //     'options' => [ 'submitForSettlement' => True ]
            // ]);
          //  dd( $result);
    }
    public function index()
    {
        return view('admin.user.index', [
            'title' => 'Users',
            'breadcrumb' => breadcrumb([
                'Users' => route('admin.user.index'),
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
        $usertype = $request->user_type ?? '';

        $main = User::where('type', 'user');
       
       
        if ($usertype == '1' || $usertype == '0') {
            $main->where('is_sender', $usertype);
        }
        $return_data['recordsTotal'] = $main->count();
        if (!empty($search)) {
            $main->where(function ($query) use ($search) {
                $query->AdminSearch($search);
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
                        'status' => route('admin.user.status_update', $value->id),
                       // 'edit' => route('admin.user.edit', $value->id),
                        'delete' => route('admin.user.destroy', $value->id),
                        'view' => route('admin.user.show', $value->id),
                    ],
                    'checked' => ($value->status == 'active') ? 'checked' : ''
                ];
                $return_data['data'][] = array(
                    'id' => $offset + $key + 1,
                    'profile_image' => get_fancy_box_html($value['profile_image']),
                    'name' => $value->name,
                    'email' => $value->email,
                    'username' => $value->username,
                    'is_sender' => ($value->is_sender == 1) ? "Yes" : "No",
                    'status' => $this->generate_switch($param),
                    'action' => $this->generate_actions_buttons($param),
                );
            }
        }
        return $return_data;
    }


    public function destroy($id)
    {
        $data = User::where('id', $id)->first();
        if ($data) {
            $data->delete();
            success_session('User Deleted successfully');
        } else {
            error_session('User not found');
        }
        return redirect()->route('admin.user.index');
    }

    public function status_update($id = 0)
    {
        $data = ['status' => 0, 'message' => 'User Not Found'];
        $find = User::find($id);
        if ($find) {
            $find->update(['status' => ($find->status == "inactive") ? "active" : "inactive"]);
            $data['status'] = 1;
            $data['message'] = 'User status updated';
        }
        return $data;
    }

    public function show($id)
    {
        
        $data = User::where(['type' => 'user', 'id' => $id])->first();
        if ($data) {
            
            return view('admin.user.view', [
                'title' => 'View user',
                'data' => $data,
                'breadcrumb' => breadcrumb([
                    'user' => route('admin.user.index'),
                    'view' => route('admin.user.show', $id)
                ]),
            ]);
        }
        error_session('user not found');
        return redirect()->route('admin.user.index');
    }

    

    public function edit($id)
    {
        // $data = User::find($id);
        // if ($data) {
        //     $title = "Update user";
        //     return view('admin.user.edit', [
        //         'title' => $title,
        //         'data' => $data,
        //         'breadcrumb' => breadcrumb([
        //             'User' => route('admin.user.index'),
        //             'edit' => route('admin.user.edit', $data->id)
        //         ]),
        //     ]);
        // }
        // error_session('user not found');
        // return redirect()->route('admin.user.index');
    }

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        if ($data) {
            
             $request->validate([
                'first_name' => ['required', 'max:255'],
                'last_name' => ['required', 'max:255'],
                //'country_code' => ['required'],
                //'mobile' => ['required', Rule::unique('users', 'mobile')->ignore($id)->where('country_code', $request->country_code)->whereNull('deleted_at')],
                'email' => ['required', 'email', Rule::unique('users')->ignore($id)->whereNull('deleted_at')],
                'profile_image' => ['file', 'image'],
            ]);
            $profile_image = $data->getRawOriginal('profile_image');
            if ($request->hasFile('profile_image')) {
                $up = upload_file('profile_image', 'user_profile_image');
                if ($up) {
                    un_link_file($profile_image);
                    $profile_image = $up;
                }
            }
           $userdata = [
                 'email' => $request->email,
                 'profile_image' => $profile_image,
                'name' => $request->first_name . ' ' . $request->last_name,
           ];
            $data->update($userdata);
            success_session('user updated successfully');
        } else {
            error_session('user not found');
        }
        return redirect()->route('admin.user.index');
    }

    
    public function walletlisting(Request $request)
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
        $main = Wallet::where('user_id',$userId);
        $return_data['recordsTotal'] = $main->count();
        if (!empty($search)) {
            $main->where(function ($query) use ($search) {
               // $query->AdminSearch($search);
               $query->where('transaction_no','like','%'.$search.'%');
            });
        }
        $return_data['recordsFiltered'] = $main->count();
        $all_data = $main->orderBy('id','desc')
            ->offset($offset)
            ->limit($datatable_filter['limit'])
            ->get();
        if (!empty($all_data)) {
            foreach ($all_data as $key => $value) {
               
                $return_data['data'][] = array(
                    'id' => $offset + $key + 1,
                    'transaction_no' => $value->transaction_no,
                    'amount' => $value->amount,
                    'message' => $value->message,
                    'status' => $value->status,
                    'created_at' => general_datetime($value->created_at),
                    
                    
                );
            }
        }
        return $return_data;
    }


}
