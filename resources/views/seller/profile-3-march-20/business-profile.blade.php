@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
.status-right-side {
    float: right;
    margin-right: 20px;
}
</style>



@php
$id_proof_img_path = "";

if(isset($business_details['id_proof']) && $business_details['id_proof']!='' && file_exists(base_path().'/uploads/id_proof/'.$business_details['id_proof']))
{
   $id_proof_img_path="uploads/id_proof/".$business_details['id_proof'];
}

 @endphp

 <div class="my-profile-pgnm">
  Business Profile

     <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Business Profile</li>
    </ul>
</div>
<div class="new-wrapper">
<div class="login-12 bussinessprofilesslogin">
@php

if($business_details['approve_status']==0){
  $status = 'Pending';
  $cls = 'status-dispatched';
}
else if($business_details['approve_status']==1){
  $status = 'Approved';
  $cls = 'status-completed';
}
else if($business_details['approve_status']==2){
  $status = 'Rejected';
  $cls = 'status-shipped';
}
else if($business_details['approve_status']==3){
  $status = 'Submitted';
  $cls = 'status-dispatched';
}

@endphp
        


        <div class="pad-0">
            <div class="login-box-12 businessprofiles">
                    <div class="login-inner-form">
                      <br/>
                      <div class="status-right-side"> Status : <div class="{{ $cls }}">{{ $status }} </div> </div>
                      <div class="clearfix"></div>



                       <div id="status_msg"></div>
                        <div class="details login-inr-fild">
                            <!-- <h3>Add Business</h3> -->
                            <form id="frm_add_business"> 

                            {{ csrf_field() }}

                                <input type="hidden" name="old_id_proof" id="old_id_proof" value="{{isset($business_details['id_proof'])?$business_details['id_proof']:''}}">

                                <div class="form-group">
                                    <label for="">Business Name <span>*</span></label>
                                    <input type="text" name="business_name" id="business_name" class="input-text" placeholder="Enter Business Name" value="{{isset($business_details['business_name'])?$business_details['business_name']:''}}" data-parsley-required="true" data-parsley-required-message="Please enter business name" {{-- data-parsley-pattern="/^[a-zA-Z ]*$/" --}}
                                    >
                                   <div id="businessname_exist_error_message"></div>

                                </div>
                                <div class="form-group">
                                    <label for="">Tax ID. <span>*</span></label>
                                   {{--  <input type="text" name="tax_id" id="tax_id" class="input-text" placeholder="Tax ID." value="{{isset($business_details['tax_id'])?$business_details['tax_id']:''}}" data-parsley-required="true" data-parsley-required-message="Tax ID. is required" data-parsley-type="digits"  data-parsley-maxlength="9"  data-parsley-maxlength="9" data-parsley-remote="{{ url('/seller/business-profile/does_tax_id_exist') }}" data-parsley-remote-options='{ "type": "POST", "dataType": "jsonp", "data": { "_token": "{{ csrf_token() }}" } }' data-parsley-remote-message="Tax ID already exists"> --}}
                                     <input type="text" name="tax_id" id="tax_id" class="input-text" placeholder="Enter Tax ID." value="{{isset($business_details['tax_id'])?$business_details['tax_id']:''}}" data-parsley-required="true" data-parsley-required-message="Please enter tax ID." data-parsley-type="digits"  data-parsley-maxlength="9"  data-parsley-maxlength="9" >
                                </div>




                              {{--   <div class="user-box form-group">
                                    <label for="">ID Proof</label>
                                    <div class="upload-block">
                                        <input type="file" style="height: 0;" name="id_proof" id="id_proof"/>
                                        <div class="input-group ">                                           
                                            <input type="text" id="hideuploadtext" class="form-control file-caption  kv-fileinput-caption" disabled="disabled"/>
                                            <div class="btn btn-primary btn-file btn-gry">
                                                <a class="file" onclick="browseImage(this)">
                                                    <img src="{{url('/')}}/assets/seller/images/upload-add-busines.png" alt="" />
                                                </a>
                                            </div>
                                            <div class="btn btn-primary btn-file btn-file-remove remove" style="border-right:1px solid #fbfbfb !important;display:none;">
                                                 <a class="file" onclick="removeBrowsedImage(this)"><i class="fa fa-trash"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
 


                                <div class="form-group">
                                    <button type="submit" class="btn-md btn-theme btn-block" id="btn_business_profile">SAVE</button>
                                </div>
                         
                            </form>
                        </div>
                    </div>
          
               {{--  <div class="col-lg-5 col-md-12 col-sm-12 col-pad-0 bg-img align-self-center none-992">
                    <a href="#" class="chw-login">
                          @if(isset($business_details['id_proof']) && $business_details['id_proof']!=''&& file_exists(base_path().'/uploads/seller_id_proof/'.$business_details['id_proof']))
                              <img src="{{ $id_proof_public_path}}/{{$business_details['id_proof']}}" class="img-responsive img-preview" alt="" id="upload-f" />
                            @else
                              <img src="{{url('/assets/images/no_image_available.jpg')}}" class="img-responsive img-preview" alt="" id="upload-f" />
                        @endif
                    </a>
                    <div class="idproof-txts">ID Proof</div>
                </div> --}}
            </div>
        </div>
 </div>
</div>


<script type="text/javascript">
       function browseImage(ref)
        {
          var upload_block = $(ref).closest('div.upload-block');
          $(upload_block).find('input[type="file"]').trigger('click');
        }

        function removeBrowsedImage(ref)
        {
          var upload_block = $(ref).closest('div.upload-block');
          
          $(upload_block).find('input.file-caption').val("");
          $(upload_block).find("div.btn-file-remove").hide();
          $(upload_block).find('input[type="file"]').val("");
        }

        $(document).ready(function()
        {
          // This is the simple bit of jquery to duplicate the hidden field to subfile
          $('div.upload-block').find('input[type="file"]').change(function()
          {
            var upload_block = $(this).closest('div.upload-block');
            if($(this).val().length>0)
            {
              $(upload_block).find("div.btn-file-remove").show();

            }

            $(upload_block).find('input.file-caption').val($(this).val());
          });
          
        });

    $('#btn_business_profile').click(function(){
      
      /*Check all validation is true*/
      if($('#frm_add_business').parsley().validate()==false) return;

      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/business-profile/update',

        data:new FormData($('#frm_add_business')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn_business_profile').prop('disabled',true);
          $('#btn_business_profile').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn_business_profile').prop('disabled',false);
          $('#btn_business_profile').html('SAVE');

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
                     },3000);
                   
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                $("#hideuploadtext").val('');
                $('#status_msg').html(error_HTML);
            }
          }
        }
      });
    });

 

 $("#business_name").change(function(){
    var business_name = $(this).val();
   
     $.ajax({
        url:SITE_URL+'/common/get_business_name/'+business_name,
        method:'GET',
        dataType:'json',                         
        success:function(response)
        {       
              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                   var error_HTML = '';   
                 $('#status_msg').html(error_HTML);
                }else if(response.status && response.status=="ERROR"){
                   

                    var error_HTML = '';   
                    error_HTML+='<div class="alert alert-danger alert-dismissible">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>'+response.msg+'</div>';                   
                    $('#status_msg').html(error_HTML);

                  //$('#status_msg').css('color','red').html(response.msg);
                  return false;

                }
              }// if object
        } //success 
      });    
  });//end business_name function


</script>  

@endsection
