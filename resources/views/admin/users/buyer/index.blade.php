@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/css/smartphoto.min.css">

    <style>
      .title-imgd.newbr.imgfroms {
    float: none;
}
.id-images{margin-left: 0px;}
.id-images .img-forntsimg{margin-left: 0px;}
.img-forntsimg.id-images{margin-left: 0px;}
.img-forntsimg.id-images .img-forntsimg{margin-left: 0px;}
      .img-forntsimg{margin-left: 110px;word-break: break-all;}
      .title-imgd{float: left;}
      .modal-dialog.maxwdths{
            max-width: 650px;
      }
     .divadrs-class .title-imgd.newbr.imgfroms{display: block;float: none;}
      .divadrs-class .address-inx-age{margin-left: 110px;}
      .chwstatus.text-right.right-side-status{position: static; margin-bottom: 20px;}
    </style>
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">Manage {{$module_title or ''}}</h4>
      </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">
            @php
                $user = Sentinel::check();
            @endphp

            @if(isset($user) && $user->inRole('admin'))
                <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
            @endif
                
            <li class="active">Manage {{$module_title or ''}}</li>
         </ol>
      </div>
   </div>
   <!-- BEGIN Main Content -->
   <div class="col-sm-12">
      <div class="white-box">
         @include('admin.layout._operation_status')
         {!! Form::open([ 'url' => $module_url_path.'/multi_action',
         'method'=>'POST',
         'enctype' =>'multipart/form-data',   
         'class'=>'form-horizontal', 
         'id'=>'frm_manage' 
         ]) !!}
         {{ csrf_field() }}
         <div class="pull-right">
            <a href="{{ $module_url_path.'/create'}}" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add New {{ str_singular($module_title) }}"><i class="fa fa-plus"></i> </a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 
            {{--  <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a>   --}}
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
         </div>
         <br/>
         <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                     <th>
                        <div class="checkbox checkbox-success">
                          <input class="checkboxInputAll" id="checkbox0" type="checkbox">
                          <label for="checkbox0">  </label>
                        </div>
                     </th>
                     <th>Name</th>
                     <th>Email</th>
                     {{-- <th>User Type</th> --}}
                     <th>Status</th>
                     <th>Email Verification Status</th>
                     <th>Age Verification Status</th>
                     <th>Profile Verification Status</th>
                     <!-- <th>Average Rating</th>
                     <th>Trades</th> -->
                     <th>Total Wallet Amount</th>
                     <th width="200px">Action</th>
                  </tr>
                 <!--  <tr>
                    <td></td>
                    <td><input type="text" name="q_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td><input type="text" name="q_email" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr> -->
              </thead>
              <tbody>
              </tbody>
            </table>
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>





<!-------------------start of profile view modal------------------------------------->

<div class="modal fade" id="show_profile_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog maxwdths" role="document">
    <input type="hidden" name="first_name" id="first_name" value="">
    <input type="hidden" name="last_name" id="last_name" value="">
    <input type="hidden" name="user_id" id="user_id" value="">
    <input type="hidden" name="approve_status" id="approve_status" value="">
    <input type="hidden" name="email" id="email" value="">
    <input type="hidden" name="phone" id="phone" value="">
    <input type="hidden" name="street_address" id="street_address" value="">
    <input type="hidden" name="country" id="country" value="">
    <input type="hidden" name="state" id="state" value="">
    <input type="hidden" name="zipcode" id="zipcode" value="">
    <input type="hidden" name="city" id="city" value="">
    <input type="hidden" name="billing_country" id="billing_country" value="">
    <input type="hidden" name="billing_state" id="billing_state" value="">
    <input type="hidden" name="billing_zipcode" id="billing_zipcode" value="">
    <input type="hidden" name="billing_street_address" id="billing_street_address" value="">
    <input type="hidden" name="billing_city" id="billing_city" value="">



    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">View Profile Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div id="viewagedetails">
        <div class="row">
            <div class="col-md-12 text-right">
              <span id="approved_profile" class="label label-success" style="display:none">Approved</span>
              <span id="rejected_profile" class="label label-danger" style="display:none">Rejected</span>
            </div>
            <div class="col-md-6">
                <div class="title-imgd">First Name</div>
                <div class="img-forntsimg" id="show_first_name"></div>
            </div>
             <div class="col-md-6">
                <div class="title-imgd">Last Name</div>
                <div class="img-forntsimg" id="show_last_name"></div>
            </div>        
             <div class="col-md-6">
                <div class="title-imgd">Email</div>
                <div class="img-forntsimg" id="show_email"></div>
            </div>
            {{--  <div class="col-md-6">
                <div class="title-imgd">Phone</div>
                <div class="img-forntsimg" id="show_phone"></div>
            </div>    --}} 

            <div class="col-md-6">
                <div class="title-imgd">Address</div>
                <div class="img-forntsimg" id="show_street_address"></div>
            </div>   

             <div class="col-md-6">
                <div class="title-imgd">City</div>
                <div class="img-forntsimg" id="show_city"></div>
            </div>   

             <div class="col-md-6">
                <div class="title-imgd">State</div>
                <div class="img-forntsimg" id="show_state"></div>
            </div>

             <div class="col-md-6">
                <div class="title-imgd">Country</div>
                <div class="img-forntsimg" id="show_country"></div>
            </div>
            
            
               
             <div class="col-md-6">
                <div class="title-imgd">Zipcode</div>
                <div class="img-forntsimg" id="show_zipcode"></div>
            </div>  
            
             <div class="col-md-6">
                <div class="title-imgd">Billing Address</div>
                <div class="img-forntsimg" id="show_billingstreetaddress"></div>
            </div> 

             <div class="col-md-6">
                <div class="title-imgd">Billing City</div>
                <div class="img-forntsimg" id="show_billingcity"></div>
            </div>

             <div class="col-md-6">
                <div class="title-imgd">Billing State</div>
                <div class="img-forntsimg" id="show_billingstate"></div>
            </div>

             <div class="col-md-6">
                <div class="title-imgd">Billing Country</div>
                <div class="img-forntsimg" id="show_billingcountry"></div>
            </div>
                      

           <div class="col-md-6">
                <div class="title-imgd">Billing Zipcode</div>
                <div class="img-forntsimg" id="show_billingzipcode"></div>
            </div>

            


        </div>   
      
     </div>  <!------row div end here------------->
     </div><!------body div end here------------->
      <div class="modal-footer">
        <button type="button" class="btn btn-success approveprofile" id="approveprofilebtn" data-dismiss="modal">Approve</button> 
        <button type="button" class="btn btn-danger rejectprofile" id="rejectprofilebtn">Reject</button>
      </div>
    </div>
  </div>
</div>
<!-------------------end of profile view modal------------------------------------->



