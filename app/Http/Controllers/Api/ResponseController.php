<?php

namespace App\Http\Controllers\Api;

use App\Bank as AppBank;
use App\Cart;
use App\Countries;
use App\Http\Controllers\Controller as Controller;
use App\User;
use App\UserBank;
use App\UserCard;
use Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{

    public $errors;

    public function __construct()
    {
        $this->errors = null;
    }

    public function apiValidation($rules, $messages = [], $data = null)
    {
        $data = ($data) ? $data : request()->all();
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $this->errors = $validator->errors()->first();
            return false;
        } else {
            return true;
        }
    }

    public function directValidation($rules, $messages = [], $direct = true, $data = null)
    {
        $data = ($data) ? $data : request()->all();
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $this->errors = $validator->errors()->first();
            if ($direct) {
                $this->sendError(null, null);
            } else {
                return false;
            }
        } else {
            //            return true;
            return $validator->valid();
        }
    }

    public function sendError($message = null, $array = true)
    {
        $empty_object = new \stdClass();
        $message = ($this->errors) ? $this->errors : ($message ? $message : __('api.err_something_went_wrong'));
        send_response(412, $message, ($array) ? [] : $empty_object);
    }

    public function sendResponse($status, $message, $result = null, $extra = null)
    {
        $empty_object = new \stdClass();
//        $data = ($result) ? $empty_object : $result;
//        send_response($status, $message, $data, $extra, ($status != 401));
        send_response($status, $message, $result, $extra, ($status != 401));
    }

    public function get_user_data($token = null)
    {
        $user_data = Auth::user();
        $userBank = UserBank::select('id','bank_name','bank_routing_no','account_no','account_holder_name')->where('user_id',$user_data->id)->orderBy('id','desc')->first();
        return [
            'id' => $user_data->id,
            'name' => $user_data->name,
            'username' => $user_data->username,
            'is_sender' => $user_data->is_sender,
            'dob' => $user_data->dob,
            'email' => $user_data->email,
            'country_code' => $user_data->country_code,
            'mobile' => $user_data->mobile,
            'bio' => $user_data->bio,
            'profile_image' => $user_data->profile_image,
            'token' => $token ?? get_header_auth_token(),
            'last_bank' => ($userBank) ? $userBank : new \stdClass(),
            'support_email' => ADMIN_EMAIL
        ];
    }

}
