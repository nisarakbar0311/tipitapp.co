<?php

namespace App\Http\Controllers\Api\V1;

use App\Content;
use App\Http\Controllers\Api\ResponseController;
use App\Mail\SendPin;
use App\User;
use App\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class GuestController extends ResponseController
{

    public function login(Request $request)
    {
        $rules = [
            'username' => ['nullable'],
            'mobile' => ['nullable'],
            'password' => ['required'],
            'push_token' => ['nullable'],
            'device_type' => ['required', 'in:android,ios'],
            'device_id' => ['required', 'max:255'],
        ];
        $messages = ['email.exists' => __('api.err_email_not_register')];
        $this->directValidation($rules, $messages);

        if ($request->username == "" && $request->mobile == "") {
            $this->sendError(__('api.username or mobile required'), false);
        }

        if($request->has('username') && $request->username != "")
        {
            $attempt = ['username' => $request->username, 'password' => $request->password, 'type' => 'user', 'status' => 'active'];
        }

        if($request->has('mobile') && $request->mobile != "")
        {
            $attempt = ['country_code' => $request->country_code, 'mobile' => $request->mobile, 'password' => $request->password, 'type' => 'user', 'status' => 'active'];
        }

        if (Auth::attempt($attempt)) {
            $token = User::AddTokenToUser();
            $this->sendResponse(200, __('api.suc_user_login'), $this->get_user_data($token));
        } else {
            $this->sendError(__('api.err_fail_to_auth'), false);
        }
    }


    public function signup(Request $request)
    {
        //Rule::unique('users', 'username')->ignore($user_id)->whereNull('deleted_at')
        $valid = $this->directValidation([
            'password' => ['required'],
            'push_token' => ['nullable'],
            'username' => Rule::unique('users', 'username')->whereNull('deleted_at'),
            // 'mobile' => Rule::unique('users', 'mobile')->whereNull('deleted_at'),
            // 'email' => ['email', Rule::unique('email')->whereNull('deleted_at')],
            'name' => ['required', 'max:100'],
            //'dob' => ['required'],
            'pin' => ['required', 'digits:4'],
            'is_sender' => ['required', 'in:0,1'],
            'device_id' => ['required', 'max:255'],
            'device_type' => ['required', 'in:android,ios'],
        ], [
            'mobile.unique' => __('api.err_mobile_is_exits'),
            'email.unique' => __('api.err_email_is_exits'),
        ]);
        
        $profileImage =  config('constants.default.user_image');

        if ($request->hasFile('profile_image')) {
            $upload_files = $request->file('profile_image')->store(config('constants.upload_paths.user_profile_image'), config('constants.upload_type'));
            if ($upload_files) {

                $profileImage = $upload_files;
            }
        }
        $issender = $request->is_sender ?? 0;


        $user = User::create([
            'password' => $request->password,
            'email' => $request->email,
            'name' => $request->name,
            'username' => $request->username,
            'country_code' => $request->country_code,
            'mobile' => $request->mobile,
            'pin' => $request->pin,
            'dob' =>  general_date($request->dob ?? ""),
            'is_sender' =>  $issender,
            'profile_image' => $profileImage,
        ]);



        if ($user) {
            Auth::loginUsingId($user->id);
            $token = User::AddTokenToUser();
            $this->sendResponse(200, __('api.suc_user_register'), $this->get_user_data($token));
        } else {
            $this->sendError(__('api.err_something_went_wrong'), false);
        }
    }
    
   //Login with Google
    public function login_with_google(Request $request)
    {
        try{
            if(!$request->has('google_id') || $request->google_id == "")
            {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Google ID is Required!',                    
                // ], 200);
                $this->sendError(__('api.Google ID is Required!'), false);
            }
            
            if(!$request->has('device_id') || $request->device_id == "")
            {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Device ID is Required!',                    
                // ], 200);
                $this->sendError(__('api.Device ID is Required!'), false);
            }
            
            if($request->has('email') && $request->email != "")
            {
                $already_exist = User::where('email', $request->email)->first();
                
                if(!empty($already_exist))
                {
                    Auth::loginUsingId($already_exist->id);
                    $token = User::AddTokenToUser();
                    $this->sendResponse(200, __('api.suc_user_login'), $this->get_user_data($token));
                }
            }

            $already = User::where('google_id', $request->google_id)->first();
            // return $already->id;

            if(!empty($already))
            {
                Auth::loginUsingId($already->id);
                $token = User::AddTokenToUser();
                $this->sendResponse(200, __('api.suc_user_login'), $this->get_user_data($token));
            
            }else{
                $user = new User;
                $user->google_id = $request->google_id;

                if($request->has('name') && $request->name != "")
                {
                    $user->name = $request->name;
                }

                if($request->has('email') && $request->email != "")
                {
                    $already_exist = User::where('email', $request->email)->first();
                    
                    if(!empty($already_exist))
                    {
                        // return response()->json([
                        //     'status' => false,
                        //     'message' => 'Email has already been Taken',                            
                        // ], 200);
                        $this->sendError(__('api.Email has already been Taken!'), false);
                    }

                    $user->email = $request->email;
                }
                
                $profileImage =  config('constants.default.user_image');
        
                if ($request->hasFile('profile_image')) {
                    $upload_files = $request->file('profile_image')->store(config('constants.upload_paths.user_profile_image'), config('constants.upload_type'));
                    if ($upload_files) {
        
                        $profileImage = $upload_files;
                    }
                }
                $user->profile_image = $profileImage;
                $issender = $request->is_sender ?? 0;
                $user->is_sender = $issender;

                if($user->save())
                {
                    Auth::loginUsingId($user->id);
                    $token = User::AddTokenToUser();
                    $this->sendResponse(200, __('api.suc_user_register'), $this->get_user_data($token));
                }else {
                    $this->sendError(__('api.err_something_went_wrong'), false);
                }
            }
        }catch(\Exception $e)
        {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'There is some trouble to proceed your action',                
            // ], 200);
            $this->sendError(__('api.There is some trouble to proceed your action!'), false);
        }
    }
    
    
    public function login_with_apple(Request $request)
    {
        try{
            if(!$request->has('apple_id') || $request->apple_id == "")
            {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Apple ID is Required!',                    
                // ], 200);
                 $this->sendError(__('api.Apple ID is Required!'), false);
            }
            
            if(!$request->has('device_id') || $request->device_id == "")
            {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Device ID is Required!',                    
                // ], 200);
                 $this->sendError(__('api.Device ID is Required!'), false);
            }

            $already = User::where('apple_id', $request->apple_id)->first();
            // return $already->id;

            if(!empty($already))
            {
                Auth::loginUsingId($already->id);
                $token = User::AddTokenToUser();
                $this->sendResponse(200, __('api.suc_user_login'), $this->get_user_data($token));
            
            }else{
                $user = new User;
                $user->apple_id = $request->apple_id;

                if($request->has('name') && $request->name != "")
                {
                    $user->name = $request->name;
                }

                if($request->has('email') && $request->email != "")
                {
                    $already_exist = User::where('email', $request->email)->first();
                    
                    if(!empty($already_exist))
                    {
                        // return response()->json([
                        //     'status' => false,
                        //     'message' => 'Email has already been Taken',                            
                        // ], 200);
                         $this->sendError(__('api.Email has already been Taken!'), false);
                    }

                    $user->email = $request->email;
                }
                
                $profileImage =  config('constants.default.user_image');
        
                if ($request->hasFile('profile_image')) {
                    $upload_files = $request->file('profile_image')->store(config('constants.upload_paths.user_profile_image'), config('constants.upload_type'));
                    if ($upload_files) {
        
                        $profileImage = $upload_files;
                    }
                }
                $user->profile_image = $profileImage;
                $issender = $request->is_sender ?? 0;
                $user->is_sender = $issender;

                if($user->save())
                {
                    Auth::loginUsingId($user->id);
                    $token = User::AddTokenToUser();
                    $this->sendResponse(200, __('api.suc_user_register'), $this->get_user_data($token));
                }else {
                    $this->sendError(__('api.err_something_went_wrong'), false);
                }
            }
        }catch(\Exception $e)
        {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'There is some trouble to proceed your action',                
            // ], 200);
             $this->sendError(__('api.There is some trouble to proceed your action!'), false);
        }
    }
    
    
    public function login_with_linkedin(Request $request)
    {
        try{
            if(!$request->has('linkedin_id') || $request->linkedin_id == "")
            {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Linkedin ID is Required!',                    
                // ], 200);
                 $this->sendError(__('api.Linkedin ID is Required!'), false);
            }
            
            if(!$request->has('device_id') || $request->device_id == "")
            {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Device ID is Required!',                    
                // ], 200);
                 $this->sendError(__('api.Device ID is Required!'), false);
            }

            $already = User::where('linkedin_id', $request->linkedin_id)->first();
            // return $already->id;

            if(!empty($already))
            {
                Auth::loginUsingId($already->id);
                $token = User::AddTokenToUser();
                $this->sendResponse(200, __('api.suc_user_login'), $this->get_user_data($token));
            
            }else{
                $user = new User;
                $user->linkedin_id = $request->linkedin_id;

                if($request->has('name') && $request->name != "")
                {
                    $user->name = $request->name;
                }

                if($request->has('email') && $request->email != "")
                {
                    $already_exist = User::where('email', $request->email)->first();
                    
                    if(!empty($already_exist))
                    {
                        // return response()->json([
                        //     'status' => false,
                        //     'message' => 'Email has already been Taken',                            
                        // ], 200);
                         $this->sendError(__('api.Email has already been Taken!'), false);
                    }

                    $user->email = $request->email;
                }
                
                $profileImage =  config('constants.default.user_image');
        
                if ($request->hasFile('profile_image')) {
                    $upload_files = $request->file('profile_image')->store(config('constants.upload_paths.user_profile_image'), config('constants.upload_type'));
                    if ($upload_files) {
        
                        $profileImage = $upload_files;
                    }
                }
                $user->profile_image = $profileImage;
                $issender = $request->is_sender ?? 0;
                $user->is_sender = $issender;

                if($user->save())
                {
                    Auth::loginUsingId($user->id);
                    $token = User::AddTokenToUser();
                    $this->sendResponse(200, __('api.suc_user_register'), $this->get_user_data($token));
                }else {
                    $this->sendError(__('api.err_something_went_wrong'), false);
                }
            }
        }catch(\Exception $e)
        {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'There is some trouble to proceed your action',                
            // ], 200);
             $this->sendError(__('api.There is some trouble to proceed your action!'), false);
        }
    }
    

    public function forgot_password(Request $request)
    {
        $data = User::password_reset($request->email, false);
        $status = $data['status'] ? 200 : 412;
        $this->sendResponse($status, $data['message']);
    }

    public function forgot_pin(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        $user_data = $request->user();
        if ($user) {
            if($user_data->email != $request->email){
                $this->sendResponse(412, __('api.err_email_not_match') );
            }
            $pin = genUniqueStr('', 4, 'users', 'pin');

            $user_data = $request->user();
            $user->pin = $pin;
            $user->save();

            $mail =  Mail::to($user->email)->send(new SendPin($user, $pin));
            
            $this->sendResponse(200, __('api.succ_temp_pin'));
        } else {
            //$data =  ['status' => false, 'message' => __('api.err_email_not_exits')];

            $this->sendResponse(412, __('api.err_email_not_exits'));
        }
    }

    public function content(Request $request, $type)
    {
        $data = Content::where('slug', $type)->first();
        return ($data) ? $data->content : "Invalid content type passed.";
    }

    public function check_ability(Request $request)
    {
        $otp = "";
        $type = $request->type;
        $is_sms_need = $request->is_sms_need;
        $rules = [
            'type' => ['required', 'in:username,email,mobile_number'],
            'value' => ['required'],
            'country_code' => ['required_if:type,mobile']
        ];
        $user_id = $request->user_id;
        if ($type == "email") {
            $rules['value'][] = 'email';
            $rules['value'][] = Rule::unique('users', 'email')->ignore($user_id)->whereNull('deleted_at');
        } elseif ($type == "username") {
            $rules['value'][] = 'regex:/^\S*$/u';
            $rules['value'][] = Rule::unique('users', 'username')->ignore($user_id)->whereNull('deleted_at');
        } else {
            $rules['value'][] = 'integer';
            $rules['value'][] = Rule::unique('users', 'mobile')->ignore($user_id)->where('country_code', $request->country_code)->whereNull('deleted_at');
        }
        $this->directValidation($rules, ['regex' => __('api.err_space_not_allowed'), 'unique' => __('api.err_field_is_taken', ['attribute' => str_replace('_', ' ', $type)])]);
        $this->sendResponse(200, __('api.succ'));
    }


    public function version_checker(Request $request)
    {
        $type = $request->type;
        $version = $request->version;
        $this->directValidation([
            'type' => ['required', 'in:android,ios'],
            'version' => 'required',
            'device_id' => ['required', 'max:255'],
            'push_token' => ['required'],
        ]);
        $data = [
            'is_force_update' => ($type == "ios") ? IOS_Force_Update : Android_Force_Update,
        ];
        DeviceToken::updateOrCreate(
            ['device_id' => $request->device_id, 'type' => $request->device_type],
            ['device_id' => $request->device_id, 'type' => $request->device_type, 'push_token' => $request->push_token, 'badge' => 0]
        );
        $check = ($type == "ios") ? (IOS_Version <= $version) : (Android_Version <= $version);
        if ($check) {
            $this->sendResponse(200, __('api.succ'), $data);
        } else {
            $this->sendResponse(412, __('api.err_new_version_is_available'), $data);
        }
    }
}
