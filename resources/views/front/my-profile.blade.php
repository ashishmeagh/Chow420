@extends('front.layout.master')
@section('main_content')
<style type="text/css">
  {{-- this css only for this page and only file upload button design purpose --}}
  .btn-file {position: relative;overflow: hidden;}
  .btn-file input[type=file] {position: absolute;top: 0;right: 0;min-width: 100%;min-height: 100%;text-align: right;opacity: 0;background:  transparent;cursor: inherit;display: block;}
  /* IE 10 fix */
  .btn-file ::-ms-browse {width:100%;height:100%;}
  .btn.btn-primary.btn-file {background: #c42881;border-color: #c42881;border-radius: 0 ;color: #fff;display: block;height: 35px;float: right;padding-top: 6px;    max-width: 92px; width: 100%;}
  .user-box .input-group {border-collapse: separate;max-width: 100%;position: relative;width: 100%;/* border: 1px solid #dadada;*/border-radius: 3px;}
  .glyphicon.glyphicon-trash, .glyphicon.glyphicon-upload, .glyphicon.glyphicon-file.kv-caption-icon {color: #888;font-weight: normal;}
  .form-control.file-caption.kv-fileinput-caption {background: #fff;  border: 0;box-shadow: none;height: 35px;max-width:48%;width: 100%;}
  .btn.btn-primary.btn-file.btn-gry {background: #ececec;border-color: #ececec;padding: 1px;}
  .btn.btn-primary.btn-file {background: #c42881 ;border-color: #c42881;border-radius: 0;color: #fff;display: block;float: right;height: 35px;max-width: 92px;padding-top: 6px;width: 100%;}
  .btn-file {overflow: hidden;position: relative;}
  .btn.btn-gry.btn-primary.btn-file .file {color: #3c3c3c;font-size: 16px;opacity: 1;padding:8px 11px; display:block;width: 100%;}
  .btn.btn-gry.btn-primary.btn-file .file:hover{ text-decoration: none;}
  .btn.btn-primary.btn-file.remove {max-width: 30px;padding: 10px 0;width: 100%;}
  .btn.btn-primary.btn-file {background: #464646;border-color:#464646;border-radius: 0;color: #fff;display: block;float: right;height:38px;max-width: 117px;padding-top: 6px;width: 100%;margin: 0;}
  a.file i { color: #fff;padding-top: 2px;}
  .audio-job select.droup {font-size: 14px;}
  .input-bx.d-se {margin-bottom: 0;}
  .user-box .file {color: #3c3c3c;cursor: pointer;display: block;left: 0;max-width: 151px;opacity: 1;position: absolute;  top:0px;width: 100%;z-index: 999;}
  .label-tag{color: #333; font-size:14px; }
  .main-input-file{margin-bottom: 20px;}
  .link-mains-shipment-right .input-group{border: 1px solid#ccc;}
</style>
<div class="main-exp-tech-opn">
  <div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="white-box-login signup-main open-tchno-opn">
   <div id="status_msg"></div>  
   @include('front.layout.flash_messages')
        <form id="frm-profile">
        {{ csrf_field() }}
            <div class="profile-img">
               <div class="upload-img">
                  <img src="{{url('/')}}/assets/images/Profile-edit-img.png" class="Profile-edit-img" alt="">
               </div>
               <input class="file-upload" type="file" onchange="readURL(this);" id="profile-image" name="profile-image">
               <div class="profile-image">
                  @if(isset($user_details_arr['profile_image']) && $user_details_arr['profile_image']!='')
                  <img src="{{$profile_img_path.'/'.$user_details_arr['profile_image']}}" id="upload-f" class="profile" alt="">
                  @else
                  <img src="{{url('/')}}/assets/images/Profile-img-new.jpg" id="upload-f" class="profile" alt="">
                  @endif
               </div>
               <input type="hidden" name="old_profile_img" value="{{$user_details_arr['profile_image'] or ''}}">
            </div>
            <div class="form-int">
               <input type="text" placeholder="First Name" value="{{$user_details_arr['first_name'] or ''}}" data-parsley-required="true" id="first_name" name="first_name" />
               
            </div>

            <div class="form-int">
               <input type="text" placeholder="Last Name" value="{{$user_details_arr['last_name'] or ''}}" data-parsley-required="true" id="last_name" name="last_name" />
               
            </div>

            <div class="form-int">
               <input type="email" placeholder="Email Address" value="{{$user_details_arr['email'] or ''}}" data-parsley-required="true" id="email" name="email" />
            </div>

            

            <div class="form-int">
              @php
                $country_id = isset($user_details_arr['country'])?$user_details_arr['country']:0;
                @endphp
                  <!-- <label class="col-md-2 col-form-label">Country<i class="red">*</i></label> -->
                  <!-- <div class="col-md-10"> -->
                     <select class="form-control" data-parsley-required="true" id="country" name="country">

                      @if(isset($countries_arr) && count($countries_arr)>0)
                      <option value="">Select Country</option>
                      @foreach($countries_arr as $country)


                       <option data-iso="{{$country['iso']}}" @if($country['id']==$country_id) selected="selected" @endif value="{{$country['id']}}">{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--' }}</option>
                     
                      @endforeach
                      @else
                      <option>Countries Not Available</option>
                      @endif
                     </select>
  

                  <!-- </div> -->
            </div>

            <div class="form-int">
               <input type="text" placeholder="Address" value="{{$user_details_arr['address'] or ''}}" data-parsley-required="true" id="address" name="address" />
            </div>

            <div class="form-int">
               <input type="text" placeholder="Post Code" value="{{$user_details_arr['post_code'] or ''}}" data-parsley-required="true" id="post_code" name="post_code" />
            </div>
           
            <div class="form-int">
               <input type="text" placeholder="Mobile No" data-parsley-required="true" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="number" id="mobile_no" name="mobile_no" value="{{$user_details_arr['phone'] or ''}}"/>
            </div>

            <!-- <div class="form-int">
              <div class="link-mains-shipment">
                <div class="link-mains-shipment-left">
                  <img src="{{url('/')}}/assets/images/link-comts.png" alt="" />
                </div>
                <div class="link-mains-shipment-right">              
                  <div class="main-input-file">
                    <input type="hidden" name="present_id_proof" value="{{ $user_details_arr['id_proof'] or ''}}">
                    @if($user_details_arr['id_proof'] == "")
                      <div class="label-tag">Id Proof</div>
                        <input type="file" id="id_proof"  name="id_proof" style="visibility:hidden; height: 0;"/>
                        <div class="input-group ">
                           <input type="text" class="form-control file-caption  kv-fileinput-caption" id="id_proof_name" disabled="disabled"/>
                           <div class="btn btn-primary btn-file btn-gry">
                              <a class="file" onclick="browseIdProof()">Browse...
                              </a>
                           </div>
                           <div class="btn btn-primary btn-file remove" onclick="removeIdProof()" style="border-right:1px solid #fbfbfb !important;display:none;" id="btn_remove_id_proof">
                              <a class="file" ><i class="fa fa-trash"></i>
                              </a>
                           </div>
                        </div>
                      @endif
                      <span>@if($user_details_arr['id_proof'] != "")<a href="{{$id_proof_public_path}}{{ isset($user_details_arr['id_proof'])?$user_details_arr['id_proof']:'--' }}" title="Preview" target="_blank">View ID proof</i></a>@endif</span>
                  </div>
                </div> -->

            <div class="clearfix"></div>
        </div>
          </div>
            
        </form>
      <div class="clearfix"></div>
      <div class="text-center">
         <button type="button" class="button-login small-button" id="btn-profile">Save</button>
      </div>
</div>
    </div>

    </div>
  </div>
</div>

@endsection

@section('extra_js')

  <script type="text/javascript">

      function browseIdProof() {         
      $("#id_proof").trigger('click');
      }
     
      function removeIdProof() {
         $('#id_proof_name').val("");
         $("#btn_remove_id_proof").hide();
         $("#id_proof").val("");
      }
     
      $('#id_proof').change(function() {
         if ($(this).val().length > 0) {
             $("#btn_remove_id_proof").show();
         }         
         $('#id_proof_name').val($(this).val());
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
        url:SITE_URL+'/buyer/update_profile',
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