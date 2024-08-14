@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product List') }}</div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
            <div class="col-md-8">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            &nbsp;
                <a class="btn btn-primary" href="{{route('product-create')}}"> {{ __('Product Add') }}</a>
            </div>
            <div class="col-md-8">
                &nbsp;
                <div class="card">
                    <table class="table">
                        <tr>
                            <td>Product Code</td>
                            <td>Product Name</td>
                            <td>Product Package (in KG)</td>
                            <td>Product Quantity</td>
                            <td>Action</td>
                        <tr>        
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->p_code}}</td>
                                <td>{{$product->p_name}}</td>
                                <td>{{$product->p_package}}</td>
                                <td>{{$product->quantity}}</td>
                                <td> <a class="btn btn-primary" href="{{route('product-edit',$product->id)}}">Edit </a> <a class="btn btn-danger" href="{{route('product-delete',$product->id)}}">Delete </a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
