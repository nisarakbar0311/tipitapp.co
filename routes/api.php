<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api\V1', 'prefix' => 'V1'], function () {
    Route::post('login', 'GuestController@login');
    Route::post('signup', 'GuestController@signup');
    Route::post('forgot_password', 'GuestController@forgot_password');
    Route::get('content/{type}', 'GuestController@content');
    Route::post('check_ability', 'GuestController@check_ability');
    Route::post('version_checker', 'GuestController@version_checker');
    Route::get('user/userSearch', 'UserController@userSearch');
    //Country Selection apis here
    Route::group(['middleware' => 'ApiTokenChecker'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::post('deleteAccount', 'UserController@deleteAccount');
            Route::post('forgot_pin', 'GuestController@forgot_pin');
            Route::get('generate_client_token', 'PaymentController@Generate_client_token');
            Route::post('wallet_add', 'PaymentController@addMoney');
            Route::get('wallet_history', 'PaymentController@walletHistory');
            Route::post('transaction_history', 'PaymentController@transactionHistory');
            Route::get('requestlist', 'PaymentController@requestList');
            Route::post('withdraw_request', 'PaymentController@withdraw_request');
            Route::post('request_money', 'PaymentController@requestMoney');
            Route::post('approve_decline', 'PaymentController@approveDecline');
            Route::post('sendMoney', 'PaymentController@sendMoney');
            Route::post('send_payout', 'PaymentController@send_payout');
            Route::post('change_password', 'UserController@changePassword');
            Route::post('check_current_pin', 'UserController@checkCurrentPin');
            Route::post('change_pin', 'UserController@changePin');
            Route::post('edit_profile', 'UserController@edit_profile');
            Route::get('getProfile', 'UserController@getProfile');
            Route::get('logout', 'UserController@logout');
        });
    });
});


