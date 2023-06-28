@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
  .changsbannerimg{
    margin: 20px auto;
    max-width: 590px; 
  }
   .changsbannerimg img {
    height: 150px; width: 100%;
  }
  .clone-divs.none-padding-profile {
    padding-right: 0;
    margin-bottom: 2px;
    margin-left: -3px;
}

span.manag-note.imagenoteupload {
    color: #498434;
}
.errorimg-cvr{
  color: red;
    font-size: 13px;
    position: absolute;
    width: 100%;
    left: 0px;
    top: 60px;
}

.changsbannerimg.midium-cover img{width: 80%;}
.changsbannerimg.small-cover img{width: 70%;}

</style>


@php
$banner_public_path = "";

if(isset($banner_arr['image_name']) && $banner_arr['image_name']!='' && file_exists(base_path().'/uploads/seller_banner/'.$banner_arr['image_name']))
{
   $banner_public_path="uploads/seller_banner/".$banner_arr['image_name'];
}

 @endphp

 <div class="my-profile-pgnm">
  Dispensary Image

     <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Dispensary Image</li>
    </ul>
</div>
<div class="new-wrapper">
<div class="login-12 bussinessprofilesslogin">
        <div class="pad-0">
            <div class="row login-box-12 businessprofiles">
                <div class="col-lg-12 col-sm-12 col-pad-0 align-self-center">
                    <div class="login-inner-form">
                       <div id="status_msg"></div>
                        <div class="details login-inr-fild">
                           {{--  <h3>Cover Image</h3> --}}
                            <div class="changsbannerimg">
                              @php
                                $is_old_img = 0;
                                if(isset($banner_arr) && count($banner_arr) > 0 && file_exists(base_path().'/uploads/seller_banner/'.$banner_arr['image_name']) && $banner_arr['image_name']!='')
                                {             
                                  $banner_img = $banner_arr['image_name'];
                                  $img_path =url('/uploads/seller_banner/'.$banner_arr['image_name']);

                                  $is_old_img = 1;
                                }
                                else
                                {
                                  $banner_img = 'chow-bnr-img-large.jpg';
                                  $img_path =url('/').'/assets/front/images/chow-bnr-img-large.jpg';
                                }
                               @endphp
                              <img src="{{$img_path}}" alt="Dispensary Image">
                            </div>
                                @php
                               /*  $is_old_img_medium = 0;
                                if(isset($banner_arr) && count($banner_arr) > 0 && file_exists(base_path().'/uploads/seller_banner/'.$banner_arr['image_medium']) && $banner_arr['image_medium']!="")
                                {             
                                  $banner_img_medium = $banner_arr['image_medium'];
                                  $img_path_medium =url('/uploads/seller_banner/'.$banner_arr['image_medium']);

                                  $is_old_img_medium = 1;
                                }
                                else
                                {
                                  $banner_img_medium = 'chow-bnr-img-medium.jpg';
                                  $img_path_medium =url('/').'/assets/front/images/chow-bnr-img-medium.jpg';
                                }*/



                               @endphp

                               @php
                               /* $is_old_img_small =0;
                                if(isset($banner_arr) && count($banner_arr) > 0 && file_exists(base_path().'/uploads/seller_banner/'.$banner_arr['image_small']) && $banner_arr['image_small']!='')
                                {             
                                  $banner_img_small= $banner_arr['image_small'];
                                  $img_path_small =url('/uploads/seller_banner/'.$banner_arr['image_small']);

                                  $is_old_img_small = 1;
                                }
                                else
                                {
                                  $banner_img_small = 'chow-bnr-img-small.jpg';
                                  $img_path_small =url('/').'/assets/front/images/chow-bnr-img-small.jpg';
                                }*/

                              @endphp

                           

                           

                            <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="seller_id" id="seller_id" value="{{ $logged_in_seller_id or '' }}" />
                                   

                                  <div class="form-group row">
                                    <label class="col-md-4 col-form-label"> Change Image <span></span></label>
                                    <div class="col-md-8">
                                      <div class="errorwithnote" id="dynamic_field">
                                           <div class="clone-divs none-padding-profile">
                                              <input type="file" class="upload-int" name="banner_image" id="banner_image"    data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" data-parsley-required-message="Please select image"> 
                                                <div class="uploadanner">Upload</div>
                                              <span class="manag-note imagenoteupload">
                                                {{-- Suggested size: 1140px X 302px --}}
                                                Suggested size: 1920px X 775px 
                                              </span>
                                              <span class="errorimg-cvr" id="image_error">{{ $errors->first('banner_image[]') }}</span>
                                          </div>                                        
                                      </div>
                                    </div>
                                    <div class="clearfix"></div>
                                  </div>


                                    {{-- <div class="changsbannerimg midium-cover">
                                       <img src="{{$img_path_medium}}" alt="Cover Image">
                                    </div> --}}



                                   {{-- <div class="form-group row">
                                    <label class="col-md-4 col-form-label"> Change Image (Medium) <span></span></label>
                                    <div class="col-md-8">
                                      <div class="errorwithnote" id="dynamic_field">
                                           <div class="clone-divs none-padding-profile">
                                              <input type="file" name="image_medium" id="image_medium"   data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#medium_image_error" data-parsley-required-message="Please select cover image"> 
                                              <span class="manag-note imagenoteupload">
                                                Suggested size: 700px X 400px
                                              </span>
                                              <span  class="errorimg-cvr" id="medium_image_error">{{ $errors->first('image_medium') }}</span>
                                          </div>                                        
                                      </div>
                                    </div>
                                    <div class="clearfix"></div>
                                  </div> --}}

                                  {{--  <div class="changsbannerimg small-cover">
                                       <img src="{{$img_path_small}}" alt="Cover Image">
                                    </div> --}}

                                 {{--   <div class="form-group row">
                                    <label class="col-md-4 col-form-label"> Change Image (Small) <span></span></label>
                                    <div class="col-md-8">
                                      <div class="errorwithnote" id="dynamic_field">
                                           <div class="clone-divs none-padding-profile">
                                              <input type="file" name="image_small" id="image_small"    data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#small_image_error" data-parsley-required-message="Please select cover image"> 
                                              <span class="manag-note imagenoteupload">
                                                Suggested size: 621px X 300px
                                              </span>
                                              <span  class="errorimg-cvr" id="small_image_error">{{ $errors->first('image_small') }}</span>
                                          </div>                                        
                                      </div>
                                    </div>
                                    <div class="clearfix"></div>
                                  </div> --}}


 
                                  
                                  @if($is_old_img == 1)
                                    <input type="hidden" name="old_img" value="{{isset($banner_arr['image_name'])?$banner_arr['image_name']:''}}">
                                  @endif

                              {{--     @if($is_old_img_medium==1)
                                   <input type="hidden" name="old_img_medium" value="{{isset($banner_arr['image_medium'])?$banner_arr['image_medium']:''}}">
                                  @endif

                                   @if($is_old_img_small==1)
                                   <input type="hidden" name="old_img_small" value="{{isset($banner_arr['image_small'])?$banner_arr['image_small']:''}}">
                                  @endif --}}


                                   

                                        
                                <button type="submit" class="butn-def" value="Add" id="btn_add">Update</button>
                              
                                              
                                   
                            
                            </form>
                        </div>
                    </div>
                </div>
      
            </div>
        </div>
   </div>
