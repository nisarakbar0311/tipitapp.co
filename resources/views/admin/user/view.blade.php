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
                    <div class="kt-widget__media text-center w-100">
                        <input type="hidden" id="user_id" value="{{$data->id}}" />
                        {!! get_fancy_box_html($data->profile_image) !!}
                    </div>
                </div>
                <div class="kt-widget__info  text-left">
                    <span class="kt-widget__label font-weight-bold">Name:</span>
                    <a href="#" class="text-right">{{$data->name}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Email:</span>
                    <a href="#" class="kt-widget__data">{{$data->email}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Username:</span>
                    <a href="#" class="kt-widget__data">{{$data->username}}</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">is Sender:</span>
                    <a href="#" class="kt-widget__data">@if($data->is_sender)  Yes @else No @endif</a>
                </div>
                <div class="kt-widget__info">
                    <span class="kt-widget__label font-weight-bold">Dob:</span>
                    <a href="#" class="kt-widget__data">{{ general_date($data->dob) }}</a>
                </div>
                
                <div class="kt-widget__info">
                    <span class="font-weight-bold">status:</span>
                    <span class="kt-widget__data">{!! user_status($data->status,$data->deleted_at) !!}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card ">
            <div class="card-body">
                <div class="card-title">
                    <span>All Transactions</span>

                    <span>-Balance (${{walletBalance($data->id)}})<span>
                </div>
                <div>
                <div class="table-responsive">
                    <table id="wallet_history_table" class="table table-bordered dt-responsive mb-4  nowrap w-100 mb-">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Transaction</th>
                                <th>Amount</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
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
