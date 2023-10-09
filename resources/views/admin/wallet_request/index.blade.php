@extends('layouts.master')
@section('title') @lang('translation.Data_Tables') @endsection
@section('css')
<link href="{{ URL::asset('/assets/admin/jquery-ui/jquery-ui.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')

@include('components.breadcum')

<div class="row">
    <div class="col-12">
        {!! success_error_view_generator() !!}

    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="form-group col-md-3">
                    <label for="username" class="form-label">Sender</label>
                    <div class="input-group auth-pass-inputgroup ">
                        <input type="text" class="form-control" name="sender_name" id="sender_name">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="username" class="form-label">Receiver</label>
                    <div class="input-group auth-pass-inputgroup ">
                        <input type="text" class="form-control" name="receiver_name" id="receiver_name">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="username" class="form-label">Date Filter</label>
                    <div class="input-group auth-pass-inputgroup ">
                        <input class="form-control" type="text" name="datefilter" id="filter_date" value="" />
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
                <div class="table-responsive">
                    <table id="listResults" class="table table-bordered dt-responsive mb-4  nowrap w-100 mb-">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Transaction No</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
                                    <input class="form-control date" type="text" name="transaction_date" id="transaction_date" placeholder="mm/dd/yyyy" value="12/11/2021" aria-invalid="false">
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

@endsection

@section('script')
<!-- Required datatable js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            oTable.draw();
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            oTable.draw();
        });


        $(document).on('keyup', '#sender_name,#receiver_name', function() {
            oTable.draw();
        })


        oTable = $('#listResults').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                "url": "{{route('admin.wallet.requestlisting')}}",
                "data": function(d) {
                    d.sender_name = $('#sender_name').val();
                    d.receiver_name = $('#receiver_name').val();
                    d.date_filter = $('#filter_date').val();
                }
            },

            "columns": [{
                    "data": "id",
                    searchable: false,
                    sortable: false
                },


                {
                    "data": "sender_id",
                    sortable: false
                },
                {
                    "data": "receiver_id",
                    sortable: false
                },


                {
                    "data": "transaction_number",
                    sortable: false
                },
                {
                    "data": "created_at",
                    sortable: false
                },
                {
                    "data": "status",
                    sortable: false
                },
                {
                    "data": "amount",
                    sortable: false
                },
                {
                    "data": "action",
                    sortable: false
                }

            ]
        });
    });
</script>
@endsection