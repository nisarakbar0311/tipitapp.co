@extends('layouts.master')
@section('title') @lang('translation.Data_Tables') @endsection
@section('css')
<link href="{{ URL::asset('/assets/admin/jquery-ui/jquery-ui.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

@include('components.breadcum')

<div class="row">
    <div class="col-12">
        {!! success_error_view_generator() !!}
        <div class="card mb-0">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#pending" role="tab" aria-selected="true"> <span class="d-block d-sm-none"><i class="fas fa-home"></i></span> <span class="d-none d-sm-block">Withdraw Request</span> </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#approve" role="tab" aria-selected="false"> <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span> <span class="d-none d-sm-block">Withdraw Settlement</span> </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content p-0 text-muted">
            <div class="tab-pane active mt-0" id="pending" role="tabpanel">
                <div class="card">
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table id="listResults" class="table table-bordered dt-responsive mb-4  nowrap w-100 mb-">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>UserName</th>
                                        <th>User Email</th>
                                        <th>Bank Name</th>
                                        <th>Account Holder Name</th>
                                        <th>Account Number</th>
                                        <th>Routing No</th>
                                        <th>Amount</th>
                                         <th>Admin Commision</th>
                                        <th>Withdraw Status</th>
                                        <th>Withdraw Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>

            <div class="tab-pane" id="approve" role="tabpanel">


                <div class="card">
                    <div class="card-body pt-0">

                        <div class="table-responsive">
                            <table id="listResults1" class="table table-bordered dt-responsive mb-4  nowrap w-100 mb-">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>UserName</th>
                                        <th>User Email</th>
                                        <th>Bank Name</th>
                                        <th>Account Holder Name</th>
                                        <th>Account Number</th>
                                        <th>Routing No</th>
                                        <th>Amount</th>
                                        <th>Admin Commision</th>
                                        <th>Withdraw Status</th>
                                        <th>Withdraw Date</th>
                                        <th>Transaction No</th>
                                        <th>Transaction Date</th>
                                        <th>Reason</th>

                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>
    <div class="card">
        <div class="card-body">
            <div class="">
                <div class="wd-sl-tableup justify-content-end">
                    <div class="wd-sl-btngrp">

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Transaction Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal wd-sl-formcontrols general_form" name="transaction_form" id="transaction_form" method="post" enctype="multipart/form-data" action="{{route('admin.wallet.settlementPost')}}">

                    {{csrf_field()}}
                    <input type="hidden" name="wallet_settlemnt_id" id="wallet_settlemnt_id" value="0" />
                    <div class="wd-sl-creatform my-auto ml-0 mr-0 w-100">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="username" class="form-label">Transaction Number</label>
                                <div class="input-group auth-pass-inputgroup ">
                                    <input name="transaction" id="transaction" type="text" class="form-control" placeholder="8648658486" autocomplete="off">
                                </div>
                                <span class="small highlight_transaction"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username" class="form-label">Transaction Date</label>
                                <div class="input-group auth-pass-inputgroup ">
                                    <input class="form-control date" type="text" name="transaction_date" id="transaction_date" placeholder="mm/dd/yyyy" value="{{date('m/d/Y')}}" aria-invalid="false">
                                </div>
                                <span class="small highlight_transaction_date"></span>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light general_modal_submit_btn">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- sample modal content -->
