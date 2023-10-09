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
     <div class="card">
            <div class="card-body">
            
            
            
                    <div class="row">
                       
                        <div class="form-group col-md-6">
                            <label for="username" class="form-label">User Type</label>
                            <div class="input-group auth-pass-inputgroup ">
                                <select class="form-select" id="user_type" name="user_type" >
                                    <option value="" selected>All</option>
                                    <option value="1" >Sender</option>
                                    <option value="0">Receiver</option>
                                   
                                </select>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive ">
                <table id="listResults" class="table table-bordered dt-responsive mb-4  nowrap w-100 mb-">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Profile Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Is Sender</th>
                            <th>Status</th>
                            <th>Action</th>
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
        $('#user_type').change(function() {
            oTable.draw();
        });

        oTable = $('#listResults').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                "url": "{{route('admin.user.listing')}}",
                "data": function(d) {
                    d.user_type = $('#user_type').val();
                }
            },
           
            "columns": [{
                    "data": "id",
                    searchable: false,
                    sortable: false
                },
                {
                    "data": "profile_image",
                    searchable: false,
                    sortable: false
                },
                {
                    "data": "name",
                },
                // {"data": "username", sortable: false},
                {
                    "data": "email",
                    sortable: false
                },
                {
                    "data": "username",
                },
                {
                    "data": "is_sender",
                },
                {
                    "data": "status",
                    searchable: false,
                    sortable: false
                },
               
                
                {
                    "data": "action",
                    searchable: false,
                    sortable: false
                }
            ]
        });
    });
</script>
@endsection