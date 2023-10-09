<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'guest', 'namespace' => 'General'], function () {
    Route::post('login', 'GeneralController@login')->name('login_post');
    Route::get('login', 'GeneralController@Panel_Login')->name('login');
    Route::get('forgot_password', 'GeneralController@Panel_Pass_Forget')->name('forgot_password');
    Route::post('forgot_password', 'GeneralController@ForgetPassword')->name('forgot_password_post');
});

Route::group(['middleware' => 'Is_Admin'], function () {
    Route::get('/', 'General\GeneralController@Admin_dashboard')->name('dashboard');
    Route::get('/totalusers', 'General\GeneralController@totalusers')->name('totalusers');
    Route::get('/profile', 'General\GeneralController@get_profile')->name('profile');
    Route::post('/profile', 'General\GeneralController@post_profile')->name('post_profile');
    Route::get('/update_password', 'General\GeneralController@get_update_password')->name('get_update_password');
    Route::post('/update_password', 'General\GeneralController@update_password')->name('update_password');
    Route::get('/site_settings', 'General\GeneralController@get_site_settings')->name('get_site_settings');
    Route::post('/site_settings', 'General\GeneralController@site_settings')->name('site_settings');
    Route::group(['namespace' => 'Admin'], function () {
        
        Route::get('custSave', 'PaymentController@custSave')->name('custSave');
        
        Route::get('/checkout', 'PaymentController@checkout');
        Route::post('/checkout', 'PaymentController@checkout');
        //        User Module
        Route::get('user/test/{userid?}', 'UsersController@test')->name('user.test');
        
        //user request money
        Route::get('wallet/requestlist', 'PaymentController@requestlist')->name('wallet.requestlist');
        Route::get('wallet/requestview/{id?}', 'PaymentController@requestview')->name('wallet.requestview');

        Route::get('wallet/requestlisting', 'PaymentController@requestlisting')->name('wallet.requestlisting');
        

        //settlmenby admin
        Route::get('wallet/transaction_settle', 'PaymentController@transactionSettle')->name('wallet.transactionSettle');
        Route::get('wallet/wallet_transaction_settlement_listing', 'PaymentController@wallet_transaction_settlement_listing')->name('wallet.wallet_transaction_settlement_listing');
        

        //withdra request
        Route::get('wallet/settlement', 'PaymentController@settlement')->name('wallet.settlement');
        Route::get('wallet/settlement_listing', 'PaymentController@settlement_listing')->name('wallet.settlement_listing');
        Route::post('wallet/settlementPost', 'PaymentController@settlementPost')->name('wallet.settlementPost');
        Route::post('wallet/settlementReject', 'PaymentController@settlementReject')->name('wallet.settlementReject');


        Route::get('user/walletlisting', 'UsersController@walletlisting')->name('user.walletlisting');

        Route::get('user/listing', 'UsersController@listing')->name('user.listing');
        Route::get('user/status_update/{id}', 'UsersController@status_update')->name('user.status_update');
        Route::resource('user', 'UsersController')->except(['create', 'store']);

        //transaction
        Route::get('transaction/listing', 'TransactionController@listing')->name('transaction.listing');
        Route::resource('transaction', 'TransactionController')->except(['create', 'store']);

        //        Content Module
        Route::resource('content', 'ContentController')->except(['show', 'create', 'store', 'destroy']);
        Route::get('content/listing', 'ContentController@listing')->name('content.listing');
    });
});