<div class="modal fade" id="reject_profile_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="buyer_id" id="buyer_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Reject Profile Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason &nbsp;</div>
          <textarea id="note_reject" name="note_reject" class="form-control" rows="5"></textarea>
          <span id="note_err"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectprofbtn" id="rejectprofbtn">Reject</button>
      </div>
    </div>
  </div> 
</div>



<!-------------------------end of reject profile modal-------------------------------------->


<!--- Start of Age Verification Model -->

<div class="modal fade" id="show_age_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog maxwdths" role="document">
    <input type="hidden" name="age_verification_front_image" id="age_verification_front_image" value="">
    <input type="hidden" name="age_verification_back_image" id="age_verification_back_image" value="">
    <input type="hidden" name="age_verification_selfie_image" id="age_verification_selfie_image" value="">

    <input type="hidden" name="age_verification_user_id" id="age_verification_user_id" value="">
    <input type="hidden" name="age_verification_age_address" id="age_verification_age_address" value="">

    <input type="hidden" name="age_verification_approve_status" id="age_verification_approve_status" value="">
    <input type="hidden" name="age_verification_age_category" id="age_verification_age_category" value="">

     <input type="hidden" name="age_verification_address_proof" id="age_verification_address_proof" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Age Verification Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">

        <div class="chwstatus text-right right-side-status">
          <span id="age_verification_status" class="label"></span>
        </div>

        <div id="showerror"></div>

       <div id="viewagedetails">
            <div id="age_proof_section">
              <div class="row">
                   <div class="col-md-6">
                    <div class="div-class-ind">
                      <div class="title-imgd newbr imgfroms">Front of ID</div>
                      <div class="id-images" id="front_image_div"></div>
                      <div class="clearfix"></div>
                    </div>
                   </div>
                   <div class="col-md-6">
                    <div class="div-class-ind">
                      <div class="title-imgd newbr imgfroms">Back of ID</div>
                      <div class="img-forntsimg id-images" id="back_image_div"></div>
                      <div class="clearfix"></div>
                    </div>

                  </div>
              </div>

               <div class="row">
                   <div class="col-md-6">
                    <div class="div-class-ind">
                      <div class="title-imgd newbr imgfroms">Selfie</div>
                      <div class="img-forntsimg id-images" id="selfie_image_div"></div>
                      <div class="clearfix"></div>
                    </div>
                   </div>

                    <div class="col-md-6">
                      <div class="div-class-ind">
                        <div class="title-imgd newbr imgfroms">Address Proof</div>                      
                        <div class="img-forntsimg id-images" id="address_proof_div"></div>
                        <div class="clearfix"></div>
                      </div>
                   </div>

                    <div class="col-md-6">
                      <div class="div-class-ind">
                        <div class="title-imgd">Age</div>
                        <div class="img-forntsimg" id="age"></div>
                        <div class="clearfix"></div>
                      </div>
                    </div>

                  

              </div>
            </div>
            
            <div class="row">
                 <div class="col-md-6">
                        <div class="div-class-ind">
                          <div class="title-imgd">Date of birth</div>
                          <div class="img-forntsimg" id="date_of_birth"></div>
                          <div class="clearfix"></div>
                        </div>
                </div>

                 <div class="col-md-6">
                  <div class="div-class-ind">
                    <div class="title-imgd">Phone</div>
                    <div class="img-forntsimg" id="phone_number"></div>
                    <div class="clearfix"></div>
                  </div>
                </div>
            </div>

              
            <div class="divadrs-class">
              <div class="title-imgd add-spct">Address</div>
              <div class="address-inx-age add-norm">
                  <span id="age_verification_address"></span>
              </div>
            </div>




            <!------added-shipping-&-billing-for age----------------->
            <hr/>
            <div class="row"> 
                <div class="col-md-12">
                          <div class="title-imgd">
                            Shipping Address : 
                          </div>
                </div><br/><br/>

                 <div class="col-md-6">
                  <div class="div-class-ind">
                    <div class="title-imgd">Address</div>
                    <div class="img-forntsimg" id="show_street_address_age"></div>
                    <div class="clearfix"></div>
                    </div>
                </div>   

                 <div class="col-md-6">
                  <div class="div-class-ind">
                    <div class="title-imgd">City</div>
                    <div class="img-forntsimg" id="show_city_age"></div>
                    <div class="clearfix"></div>
                  </div>
                </div>   

                 <div class="col-md-6">
                  <div class="div-class-ind">
                    <div class="title-imgd">State</div>
                    <div class="img-forntsimg" id="show_state_age"></div>
                    <div class="clearfix"></div>
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="div-class-ind">
                    <div class="title-imgd">Country</div>
                    <div class="img-forntsimg" id="show_country_age"></div>
                    <div class="clearfix"></div>
                  </div>
                </div>
                
                 <div class="col-md-6">
                  <div class="div-class-ind">
                    <div class="title-imgd">Zipcode</div>
                    <div class="img-forntsimg" id="show_zipcode_age"></div>
                    <div class="clearfix"></div>
                  </div>
                </div>  
            </div>
                <hr/>
               <div class="row">
                        <div class="col-md-12">
                           <div class="title-imgd">
                            Billing Address : 
                          </div>
                        </div> <br/><br/>
                      
                       <div class="col-md-6">
                        <div class="div-class-ind">
                          <div class="title-imgd"> Address</div>
                          <div class="img-forntsimg" id="show_billingstreetaddress_age"></div>
                          <div class="clearfix"></div>
                        </div>
                      </div> 

                       <div class="col-md-6">
                        <div class="div-class-ind">
                          <div class="title-imgd"> City</div>
                          <div class="img-forntsimg" id="show_billingcity_age"></div>
                          <div class="clearfix"></div>
                        </div>
                      </div>

                       <div class="col-md-6">
                        <div class="div-class-ind">
                          <div class="title-imgd"> State</div>
                          <div class="img-forntsimg" id="show_billingstate_age"></div>
                          <div class="clearfix"></div>
                        </div>
                      </div>

                       <div class="col-md-6">
                        <div class="div-class-ind">
                          <div class="title-imgd"> Country</div>
                          <div class="img-forntsimg" id="show_billingcountry_age"></div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                                

                     <div class="col-md-6">
                      <div class="div-class-ind">
                          <div class="title-imgd">Zipcode</div>
                          <div class="img-forntsimg" id="show_billingzipcode_age"></div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
              </div>
            <!----------------end-ship-billing-on--age-verfication--------->




            <div class="divadrs-class">
              <div id="rejectdiv">
                <div class="desc-sellr-admin">
                    <div class="title-imgd add-spct">Reject Reason </div>
                    <div class="img-forntsimg add-norm" id="show_reject_reason"></div>
                    </div>
                </div>
          </div>

          <div class="divadrs-class">
            <div id="age_category_div">
              <div class="desc-sellr-admin">
                  <div class="title-imgd add-spct">Age Category : </div>
                  <div class="img-forntsimg add-norm" id="show_age_category"></div>
                  </div>
              </div>
          </div>
          
          <div class="divadrs-class"> 
            <div id="age_verification_chooseage_section"> 
              <div class="col-md-4">
                <label class="title-imgd add-spct">Age Category <i class="red">*</i></label></div>
              <div class="col-md-8">
                <input type="radio" name="age_category" value="1" style="display: none">  
                <input type="radio" name="age_category" id="age_cat" value="2"> 21+
              </div>
              <span id="caterr"></span>
            </div>
          </div>
     </div>  <!------row div end here------------->
     
      </div><!------body div end here------------->
      <div class="modal-footer">
        <button type="button" class="btn btn-success approveagebtn" id="approveagebtn" >Approve</button>
        <button type="button" class="btn btn-danger rejectagebtn" id="rejectagebtn">Reject</button>
        <button type="button" class="btn btn-info setagecategorybtn" id="setagecategorybtn" >Set Age Catgory</button>        

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="reject_age_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="buyer_id" id="buyer_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Reject Age Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason</div>
            <textarea id="note" name="note" class="form-control" rows="5"></textarea>
            <span id="noteerr"></span>
                    
     </div>  <!------row div end here------------->
         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectbtn" id="rejectbtn">Reject</button>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="set_agecategory_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="buyer_id" id="buyer_id" value="">
    <input type="hidden" name="hidden_age_category" id="hidden_age_category" value="">


    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Set Age Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" >
          <div class="col-md-12">
             <div class="form-group">
               <div class="col-md-6"> <label for="">Age Category <i class="red">*</i></label></div>
               <div class="col-md-6">
                 <input type="radio" name="age_category" value="1" style="display: none">  
                 <input type="radio" name="age_category" value="2"> 21+
              </div>
               <span id="caterrs"></span>
            </div>
          </div>
     </div>  <!------row div end here------------->
         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger saveagecatbtn" id="saveagecatbtn">Save</button>
      </div>
    </div>
  </div>
