
@extends('layouts.admin.app')

@section('h_style')
    <style>
        .login_bg_main {
            background-image: url({{asset('assets/admin/images/misc/bg-1.jpg')}});
        }
    </style>
@endsection

@section('content')
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor login_bg_main">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container" style="width: 100%">
                        <div class="kt-login__logo">
                                    <h1  style="color:white;">{{ ucfirst($content->title) }}</h1> 
                        </div>
                        <div style="color:white;">
                            {!!$content->content !!}
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