</div>
<script>
$('.uploadanner').click(function() {
  $('.upload-int').click();
});
</script>


<script type="text/javascript">
  var module_url_path  = "{{ $module_url_path or ''}}";

  //Check image validation on upload file
  $(":file").on("change", function(e) 
  {
      var selectedID      = $(this).attr('id');

      var fileType        = this.files[0].type;
      var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                             "image/JPG", "image/JPEG", "image/PNG"];
      
      if($.inArray(fileType, validImageTypes) < 0) 
      {
        swal('Alert!','Please select valid image type. Only jpg, jpeg and png file is allowed.');

        $('#'+selectedID).val('');
      }
  });

  $('#btn_add').click(function()
  {
    if($('#validation-form').parsley().validate()==false) return;
    
    $.ajax({
                
        url: module_url_path+'/store',
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
                       title: 'Success',
                       text: data.description,
                       type: data.status,
                       confirmButtonText: "OK",
                       closeOnConfirm: false
                    },
                   function(isConfirm,tmp)
                   {
                     if(isConfirm==true)
                     {
                        window.location = window.location.href;
                     }
                   });
            }
            else if(data.status =='ImageFAILURE')
            { 
               $("#image_error").html(data.description);
               $("#image_error").css('color','red');

            }
            else if(data.status =='MediumImageFAILURE')
            { 
               $("#medium_image_error").html(data.description);
               $("#medium_image_error").css('color','red');

            }
             else if(data.status =='SmallImageFAILURE')
            { 
               $("#small_image_error").html(data.description);
               $("#small_image_error").css('color','red');

            }
            else{
               swal('warning',data.description,data.status);
            }  
        }
        
      });   

  });
</script>  

@endsection
