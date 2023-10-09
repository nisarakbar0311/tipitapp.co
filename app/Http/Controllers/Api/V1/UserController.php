<?php

namespace App\Http\Controllers\Api\V1;


use App\DeviceToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ResponseController;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends ResponseController
{

    public function getProfile()
    {
        $this->sendResponse(200, __('api.succ'), $this->get_user_data());
    }

    public function checkCurrentPin(Request $request){
        $user_data = $request->user();

        $valid = $this->apiValidation([
           'current_pin' => ['required'],
        ]);

        if ($valid) {
            if (Hash::check($request->current_pin, $user_data->pin)) {
                 $this->sendResponse(200, __('api.succ_pin'));
            } else {
                $this->sendError(__('api.err_current_pin_mismatch'), null);
            }

        } else {
            $this->sendError(null, false);
        }

    }

    public function changePin(Request $request){
        $user_data = $request->user();

        $valid = $this->apiValidation([
           
            'new_pin' => ['required','digits:4'],
            'conf_pin' => ['required', 'same:new_pin'],
        ]);

        if ($valid) {
            
            $user = User::where('id', $user_data->id)->first();
            if($user){
                $user->pin = $request->new_pin;
                $user->save();
            }
            
            
            $this->sendResponse(200, __('api.succ_pin_updated'), null);
        } else {
            $this->sendError(null, false);
        }

    }


    public function edit_profile(Request $request)
    {
       
        $user_data = $request->user();
        
        // return $user_data;
         
        $update_data = [];

        if(isset($request->email)){
            $valid = $this->apiValidation([
                'email' => ['required', 'email', Rule::unique('users')->ignore($user_data->id)->whereNull('deleted_at')],
                // 'name' => ['required', 'max:100'],
            ]);

            if ($valid) {
                $update_data['email'] =  $request->email;
            }else{
                $this->sendError(null, false);
            }

        }

        if(isset($request->name)){
            $valid = $this->apiValidation([
                'name' => ['required', 'max:100'],
            ]);

            if ($valid) {
                $update_data['name'] = $request->name;
            }else{
                $this->sendError(null, false);
            }

        }

        // if(isset($request->is_sender)){
        //     $valid = $this->apiValidation([
        //         'is_sender' => ['required', 'max:100'],
        //     ]);

        //     if ($valid) {
        //         $update_data['is_sender'] = $request->is_sender;
        //     }else{
        //         $this->sendError(null, false);
        //     }

        // }

        
        if ($request->has('is_sender')) {
            $update_data['is_sender'] = $request->is_sender;
        }

         if ($request->has('bio')) {
            
             $update_data['bio'] = $request->bio ?? "";
         }


        if ($request->hasFile('profile_image')) {
            $upload_files = $request->file('profile_image')->store(config('constants.upload_paths.user_profile_image'), config('constants.upload_type'));
            if ($upload_files) {
                un_link_file($user_data->profile_image);
                $update_data['profile_image'] = $upload_files;
            }
         }

         if(count($update_data) > 0){
             $user_data->update($update_data);
             $this->sendResponse(200, __('api.succ_profile_updated'), $this->get_user_data());
         }else{

            $this->sendError('Atleast one field required',false);

         }
         
    }

    


    public function changePassword(Request $request)
    {

        $user_data = $request->user();

        $valid = $this->apiValidation([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'conf_password' => ['required', 'same:new_password'],
        ]);

        if ($valid) {

            if (isset($request->current_password)) {

                $currentPassword = $user_data->password;

                if (Hash::check($request->current_password, $currentPassword)) {

                    $user = User::where('id', $user_data->id)->update(['password' => bcrypt($request->new_password)]);

                    $this->sendResponse(200, __('api.succ_password_updated'), null);
                } else {
                    $this->sendError(__('api.err_current_password_mismatch'), null);
                }
            } else {

                $user = User::where('id', $user_data->id)->update(['password' => bcrypt($request->new_password)]);

                $this->sendResponse(200, __('api.succ_password_updated'), null);
            }
        } else {
            $this->sendError(null, false);
        }
    }

    public function logout(Request $request)
    {
        DeviceToken::where('token', get_header_auth_token())->delete();
        $this->sendResponse(200, __('api.succ_logout'), false);
    }

    public function update_name(Request $request)
    {
        $user_data = $request->user();
        $this->directValidation([
            'first_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
        ]);
        $user_data->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);
        $this->sendResponse(200, __('api.succ_name_update'), $this->get_user_data());
    }

    public function update_email(Request $request)
    {
        $user_data = $request->user();
        $this->directValidation([
            'email' => ['required', 'email', Rule::unique('users')->ignore($user_data->id)->whereNull('deleted_at')],
        ]);
        $user_data->update([
            'email' => $request->email,
        ]);
        $this->sendResponse(200, __('api.succ_email_update'), $this->get_user_data());
    }

    public function update_mobile_number(Request $request)
    {
        $user_data = $request->user();
        $this->directValidation([
            'mobile' => ['required', 'integer', Rule::unique('users')->where('country_code', $request->country_code)->ignore($user_data->id)->whereNull('deleted_at')],
            'country_code' => ['required'],
        ], [
            'mobile.unique' => __('api.err_mobile_is_exits'),
        ]);
        $user_data->update([
            'mobile' => $request->mobile,
            'country_code' => $request->country_code,
        ]);
        $this->sendResponse(200, __('api.succ_number_update'), $this->get_user_data());
    }

    public function update_profile_image(Request $request)
    {
        $user_data = $request->user();
        $this->directValidation([
            'profile_image' => ['required', 'file', 'image'],
        ]);
        $up = $this->upload_file('profile_image', 'user_profile_image');
        if ($up) {
            un_link_file($user_data->profile_image);
            $user_data->update(['profile_image' => $up]);
            $this->sendResponse(200, __('api.succ_profile_picture_update'), $this->get_user_data());
        } else {
            $this->sendError(412, __('api.errr_fail_to_upload_image'));
        }
    }

    function userSearch(Request $request)
    {
        $user_data = $request->user();

        $token = get_header_auth_token();
        $user_data  = getUser($token);
         $userid = $user_data;
         $userId = isset($userid) ? $userid : 0;
        // $limit = $request->limit ?? 10;
        // $offset = $request->offset ?? 0;
        $search = $request->search ?? '';

        if(empty($search)){
            $this->sendResponse(200, "No user found",[]);
        }
       
        $users = User::where('id','!=',$userId)->where('username','like','%'.$search.'%')->where('type','user')->orderby('id', 'desc')->get();

        if (count($users) > 0) {
            $usersdata = $users->map(function ($item, $key) {
                $detail['id'] =  $item['id'];
                $detail['name'] =  $item['name'];
                 $detail['username'] =  $item['username'];
                 $detail['profile_image'] =  $item['profile_image'];
                 $detail['email'] =  $item['email'];
                 $detail['is_sender'] =  $item['is_sender'];
                 $detail['dob'] =  $item['dob'];
                $detail['date'] =  date('Y-m-d H:i:s', strtotime($item['created_at']));
                return $detail;
            });
            
            $this->sendResponse(200, __('api.succ_user_list'),$usersdata);
        } else {
            $this->sendResponse(412, __('No user found'),[]);
        }
    }

    public function deleteAccount(Request $request){
       

        $userData = $request->user();
          
        $user = User::where('id',$userData->id)->first();
        if($user){
            DeviceToken::where('user_id',$userData->id)->delete();
            User::where('id',$userData->id)->delete();
           $this->sendResponse(200, __('api.succ_account_deleted'));

        }else{

            $this->sendError(__('api.err_something_went_wrong'), false);
        }
        

    }

}
