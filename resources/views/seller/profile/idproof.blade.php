@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
 
.uplaod-edit-img {
    width: 100px;
    height: 100px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-top: 10px;
 overflow: hidden;
 padding: 5px;
}
.profl-em img{width: 100%; height: 100%;}
.yprofiles{position: relative; margin-bottom: 25px;}
.yprofiles .form-control{height: 45px;padding: 0;}
.yprofiles input[type=file]::-webkit-file-upload-button {
     background-color: #333;
     padding: 5px 20px; border: none; height: 45px; color: #ffff;
     position: absolute; left: 0px; top: 0px;
}
.status-div-icon.innermain-my-profile{margin-bottom: 30px;}
.titleidproof{max-width: 850px; margin: 0 auto;}
.innermain-my-profile .myprofile-main{    border-bottom: none;}


.innermain-my-profile .myprofile-main{    border-bottom: none;}
.status-div-icon.innermain-my-profile{padding: 0px;}
.main-my-profile.spacenon{padding-top: 0px;}
.form-group.age-csp{margin-top: 20px;}
.font-eightr label{font-weight: 600 !important;}
.form-group.font-eightr.age-csp {
    margin-bottom: 0;
}
.innermain-my-profile.imgdnones{padding-bottom: 0px;}
</style>

<div class="my-profile-pgnm">ID Proof Verification

   <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li>ID Proof Verification</li>
  </ul>
</div>


<div class="new-wrapper">

