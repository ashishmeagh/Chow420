@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
  .changsbannerimg{
    margin: 20px auto;
    max-width: 590px; 
  }
</style>




 <div class="my-profile-pgnm">
  Wholesale Access
     <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Wholesale Access</li>
    </ul>
</div>
<div class="new-wrapper">
<div class="login-12 bussinessprofilesslogin">
        <div class="pad-0">
            <div class="row login-box-12 businessprofiles">
                <div class="col-lg-12 col-sm-12 col-pad-0 align-self-center">
                    <div class="login-inner-form wholesale-code">
                       <div id="status_msg"></div>
                        <div class="details login-inr-fild">
                                                    
                          <h4><span> Access Code : </span>  2020CHOWWHOLE7 </h4>
                         
                          <a href="https://chowpods.com/wholesale" class="btn btn-info" target="_blank">Access Wholesale Prices</a>                                               
                                          
                                   
                            
                        </div>
                    </div>
                </div>
      
            </div>
        </div>
   </div>
</div>


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