</div>
<!-----------------------------end of set age category modal-------------->


<script type="text/javascript" src="{{url('/')}}/assets/common/js/smartphoto.js?v=1""></script>

<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "{{ $module_url_path }}";
   var base_url = "{{ url('/')}}";
   var user_id_proof = "{{ $user_id_proof }}";
   let smartPhotoInit = undefined;


   $(document).on("click",".view_profile_section",function() {
      var first_name = $(this).attr('first_name');
      var last_name = $(this).attr('last_name');
      var user_id = $(this).attr('user_id');
      var approve_status = $(this).attr("approve_profile_status");
      var email = $(this).attr('email');
      var phone= $(this).attr('phone');
      var street_address= $(this).attr('street_address');
      var country= $(this).attr('country');
      var state= $(this).attr('state');
      var zipcode = $(this).attr('zipcode');
      var city = $(this).attr('city');

      var billing_country= $(this).attr('billing_country');
      var billing_state= $(this).attr('billing_state');
      var billing_zipcode= $(this).attr('billing_zipcode');
      var billing_street_address = $(this).attr('billing_street_address');
      var billing_city = $(this).attr('billing_city');


     // if(first_name && last_name && email && phone && street_address && country && state)
      //{
        $("#show_profile_section").modal('show');

          $("#first_name").val(first_name);
          $("#last_name").val(last_name);
          $("#user_id").val(user_id);
          $("#email").val(email);
          $("#phone").val(phone);
          $("#street_address").val(street_address);
          $("#country").val(country);
          $("#state").val(state);
          $("#zipcode").val(zipcode);
          $("#city").val(city);

          $("#billing_country").val(billing_country);
          $("#billing_state").val(billing_state);
          $("#billing_zipcode").val(billing_zipcode);
          $("#billing_street_address").val(billing_street_address);
          $("#billing_city").val(billing_city);

         
          if(first_name)
            $('#show_first_name').html(first_name);
          else
            $('#show_first_name').html('-');

          if(last_name)
            $('#show_last_name').html(last_name);
          else
            $('#show_last_name').html('-');


          if(email)
            $('#show_email').html(email);
          else
            $('#show_email').html('-');

         //  if(phone)
         //  $('#show_phone').html(phone);
         // else
         //  $('#show_phone').html('-');

          if(street_address)
            $('#show_street_address').html(street_address);
          else
            $('#show_street_address').html('-');


          if(country)
            $('#show_country').html(country);
          else
            $('#show_country').html('-');

           if(state) 
             $('#show_state').html(state);
           else
             $('#show_state').html('-');

           if(zipcode) 
             $('#show_zipcode').html(zipcode);
           else
             $('#show_zipcode').html('-');

            if(city) 
             $('#show_city').html(city);
           else
             $('#show_city').html('-');


            if(billing_country) 
             $('#show_billingcountry').html(billing_country);
           else
             $('#show_billingcountry').html('-');

            if(billing_state) 
             $('#show_billingstate').html(billing_state);
           else
             $('#show_billingstate').html('-');

             if(billing_zipcode) 
             $('#show_billingzipcode').html(billing_zipcode); 
           else
             $('#show_billingzipcode').html('-');

           if(billing_street_address)
            $("#show_billingstreetaddress").html(billing_street_address);
           else
            $('#show_billingstreetaddress').html('-');

           if(billing_city)
            $("#show_billingcity").html(billing_city);
           else
            $('#show_billingcity').html('-');


           if(approve_status==1)
          {
            $("#approveprofilebtn").hide();
            $("#approved_profile").show();
            $("#rejectprofilebtn").show();
          }
            if(approve_status==2)
          {
            $("#rejectprofilebtn").hide();
            $("#rejected_profile").show();
          }



           if((first_name=="" || last_name=="" || email=="" || street_address=="" || country=="" || state=="" || zipcode==""  || city=="" || billing_country=="" || billing_state=="" || billing_zipcode=="" || billing_street_address=="" || billing_city=="") && approve_status==0)
          {
           
            $(".approveprofile").hide();
            $(".rejectprofile").hide();
          }
          else if(first_name.trim()!='' && last_name.trim()!='' && email.trim()!='' && street_address.trim()!='' && country.trim()!='' && state.trim()!='' && zipcode.trim()!=''  
            && city.trim()!=''  && billing_country!='' && billing_state!='' && billing_zipcode!='' && billing_street_address!='' 
            && billing_city!='' && approve_status==3)
          {
             
              $(".approveprofile").show();
              $(".rejectprofile").show();
          }


     /* }
      else
      {
         swal('Warning','All profile details not filled by buyer','warning');
      }*/

    });



     //start of age approve
     $(document).on("click",".approveprofile",function() {
      var user_id = $("#user_id").val();
      if(user_id)
      {
          swal({
            title: 'Do you really want to approve the profile details of this user?',
            type: "warning",
            showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            confirmButtonColor: "#8d62d5",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: false
          },
          function(isConfirm,tmp)
          {
            if(isConfirm==true)
            {

                $.ajax({
                    url: module_url_path+'/approveprofile',
                    type:"GET",
                    data: {user_id:user_id},             
                    dataType:'json',
                    beforeSend: function()
                    {      
                      showProcessingOverlay();
                    },
                    success:function(response)
                    { 
                        hideProcessingOverlay();

                        if(response.status == 'SUCCESS')
                        { 
                          swal({
                                  title: 'Success',
                                  text: response.description,
                                  type: 'success',
                                  confirmButtonText: "OK",
                                  closeOnConfirm: true
                               },
                              function(isConfirm,tmp)
                              {                       
                                if(isConfirm==true)
                                {
                                    window.location.reload();
                                }

                              });
                        }
                        else
                        {                
                          swal('Error',response.description,'error');
                        }  
                     }//success  
                 }); // end of ajax
              }
          }) // end of confirm box  

      }    
    }); 


     // function to show reject profile modal
     $(document).on("click","#rejectprofilebtn",function() {
      $("#reject_profile_sectionmodal").modal('show');
      $("#show_profile_section").modal('hide');      
      var user_id = $("#user_id").val();
      var approve_status = $("#approve_status").val();

      $("#buyer_id").val(user_id);
    });   

     //rejectprofbtn

     $(document).on("click",".rejectprofbtn",function() {
      
      var user_id = $("#buyer_id").val();
      var note_reject = $("#note_reject").val();
     
      if(note_reject=="")
      {
        $("#note_err").html('Please enter note');
        $("#note_err").css('color','red');
      }else{
         $("#note_err").html('');
          if(user_id && note)
          { 


              swal({
                  title: 'Do you really want to reject the profile details of this user?',
                  type: "warning",
                  showCancelButton: true,
                  // confirmButtonColor: "#DD6B55",
                  confirmButtonColor: "#8d62d5",
                  confirmButtonText: "Yes, do it!",
                  closeOnConfirm: false
                },
                function(isConfirm,tmp)
                {
                  if(isConfirm==true)
                  {


                        $.ajax({
                            url: module_url_path+'/rejectprofile',
                            type:"GET",
                            data: {user_id:user_id,note:note_reject},             
                            dataType:'json',
                            beforeSend: function(){      
                              showProcessingOverlay();      
                            },
                            success:function(response)
                            { 
                                hideProcessingOverlay();
                                  if(response.status == 'SUCCESS')
                                      { 
                                        swal({
                                                title: 'Success',
                                                text: response.description,
                                                type: 'success',
                                                confirmButtonText: "OK",
                                                closeOnConfirm: true
                                             },
                                            function(isConfirm,tmp)
                                            {                       
                                              if(isConfirm==true)
                                              {
                                                  window.location.reload();
                                              }

                                            });
                                      }
                                      else
                                      {                
                                        swal('Error',response.description,'error');
                                      }  
                            }  
                         }); // end of ajax

                     }
                  })// END OF CONFIRM BOX      

           } //if user id and note
      } //else    
    }); // end of profile reject btn 


   //-----------------------------start of age section -------------------//
   // for set category
   $(document).on("click","#setagecategorybtn",function() {
      $("#set_agecategory_modal").modal('show');
      $("#show_age_section").modal('hide');      
      var user_id = $("#age_verification_user_id").val();
      $("#buyer_id").val(user_id);

      var age_category = $("#age_category").val();      
      $("#hidden_age_category").val(age_category);
      $('input:radio[name=age_category]').val([age_category]);

    });

