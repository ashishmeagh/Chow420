@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
.status-right-side {
    float: right;
    margin-right: 20px;
}
/*.status-div-icon.innermain-my-profile.max-widnone{margin-bottom: 30px;}*/
.login-12.bussinessprofilesslogin .login-box-12.businessprofiles {
    max-width: 850px;
}
.bankdetailstitle{
  max-width: 850px; width: 100%; text-align: left; margin:0 auto; 
}
.bankdetailstitle h3{margin-top: 0px;}
.main-my-profile.paddingnone {
    padding: 10px 0 0px;
}
.uplaod-edit-img{margin-top: 5px;}
.alert {
    margin: 0px 30px 15px;
}
.login-box-12.businessprofiles .alert {
    margin: 30px 30px 0px; text-align: left;
}
.login-12.bussinessprofilesslogin {
    padding-top: 0;
}
.innermain-my-profile{margin-bottom: 30px;}
</style>
 

 <div class="my-profile-pgnm">
 Bank details verification

     <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Bank details verification</li>
    </ul>
</div>
<div class="new-wrapper">


<!--------------------start of id proof div----------------------->


<div class="main-dv-re edit-top-space">
<div class="main-my-profile paddingnone">

  <div class="idprooftitle ">ID Proof Details</div>


   <div class="status-div-icon innermain-my-profile max-widnone">
        <div class="myprofile-lefts"> Verification Status </div>
          @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==0)
            <div class="myprofile-right">
              <div class="status-dispatched">Pending</div>
            </div>
          @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
            <div class="myprofile-right">
              <div class="status-completed">Approved</div>
            </div>
          @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==2)
            <div class="myprofile-right">
              <div class="status-shipped">Rejected</div>
            </div>  
              <div class="main-rejects">
                <div class="myprofile-lefts">Reject Reason</div>
                 <div class="myprofile-right">{{isset($user_details_arr['user_details']['note'])?$user_details_arr['user_details']['note']:''}}
                 </div>
               </div> 

          @elseif(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==3)
            <div class="myprofile-right">
              <div class="status-dispatched">Submitted</div>
            </div>     

          @endif 
   </div>






   <form id="frm-profile_idproof" class="">

        {{ csrf_field() }}
                    
  <input type="hidden" name="old_front_image" value="{{$user_details_arr['user_details']['front_image'] or ''}}"> 
  <input type="hidden" name="old_back_image" value="{{$user_details_arr['user_details']['back_image'] or ''}}"> 
  <input type="hidden" name="old_selfie_image" value="{{$user_details_arr['user_details']['selfie_image'] or ''}}"> 
   
  <input type="hidden" name="old_addressproof_image" value="{{$user_details_arr['user_details']['address_proof'] or ''}}"> 
      <!----------------------------start of form of age verification------------->

      
        @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
          <!------------------approved----------------------->


            {{--    <div class="status-div-icon innermain-my-profile max-widnone">
                   
                        <div class="myprofile-lefts"> Verification Status </div>
                      @if(isset($user_details_arr['user_details']['approve_verification_status']) && $user_details_arr['user_details']['approve_verification_status']==1)
                        <div class="myprofile-right">
                          <div class="status-completed">Approved</div>
                        </div>
                      @endif 
               </div> --}}

        @else
          <!--------------------pending---------------------------------------->
        <div class="clearfix"></div>
          <div class="innermain-my-profile">      
            <div class="row">      
              <div id="status_msg_idproof" class="row"></div>
              <div class="form-group">
                <div class="col-md-2"><label for="">Front of ID <span>*</span></label></div>
                <div class="col-md-10">
                  <div class="yprofiles">
                    <div class="int-profiles">                                
                      <input type="file" class="form-control" id="front_image" name="front_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error"  @if(isset($user_details_arr['user_details']['front_image']) && $user_details_arr['user_details']['front_image']!=''  && file_exists(base_path().'/uploads/seller_id_proof/'.$user_details_arr['user_details']['front_image'])) @else required="" data-parsley-required-message="Please select front of ID" @endif>
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
                      <input type="file" class="form-control" id="back_image" name="back_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" @if(isset($user_details_arr['user_details']['back_image']) && $user_details_arr['user_details']['back_image']!='' && file_exists(base_path().'/uploads/seller_id_proof/'.$user_details_arr['user_details']['back_image'])) @else required="" data-parsley-required-message="Please select back of ID" @endif>
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
                        <input type="file" class="form-control" id="selfie_image" name="selfie_image"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" @if(isset($user_details_arr['user_details']['selfie_image']) && $user_details_arr['user_details']['selfie_image']!='' && file_exists(base_path().'/uploads/seller_id_proof/'.$user_details_arr['user_details']['selfie_image'])) @else required="required" data-parsley-required-message="Please select selfie" @endif>
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
                <div class="col-md-2"><label for="">Address Proof <span>*</span></label></div>
                <div class="col-md-10">
                  <div class="yprofiles">
                    <div class="int-profiles">                            
                        <input type="file" class="form-control" id="address_proof" name="address_proof"  data-allowed-file-extensions="png jpg JPG jpeg JPEG" data-errors-position="outside" data-parsley-errors-container="#image_error" @if(isset($user_details_arr['user_details']['address_proof']) && $user_details_arr['user_details']['address_proof']!='' && file_exists(base_path().'/uploads/seller_id_proof/'.$user_details_arr['user_details']['address_proof'])) @else required="required" data-parsley-required-message="Please select address proof" @endif>
                    </div>
                    @if(isset($user_details_arr['user_details']['address_proof']) && $user_details_arr['user_details']['address_proof']!='' && file_exists(base_path().'/uploads/seller_id_proof/'.$user_details_arr['user_details']['address_proof']))

                      @php
                        $ext = pathinfo($user_details_arr['user_details']['address_proof'], PATHINFO_EXTENSION);

                        if($ext=="pdf" || $ext=="doc" || $ext=="docx" || $ext=="xls" || $ext=="xlsx"){  
                      @endphp

                      <div class="uplaod-edit-img">
                        <a href="{{$id_proof_path.'/'.$user_details_arr['user_details']['address_proof']}}" id="upload-f" class="profile" alt="Address Proof" target="_blank">View Address Proof</a>
                       
                      </div>   

                      @php 
                         }else{
                      @endphp
                           <div class="uplaod-edit-img">
                            <img src="{{$id_proof_path.'/'.$user_details_arr['user_details']['address_proof']}}" id="upload-f" class="profile" alt="Address Proof" width="100" height="100">                      
                          </div>   
                      @php
                        }//else
                      @endphp

                    @endif
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>



               <div class="form-group">
                    <div class="">
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
                  <a href="javascript:void(0)" class="butn-def" id="btn-profile_idproof">SAVE</a>
                </div> 
              </div>
            </div>
          </div>

          @endif 
      
        <!-----------------------------end of form of age verification-------------------->

  </form>
