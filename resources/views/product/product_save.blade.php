@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<style>
  .error{
    color: red;
  }
  .required:after {
    content:" *";
    color: red;
  }
</style>
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
                <form action="{{route('product-save')}}" method="post" name="product-add" id="product_add" enctype="multipart/form-data">
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
                        <span class="pip"><img class="imageThumb" width= "50px" height="50px" src="{{ asset('storage/images/' . basename($proImages['p_image'])) }}"  title=""> <span class="btn btn-danger remove" onclick="removeImage({{$proImages['id']}})">Remove image</span></span>
                        @endforeach
                    @endif

                    <div class="mb-3 input-group repeatDiv" id="repeatDiv">
                      <input type="file" class="form-control" name="file[]" placeholder="Enter Title" onchange="previewImage(this)">
                    </div>

                    <div class="mb-3 input-group">
                      <button type="button" class="btn btn-info" id="repeatDivBtn" data-increment="1">Add More Input</button>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-secondary" href="{{route('product-list')}}"> {{ __('Back') }}</a>
                    </div>
                </form>                  
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {
// Client side validation


$("#product_add").validate({
    rules: {
        p_name: {
            required: true
        },
        p_code: {
            required: true
        },
        p_package: {
            required: true
        },
        p_quantity:{
          required: true
        },
        p_description:{
          required: true
        }
    },
    messages: {
        p_name: {
            required: "Please enter your product Name",
        },
        p_code: {
            required: "Please enter your product Code",
        },
        p_package: {
            required: "Please enter your product package",
        },
        p_quantity:{
          required: "Please enter your product Quantity",
        },
        p_description:{
          required: "Please enter your product Description",
        }
    },
    submitHandler: function(form) {
      console.log(form);
        form.submit();
    }
});

// Add more button Jquery
$("#repeatDivBtn").click(function () {
    $newid = $(this).data("increment");
    $repeatDiv = $("#repeatDiv").wrap('<div/>').parent().html();
    $('#repeatDiv').unwrap();
    $($repeatDiv).insertAfter($(".repeatDiv").last());
    $(".repeatDiv").last().attr('id',   "repeatDiv" + '_' + $newid);
    $("#repeatDiv" + '_' + $newid).append('<div class="input-group-append"><button type="button" class="btn btn-danger removeDivBtn" data-id="repeatDiv'+'_'+ $newid+'">Remove</button></div>');
    $("#"+"repeatDiv_"+ $newid+" span").remove();
    $newid++;
    $(this).data("increment", $newid);

});

$(document).on('click', '.removeDivBtn', function () {
    $divId = $(this).data("id");
    $("#"+$divId).remove();
    $inc = $("#repeatDivBtn").data("increment");
    $("#repeatDivBtn").data("increment", $inc-1);
  });
});

function previewImage(file){
  if (file.files && file.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("<span class=\"pip\">" + "<img class=\"imageThumb\" width= \"50px\" height=\"50px\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "<br/><span class=\"btn btn-danger remove\">Remove image</span>" + "</span>").insertAfter(file); $(".remove").click(function(){
            console.log(file);
            $(file).val('');
            $(this).parent(".pip").remove();
          });
        }
        reader.readAsDataURL(file.files[0]);
  }
}

function removeImage(image){
  var mode = $('#mode').val();
  var oldimage = $('#oldimages').val();
  if(mode == 'edit'){
    var hiddenField = document.getElementById('oldimages');
    // Append the new value to the existing value
    if(oldimage == ''){
      hiddenField.value += image;
    }else{
      hiddenField.value += ','+image;
    }
  }
  $(this).parent(".pip").remove();
}

</script>
@endsection