// for save category
  

     $(document).on("click",".saveagecatbtn",function() {
      
      var user_id = $("#buyer_id").val();      
      //$("#rejectreason").show();
       // $("#viewagedetails").hide();
      var age_category =  $('input[name=age_category]:checked').val();
      if($('input[name="age_category"]:checked').length == 0) 
      {

        $("#caterrs").html('Please select age category');
        $("#caterrs").css('color','red');
      }else{
        $("#caterrs").html('');
          if(user_id && age_category)
          { 
           

              $.ajax({
                  url: module_url_path+'/savecategoryage',
                  type:"GET",
                  data: {user_id:user_id,age_category:age_category},             
                  dataType:'json',
                  beforeSend: function(){            
                  },
                  success:function(response)
                  {
                        if(response.status == 'SUCCESS')
                            { 
                              swal({
                                      title: 'Success',
                                      text: response.description,
                                      type: 'success',
                                      confirmButtonText: "OK",
                                      closeOnConfirm: true
                                   },
                                  function(isConfirm,tmp)
                                  {                       
                                    if(isConfirm==true)
                                    {
                                        window.location.reload();
                                    }

                                  });
                            }
                            else
                            {                
                              swal('Error',response.description,'error');
                            }  
                  }  
               }); 
           } //if user id and note
      } //else    
    });
 



 