<div id="rejectModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Reject Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal wd-sl-formcontrols" name="reject_form" id="reject_form" method="post" enctype="multipart/form-data" action="{{route('admin.wallet.settlementReject')}}">

                    {{csrf_field()}}
                    <input type="hidden" name="wallet_settlemnt_id_reject" id="wallet_settlemnt_id_reject" value="0" />
                    <div class="wd-sl-creatform my-auto ml-0 mr-0 w-100">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="username" class="form-label">Reason</label>
                                <div class="input-group auth-pass-inputgroup ">
                                    <textarea name="reason" id="reason" class="form-control" required></textarea>
                                </div>
                                <span class="small highlight_reason"></span>
                            </div>
                        </div>


                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light general_modal_submit_btn_reject">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Required datatable js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    function transactionFormSubmit() {

        $("#transaction_form").validate({
            rules: {
                transaction: {
                    required: true,
                },
                transaction_date: {
                    required: true,
                },

            },
            messages: {
                transaction: {
                    required: 'Please enter transaction number'
                },
                trailer_name: {
                    required: 'Please enter transaction date'
                },
            },
            onfocusout: function(element) {
                $(element).valid();
            },
            errorElement: 'span',
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorPlacement: function(error, element) {
                error.appendTo('.highlight_' + element.attr("name"));
            },
            invalidHandler: function(event, validator) {
                var alert = $('#kt_form_1_msg');
                alert.removeClass('kt--hide').show();

            },
            submitHandler: function(form) {
                addOverlay();
                //form.submit();
                var urldata = $('#transaction_form').attr('action');

                var formData = new FormData($('#transaction_form')[0]);
                $.ajax({
                    type: 'POST',
                    url: urldata,
                    //async: false,
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('value')
                    },
                    beforeSend: function() {

                    },
                    success: function(returnData) {
                        if (returnData.status) {
                            $('#myModal').modal('hide');
                            show_toastr_notification(returnData.msg);
                            oTable.draw();
                            oTable1.draw();
                            return;
                        }
                        show_toastr_notification('something went wrong', 412);

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        //$form.find('button[type="submit"]').text('Submit').removeAttr('disabled');
                        swal('error', 'something went wrong', 'error');
                    },
                    complete: function() {
                        removeOverlay();
                    }
                });
            }
        });

    }


    function rejectFormSubmit() {
       
        $("#reject_form").validate({
            rules: {
                reason: {
                    required: true,
                    maxlength: 100
                }

            },
            messages: {
                reason: {
                    required: 'Please enter reason'
                }
            },
            onfocusout: function(element) {
                $(element).valid();
            },
            errorElement: 'span',
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorPlacement: function(error, element) {
                error.appendTo('.highlight_' + element.attr("name"));
            },
            invalidHandler: function(event, validator) {
                var alert = $('#kt_form_1_msg');
                alert.removeClass('kt--hide').show();

            },
            submitHandler: function(form) {
                addOverlay();
                //form.submit();
                var urldata = $('#reject_form').attr('action');

                var formData = new FormData($('#reject_form')[0]);
                $.ajax({
                    type: 'POST',
                    url: urldata,
                    //async: false,
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('value')
                    },
                    beforeSend: function() {

                    },
                    success: function(returnData) {
                        if (returnData.status) {
                            $('#rejectModal').modal('hide');
                            show_toastr_notification(returnData.msg);
                            oTable.draw();
                            oTable1.draw();
                            return;
                        }
                        show_toastr_notification('something went wrong', 412);

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        //$form.find('button[type="submit"]').text('Submit').removeAttr('disabled');
                        swal('error', 'something went wrong', 'error');
                    },
                    complete: function() {
                        removeOverlay();
                    }
                });
            }
        });

    }


    $(document).ready(function() {
        loadDate();

        $(document).on('click', '.transaction_settlment_btn', function() {
            $('#transaction_form')[0].reset();
            var transactionId = $(this).data('id');
            $('#wallet_settlemnt_id').val(transactionId);
            transactionFormSubmit();

        });

        $(document).on('click', '.reject_settlment_btn', function() {
            $('#reject_form')[0].reset();
            var transactionId = $(this).data('id');
            $('#wallet_settlemnt_id_reject').val(transactionId);
            rejectFormSubmit();

        });


        $(document).on('click', '.general_modal_submit_btn', function() {
            $('.general_form').submit();
        });

        $(document).on('click', '.general_modal_submit_btn_reject', function() {
            $('#reject_form').submit();
        });

        



        oTable = $('#listResults').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": "{{route('admin.wallet.settlement_listing')}}",
            "columns": [{
                    "data": "id",
                    searchable: false,
                    sortable: false
                },


                {
                    "data": "user_id",
                    sortable: false
                },
                {
                    "data": "email",
                    sortable: false
                },
                {
                    "data": "bank_name",
                    sortable: false
                },


                {
                    "data": "account_holder_name",
                    sortable: false
                },
                {
                    "data": "account_no",
                    sortable: false
                },
                {
                    "data": "bank_routing_no",
                    sortable: false
                },
                {
                    "data": "withdraw_amount",
                    sortable: false
                },
                {
                    "data": "admin_commision",
                    sortable: false
                },
                
                {
                    "data": "withdraw_status",
                    sortable: false
                },
                {
                    "data": "withdraw_date",
                    sortable: false
                },
                {
                    "data": "action",
                    sortable: false
                }


            ]
        });

        oTable1 = $('#listResults1').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": "{{route('admin.wallet.wallet_transaction_settlement_listing')}}",
            "columns": [{
                    "data": "id",
                    searchable: false,
                    sortable: false
                },


                {
                    "data": "user_id",
                    sortable: false
                },
                {
                    "data": "email",
                    sortable: false
                },
                {
                    "data": "bank_name",
                    sortable: false
                },


                {
                    "data": "account_holder_name",
                    sortable: false
                },
                {
                    "data": "account_no",
                    sortable: false
                },
                {
                    "data": "bank_routing_no",
                    sortable: false
                },
                {
                    "data": "withdraw_amount",
                    sortable: false
                },
                {
                    "data": "admin_commision",
                    sortable: false
                },
                {
                    "data": "withdraw_status",
                    sortable: false
                },
                {
                    "data": "withdraw_date",
                    sortable: false
                },
                {
                    "data": "transaction_number",
                    sortable: false
                },
                {
                    "data": "transaction_date",
                    sortable: false
                },
                {
                    "data": "reason",
                    sortable: false
                },
                


            ]
        });
    });
</script>
@endsection