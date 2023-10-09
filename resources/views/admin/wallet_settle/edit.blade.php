@extends('layouts.master')

@section('css')
<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@section('title')
@lang('translation.Form_Layouts')
@endsection @section('content')
@include('components.breadcum')
<div class="row">
    <div class="col-12">
    </div>
    <div class="card">
        <div class="card-body">
            <form class="" name="main_form" id="main_form" method="post" action="{{route('admin.vehicalType.update',$data->id)}}" enctype="multipart/form-data">
                {!! get_error_html($errors) !!}
                @csrf
                @method('PATCH')

                <div class="mb-3 row">
                    <label for="example-text-input" class="col-md-2 col-form-label"><span class="text-danger">*</span>Category</label>
                    <div class="col-md-10">
                        <select class="form-control select2-templating" name="category" id="category">
                            @foreach($category as $cat)
                             <option value="{{$cat->id}}"  @if($data->category_id == $cat->id) selected @endif> {{$cat->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="formFile" class="col-md-2 col-form-label"><span class="text-danger">*</span>Type Image</label>
                    <div class="col-md-8">
                        <input class="form-control" type="file" id="type_image" name="type_image" accept="image/*">
                    </div>
                    <div class="col-md-2">
                        <a href="{{asset($data->type_image)}}" target="_blanck"><img src="{{asset($data->type_image) }}" width="50"/></a>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="example-text-input" class="col-md-2 col-form-label"><span class="text-danger">*</span>Vehical Type</label>
                    <div class="col-md-10">
                        <input type="text" name="vehical_type" id="vehical_type" class="form-control" maxlength="255"   value="{{$data->vehical_type}}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="example-text-input" class="col-md-2 col-form-label"><span class="text-danger">*</span>Base Price</label>
                    <div class="col-md-10">
                        <input type="text" name="base_price" id="base_price" class="form-control" maxlength="255"  value="{{$data->base_price}}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="example-text-input" class="col-md-2 col-form-label"><span class="text-danger">*</span>Price per km</label>
                    <div class="col-md-10">
                        <input type="text" name="price_per_km" id="price_per_km" class="form-control" maxlength="255"  value="{{$data->price_per_km}}">
                    </div>
                </div>

               


                <div class="kt-portlet__foot">
                    <div class=" ">
                        <div class="row">
                            <div class="wd-sl-modalbtn">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="save_changes">Submit</button>
                                <a href="{{route('admin.vehicalType.index')}}" id="close"><button type="button" class="btn btn-outline-secondary waves-effect">Cancel</button></a>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection


@section('script')
<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script>
  
    $(function() {
        let id = "{{$data->id}}";

        $("#main_form").validate({
            rules: {
                vehical_type: {
                    required: true
                },
                type_image: {
                    required: true
                },
                base_price: {
                    required: true
                },
                price_per_km: {
                    required: true
                }
            },
            messages: {
                collection_name: {
                    required: "Please enter collection name"
                },
                url: {
                    required: "Please enter url"
                },
            },
            submitHandler: function(form) {
                addOverlay();
                form.submit();
            }
        });
    });
</script>
@endsection