// for view age details
     $(document).on("click",".view_age_section",function() { 
      $('input:radio[id=age_cat]').prop('checked', true); // set 21+ age selected

      // $('#age_body').html('');

      var front_image    = $(this).attr('front_image');
      var back_image     = $(this).attr('back_image');
      var selfie_image   = $(this).attr('selfie_image');
      var address_proof   = $(this).attr('address_proof');
      var user_id         = $(this).attr('user_id');
      var date_of_birth   = $(this).attr('date_of_birth');
      var phone           = $(this).attr('phone');

      var age_address    = $(this).attr('age_address');
      var age_category   = $(this).attr("age_category");
      var approve_status = $(this).attr("approve_status");
      var note           = $(this).attr('note');



      /**********Shipping*&*Billing****************/

      var street_address= $(this).attr('street_address');
      var country= $(this).attr('country');
      var state= $(this).attr('state');
      var zipcode = $(this).attr('zipcode');
      var city = $(this).attr('city');

      var billing_country= $(this).attr('billing_country');
      var billing_state= $(this).attr('billing_state');
      var billing_zipcode= $(this).attr('billing_zipcode');
      var billing_street_address = $(this).attr('billing_street_address');
      var billing_city = $(this).attr('billing_city');

      /*************************************************/

      if(approve_status=='1')
      {
        $('#age_verification_status').html('Approved').addClass('label label-success').removeClass('label-danger label-warning');
        $("#setagecategorybtn").show();
        $('#age_proof_section').hide();
        $('#age_verification_chooseage_section').hide();
        
      }
      else if(approve_status=='2')
      {
        $('#age_verification_status').html('Rejected').addClass('label label-danger').removeClass('label-success label-warning');
        $("#setagecategorybtn").hide();        
        $('#age_proof_section').hide();
       
      }
      else if(approve_status == 0)  // commentd at 12-feb-20
      {
        $('#age_verification_status').html('Pending').addClass('label label-warning').removeClass('label-danger label-success');
        $('#age_proof_section').show();        
        $('#setagecategorybtn').hide();
      }
       else if(approve_status == 3)
      {
        $('#age_verification_status').html('Submitted').addClass('label label-warning').removeClass('label-danger label-success');
        $('#age_proof_section').show();        
        $('#setagecategorybtn').hide();
      }

      //if(front_image || back_image || selfie_image || user_id || age_address)
      if(front_image || back_image || selfie_image || user_id)

      {
        



          $("#show_age_section").modal('show');          
          $("#age_verification_user_id").val(user_id);
          $("#age_verification_front_image").val(front_image);
          $("#age_verification_back_image").val(back_image);
          $("#age_verification_selfie_image").val(selfie_image);
          $("#age_verification_age_address").val(age_address);
          $("#age_verification_approve_status").val(approve_status);
          $("#age_verification_age_category").val(age_category);
          $("#age_verification_address_proof").val(address_proof);

          if(age_address){
          $("#age_verification_address").html(age_address);
          }else{
          $("#age_verification_address").html('-');
          }
          

          if(front_image)
          {      
            var src  = user_id_proof+front_image; 
            var front_img_src = '<img src="'+src+'" width="100px" height="100px" />';

            front_img =  '<a href="'+src+'" class="js-img-viwer" id="link_front_image" data-caption="Front of ID">\
                        <div class="img-forntsimg" id="show_front_image">'+front_img_src+'</div>\
                      </a>';
          }
          else
          { 
            var front_img =' - ';
          }            

          $("#front_image_div").html(front_img);
          

          if(back_image)
          {
           
            var src_back = user_id_proof+back_image; 
            var back_img_src = '<img src="'+src_back+'" width="100px" height="100px" />';
            
            var back_img = ' <a href="'+src_back+'" class="js-img-viwer" id="link_back_image" data-caption="Back of ID">\
                        <div class="img-forntsimg" id="show_back_image">'+back_img_src+'</div>\
                      </a>';
          }
          else
          {  
            var back_img =' - ';
            
          }               

          // $("#show_back_image").html(back_img);
          $("#back_image_div").html(back_img);
          

          if(selfie_image)
          {
            var src_selfie = user_id_proof+selfie_image; 
            var selfie_img_src = '<img src="'+src_selfie+'" width="100px" height="100px" />';

            var selfie_img =  '<a href="'+src_selfie+'" class="js-img-viwer" id="link_selfie_image" data-caption="Selfie">\
                                <div class="img-forntsimg" id="show_selfie_image">'+selfie_img_src+'</div>\
                              </a>';
           
          }
          else
          {   
            var selfie_img =' - ';              
          }               

          // $("#show_selfie_image").html(selfie_img);
          $("#selfie_image_div").html(selfie_img);

           if(address_proof)
          {
            var ext = address_proof.split('.').pop();
            if(ext=="doc" || ext=="pdf" || ext=="docx" || ext=="xls" || ext=="xlsx")
            {
               var src_addrproof     = user_id_proof+address_proof; 
               var addressproof_img_src = '<a href="'+src_addrproof+'" target="_blank">View Address Proof</a>';
            }
            else
            {
               var src_addrproof     = user_id_proof+address_proof; 
               var addressproof_img_src = '<img src="'+src_addrproof+'" width="100px" height="100px" />';
            }
           
            var addressproof_img = '<a href="'+src_addrproof+'" class="js-img-viwer" id="link_address_proof" data-caption="Address Proof">\
                  <div class="img-forntsimg" id="show_address_proof">'+addressproof_img_src+'</div>\
                </a>';
          }
          else
          {
            var addressproof_img =' - ';
           
          }               

          $("#address_proof_div").html(addressproof_img);


          /**********shipping*&*Billing********************/
             if(street_address)
            $('#show_street_address_age').html(street_address);
            else
            $('#show_street_address_age').html('-');


          if(country){
            $('#show_country_age').html(country);
          }
          else{
            $('#show_country_age').html('-');
          }

           if(state) 
             $('#show_state_age').html(state);
           else
             $('#show_state_age').html('-');

           if(zipcode) 
             $('#show_zipcode_age').html(zipcode);
           else
             $('#show_zipcode_age').html('-');

            if(city) 
             $('#show_city_age').html(city);
           else
             $('#show_city_age').html('-');


            if(billing_country) 
             $('#show_billingcountry_age').html(billing_country);
           else
             $('#show_billingcountry_age').html('-');

            if(billing_state) 
             $('#show_billingstate_age').html(billing_state);
           else
             $('#show_billingstate_age').html('-');

             if(billing_zipcode) 
             $('#show_billingzipcode_age').html(billing_zipcode); 
           else
             $('#show_billingzipcode_age').html('-');

           if(billing_street_address)
            $("#show_billingstreetaddress_age").html(billing_street_address);
           else
            $('#show_billingstreetaddress_age').html('-');

           if(billing_city)
            $("#show_billingcity_age").html(billing_city);
           else
            $('#show_billingcity_age').html('-');

          /************Shipping*&*Billing**********************/



                    
          callImageViewer();


          if (date_of_birth) {

              $("#date_of_birth").html(date_of_birth);

              /* --------------- AGE CALCULATION --------------- */

              var today = new Date();
              var birthDate = new Date(date_of_birth);
              var age = today.getFullYear() - birthDate.getFullYear();
              var m = today.getMonth() - birthDate.getMonth();
              if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                  age = age - 1;
              }

              /* --------------- AGE CALCULATION --------------- */

              $("#age").html(age+ " Years");

          }
          else {

              $("#date_of_birth").html("NA");
              $("#age").html("NA");
          }

          if (phone) {
            $("#phone_number").html(phone);
          }
          else {
            $("#phone_number").html("NA");
          }


          if(approve_status==2)
          {
              $("#rejectdiv").show();
              $("#show_reject_reason").html(note);

              //hide age category
              $("#age_category_div").hide();

          }
          else
          {
              $("#rejectdiv").hide();
          }

          if(approve_status==2)
          {
            $("#rejectagebtn").hide();
            $("#rejected_age").show();
          }
          
          if(approve_status==1)
          {
            $("#approveagebtn").hide();
            $("#approved_age").show();
            $("#rejectagebtn").show();


            /**********show age category************/
            $("#age_category_div").show();
            if(age_category==1)
              var age = '18+';
            else if(age_category==2)
              var age = '21+';
            if(age_category>0)
            $("#show_age_category").html(age);
            else
             $("#show_age_category").html('-');  
            /*********end of show age category******/

          }

           // if(front_image=="" && back_image=="" && selfie_image=="" && address_proof=="" && approve_status==0)
            if(front_image=="" && back_image=="" && selfie_image=="" && approve_status==0)  
          {
            $("#rejectagebtn").hide();
            $("#approveagebtn").hide();
            $("#age_verification_chooseage_section").hide();
            //hide age category
            $("#age_category_div").hide();
          }
          // else if(front_image && back_image && selfie_image && address_proof && approve_status==3)
          else if(front_image && back_image && selfie_image && approve_status==3)

          {
   
              $("#approveagebtn").show();
              $("#rejectagebtn").show();
            $("#age_verification_chooseage_section").show();
              $("#age_category_div").hide();
          }   
          // else if(front_image && back_image && selfie_image && address_proof && approve_status==0){ 
          else if(front_image && back_image && selfie_image && approve_status==0){   
            // new codnition added for pending status
   
              $("#approveagebtn").hide();
              $("#rejectagebtn").hide();
              $("#age_verification_chooseage_section").hide();
              $("#age_category_div").hide();
              $("#setagecategorybtn").hide();
          }   



      }    
    });



  $(document).on("click","#approveagebtn",function() {


    var user_id = $("#age_verification_user_id").val();
    var front_image = $("#age_verification_front_image").val();
    var back_image = $("#age_verification_back_image").val();
    var age_address = $("#age_verification_age_address").val();
    var selfie_image = $("#age_verification_selfie_image").val();
    var address_proof = $("#age_verification_address_proof").val();

    var age_category =  $('input[name=age_category]:checked').val();
    
    if($('input[name="age_category"]:checked').length == 0) 
    {
      $("#caterr").html('Please select age category');
      $("#caterr").css('color','red');
      
    }else{
      // if(user_id && front_image && back_image && selfie_image && address_proof && age_address && age_category)
      if(user_id && front_image && back_image && selfie_image && age_category)
      {
        $("#showerror").html('');

        swal({
          title: 'Do you really want to approve the age verfication details of this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {

            $.ajax({
              url: module_url_path+'/approveage',
              type:"GET",
              data: {user_id:user_id,age_category:age_category},             
              dataType:'json',
              beforeSend: function(){      
               showProcessingOverlay();       
              },
              success:function(response)
              {
                hideProcessingOverlay(); 
                if(response.status == 'SUCCESS')
                { 
                  swal({
                    title: 'Success',
                    text: response.description,
                    type: 'success',
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                  },
                  function(isConfirm,tmp)
                  {                       
                    if(isConfirm==true)
                    {
                      window.location.reload();
                    }

                  });
                }
                else
                {                
                  swal('Error',response.description,'error');
                }  
              }  
            }); // end of ajax

          }
        }) // end of confirm 
      }else{
        swal('Alert!','All age verification details not filled by buyer');
      }  
    }  
    
  });


  $(document).on("click","#rejectagebtn",function() {
     
    var user_id = $("#age_verification_user_id").val();
    var front_image = $("#front_image").val();
    var back_image = $("#back_image").val();
    var selfie_image= $("#selfie_image").val();
    var age_address = $("#age_address").val();
    $("#buyer_id").val(user_id);     
    $("#reject_age_sectionmodal").modal('show');
    $("#show_age_section").modal('hide');          

  });


  $(document).on("click",".rejectbtn",function() {
      
    var user_id = $("#buyer_id").val();
    
    //$("#rejectreason").show();
   // $("#viewagedetails").hide();
    var note = $("#note").val();
    if(note=="")
    {
      $("#noteerr").html('Please enter the reason for rejection');
      $("#noteerr").css('color','red');
    }else{
       $("#noteerr").html('');
        if(user_id && note)
        { 
       swal({
          title: 'Do you really want to reject the age verfication details of this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {

            $.ajax({
                url: module_url_path+'/rejectage',
                type:"GET",
                data: {user_id:user_id,note:note},             
                dataType:'json',
                beforeSend: function(){    
                 showProcessingOverlay();           
                },
                success:function(response)
                {
                  hideProcessingOverlay(); 
                  if(response.status == 'SUCCESS')
                  { 
                    swal({
                        title: 'Success',
                        text: response.description,
                        type: 'success',
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                     },
                    function(isConfirm,tmp)
                    {                       
                      if(isConfirm==true)
                      {
                          window.location.reload();
                      }

                    });
                  }
                  else
                  {                
                    swal('Error',response.description,'error');
                  }  
                }  
             }); // end of ajax

            }
          })// end of confirm box

        } //if user id and note
      } //else    
  });


    

   /****************************end of age section**************************************/
   function show_details(url)
   { 
      
       window.location.href = url;
   } 
   
   function confirm_delete(ref,event)
   {
      var delete_param = 'Buyer';
      confirm_action(ref,event,'Do you really want to delete this record?',delete_param);
   }

   function confirm_approve(ref,event)
   {
      confirm_action(ref,event,'Do you really want to approve this record?');
   }
   
   function confirm_approve_status(ref,event)
   {
      confirm_action(ref,event,'Do you really want to approve id proof of this record?');
   }

   /*Script to show table data*/
   
   var table_module = false;
   $(document).ready(function()
   {
    
   table_module = $('#table_module').DataTable({ 
     processing: true,
     serverSide: true,
     autoWidth: false,
     bFilter: false ,     
     ajax: {
     'url':'{{ $module_url_path.'/get_records'}}',
     'data': function(d)
       {
         d['column_filter[q_name]']                      = $("input[name='q_name']").val()
         d['column_filter[q_email]']                     = $("input[name='q_email']").val()
         d['column_filter[q_user_type]']                 = $("select[name='q_user_type']").val()
         d['column_filter[q_status]']                    = $("select[name='q_status']").val()
         d['column_filter[q_vstatus]']                   = $("select[name='q_vstatus']").val()
         d['column_filter[q_email_verification_status]'] = $("select[name='q_email_verification_status']").val()
         d['column_filter[q_age_verification_status]']   = $("select[name='q_age_verification_status']").val()
          d['column_filter[q_profile_verification_status]']   = $("select[name='q_profile_verification_status']").val()
       }
     },
     columns: [
     {
       render : function(data, type, row, meta) 
       {
       return '<div class="checkbox checkbox-success"><input type="checkbox" '+
               ' name="checked_record[]" '+  
               ' value="'+row.enc_id+'" id="checkbox'+row.id+'" class="case checkboxInput"/><label for="checkbox'+row.id+'">  </label></div>';
       },
       "orderable": false,
       "searchable":false
     },
     {data: 'user_name', "orderable": true, "searchable":false},
     {data: 'email', "orderable": true, "searchable":false},
     // {                  
     //    render(data, type, row, meta)
     //    {
     //        if(row.user_type == 'buyer')
     //        {
     //         return `Buyer`;
     //        }
     //        else if(row.user_type == 'seller')
     //        {
     //          return `Seller`;
     //        }
     //    },

     //      orderable: false, 
     //      searchable: false,
          
     //  },
     {
       render : function(data, type, row, meta) 
       {
         return row.build_status_btn;
       },
       "orderable": false, "searchable":false
     },
     {
      render : function(data, type, row, meta)
      {
        /*if(row.is_trusted==1) {
          var is_trusted = '<input type="checkbox" checked data-size="small"  data-enc_id="'+btoa(row.id)+'" class="js-switch toggleTrusted" data-color="#99d683" data-secondary-color="#f96262" />';
        } else {
          var is_trusted = `<input type="checkbox" data-size="small" data-enc_id="`+btoa(row.id)+`"  class="js-switch toggleTrusted" data-color="#99d683" data-secondary-color="#f96262" />`;
        }*/

        if(row.completed==1) {

          var completed = '<span class="status-completed">Verified</span>';
        } else {
          var completed = '<span class="status-shipped">Unverified</span>';
        }

        return completed;
        
      }
     },
     {
      render : function(data, type, row, meta)
      {
        var approve_status = '';

        if(row.approve_status==0) 
        {
          approve_status = '<span class="label label-warning">Pending</span>';
        } 
        else if(row.approve_status==3)
        {
          approve_status = '<span class="label label-warning">Submitted</span>';
        }
        else if(row.approve_status==1)
        {
          approve_status = '<span class="label label-success">Approved</span>';
        }
        else if(row.approve_status==2)
        {
          approve_status = '<span class="label label-danger">Rejected</span>';
        }

        return approve_status;
        
      }
     },




      {
      render : function(data, type, row, meta)
      {
        var approve_profile_status = '';

        if(row.approve_profile_status==0) 
        {
          approve_profile_status = '<span class="label label-warning">Pending</span>';
        } 
        else if(row.approve_profile_status==3)
        {
          approve_profile_status = '<span class="label label-danger">Submitted</span>';
        }
        else if(row.approve_profile_status==1)
        {
          approve_profile_status = '<span class="label label-success">Approved</span>';
        }
        else if(row.approve_profile_status==2)
        {
          approve_profile_status = '<span class="label label-danger">Rejected</span>';
        }
        return approve_profile_status;
        
      }
     },

      {
       render : function(data, type, row, meta) 
       {
         return row.total_wallet_amount;
       },
       "orderable": false, "searchable":false
     },
    
     {
       render : function(data, type, row, meta) 
       {
         return row.build_action_btn;
       },
       "orderable": false, "searchable":false
     }
    
     ]
   });
   
   $('input.column_filter').on( 'keyup click', function () 
   {
       filterData();
   });
   
   $('#table_module').on('draw.dt',function(event)
   {
     var oTable = $('#table_module').dataTable();
     var recordLength = oTable.fnGetData().length;
     $('#record_count').html(recordLength);
   
     var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
       $('.js-switch').each(function() {
          new Switchery($(this)[0], $(this).data());
       });
   
     $("input.toggleSwitch").change(function(){
         statusChange($(this));
      });

      $('input.toggleTrusted').change(function(){

         if($(this).is(":checked"))
         {
           var status  = 'trusted';
         }
         else
         {
          var status  = 'not-trusted';
         }
         
         var user_id = $(this).attr('data-enc_id');  
        
         $.ajax({
             method   : 'GET',
             dataType : 'JSON',
             data     : {status:status,user_id:user_id},
             url      : module_url_path+'/mark_as_trusted',
             success  : function(response)
             {                         
              if(typeof response == 'object' && response.status == 'SUCCESS')
              {
                swal('Done', response.message, 'success');
              }
              else
              {
                swal('Oops...', response.message, 'error');
              }               
             }
         });
      }); 

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td><input type="text" name="q_name" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    <td><input type="text" name="q_email" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    
                    <td>
                       <select class="search-block-new-table column_filter small-form-control" name="q_status" id="q_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                        </select>
                    </td>
                    <td>
                      <select class="search-block-new-table column_filter small-form-control" name="q_email_verification_status" id="q_email_verification_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="1">Verified</option>
                        <option value="0">Unverified</option>
                      </select>
                    </td>
                    <td>
                      <select class="search-block-new-table column_filter small-form-control" name="q_age_verification_status" id="q_age_verification_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="0">Pending</option>
                         <option value="3">Submitted</option>
                        <option value="1">Approved</option>
                        <option value="2">Rejected</option>
                      </select>
                    </td>
                     <td>
                      <select class="search-block-new-table column_filter small-form-control" name="q_profile_verification_status" id="q_profile_verification_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="0">Pending</option>
                        <option value="3">Submitted</option>
                        <option value="1">Approved</option>
                        <option value="2">Rejected</option>
                      </select>
                    </td>




                </tr>`);



       $('input.column_filter').on( 'keyup click', function () 
        {
             filterData();
        });
   });
   

 // <select class="search-block-new-table column_filter small-form-control" name="q_vstatus" id="q_vstatus" onchange="filterData();">
 //                        <option value="">All</option>
 //                        <option value="1">Active</option>
 //                        <option value="0">Block</option>
 //                        </select>


   function filterData()
   {
   table_module.draw();
   }
   
   function statusChange(data)
   {
       var type = data.attr('data-type');
       var alert_text = 'Do you really want to '+ type + ' this buyer?'
     swal({
          title: alert_text,
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
           var ref = data; 
           var type = data.attr('data-type');
           var enc_id = data.attr('data-enc_id');
           var id = data.attr('data-id');
           
             $.ajax({
               url:module_url_path+'/'+type,
               type:'GET',
               data:{id:enc_id},
               dataType:'json',
               success: function(response)
               {
                 if(response.status=='SUCCESS'){
                   if(response.data=='ACTIVE')
                   {
                     $(ref)[0].checked = true;  
                     $(ref).attr('data-type','deactivate');
                     sweetAlert('Success!','Buyer   activated successfully.','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','activate');
                     sweetAlert('Success!','Buyer deactivated successfully.','success');
                     location.reload(true);
                   }
                 }
                 else
                 {
                   sweetAlert('Error','Something went wrong!','error');
                 }  
               }
             }); 
          } 
          else
          {
            $(data).trigger('click');
          }
       })
   } 


   function approve_user(ref)
   {  
      swal({
          title: 'Are you sure to approve this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
              var enc_id = ref.attr('data-enc_id');
              $.ajax({
               url:module_url_path+'/approve',
               type:'GET',
               data:{enc_id:enc_id},
               dataType:'json',
               beforeSend : function()
               { 
                 showProcessingOverlay();        
               },        
               success:function(response)
               {
                  hideProcessingOverlay();
                  
                  swal({
                    title: response.description,
                    type: response.status,
                    showCancelButton: false,
                    confirmButtonColor: "#8d62d5",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                  },
                  function(isConfirm,tmp)
                  {
                    if(isConfirm==true)
                    {
                      location.reload();
                    }
                  });
               }
             });
          }
        });
   }


  $(function(){
    $("input.checkboxInputAll").click(function(){
       var is_checked = $("input.checkboxInputAll").is(":checked");
      if(is_checked)
      {
         $("input.checkboxInput").prop('checked',true);
      }
      else
      {
        $("input.checkboxInput").prop('checked',false);
      }
     }); 
  });


   function approve_id_proof(ref)
   {  
    
      swal({
          title: 'Do you really want to approve id proof of this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
              var enc_id = ref.attr('data-enc_id');
              var csrf_token = "{{ csrf_token()}}";

              $.ajax({
               url:module_url_path+'/approveidproof',
               type:'POST',
               data:{enc_id:enc_id,_token:csrf_token},
               dataType:'json',
               beforeSend : function()
               { 
                 showProcessingOverlay();        
               },        
               success:function(response)
               {
                  hideProcessingOverlay();

                  if(response.status == 'SUCCESS')
                  {
                      swal(response.status,response.message,'success');
                  }else{
                     swal(response.status,response.message,'error');
                  }
               }
             });
          }
        });
   }


   function delete_id_proof(ref)
   {  
    
      swal({
          title: 'Do you really want to delete id proof of this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
              var enc_id = ref.attr('data-enc_id');
              var csrf_token = "{{ csrf_token()}}";

              $.ajax({
               url:module_url_path+'/deleteidproof',
               type:'POST',
               data:{enc_id:enc_id,_token:csrf_token},
               dataType:'json',
               beforeSend : function()
               { 
                 showProcessingOverlay();        
               },        
               success:function(response)
               {
                  hideProcessingOverlay();

                  if(response.status == 'SUCCESS')
                  {
                      swal(response.status,response.message,'success');
                  }else{
                     swal(response.status,response.message,'error');
                  }
               }
             });
          }
        });
   }


   function callImageViewer(){
        
      smartPhotoInit = new SmartPhoto(".js-img-viwer");

      // console.log(smartPhotoInit);

      smartPhotoInit.on('change',function(){
          console.log('change');
      });
      smartPhotoInit.on('close',function(){
          smartPhotoInit.destroy();
      });
      smartPhotoInit.on('swipestart',function(){
          console.log('swipestart');
      });
      smartPhotoInit.on('swipeend',function(){
          console.log('swipeend');
      });
      smartPhotoInit.on('loadall',function(){
          console.log('loadall');
      });
      smartPhotoInit.on('zoomin',function(){
          console.log('zoomin');
      });
      smartPhotoInit.on('zoomout',function(){
          console.log('zoomout');
      });
      smartPhotoInit.on('open',function(){
          console.log('open');
          $("#show_age_section").modal('hide');
      });
  } 


</script>


<script>
  //verfiy user email functionalty
  $(document).on("click",".verifyuserbtn",function() {
      var user_id = $(this).attr('user_id');
      var email = $(this).attr('email');
      var completed = $(this).attr('completed');

      $("#buyer_id").val(user_id);     
      $("#email").val(email);  
      $("#setemailhere").html(email);     
      $("#verifyusersectionmodal").modal('show');
      if(completed=="1")
      {
        $("#verifyuseremailbtn").hide();
        $("#email_verification_status").show();
      }
      else{
         $("#verifyuseremailbtn").show();
         $("#email_verification_status").hide();

      }

  });

 
  $(document).on("click",".verifyuseremailbtn",function() {
      
    var user_id = $("#buyer_id").val();    
    var email = $("#email").val();
   
    if(user_id && email)
    { 
       swal({
          title: 'Do you really want to verify email of this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {

            $.ajax({
                url: module_url_path+'/verifyuseremail',
                type:"GET",
                data: {user_id:user_id,email:email},             
                dataType:'json',
                beforeSend: function(){    
                 showProcessingOverlay();           
                },
                success:function(response)
                {
                  hideProcessingOverlay(); 
                  if(response.status == 'SUCCESS')
                  { 
                    swal({
                        title: 'Success',
                        text: response.description,
                        type: 'success',
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                     },
                    function(isConfirm,tmp)
                    {                       
                      if(isConfirm==true)
                      {
                          window.location.reload();
                      }

                    });
                  }
                  else
                  {                
                    //swal('Error',response.description,'error');

                        swal({
                            title: 'Error',
                            text: response.description,
                            type: 'error',
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                         },
                        function(isConfirm,tmp)
                        {                       
                          if(isConfirm==true)
                          {
                              window.location.reload();
                          }

                        });
                   
                  }//else  
                }  
             }); // end of ajax

            }
          })// end of confirm box

        } //if user id and note
  });

</script>

<!-------------------verify user modal------------------------------>

<div class="modal fade" id="verifyusersectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="buyer_id" id="buyer_id" value="">
    <input type="hidden" name="email" id="email" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Verify User Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">

        <div class="chwstatus text-right">
          <span id="email_verification_status" class="label label-success" style="display: none">Verified</span>
        </div>

        <div class="row" id="viewagedetails">
          <div class="title-imgd">Email :  </div>
           <span id="setemailhere" style="padding-left:10px;"></span>
                    
         </div>  <!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-success verifyuseremailbtn" id="verifyuseremailbtn">Verify</button>
      </div>
    </div>
  </div>
</div>
<!----------------end verify user email modal----------------------------->


<script>
  
   //function for resend activation email
    $(document).on("click",".resendactivationemail",function() { 
      var user_id = $(this).attr('user_id');
      var email = $(this).attr('email');
      var completed = $(this).attr('completed');
      var code = $(this).attr('code');
      var activationcode = $(this).attr('activationcode');
       if(user_id && email)
      { 
        if(completed=="1"){
          swal('','This user is already having verified email .','warning');
        }else{

        swal({
          title: 'Do you really want to send verification email to this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {

            $.ajax({
                url: module_url_path+'/sendverificationemail',
                type:"GET",
                data: {user_id:user_id,email:email,code:code,completed:completed,activationcode:activationcode},        
                dataType:'json',
                beforeSend: function(){    
                 showProcessingOverlay();           
                },
                success:function(response)
                {
                  hideProcessingOverlay(); 
                  if(response.status == 'SUCCESS')
                  { 
                    swal({
                        title: 'Success',
                        text: response.description,
                        type: 'success',
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                     },
                    function(isConfirm,tmp)
                    {                       
                      if(isConfirm==true)
                      {
                          window.location.reload();
                      }

                    });
                  }
                  else
                  {                
                    //swal('Error',response.description,'error');

                        swal({
                            title: 'Error',
                            text: response.description,
                            type: 'error',
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                         },
                        function(isConfirm,tmp)
                        {                       
                          if(isConfirm==true)
                          {
                              window.location.reload();
                          }

                        });
                   
                  }//else  
                }  
             }); // end of ajax

            }
          })// end of confirm box
       }//else of completed 

     } //if user id and email
         
  });
</script>


@stop