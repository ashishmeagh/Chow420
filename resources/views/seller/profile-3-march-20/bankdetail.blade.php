@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
.status-right-side {
    float: right;
    margin-right: 20px;
}
</style>
 

 <div class="my-profile-pgnm">
  Bank Details

     <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Bank Details</li>
    </ul>
</div>
<div class="new-wrapper">
<div class="login-12 bussinessprofilesslogin">
       

        <div class="pad-0">
            <div class="login-box-12 businessprofiles">
                    <div class="login-inner-form">
                      <br/>
                    
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
                                    <label for="">Paypal Email <span>*</span></label>
                                 
                                     <input type="text" name="paypal_email" id="paypal_email" class="input-text" placeholder="Enter paypal email." value="{{isset($user_details_arr['user_details']['paypal_email'])?$user_details_arr['user_details']['paypal_email']:''}}" 
                                     data-parsley-required="true" data-parsley-type="email"
                                     data-parsley-required-message="Please enter paypal email." >
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn-md btn-theme btn-block" id="btn_bank_detail">SAVE</button>
                                </div>
                         
                            </form>
                        </div>
                    </div>
          
             
            </div>
        </div>
 </div>
</div>


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
