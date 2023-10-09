@extends('layouts.master')

@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/assets/admin/vendors/general/datatable/jquery.dataTables.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@include('components.breadcum')
<div class="row">
    <div class="col-md-3">
        <div class="card ">
            <div class="card-body">
                <div class="card-title">
                    <h3 style="text-align:center;">Receiver</h3>
                    <div class="kt-widget__media text-center w-100">
                       
                        <input type="hidden" id="user_id" value="{{$data->id}}" />
                        {!! get_fancy_box_html($data->senderUser->profile_image) !!}
                    </div>
                </div>
                <div class="kt-widget__info  text-left">
                    <span class="kt-widget__label font-weight-bold">Name:</span>
                    <a href="#" class="text-right">{{$data->senderUser->name}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Email:</span>
                    <a href="#" class="kt-widget__data">{{$data->senderUser->email}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Username:</span>
                    <a href="#" class="kt-widget__data">{{$data->senderUser->username}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">is Sender:</span>
                    <a href="#" class="kt-widget__data">@if($data->senderUser->is_sender)  Yes @else No @endif</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Dob:</span>
                    <a href="#" class="kt-widget__data">{{ general_date($data->senderUser->dob) }}</a>
                </div>
                
                <div class="kt-widget__info">
                    <span class="font-weight-bold">status:</span>
                    <span class="kt-widget__data">{!! user_status($data->senderUser->status,$data->senderUser->deleted_at) !!}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card ">
            <div class="card-body">
                <div class="card-title">
                <h3 style="text-align:center;">Sender</h3>
                    <div class="kt-widget__media text-center w-100">
                        <input type="hidden" id="user_id" value="{{$data->id}}" />
                        {!! get_fancy_box_html($data->receiverUser->profile_image) !!}
                    </div>
                </div>
                <div class="kt-widget__info  text-left">
                    <span class="kt-widget__label font-weight-bold">Name:</span>
                    <a href="#" class="text-right">{{$data->receiverUser->name}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Email:</span>
                    <a href="#" class="kt-widget__data">{{$data->receiverUser->email}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Username:</span>
                    <a href="#" class="kt-widget__data">{{$data->receiverUser->username}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">is Sender:</span>
                    <a href="#" class="kt-widget__data">@if($data->receiverUser->is_sender)  Yes @else No @endif</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Dob:</span>
                    <a href="#" class="kt-widget__data">{{ general_date($data->receiverUser->dob) }}</a>
                </div>
                
                <div class="kt-widget__info">
                    <span class="font-weight-bold">status:</span>
                    <span class="kt-widget__data">{!! user_status($data->receiverUser->status,$data->receiverUser->deleted_at) !!}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card ">
            <div class="card-body">
                <div class="card-title">
                <h3 style="text-align:center;">Transaction Detail</h3>
                    
                </div>
                <div class="kt-widget__info  text-left">
                    <span class="kt-widget__label font-weight-bold">Transaction Number:</span>
                    <a href="#" class="text-right">{{$data->transaction_number}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Message:</span>
                    <a href="#" class="kt-widget__data">{{$data->message}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Amount:</span>
                    <a href="#" class="kt-widget__data">{{$data->amount}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Status:</span>
                    <a href="#" class="kt-widget__data">{{ucfirst( transactionStatus($data->status))}}</a>
                </div>

                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Date:</span>
                    <a href="#" class="kt-widget__data">{{  $data->created_at }}</a>
                </div>
                
                
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('script')
<script src="{{asset('/assets/admin/vendors/general/datatable/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function () {

        walletTable = $('#wallet_history_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                "url": "{{route('admin.user.walletlisting')}}",
                "data": function(d) {
                    d.user_id = $('#user_id').val();
                }
            },
            "columns": [
                {
                    "data": "id",
                    searchable: false,
                    sortable: false
                },
                {
                    "data": "transaction_no",
                    sortable: false
                },
                {
                    "data": "amount",
                    sortable: false
                },
                {
                    "data": "message",
                    sortable: false
                },
                {
                    "data": "status",
                    sortable: false
                },
                {
                    "data": "created_at",
                    sortable: false
                }
            ]
                
            });



    });

    

</script>
@endsection