<div class="main-my-profile">
 
   {{--  <span class="manag-note text-note"> Your privacy is our top priority. After identity verification, all personal data will be removed from our servers. </span> --}}

    <form id="frm-profile">
        {{ csrf_field() }}
{{--         <div class="titleidproof"><h3>Id Proof Verification</h3><br/></div>
 --}}        


           @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['front_image'] && $user_details_arr['user_details']['back_image'])

                       

               <div class="status-div-icon innermain-my-profile">
                <div class="myprofile-main">
                        <div class="myprofile-lefts">ID Verification Status </div>
                      @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
                        <div class="myprofile-right">
                          <div class="status-completed">Approved</div>
                        </div>

                                             

                      @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']=='0' && $user_details_arr['user_details']['front_image'] && $user_details_arr['user_details']['back_image'])

                        <div class="myprofile-right">
                          <div class="status-dispatched">Pending</div>
                        </div>  

                         @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']=='3' && $user_details_arr['user_details']['front_image'] && $user_details_arr['user_details']['back_image'])

                        <div class="myprofile-right">
                          <div class="status-dispatched">Submitted</div>
                        </div>

                        
                       @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==2)
                  
                        <div class="myprofile-right">
                            <div class="status-shipped">Rejected</div>
                        </div>
                        <div class="main-rejects">
                          <div class="myprofile-lefts">Reject Reason</div>
                            <div class="myprofile-right">{{isset($user_details_arr['user_details']['note'])?$user_details_arr['user_details']['note']:''}}</div>
                        </div>
                        <div class="clearfix"></div>
                  
                      @endif
                      </div>
               </div>
           @endif    
  <input type="hidden" name="old_front_image" value="{{$user_details_arr['user_details']['front_image'] or ''}}"> 
  <input type="hidden" name="old_back_image" value="{{$user_details_arr['user_details']['back_image'] or ''}}"> 
  <input type="hidden" name="old_selfie_image" value="{{$user_details_arr['user_details']['selfie_image'] or ''}}"> 
   

      <!----------------------------start of form of age verification------------->

      
        @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
          <!------------------approved----------------------->
          @if(file_exists($id_proof_path.$user_details_arr['user_details']['front_image']) && file_exists($id_proof_path.$user_details_arr['user_details']['back_image']) && file_exists($id_proof_path.$user_details_arr['user_details']['selfie_image']))  
            <div class="innermain-my-profile">      
              <div id="status_msg" class="row"></div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group font-eightr fornts-img">
                    <label for="">Front of ID</label>
                    <div class="yprofiles">                           
                      <div class="uplaod-edit-img">
                        @if(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!='')
                          <img src="{{$id_proof_path.$user_details_arr['user_details']['front_image']}}" id="upload-f" class="profile" alt="Front of ID" width="100" height="100">
                        @else
                          <img src="{{url('/')}}/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="Front of ID" width="100" height="100">
                        @endif
                      </div>    
                    </div> 
                    <div class="clearfix"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group font-eightr fornts-img"><label for="">Back of ID</label>
                    <div class="yprofiles">
                      <div class="uplaod-edit-img">
                        @if(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!='')
                          <img src="{{$id_proof_path.'/'.$user_details_arr['user_details']['back_image']}}" id="upload-f" class="profile" alt="Back of ID" width="100" height="100">
                        @else
                          <img src="{{url('/')}}/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="Back of ID" width="100" height="100">
                        @endif
                      </div> 
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group font-eightr fornts-img"><label for="">Selfie</label>
                    <div class="yprofiles">
                      <div class="uplaod-edit-img">
                        @if(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!='')
                          <img src="{{$id_proof_path.'/'.$user_details_arr['user_details']['selfie_image']}}" id="upload-f" class="profile" alt="Selfie" width="100" height="100">
                        @else
                          <img src="{{url('/')}}/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="Selfie" width="100" height="100">
                        @endif
                      </div> 
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
          @endif

        @else
          <!--------------------pending---------------------------------------->

          <div class="innermain-my-profile">      
            <div class="row">      
              <div id="status_msg" class="row"></div>
              <div class="form-group">
                <div class="col-md-2"><label for="">Front of ID <span>*</span></label></div>
                <div class="col-md-10">
                  <div class="yprofiles">
                    <div class="int-profiles">                                
                      <input type="file" class="form-control" id="front_image" name="front_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error"  @if(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!='') @else required="" data-parsley-required-message="Please select front of ID" @endif>
                    </div>

                    @if(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!='')
                        <div class="uplaod-edit-img">
                            <img src="{{$id_proof_path.$user_details_arr['user_details']['front_image']}}" id="upload-f" class="profile" alt="Front of ID" width="100" height="100">
                          {{--  @else
                          <img src="{{url('/')}}/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="" width="100" height="100"> --}}
                        </div> 
                      @endif
                  </div> 
                </div>
                <div class="clearfix"></div>
              </div>               

              <div class="form-group">
                <div class="col-md-2"><label for="">Back of ID <span>*</span></label></div>
                <div class="col-md-10">
                  <div class="yprofiles">
                    <div class="int-profiles">                            
                      <input type="file" class="form-control" id="back_image" name="back_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" @if(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!='') @else required="" data-parsley-required-message="Please select back of ID" @endif>
                    </div>

                    @if(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!='')

                      <div class="uplaod-edit-img">
                        <img src="{{$id_proof_path.'/'.$user_details_arr['user_details']['back_image']}}" id="upload-f" class="profile" alt="Back of ID" width="100" height="100">
                        {{--  @else
                        <img src="{{url('/')}}/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="" width="100" height="100"> --}}
                      </div>   
                    @endif
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="form-group">
                <div class="col-md-2"><label for="">Selfie <span>*</span></label></div>
                <div class="col-md-10">
                  <div class="yprofiles">
                    <div class="int-profiles">                            
                        <input type="file" class="form-control" id="selfie_image" name="selfie_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" @if(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!='') @else required="required" data-parsley-required-message="Please select selfie" @endif>
                    </div>
                    @if(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!='')

                      <div class="uplaod-edit-img">
                        <img src="{{$id_proof_path.'/'.$user_details_arr['user_details']['selfie_image']}}" id="upload-f" class="profile" alt="Selfie" width="100" height="100">
                        {{--  @else
                        <img src="{{url('/')}}/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="" width="100" height="100"> --}}
                      </div>   
                    @endif
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>



               <div class="form-group">
                    <div class="row">
                     <div class="col-md-2"><label for="">Address <span>*</span></label></div>
                     <div class="col-md-10">
                      <div class="yprofiles">
                      <input type="text" id="age_address" name="age_address" value="{{$user_details_arr['user_details']['age_address'] or ''}}" data-parsley-required="true" data-parsley-required-message="Please enter full address" class="input-text" placeholder="Address">
                     <span class="add_note" for=""></span>
                     </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                </div>




              <div class="col-md-12">
                <div class="button-list-dts">
                  <a href="#" class="butn-def" id="btn-profile">Save</a>
                </div> 
              </div>
            </div>
          </div>

          @endif 
      
              <!-----------------------------end of form of age verification-------------------->

  </form>
</div>
</div>
<script type="text/javascript">

    //Check image validation on upload file
    $(":file").on("change", function(e) 
    {
        var selectedID      = $(this).attr('id');

        var fileType        = this.files[0].type;
        var validImageTypes = ["image/jpg", "image/jpeg", "image/png",
                               "image/JPG", "image/JPEG", "image/PNG"];
      
        if($.inArray(fileType, validImageTypes) < 0) 
        {
          swal('Alert!','Please select valid image type. Only jpg, jpeg and png file are allowed.');

          $('#'+selectedID).val('');
        }
    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $('#upload-f')
                    .attr('src', e.target.result)
                    .width(160)
                    .height(160);
            };
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#btn-profile').click(function(){
      
      /*Check all validation is true*/
      if($('#frm-profile').parsley().validate()==false) return;

      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/id_verification/update',

        data:new FormData($('#frm-profile')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-profile').prop('disabled',true);
          $('#btn-profile').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn-profile').prop('disabled',false);
          $('#btn-profile').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg').html(success_HTML);
                    setTimeout(function(){
                       window.location.reload();
                    },2000);
                   
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                
                $('#status_msg').html(error_HTML);
            }
          }
        }
      });
    });
</script>    
@endsection
