@extends('layouts.app')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product List') }}</div>
            </div>
        </div>
    </div>
    &nbsp;
    <div class="row justify-content-center">
            <div class="col-md-8">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            &nbsp;
                <a class="btn btn-primary" href="{{route('products.create')}}"> {{ __('Product Add') }}</a>
            </div>
            <div class="col-md-8">
                &nbsp;
                <div class="card">
                <div class="card-title">
                    <div class="col-md-4 d-flex align-items-center position-relative my-1">
                        <input type="text" name="search" class="form-control search-name form-control-solid w-250px ps-14 me-2" placeholder="Search">
                        <button class="btn btn-primary btn-sm searchName me-2" id="search">
                        <span class="svg-icon svg-icon-2">
                        </span>
                        Search
                    </button>
                    <button class="btn btn-danger btn-sm clearName d-none" id="clear">
                        <span class="svg-icon svg-icon-2">
                        </span>
                        Clear
                    </button>
                    </div>
                    

                </div>
                    <table id="product_table" class="display" style="width:100%">
                        <thead>
                                <th>Id</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Product Package (in KG)</th>
                                <th>Product Quantity</th>
                                <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var getProduct = `{{ route('get-product') }}`;
    var storeProduct = `{{ route('products.store') }}`;
</script>
@include('admin.js')
<script src="{{ asset('assets/js/admin/product.js') }}"></script>
@endsection
