$(function () {
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

var table = $("#product_table").DataTable({
    processing: true,
    serverSide: true,
    columnDefs: [
        {
            searchable: true,
        },
    ],
    ajax: {
        url: getProduct,
        data: function (d) {
          d.search = $(".search-name").val();
      },
    },
    aaSorting: [
                [0, 'desc']
            ],
    columns: [
        { data: "id"},
        { data: "p_code"},
        { data: "p_name"},
        { data: "p_package"},
        { data: "p_quantity",orderable: false,
            searchable: false,},
        {
            data: "action",
            orderable: false,
            searchable: false,
        },
    ],
    lengthMenu: [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"],
    ],
});

$("body").on("click", ".searchName", function () {
  console.log('hello');
  table.draw();
});

$("body").on("click", ".clearName", function () {
  $(".search-name").val('')
  $(this).addClass('d-none');
  table.draw();
});

$('.search-name').on('keyup', function () {
  if ($(this).val().length > 0) {
      $('.clearName').removeClass('d-none');
  } else {
      $('.clearName').addClass('d-none');
  }
});

$("body").on("click", ".deleteProduct", function () {
  var id = $(this).data("id");
  swal({
      title: `Are you sure you want to delete this record?`,
      text: "If you delete this, it will be gone forever.",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  }).then((willDelete) => {
      if (willDelete) {
          $.ajax({
            type: "post",
            url: $(this).data('route'),
            data: {
              '_method': 'delete'
            },
              success: function (data) {
                  toastr.success(data.message);
                  table.draw();
              },
              error: function (data) {
                  toastr.error(data);
              },
          });
      }
  });
});
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
                required: "Please enter your Product Name",
            },
            p_code: {
                required: "Please enter your Product Code",
            },
            p_package: {
                required: "Please enter your Product package",
            },
            p_quantity:{
              required: "Please enter your Product Quantity",
            },
            p_description:{
              required: "Please enter your Product Description",
            }
        },
        submitHandler: function(form) {
          console.log(form);
            form.submit();
        }
    });
});

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
      $("<span class=\"pip\">" + "<img class=\"imageThumb\" width= \"50px\" height=\"50px\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "<br/>" + "</span>").insertAfter(file); $(".remove").click(function(){
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
  var hiddenField = document.getElementById('oldimages');
  // Append the new value to the existing value
  if(oldimage == ''){
    hiddenField.value += image;
  }else{
    hiddenField.value += ','+image;
  }
  $('#image_'+image).remove();
}


