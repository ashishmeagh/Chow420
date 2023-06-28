@extends('buyer.layout.master')
@section('main_content')

<style type="text/css">
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
</style>


<div class="my-profile-pgnm">
  Add Forum Post

     <ul class="breadcrumbs-my">
     <li><a href="{{url('/')}}">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/buyer/posts">My Forum Posts</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Add Forum Post</li>
    </ul>
</div> 
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">

<div class="main-my-profile"> 
   <div class="innermain-my-profile add-product-inrs space-o" style="padding-top: 30px;">
    <form id="validation-form">
        {{ csrf_field() }}
   {{-- <div class="profile-img-block">
        <div class="pro-img"><img src="{{url('/')}}/assets/images/default-product-image.png" class="img-responsive img-preview" alt=""/></div>                            
        <div class="update-pic-btns">
            <button class="up-btn"> <span><i class="fa fa-camera"></i></span></button>
            <input style="height: 100%; width: 100%; z-index: 99;" id="logo-id" name="product_image"  type="file" class="attachment_upload" data-parsley-required=true data-parsley-required-message="Please Upload file">
        </div> 
        <div class="upload-product-img">Upload Product Image</div>                           
    </div>  --}}
       <div class="row">  
         <h4> <span id="showerr"></span> </h4>

            <div class="col-md-12">
                 <div class="form-group">
                    <label for="container_id">Forum Container <span>*</span></label>
                    <div class="select-style">
                        <select class="frm-select" name="container_id" id="container_id"  data-parsley-required ='true' data-parsley-required-message="Please select forum container">
                            <option value="">Select forum container</option>
                            @foreach($arr_container as $container)
                              <option value="{{ $container['id'] or ''}}">{{ $container['title'] or '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

          <div class="col-md-12">
                 <div class="form-group">
                    <label for="product_name">Title <span>*</span></label>
                    <input type="text" name="title" id="title" class="input-text" placeholder="Enter forum post title" data-parsley-required-message="Please enter forum post title" data-parsley-required ='true'>
                </div>
          </div>

        

           
           {{--  <div class="col-md-12">
                 <div class="form-group">
                    <label for="description"> Description <span>*</span></label>
                    <textarea name="description" id="description" placeholder="Enter forum post description" data-parsley-required ='true' data-parsley-required-message="Please enter forum post description"></textarea>
                </div>
            </div>  --}}
          

            <input type="hidden" id="checkbox5" name="is_active" value="1" />
           
                  
            <div class="col-md-12">
                <div class="button-list-dts">
                    <a href="javascript:void(0)" class="butn-def" id="btn_add">Add</a>
                    <a href="{{ url('/') }}/buyer/posts" class="butn-def cancelbtnss">Back</a>
                </div>
            </div>
       </div>
   </form>
   </div>
</div>
</div>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

<script type="text/javascript">
  var SITE_URL  = "{{ url('/')}}";
  function check_price_drop() {
    
    var unit_price = parseFloat($('#unit_price').val());
    var price_drop_to =parseFloat($('#price_drop_to').val());
    
    if(price_drop_to >= unit_price){
        $('#price_drop_error').html('Price Drop should not be greater than or equal Unit Price').css('color','red');
        $('#btn_add').attr('disabled',true);

        
    }else{
        $('#price_drop_error').html('').css('color','black');
        $('#btn_add').attr('disabled',false);

    }
}
  $(document).ready(function()
  {
    
     

    var csrf_token = $("input[name=_token]").val(); 


    $('#btn_add').click(function()
    {
        var flag=0;
        if($('#validation-form').parsley().validate()==false) return;

        if(flag==0){
    
        $.ajax({                  
          url: SITE_URL+'/buyer/posts/save',
          data: new FormData($('#validation-form')[0]),
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
          beforeSend : function()
          { 
            showProcessingOverlay();        
          },
          success:function(data)
          {
             hideProcessingOverlay(); 
             if('success' == data.status)
             {
              
                $('#validation-form')[0].reset();

                  swal({
                         title:'Success',
                         text: data.description,
                         type: data.status,
                         confirmButtonText: "OK",
                         closeOnConfirm: false
                      },
                     function(isConfirm,tmp)
                     {
                       if(isConfirm==true)
                       {
                          window.location = data.link;
                       }
                     });
              }
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   
       }else{
         return false;
       }

    });

  });




   function get_second_level_category()
  {
      var first_level_category_id  = $('#first_level_category_id').val();

      $.ajax({
              url:SITE_URL+'/seller/product/get_second_level_category',
              type:'GET',
              data:{
                      first_level_category_id:first_level_category_id,
                      _token:$("input[name=_token]").val()
                    },
              dataType:'JSON',
              beforeSend: function() {
                showProcessingOverlay(); 
              },
              success:function(response)
              { 
                  hideProcessingOverlay();                   
                  var html = '';
                  html +='<option value="">Select Subcategory</option>';
                   
                  for(var i=0; i < response.second_level_category.length; i++)
                  {
                    var obj_cat = response.second_level_category[i];
                    html+="<option value='"+obj_cat.id+"'>"+obj_cat.name+"</option>";
                  }
                  
                  $("#second_level_category_id").html(html);
              }
      });
  }



$('.decimal').keyup(function()
{
  var val = $(this).val();
  if(isNaN(val)){
       val = val.replace(/[^0-9\.]/g,'');
       if(val.split('.').length>2) 
           val =val.replace(/\.+$/,"");
  }
  $(this).val(val); 
});


//Check image validation on upload file
$("#product_image").on("change", function(e) 
{   
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                           "image/JPG", "image/JPEG", "image/PNG"];
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
      swal('Alert!','Please select valid image type. Only jpg, jpeg and png file is allowed.');

      $('#'+selectedID).val('');

      var previewImageID = selectedID+'_preview';
      $('#'+previewImageID+' + img').remove();
    }
    else
    {
      filePreview(this);
    }
});

$("#product_certificate").on("change", function(e) 
{   
    var selectedID      = $(this).attr('id');

    var fileType        = this.files[0].type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png","application/pdf",
                           "image/JPG", "image/JPEG", "image/PNG"];
  
    if($.inArray(fileType, validImageTypes) < 0) 
    {
      swal('Alert!','Please select valid image type. Only jpg, jpeg,png and pdf file is allowed.');

      $('#'+selectedID).val('');

      var previewImageID = selectedID+'_preview';
      $('#'+previewImageID+' + img').remove();
    }
    else
    {
      filePreview(this);
    }
}); 



function filePreview(input) {

    var selectedID      = $(input).attr('id');
    var previewImageID  = selectedID+'_preview';

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+previewImageID+' + img').remove();
            $('#'+previewImageID).after('<img src="'+e.target.result+'" width="100" height="100"/>');
        };
        reader.readAsDataURL(input.files[0]);
    }
}


function changeVideoUrlStatus(video_type_object) {

    var video_type = $(video_type_object).val();
    // alert(video_type);
    if(video_type === "vimeo" || video_type === "youtube")
    {
      $('.product_video_url_div').show();
      $('#product_video_url').attr('data-parsley-required',true);
    }
    else
    {
      $('.product_video_url_div').hide();
      $('#product_video_url').removeAttr('data-parsley-required');

    }

}

</script>
@endsection