@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product')}} {{isset($mode) && $mode =='edit' ? 'Edit':'Add' }}</div>
            </div>
        </div>
    </div>
    &nbsp;
    <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="">
                <form action="{{route('products.store')}}" method="post" name="product-add" id="product_add" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="mode" id="mode" value="{{$mode??'create'}}">
                    <input type="hidden" name="id" value="{{$product->id??0}}">
                    <input type="hidden" id="oldimages" name="oldimages" value="">
                    <div class="form-group">
                      <label class="required" for="p_name">Product Name:</label>
                      <input name="p_name" class="form-control" id="p_name" value="{{$product->p_name??''}}">
                      <div class="error" id="p_name_error">{{ $errors->first('p_name')??'' }}</div>
                    </div>
                    <div class="form-group">
                      <label class="required" for="p_code">Product Code:</label>
                      <input name="p_code" class="form-control" id="p_code" value="{{$product->p_code??''}}">
                      <div class="error" id="p_code_error">{{ $errors->first('p_code')??'' }}</div>
                    </div>
                    <div class="form-group">
                      <label class="required" for="p_package">Product Package:</label>
                      <select class="form-control" name="p_package">
                        <option value="">Select</option>
                        @foreach($packages as $package)
                          <option value="{{$package->name}}" @if(isset($product->p_package) && $product->p_package == $package->name) selected @endif> {{ $package->name}}</option>
                        @endforeach
                      </select>
                      <div class="error" id="p_package_error">{{ $errors->first('p_package')??'' }}</div>
                    </div>
                    <div class="form-group">
                      <label class="required" for="p_quantity">Product Quantity:</label>
                      <input name="p_quantity" class="form-control" id="p_quantity" value="{{$product->p_quantity??''}}">
                      <div class="error" id="p_quantity_error">{{ $errors->first('p_quantity')??'' }}</div>
                    </div>
                    <div class="form-group">
                      <label class="required" for="p_description">Product Description:</label>
                      <textarea name="p_description" class="form-control" id="p_description">{{$product->p_description??''}}</textarea>
                      <div class="error" id="p_description_error">{{ $errors->first('p_description')??'' }}</div>
                    </div>
                    <div class="row">
                    <div class="field" align="left">
                    <h3>Upload your images</h3>
                    </div>
                    @if(isset($mode) && $mode == 'edit')
                        @foreach($productImages as $proImages)
                        <span class="pip" id="image_{{$proImages['id']}}"><img class="imageThumb" width= "50px" height="50px" src="{{ asset('storage/images/' . basename($proImages['p_image'])) }}"  title=""> <span class="btn btn-danger remove" onclick="removeImage({{$proImages['id']}})">Remove image</span></span>
                        @endforeach
                    @endif

                    <div class="mb-3 input-group repeatDiv" id="repeatDiv">
                      <input type="file" class="form-control" name="file[]" placeholder="Enter Title" onchange="previewImage(this)">
                    </div>

                    <div class="mb-3 input-group">
                      <button type="button" class="btn btn-info" id="repeatDivBtn" data-increment="1">Add More Image</button>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-secondary" href="{{route('products.index')}}"> {{ __('Back') }}</a>
                    </div>
                </form>                  
            </div>
        </div>
    </div>
</div>
@include('admin.js')
<script>
    var getProduct = `{{ route('get-product') }}`;
    var storeProduct = `{{ route('products.store') }}`;
</script>
<script src="{{ asset('assets/js/admin/product.js') }}"></script>
@endsection