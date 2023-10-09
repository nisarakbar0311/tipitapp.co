@extends('layouts.master')
@section('title') @lang('translation.Data_Tables') @endsection
@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/assets/admin/vendors/general/datatable/jquery.dataTables.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
@endsection
@section('content')

@include('components.breadcum')

<div class="row">
    <div class="col-12">
        {!! success_error_view_generator() !!}

    </div>
    <!-- <div class="card">
            <div class="card-body">
                <div class="row">

                        <div class="form-group col-md-6">
                            <label for="username" class="form-label">Transaction Type</label>
                            <div class="input-group auth-pass-inputgroup ">
                                <select class="form-select" id="transaction_type" name="transaction_type" >
                                    <option value="">All</option>
                                    <option value="admin" selected>Admin</option>
                                    <option value="user">User</option>

                                </select>
                            </div>
                        </div>
                    </div>

            </div>
        </div> -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive ">
                <table id="listResults" class="table table-bordered dt-responsive mb-4  nowrap w-100 mb-">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>UserName</th>
                            <th>Transaction Number</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- Required datatable js -->
<script src="{{asset('/assets/admin/vendors/general/validate/jquery.validate.min.js')}}"></script>
<script src="{{asset('/assets/admin/vendors/general/datatable/jquery.dataTables.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function() {
        oTable = $('#listResults').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                "url": "{{route('admin.transaction.listing')}}",
                "data": function(d) {
                    d.transaction_type = $('#transaction_type').val();
                }
            },

            "columns": [{
                    "data": "id",
                    searchable: false,
                    sortable: false
                },
                {
                    "data": "user_id",
                    searchable: false,
                    sortable: false
                },
                {
                    "data": "transaction_number",
                    searchable: false,
                    sortable: false
                },
                {
                    "data": "amount",
                    sortable: false
                },
                // {"data": "username", sortable: false},
                {
                    "data": "payment_status",
                    sortable: false
                },
                {
                    "data": "created_at",
                    sortable: false
                }

            ]
        });

        $('#transaction_type').change(function() {
            oTable.draw();
        });
    });
</script>
@endsection