</div>
</div>
<!---------------------end of id proof div------------------------>









<div class="login-12 bussinessprofilesslogin">
        <div class="bankdetailstitle">
          <div class="idprooftitle">Bank Details</div>
        </div>

        <div class="pad-0">
            <div class="login-box-12 businessprofiles">
                    <div class="login-inner-form">
                     
                    
                      <div class="clearfix"></div>

                       <div id="status_msg"></div>
                        <div class="details login-inr-fild">
                            <form id="frm_bank"> 

                            {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="">Registered Name <span>*</span></label>
                                    <input type="text" name="registered_name" id="registered_name" class="input-text" placeholder="Enter registered name" value="{{isset($user_details_arr['user_details']['registered_name'])?$user_details_arr['user_details']['registered_name']:''}}"
                                     data-parsley-required="true"
                                      data-parsley-required-message="Please enter registered name" data-parsley-pattern="/^[a-zA-Z ]*$/">
                                </div>
                                 <div class="form-group">
                                    <label for="">Account Number <span>*</span></label>
                                 
                                     <input type="text" name="account_no" id="account_no" class="input-text" placeholder="Enter account number." value="{{isset($user_details_arr['user_details']['account_no'])?$user_details_arr['user_details']['account_no']:''}}" 
                                     data-parsley-required="true"
                                      data-parsley-required-message="Please enter account number." >
                                </div>

                                <div class="form-group">
                                    <label for="">Routing Number <span>*</span></label>
                                 
                                     <input type="text" name="routing_no" id="routing_no" class="input-text" placeholder="Enter routing number." value="{{isset($user_details_arr['user_details']['routing_no'])?$user_details_arr['user_details']['routing_no']:''}}" 
                                     data-parsley-required="true"
                                      data-parsley-required-message="Please enter routing number." >
                                </div>
 
                                 <div class="form-group">
                                    <label for="">Swift Number <span>*</span></label>
                                 
                                     <input type="text" name="switft_no" id="switft_no" class="input-text" placeholder="Enter switft number." value="{{isset($user_details_arr['user_details']['switft_no'])?$user_details_arr['user_details']['switft_no']:''}}" 
                                     data-parsley-required="true"
                                     data-parsley-required-message="Please enter swift number." 
                                      >
                                </div>


                                 <div class="form-group">
                                    <label for="">Paypal Email <span></span></label>
                                 
                                     <input type="text" name="paypal_email" id="paypal_email" class="input-text" placeholder="Enter paypal email." value="{{isset($user_details_arr['user_details']['paypal_email'])?$user_details_arr['user_details']['paypal_email']:''}}"                                       
                                     data-parsley-type="email"
                                     data-parsley-required-message="Please enter paypal email." >
                                </div>

                                  <div class="button-list-dts">
                  <a href="javascript:void(0)" class="butn-def" id="btn_bank_detail">SAVE</a>
                </div>
                                {{-- <div class="form-group">
                                    <button type="submit" class="btn-md btn-theme" id="btn_bank_detail">SAVE</button>
                                </div> --}}
                         
                            </form>
                        </div>
                    </div>
          
             
            </div>
        </div>
 </div>
</div>
<script>
  
  $('#btn-profile_idproof').click(function(){
      
      /*Check all validation is true*/
      if($('#frm-profile_idproof').parsley().validate()==false) return;

      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/id_verification/update',

        data:new FormData($('#frm-profile_idproof')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn-profile_idproof').prop('disabled',true);
          $('#btn-profile_idproof').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn-profile_idproof').prop('disabled',false);
          $('#btn-profile_idproof').html('SAVE');

          if(typeof response =='object')
          {
            if(response.status && response.status=="SUCCESS")
            {
              var success_HTML = '';
              success_HTML +='<div class="alert alert-success alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';

                    $('#status_msg_idproof').html(success_HTML);
                     $('html, body').animate({
                          scrollTop: $('#status_msg_idproof').offset().top
                      }, 'slow');

                    setTimeout(function(){
                       window.location.href="{{ url('/') }}/seller/bank_detail";
                    },4000);
                   
            }
            else
            {                    
                var error_HTML = '';   
                error_HTML+='<div class="alert alert-danger alert-dismissible">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                    </button>'+response.message+'</div>';
                
                $('#status_msg_idproof').html(error_HTML);
            }
          }
        }
      });
    });

</script>


<script type="text/javascript">
     

    $('#btn_bank_detail').click(function(){
      
      /*Check all validation is true*/
      if($('#frm_bank').parsley().validate()==false) return;

      $.ajax({
        //url:SITE_URL+'/seller/business-profile/update',
        url:SITE_URL+'/seller/bank_detail/update',

        data:new FormData($('#frm_bank')[0]),
        method:'POST',
        contentType:false,
        processData:false,
        cache: false,
        dataType:'json',
        beforeSend : function()
        {
          showProcessingOverlay();
          $('#btn_bank_detail').prop('disabled',true);
          $('#btn_bank_detail').html('Updating... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
        },
        success:function(response)
        {
          hideProcessingOverlay();
          $('#btn_bank_detail').prop('disabled',false);
          $('#btn_bank_detail').html('SAVE');

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
                  //  window.location.reload();
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
</script>  

@endsection
