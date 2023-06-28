@extends('admin.layout.master')                
@section('main_content')

 <?php
   $mem_plan= json_encode($arr_membership);
?>

<script type="text/javascript">
var mem_plan= <?php echo $mem_plan ?>;
console.log(mem_plan);
var option ='';

for (i=0; i<mem_plan.length; i++) {

option += "<option value='"+mem_plan[i]+"'>"+mem_plan[i]+"</option>";

}

</script> 

<style type="text/css">
.inlineblock-col{display: inline-block; text-align: left; width: 110px; vertical-align: middle;margin: 10px;}
.row-classs{display: block; text-align: center;}

  .desc-sellr-admin{margin-top: 30px;}
  .modal-dialog.onlytitletxtmodal .close{
    position: absolute; right: 0px; top: 0px; width: 40px; height: 40px;  text-align: center;line-height: 40px;z-index: 99; opacity: 1;
  }
  .modal-dialog.onlytitletxtmodal { max-width: 340px; width: 100%;}
  .modal-dialog.onlytitletxtmodal h2{margin: 50px 0px;}
  .address-map{margin-top: 15px;}
  .divr-listmaim{margin-bottom: 15px; color: #222;}
  .divr-listmaim-left{float: left; font-weight: 600; letter-spacing: 0.7px;}
  .divr-listmaim-right{margin-left: 140px;}
  /*.modal-footer.btnctr-txt{display: block;}*/

  .btn-primary, .btn-primary.disabled {
    background: #b835cd;
    border: 1px solid #b835cd;
}
.btn-primary:hover, .btn-primary.disabled:hover {
    background: #444;
    border: 1px solid #444;
}
.btn-primary:focus, .btn-primary.disabled:focus {
    background: #444;
    border: 1px solid #444;
}
</style>
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/css/smartphoto.min.css">
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
                     <th>Business Name</th>
                     <th>Email</th>
                     <th>Status</th>
                      <th>Is Featured</th>
                     <th>Email Verification Status</th>
                     <th>ID Proof Verification Status</th>
                     <th>Profile Verification Status</th>
                     <th>Business Verification Status</th>
                     <th>Documents Verification Status</th>
                     <th>Membership</th>
                     <th>Membership Plan</th>
                     <th width="10%">Action</th>
                  </tr>
                
              </thead>
              <tbody>
              </tbody>
            </table>
         </div>
         {!! Form::close() !!}
      </div>
   </div> 
</div>


 
<!-----------------------------start of business modal--------------------------------------->
<div class="modal fade" id="approve_business" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="seller_id" id="seller_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Business Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="business_body">
        <div class="mainbody-mdls">
          
          <div class="col-md-12 text-right">
            <span class="label label-success showapproved" id="labelApprove" style="display: none">Approved</span>
            <span class="label label-danger showrejected" id="labelReject" style="display: none">Rejected</span>
          </div>
          
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left">Business Name :</div>
             <div class="mainbody-mdls-fd-right" id="business_name"></div>
             <div class="clearfix"></div>
          </div>
         {{--  <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left">Tax Id :</div>
             <div class="mainbody-mdls-fd-right" id="tax_id"></div>
             <div class="clearfix"></div>
          </div> --}}

        {{--   <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left">Id Proof :</div>
             <div class="mainbody-mdls-fd-right" id="id_proof"></div>
             <div class="clearfix"></div>
          </div> --}}

        </div>
      
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-success approvestatus approvebusiness" style="display: none;" id="btnApprove" data-val="1" data-dismiss="modal" data-status="approve">Approve</button>
        <button type="button" class="btn btn-danger approvestatus rejectbusiness" style="display: none;" id="btnReject" data-val="2" data-status="reject">Reject</button>
      </div>
    </div>
  </div>
</div>
<!---------------------end of business modal--------------------------------------->


<!-------------------start of age view modal------------------------------------->

<div class="modal fade" id="show_age_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="front_image" id="front_image" value="">
    <input type="hidden" name="back_image" id="back_image" value="">
    <input type="hidden" name="selfie_image" id="selfie_image" value="">
    <input type="hidden" name="age_address" id="age_address" value="">
    <input type="hidden" name="address_proof" id="address_proof" value="">



    <input type="hidden" name="user_id" id="user_id" value="">
    <input type="hidden" name="approve_verification_status" id="approve_verification_status" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">ID Proof Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">

          <span id="showerror"></span> <br/>

       <div id="viewagedetails">
        <div class="row">

          <div class="col-md-12 text-right">
            <span id="approved_age" class="label label-success" style="display: none">Approved</span>
            <span id="rejected_age" class="label label-danger" style="display: none">Rejected</span>
          </div>

            <div class="col-md-6">
                <div class="title-imgd">Front of ID</div>

                <div id="front_image_div"></div>

            </div>
             <div class="col-md-6">
                <div class="title-imgd">Back of ID</div>

                 <div id="back_image_div"></div>
            </div>  

             {{-- <div class="col-md-4">
                <div class="title-imgd">Selfie </div>                  
                <div id="selfie_image_div"></div>
            </div>    --}}

        </div>   
        

          <div class="row">

            <div class="col-md-6">
                <div class="title-imgd">Selfie </div>
                <div id="selfie_image_div"></div>
            </div>    

            <div class="col-md-6">
              
                <div class="title-imgd">Address Proof </div>
                <div id="address_proof_div"></div>
              
            </div>

        </div>   

         <div class="row">
            <div class="col-md-12">
               <div class="address-map">
                  <div class="title-imgd">Address </div>
                  
                <div id="id_address_div"></div>
               </div>

            </div>
        </div>   

        <!---------------profile--address----------------->
         <hr/>
         <div class="row">

             <div class="col-md-12"> <div class="title-imgd">Profile Address : </div></div>
                <br/><br/>
              <div class="col-md-6">
                    <div class="title-imgd"> Address</div>
                    <div class="img-forntsimg" id="show_street_address_idproof"></div>
                </div> 
                 <div class="col-md-6">
                    <div class="title-imgd">City</div>
                    <div class="img-forntsimg" id="show_city_idproof"></div>
                </div>
                <div class="col-md-6">
                    <div class="title-imgd">State</div>
                    <div class="img-forntsimg" id="show_state_idproof"></div>
                </div>
                 <div class="col-md-6">
                    <div class="title-imgd">Country</div>
                    <div class="img-forntsimg" id="show_country_idproof"></div>
                </div>
               
                 <div class="col-md-6">
                    <div class="title-imgd">Zipcode</div>
                    <div class="img-forntsimg" id="show_zipcode_idproof"></div>
                </div> 
          </div>      
        <!--------------end-profile--address-------------->
        <div class="row">          
          <div class="col-md-12" id="rejectdiv" style="display: none;"> <hr/>
            <div class="desc-sellr-admin">
                <div class="title-imgd">Reject Reason </div>
                <div class="img-forntsimg" id="show_reject_reason"></div>
                </div>
            </div>

        </div>

     </div>  <!------row div end here------------->
     </div><!------body div end here------------->
      <div class="modal-footer">
        <button type="button" class="btn btn-success approveage" id="approveagebtn" data-dismiss="modal">Approve</button>
        <button type="button" class="btn btn-danger rejectage" id="rejectagebtn">Reject</button>
      </div>
    </div>
  </div>
</div>
<!-------------------end of age view modal------------------------------------->


<!-------------------start of documents view modal------------------------------------->

<div class="modal fade" id="view_document_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <input type="hidden" name="user_id" id="user_id_doc" value="">
    <input type="hidden" name="approve_verification_status" id="approve_verification_status" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Uploaded Documents</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">

          <span id="showerror"></span> <br/>

       <div id="viewdocumentdetails">
        <div class="row">

          <div class="col-md-12 text-right">
            <span id="approved_document" class="label label-success" style="display: none">Approved</span>
            <span id="rejected_document" class="label label-danger" style="display: none">Rejected</span>
            <span id="pending_document" class="label label-warning" style="display: none">Pending</span>
            <span id="submitted_document" class="label label-warning" style="display: none">Submitted</span>
          </div>

            <div class="document_div">  

            </div>

            <div class="no_doc_div modal-title"></div>



             {{-- <div class="col-md-4">
                <div class="title-imgd">Selfie </div>                  
                <div id="selfie_image_div"></div>
            </div>    --}}

        </div>   
    
        <!--------------end-profile--address-------------->
        <div class="row">          
          <div class="col-md-12" id="rejectdiv" style="display: none;"> <hr/>
            <div class="desc-sellr-admin">
                <div class="title-imgd">Reject Reason </div>
                <div class="img-forntsimg" id="show_reject_reason"></div>
                </div>
            </div>

        </div>

     </div>  <!------row div end here------------->
     </div><!------body div end here------------->
      <div class="modal-footer">
        <div class="app_rej">
            <button type="button" class="btn btn-success approvedocument"  data-dismiss="modal">Approve</button>
            <button type="button" class="btn btn-danger rejectdocumentbutton" id="rejectdocbutton">Reject</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-------------------end of documents view modal------------------------------------->


<!------------------start of document reject modal----------------------------------->
<div class="modal fade" id="reject_document_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="seller_id" id="seller_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Reject Documents</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason &nbsp;</div>  
          <textarea id="note_reject_doc" name="note" rows="5" class="form-control"></textarea>
          <span id="noteerrdoc"></span>
      </div>  <!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectdocbtn" id="rejectdocbtn">Reject</button>
      </div>
    </div>
  </div>
</div>
<!-------------------end of documents reject modal------------------------------------->



<div class="modal fade" id="reject_age_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="seller_id" id="seller_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Reject ID Proof Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason &nbsp;</div>  
          <textarea id="note" name="note" rows="5" class="form-control"></textarea>
          <span id="noteerr"></span>
      </div>  <!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectbtn" id="rejectbtn">Reject</button>
      </div>
    </div>
  </div>
</div>




<!------------------------------------------------------->
 
<!-------------------start of profile view modal------------------------------------->

<div class="modal fade" id="show_profile_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="first_name" id="first_name" value="">
    <input type="hidden" name="last_name" id="last_name" value="">
    <input type="hidden" name="user_id" id="user_id" value="">
    <input type="hidden" name="approve_status" id="approve_status" value="">
    <input type="hidden" name="email" id="email" value="">
    <input type="hidden" name="phone" id="phone" value="">
    <input type="hidden" name="street_address" id="street_address" value="">
    <input type="hidden" name="country" id="country" value="">
    <input type="hidden" name="zipcode" id="zipcode" value="">
    <input type="hidden" name="state" id="state" value="">
    <input type="hidden" name="city" id="city" value="">



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
            <span id="approved_profile" class="label label-success" style="display: none">Approved</span>
            <span id="rejected_profile" class="label label-danger" style="display: none">Rejected</span>
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
           {{--   <div class="col-md-6">
                <div class="title-imgd">Phone</div>
                <div class="img-forntsimg" id="show_phone"></div>
            </div>     --}}
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
                         
        </div>   
      
     </div>  <!------row div end here------------->
     </div><!------body div end here------------->
      <div class="modal-footer">

        <button type="button" class="btn btn-success approveprofile" id="approveprofilebtn" data-dismiss="modal" style="display: none">Approve</button>
        <button type="button" class="btn btn-danger rejectprofile" id="rejectprofilebtn" style="display: none">Reject</button>       
      </div>
    </div>
  </div>
</div>
<!-------------------end of profile view modal------------------------------------->
  


<div class="modal fade" id="reject_profile_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="seller_id" id="seller_id" value="">

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
            
              <textarea id="note_reject" name="note_reject" rows="5" class="form-control"></textarea>
              <span id="note_err"></span>
             
      </div>  <!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectprofbtn" id="rejectprofbtn">Reject</button>
      </div>
    </div>
  </div>
</div>

<!-------------------------end of reject profile modal-------------------------------------->

<!---------------------------ID Proof Verified Modal Start---------------------------------------------->
<div class="modal fade" id="id_proof_verified_modal" tabindex="-1" role="dialog" aria-labelledby="idProofVerifiedModal" aria-hidden="true">
  <div class="modal-dialog onlytitletxtmodal" role="document">
    <div class="modal-content">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <img src="{{url('/')}}/assets/images/popup-close-btn.png">
        </button>
      <div class="modal-body">
         
           <h2 class="text-center">Id proof is already verified!</h2>
         <!------row div end here------------->         
      </div><!------body div end here------------->
      
    </div>
  </div>
</div>
<!---------------------------ID Proof Verified Modal End---------------------------------------------->





<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">View Membership</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="divr-listmaim">
               <div class="divr-listmaim-left">Plan Name : </div>
               <div class="divr-listmaim-right" id="showplanname"> </div>
               <div class="clearfix"></div>
            </div>
             <div class="divr-listmaim">
               <div class="divr-listmaim-left">Membership : </div>
               <div class="divr-listmaim-right" id="showmembership"> </div>
               <div class="clearfix"></div>
            </div>
             <div class="divr-listmaim">
               <div class="divr-listmaim-left"> Date : </div>
               <div class="divr-listmaim-right" id="showstart"> </div>
               <div class="clearfix"></div>
            </div>

             <div class="divr-listmaim" id="hideprice">
               <div class="divr-listmaim-left">Amount($):</div>
               <div class="divr-listmaim-right" id="showprice"> </div>
               <div class="clearfix"></div>
            </div>

         {{--   <div class="divr-listmaim" id="hidetransactionid">
               <div class="divr-listmaim-left">Transaction Id :</div>
               <div class="divr-listmaim-right" id="showtransactionid"> </div>
               <div class="clearfix"></div>
            </div> --}}

             <div class="divr-listmaim" id="hidepaymentstatus">
               <div class="divr-listmaim-left">Payment status :</div>
               <div class="divr-listmaim-right" id="showpaymentstatus"> </div>
               <div class="clearfix"></div>
            </div>

             <div class="divr-listmaim" id="hidecancelstatus">
               <div class="divr-listmaim-left">Cancelled status :</div>
               <div class="divr-listmaim-right" id="showcancelstatus"> </div>
               <div class="clearfix"></div>
            </div>

            

        
      </div>
      <div class="modal-footer text-center btnctr-txt">
        <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('click','.planmodel',function(){



    var membership = $(this).attr('membership');
    var startdate = $(this).attr('startdate');
    var enddate = $(this).attr('enddate');
    var amount = $(this).attr('amount');
    var planname = $(this).attr('planname');
    var transaction_id = $(this).attr('transaction_id');
    var payment_status = $(this).attr('payment_status');

    var is_cancel = $(this).attr('is_cancel');

    if(planname.trim()!='')
      $("#showplanname").html(planname);
    else
      $("#showplanname").html('-');

     if(membership.trim()!=''){
        if(membership==1){
         var setmember = 'Free';
        }
        else {
         var setmember = 'Paid';
        }
       $("#showmembership").html(setmember);
     }     
    else{
       $("#showmembership").html('-');

    }
     
     if(startdate.trim()!='')
      $("#showstart").html(startdate);
    else
      $("#showstart").html('-');

    
    if(membership=='1'){
      $("#hideprice").hide();
      $("#hidepaymentstatus").hide();
      $("#hidetransactionid").hide();
    }else{
       $("#hideprice").show();
       $("#hidepaymentstatus").show();
       $("#hidetransactionid").show();
    }
     if(amount!='')
      $("#showprice").html('$'+amount);
    else
      $("#showprice").html('-');

       if(transaction_id!='')
        $("#showtransactionid").html(transaction_id);
      else
        $("#showtransactionid").html('-');

      if(payment_status!=''){

          if(payment_status=='0')
            var paystatus ='Ongoing';
          else if(payment_status=='1')
            var paystatus = 'Completed';
          else if(payment_status=='2')
            var paystatus = 'Failed';

        $("#showpaymentstatus").html(paystatus);
      }
      else{
        $("#showpaymentstatus").html('-');
      }
     
     if(is_cancel=="1")
     {
        $("#showcancelstatus").html('Cancelled');

     }else{
        $("#showcancelstatus").html(' NA');

     }


  });
</script>






  
<script type="text/javascript" src="{{url('/')}}/assets/common/js/smartphoto.js?v=1""></script>

<script>

  let smartPhotoInit = undefined;
  
   $(document).on("click",".view_profile_section",function() { 
      var first_name = $(this).attr('first_name');
      var last_name = $(this).attr('last_name');
      var user_id = $(this).attr('user_id');
      var approve_status = $(this).attr("approve_status");
      var email = $(this).attr('email');
      var phone= $(this).attr('phone');
      var street_address= $(this).attr('street_address');
      var country= $(this).attr('country');
      var zipcode= $(this).attr('zipcode');
      var state= $(this).attr('state');
      var city= $(this).attr('city');



     // if(first_name && last_name && email && phone && street_address && country && zipcode && state)
     // {
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

          // if(phone)
          //   $('#show_phone').html(phone);
          // else
          //   $('#show_phone').html('-');

           if(street_address)
             $('#show_street_address').html(street_address);
           else
             $('#show_street_address').html('-');

           if(country)
             $('#show_country').html(country);
           else
            $('#show_country').html('-');

           if(zipcode)
             $('#show_zipcode').html(zipcode);
           else
             $('#show_zipcode').html('-');


           if(state)
             $('#show_state').html(state);
           else
             $('#show_state').html('-');

           if(city)
             $('#show_city').html(city);
           else
             $('#show_city').html('-');



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

        
          //  if((first_name=="" || last_name=="" || email=="" || phone=="" || street_address=="" || zipcode=="" || country=="" || state=="" || city=="") && approve_status==0)
          // {
           if((first_name=="" || last_name=="" || email=="" || street_address=="" || zipcode=="" || country=="" || state=="" || city=="") && approve_status==0)
          {   

            $(".approveprofile").hide();
            $(".rejectprofile").hide();
          }
          // else if(first_name.trim()!='' && last_name.trim()!='' && email.trim()!='' && phone.trim()!='' && street_address.trim()!='' && zipcode.trim()!='' && country.trim()!='' && state.trim()!='' && city.trim()!='' && approve_status==3)
          // {
          else if(first_name.trim()!='' && last_name.trim()!='' && email.trim()!='' && street_address.trim()!='' && zipcode.trim()!='' && country.trim()!='' && state.trim()!='' && city.trim()!='' && approve_status==3)
          {  
              $(".approveprofile").show();
              $(".rejectprofile").show();
          }
 

    

    });
 

     //start of document approve
     $(document).on("click",".approvedocument",function() {
      var user_id = $("#user_id_doc").val();
      if(user_id)
      {

           swal({
                  title: 'Do you really want to approve the document of this user?',
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
                          url: module_url_path+'/approvedocument',
                          type:"GET",
                          data: {user_id:user_id},             
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
                                        title: 'Success!',
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
                })//end of confirm box  
      }    
    }); 




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
                          beforeSend: function(){    
                            showProcessingOverlay();        
                          },
                          success:function(response)
                          { 
                            hideProcessingOverlay();
                              if(response.status == 'SUCCESS')
                              {  
                                swal({
                                        title: 'Success!',
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
                })//end of confirm box  
      }    
    });  


     // function to show reject profile modal
     $(document).on("click","#rejectprofilebtn",function() {
      $("#reject_profile_sectionmodal").modal('show');
      $("#show_profile_section").modal('hide');      
      var user_id = $("#user_id").val();
      var approve_status = $("#approve_status").val();

      $("#seller_id").val(user_id);
    });   


     //rejectprofbtn

     $(document).on("click",".rejectprofbtn",function() {
      
      var user_id = $("#seller_id").val();
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
                                              title: 'Success!',
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
                       }); //end of ajax

                    }
                }) // end of reject confirm box  


           } //if user id and note
      } //else    
    }); // end of profile reject btn 


  

  //  view age section starts here
      var seller_id_proof = "{{ $seller_id_proof }}";
     // for view age details popup
     $(document).on("click",".view_age_section",function() 
     {    

        var front_image                 = $(this).attr('front_image');
        var back_image                  = $(this).attr('back_image');
        var user_id                     = $(this).attr('user_id');
        var approve_verification_status = $(this).attr("approve_verification_status");
        var note                        = $(this).attr('note');
        var selfie_image                = $(this).attr('selfie_image');
        var age_address                 = $(this).attr('age_address');
        var address_proof               = $(this).attr('address_proof');

        /***************profile**address**************/
            var street_address= $(this).attr('street_address');
            var country= $(this).attr('country');
            var zipcode= $(this).attr('zipcode');
            var state= $(this).attr('state');
            var city= $(this).attr('city');

        /**************end*profile*address*************/



        if(approve_verification_status == 1)
        {
          $('#id_proof_verified_modal').modal('show');
          return;
        }


        if(front_image || back_image || selfie_image || user_id || age_address || address_proof)
        {
          $("#show_age_section").modal('show');

          $("#front_image").val(front_image);
          $("#back_image").val(back_image);
          $("#selfie_image").val(selfie_image);
          $("#user_id").val(user_id);
          $("#approve_verification_status").val(approve_verification_status);
          $("#age_address").val(age_address);
          $("#address_proof").val(address_proof);

          if(front_image)
          {      
            var src           = seller_id_proof+front_image; 
            var front_img_src = '<img src="'+src+'" width="100px" height="100px" />';

            var front_img     = '<a href="'+src+'" class="js-img-viwer" id="link_front_image" data-caption="Front of ID">\
                  <div class="img-forntsimg" id="show_front_image">'+front_img_src+'</div>\
                </a>';
            
          }
          else
          {
            var front_img ='Not Uploaded';
            
          }               

          $("#front_image_div").html(front_img);

          if(back_image)
          {
            var src_back     = seller_id_proof+back_image; 
            var back_img_src = '<img src="'+src_back+'" width="100px" height="100px" />';
            
            var back_img = ' <a href="'+src_back+'" class="js-img-viwer" id="link_back_image" data-caption="Back of ID">\
                  <div class="img-forntsimg" id="show_back_image">'+back_img_src+'</div>\
                </a>';
          }
          else
          {
            var back_img ='Not Uploaded';
            
          }               

          $("#back_image_div").html(back_img);


          if(selfie_image)
          {
            var src_selfie     = seller_id_proof+selfie_image; 
            var selfie_img_src = '<img src="'+src_selfie+'" width="100px" height="100px" />';

            var selfie_img = '<a href="'+src_selfie+'" class="js-img-viwer" id="link_selfie_image" data-caption="Selfie">\
                  <div class="img-forntsimg" id="show_selfie_image">'+selfie_img_src+'</div>\
                </a>';
          }
          else
          {
            var selfie_img ='Not Uploaded';
           
          }               

          $("#selfie_image_div").html(selfie_img);


          if(age_address){
               $("#id_address_div").html(age_address);
          }else{
                $("#id_address_div").html('-');
          }


           if(address_proof)
          {
            var ext = address_proof.split('.').pop();
            if(ext=="doc" || ext=="pdf" || ext=="docx" || ext=="xls" || ext=="xlsx")
            {
               var src_addrproof     = seller_id_proof+address_proof; 
               var addressproof_img_src = '<a href="'+src_addrproof+'" target="_blank">View Address Proof</a>';
            }
            else
            {
               var src_addrproof     = seller_id_proof+address_proof; 
               var addressproof_img_src = '<img src="'+src_addrproof+'" width="100px" height="100px" />';
            }
           
            var addressproof_img = '<a href="'+src_addrproof+'" class="js-img-viwer" id="link_address_proof" data-caption="Address Proof">\
                  <div class="img-forntsimg" id="show_address_proof">'+addressproof_img_src+'</div>\
                </a>';
          }
          else
          {
            var addressproof_img ='Not Uploaded';
           
          }               

          $("#address_proof_div").html(addressproof_img);


           //show proifle address start

             if(street_address)
             $('#show_street_address_idproof').html(street_address);
             else
               $('#show_street_address_idproof').html('-');

             if(country)
               $('#show_country_idproof').html(country);
             else
              $('#show_country_idproof').html('-');

             if(zipcode)
               $('#show_zipcode_idproof').html(zipcode);
             else
               $('#show_zipcode_idproof').html('-');


             if(state)
               $('#show_state_idproof').html(state);
             else
               $('#show_state_idproof').html('-');

             if(city)
               $('#show_city_idproof').html(city);
             else
               $('#show_city_idproof').html('-');

             //end of profile address here


          callImageViewer();


          if((front_image=="" || back_image=="" || selfie_image=="" || age_address=="" || address_proof=="") && approve_verification_status==0){
            $("#approveagebtn,#rejectagebtn").hide();
            $("#approved_age,#rejected_age").hide();
          }else{
            $("#approveagebtn,#rejectagebtn").show();
          }


          if(approve_verification_status==2){
            $("#approveagebtn,#rejectagebtn").hide();
            $("#rejected_age").show();

            $("#rejectdiv").show();
            $("#show_reject_reason").html(note);

          }else if(approve_verification_status==1){
            $("#approveagebtn,#rejectagebtn").hide();
            $("#approved_age").show();
            $("#rejectdiv").hide();
          }else if(approve_verification_status==0){
            $('#rejectdiv').hide();
          }



          // if(approve_verification_status==2)
          // {
          //     $("#rejectdiv").show();
          //     $("#show_reject_reason").html(note);
          // }else{
          //     $("#rejectdiv").hide();
          // } 

          // if(approve_verification_status==1)
          // {
          //   $("#approveagebtn").hide();
          //   $("#approved_age").show();
          //   $("#rejectagebtn").show();
          // } 
          // if(approve_verification_status==2)
          // {
          //   console.log(2342342);
          //   $("#rejectagebtn").hide();
          //   $("#rejected_age").show();
          // }

          // if(front_image=="" && back_image=="" && selfie_image=="" && approve_verification_status==0)
          // {
          //   console.log(234);
          //   $("#approveagebtn,#rejectagebtn").hide();
          //   // $(".approveage").hide();
          //   // $(".rejectage").hide();
          // }else if(front_image && back_image && selfie_image && approve_verification_status==0){
          //     $("#approveagebtn,#rejectagebtn").show();
          //     // $(".approveage").show();
          //     // $(".rejectage").show();
          // }



          // if(front_image && back_image)
          // {
          //     $(".approveage").show();
          //     $(".rejectage").show();
          // }else{
          //     $(".approveage").hide();
          //     $(".rejectage").hide();
          // }
        }    
    });

    
   var seller_document = "{{ $seller_document }}";
    // View document section starts here
    $(document).on("click",".view_document_section",function() 
     {    

        var seller_id           = $(this).attr('seller_id');
        var verification_status = $(this).attr('verification_status'); 
        var document_titles = document_files =[];
        res = "";
        if(seller_id!="")
        {  
            $.ajax({
                      url: module_url_path+'/get_documents',
                      type:"GET",
                      data: {seller_id:seller_id},             
                      dataType:'json',
                      /*beforeSend: function(){    
                        showProcessingOverlay();        
                      },*/
                      success:function(response)
                      {
                         $(".document_div").html('');

                       for (var key in response) {

                        if(response[key].length!=0)
                       {   
                        for(i=0;i<response[key].length;i++)
                        { 
                             if(response[key][i]['document'])
                            {      
                              var src           = seller_document+response[key][i]['document']; 
                              if(src)
                              {  

                              var ext = src.split('.').pop();
                              if(ext=="doc" || ext=="pdf" || ext=="docx" || ext=="xls" || ext=="xlsx")
                              {
                                 var src_doc     = seller_document+response[key][i]['document']; 
                                 var document_src = '<a href="'+src_doc+'" target="_blank">View Document</a>';
                              }
                              else
                              {
                                  var document_src  = '<img src="'+src+'" width="100px" height="100px" />';
                              }  
                             
                              var doc           = '<a href="'+src+'" class="js-img-viwer" id="link_front_image" data-caption="Document" download>\
                                    <div class="img-forntsimg" id="show_front_image">'+document_src+'</div>\
                                  </a>';
                              }
                              else
                              {
                                 var doc = "Not Uploaded";
                              }    
                            } 

                            if(response[key][i]['document_title'])
                            {
                               var doc_title = response[key][i]['document_title'];
                            } 
                            else
                            {
                               var doc_title = '-';
                            }
                           $(".document_div").append('<div class="col-md-6"><div class="title-imgd">Document Title</div><div id="document_title_div_'+i+'">'+doc_title+'</div></div><div class="col-md-6"><div class="title-imgd">Document</div><div id="document_div_'+i+'">'+doc+'</div></div>');
                        }
                           $(".no_doc_div").html('');
                          // $(".app_rej").css("display","block");

                       }

                       if(response[key].length==0) 
                       {
                          $(".document_div").html(''); 
                          $(".no_doc_div").html('No documents uploaded');
                          $(".app_rej").css("display","none");
                       } 

                       }



                      }  
                         
                       });

                   $("#user_id_doc").val(seller_id);
                   $("#reject_doc_sectionmodal #seller_id").val(seller_id);
                   if(verification_status!="" && verification_status==1)
                   {
                      $("#approved_document").show();
                      $("#rejected_document").hide();
                      $("#pending_document").hide();
                      $("#submitted_document").hide();
                      $(".app_rej").css("display","none");
                   }

                   if(verification_status!="" && verification_status==2)
                   {
                      $("#approved_document").hide();
                      $("#rejected_document").show();
                      $("#pending_document").hide();
                      $("#submitted_document").hide();
                      $(".app_rej").css("display","none");
                   }

                   if(verification_status!="" && verification_status==0)
                   {
                      $("#approved_document").hide();
                      $("#rejected_document").hide();
                      $("#pending_document").hide();
                      $("#submitted_document").hide();
                      $(".app_rej").css("display","none");
                   }

                     if(verification_status!="" && verification_status==3)
                   {
                      $("#approved_document").hide();
                      $("#rejected_document").hide();
                      $("#pending_document").hide();
                      $("#submitted_document").show();
                      $(".app_rej").css("display","block");
                   }



                  $("#view_document_section").modal('show');

      }


        /***************profile**address**************/
            var street_address= $(this).attr('street_address');
            var country= $(this).attr('country');
            var zipcode= $(this).attr('zipcode');
            var state= $(this).attr('state');
            var city= $(this).attr('city');

        /**************end*profile*address*************/

    }); 

  
    
     //start of age approve
     $(document).on("click",".approveage",function() {
       var user_id = $("#user_id").val(); 
       var front_image = $("#front_image").val();
       var back_image = $("#back_image").val();
       var selfie_image = $("#selfie_image").val();
       var address_proof = $("#address_proof").val();

            if(user_id && front_image && back_image && selfie_image && address_proof)
            {
                $("#showerror").html('');

                 swal({
                  title: 'Do you really want to approve the id proof details of this user?',
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
                      data: {user_id:user_id},             
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
                       }//success  
                   }); //end of ajax

                 } //is confirm
               })//end of sweet confirm box    


            } //end of all fields

    }); 
    // end of age approve

    // function to show reject modal
     $(document).on("click","#rejectagebtn",function() {
     // $("#reject_age_sectionmodal").modal('show');
     // $("#show_age_section").modal('hide');      
      var user_id = $("#user_id").val();
      var approve_verification_status = $("#approve_verification_status").val();

      var front_image = $("#front_image").val();
      var back_image = $("#back_image").val();
      var selfie_image= $("#selfie_image").val();

      $("#seller_id").val(user_id);

      /* if(front_image && back_image && selfie_image)
      {
         $("#reject_age_sectionmodal").modal('show');
         $("#show_age_section").modal('hide');      
      }else
      {
         $("#showerror").html('All the details are not entered for id verification');
         $("#showerror").css('color','red');
         $("#show_age_section").show(); 
      }*/

      $("#reject_age_sectionmodal").modal('show');
      $("#show_age_section").modal('hide');  


      
    });

     //function to reject age verification
     $(document).on("click",".rejectbtn",function() {
      
      var user_id = $("#seller_id").val();
      var note = $("#note").val();
      if(note=="")
      {
        $("#noteerr").html('Please enter note');
        $("#noteerr").css('color','red');
      }else{
         $("#noteerr").html('');
          if(user_id && note)
          { 

            swal({
                  title: 'Do you really want to reject the id proof details of this user?',
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
                            }  
                         }); 

                  }
               })//end of sweet confirm box

           } //if user id and note
      } //else    
    });


    // function to show doc reject modal
     $(document).on("click","#rejectdocbutton",function() {
      var user_id = $("#user_id_doc").val();
      var approve_verification_status = $("#approve_verification_status").val();
      $("#seller_id").val(user_id);
      $("#reject_document_sectionmodal").modal('show');
      $("#view_document_section").modal('hide');  
    });     
  
  //function to reject doc
  $(document).on("click",".rejectdocbtn",function() {
      
      var user_id = $("#seller_id").val();
      var note    = $("#note_reject_doc").val();
      if(note=="")
      {
        $("#noteerrdoc").html('Please enter note');
        $("#noteerrdoc").css('color','red');
      }else{
         $("#noteerrdoc").html('');
          if(user_id && note)
          { 

            swal({
                  title: 'Do you really want to reject the documents of this user?',
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
                            url: module_url_path+'/rejectdocument',
                            type:"GET",
                            data: {user_id:user_id,note:note},             
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
                            }  
                         }); 

                  }
               })//end of sweet confirm box

           } //if user id and note
      } //else    
    }); 




</script>




<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "{{ $module_url_path }}";

   function show_details(url)
   { 
      
       window.location.href = url;
   } 
   
   function confirm_delete(ref,event)
   { 
      var delete_param = "Seller"; 
      confirm_action(ref,event,'Do you really want to delete this record?',delete_param);
   }

   function confirm_approve(ref,event)
   {
      confirm_action(ref,event,'Do you really want to approve this record?');
   }

    $(document).on("click",".approve_business",function() {
      var sellerid = $(this).attr('data-enc_id');

      if(sellerid)
      {
          $("#approve_business").modal('show');
          $("#seller_id").val(sellerid);

          $.ajax({
              url: module_url_path+'/get_business_details',
              type:"GET",
              data: {seller_id:sellerid},             
              dataType:'json',
              beforeSend: function(){            
              },
              success:function(response)
              {
                 if(response.status == 'SUCCESS')
                  {   
                     var approve_status =response.approve_status;
                    
                     if(response.business_name!=undefined){

                      if(response.id_proof!='-'){
                        var src = "{{ url('/') }}/uploads/id_proof/"+response.id_proof;
                        var img = '<img src="'+src+'" width=120 height=100 />';
                      }else{
                        var img = '-';
                      }
                      $("#business_body #business_name").html(response.business_name);
                      $("#business_body #tax_id").html(response.tax_id);
                      $("#business_body #id_proof").html(img);     

                    //  if(approve_status==0 && (response.business_name=='-' || response.tax_id=='-')){
                      if(approve_status==0 && (response.business_name=='-')){
                        $("#btnApprove,#btnReject").hide();
                        $("#labelApprove,#labelReject").hide();
                      }
                      /*else if((approve_status==0 || approve_status==3) && response.business_name!='-' && response.tax_id!='-'){*/

                       else if((approve_status==0 || approve_status==3) && response.business_name!='-'){  

                        $("#btnApprove,#btnReject").show();
                        $("#labelApprove,#labelReject").hide();
                      } 
                      else if(approve_status==1){
                         $("#btnApprove,#btnReject").hide();
                         $("#labelApprove").show();
                         $("#labelReject").hide();
                      }
                      else if(approve_status==2){
                         $("#btnApprove,#btnReject").hide();
                         $("#labelApprove").hide();
                         $("#labelReject").show();
                      }
                       
                    }else{
                        swal("Error","Business details not available","error");
                    }
                  }
                  else{
                       swal("Error","Business details not available","error");
                  }
              }  
           }); 

      }    
    });

     $(document).on("click",".approvestatus",function()
     {
        var sellerid    = $("#seller_id").val();
        var val         = $(this).attr('data-val');
        var data_status = $(this).attr('data-status');

        if(sellerid)
        {
          var csrf_token = "{{ csrf_token()}}";

          swal({
            title: 'Do you really want to '+data_status+' the business details of this user?',
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
                url:module_url_path+'/approve_business_details',
                type:'GET',
                data:{seller_id:sellerid,status:val,_token:csrf_token},
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
                      
                         $("#approve_business").modal('hide');
                         setTimeout(function(){
                           window.location.reload();
                         },2000);
                         
                      
                   }else{
                      swal(response.status,response.message,'error');
                          $("#approve_business").modal('hide');

                   }
                }
              }); //end of ajax

             }
           })//end of sweet confirm box


      }// if seller id
    });



    

  // function confirm_approve_business(ref)
  //  {  
    
  //     swal({
  //         title: 'Are you sure to approve business details of this user?',
  //         type: "warning",
  //         showCancelButton: true,
  //         // confirmButtonColor: "#DD6B55",
  //         confirmButtonColor: "#8d62d5",
  //         confirmButtonText: "Yes, do it!",
  //         closeOnConfirm: false
  //       },
  //       function(isConfirm,tmp)
  //       {
  //         if(isConfirm==true)
  //         {
  //             var seller_id = ref.attr('data-enc_id');
  //             var csrf_token = "{{ csrf_token()}}";

  //             $.ajax({
  //              url:module_url_path+'/approve_business_details',
  //              type:'GET',
  //              data:{seller_id:seller_id,_token:csrf_token},
  //              dataType:'json',
  //              beforeSend : function()
  //              { 
  //                showProcessingOverlay();        
  //              },        
  //              success:function(response)
  //              {
  //                 hideProcessingOverlay();

  //                 if(response.status == 'SUCCESS')
  //                 {
  //                     swal(response.status,response.message,'success');
  //                 }else{
  //                    swal(response.status,response.message,'error');
  //                 }
  //              }
  //            });
  //         }
  //       });
  //  }
   
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
         d['column_filter[q_name]']        = $("input[name='q_name']").val()
         d['column_filter[q_email]']       = $("input[name='q_email']").val()
         d['column_filter[q_user_type]']       = $("select[name='q_user_type']").val()
         d['column_filter[q_status]']       = $("select[name='q_status']").val()
         d['column_filter[q_vstatus]']       = $("select[name='q_vstatus']").val()

         d['column_filter[q_email_verification_status]'] = $("select[name='q_email_verification_status']").val()
         d['column_filter[q_id_verification_status]']   = $("select[name='q_id_verification_status']").val()

         d['column_filter[q_profile_verification_status]']   = $("select[name='q_profile_verification_status']").val()

         d['column_filter[q_business_verification_status]']   = $("select[name='q_business_verification_status']").val()

        d['column_filter[q_documents_verification_status]']   = $("select[name='q_documents_verification_status']").val()
         d['column_filter[q_planname]']   = $("select[name='q_planname']").val()

          d['column_filter[q_featured]']  = $("select[name='q_featured']").val()

         d['column_filter[q_business_name]']        = $("input[name='q_business_name']").val()

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
     {data: 'business_name', "orderable": true, "searchable":false},
     {data: 'email', "orderable": true, "searchable":false},
     
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
         return row.build_featured_btn;
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
        }
        return is_trusted;*/

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
        var approve_verification_status  = '';

        if(row.approve_verification_status==0) 
        {
          approve_verification_status = '<span class="label label-warning">Pending</span>';
        }
        else if(row.approve_verification_status==3) 
        {
          approve_verification_status = '<span class="label label-warning">Submitted</span>';
        }
        else if(row.approve_verification_status==1)
        {
          approve_verification_status = '<span class="label label-success">Approved</span>';
        }
        else if(row.approve_verification_status==2)
        {
          approve_verification_status = '<span class="label label-danger">Rejected</span>';
        }
        return approve_verification_status;
     
      }
     },
    
     {
      render : function(data, type, row, meta)
      {
        var approve_status  = '';

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
        var business_approve_status  = '';

        if(row.business_approve_status==0) 
        {
          business_approve_status = '<span class="label label-warning">Pending</span>';
        }
        else if(row.business_approve_status==3) 
        {
          business_approve_status = '<span class="label label-warning">Submitted</span>';
        }
        else if(row.business_approve_status==1)
        {
          business_approve_status = '<span class="label label-success">Approved</span>';
        }
        else if(row.business_approve_status==2)
        {
          business_approve_status = '<span class="label label-danger">Rejected</span>';
        }
        return business_approve_status;
     
      }
     },

     {
      render : function(data, type, row, meta)
      {
        var documents_verification_status  = '';

        if(row.documents_verification_status==0) 
        {
          documents_verification_status = '<span class="label label-warning">Pending</span>';
        }
        else if(row.documents_verification_status==3) 
        {
          documents_verification_status = '<span class="label label-warning">Submitted</span>';
        }
        else if(row.documents_verification_status==1)
        {
          documents_verification_status = '<span class="label label-success">Approved</span>';
        }
        else if(row.documents_verification_status==2)
        {
          documents_verification_status = '<span class="label label-danger">Rejected</span>';
        }
        return documents_verification_status;
     
      }
     },

     {
       render : function(data, type, row, meta) 
       {
         return row.build_subscriptionbtn;
       },
       "orderable": false, "searchable":false
      },
       {data: 'membership_plan', "orderable": true, "searchable":false},


     {
       render : function(data, type, row, meta) 
       {
         return row.build_action_btn;
       },
       "orderable": false, "searchable":false
     },

      

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
      $("input.toggleSwitchFeatured").change(function(){
          featured_seller($(this));
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
                     <td><input type="text" name="q_business_name" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    <td><input type="text" name="q_email" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    
                    <td>
                       <select class="search-block-new-table column_filter small-form-control" name="q_status" id="q_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                        </select>
                    </td>
                    <td>
                      <select name="q_featured" id="q_featured" class="form-control" onchange="filterData()">
                        <option value="">Select</option>
                        <option value="1">Featured</option>
                        <option value="0">Unfeatured</option>
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
                      <select class="search-block-new-table column_filter small-form-control" name="q_id_verification_status" id="q_id_verification_status" onchange="filterData();">
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

                    <td>
                      <select class="search-block-new-table column_filter small-form-control" name="q_business_verification_status" id="q_business_verification_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="0">Pending</option>
                        <option value="3">Submitted</option>
                        <option value="1">Approved</option>
                        <option value="2">Rejected</option>
                      </select>
                    </td>
                    <td>
                     <select class="search-block-new-table column_filter small-form-control" name="q_documents_verification_status" id="q_documents_verification_status" onchange="filterData();">
                        <option value="">All</option>
                        <option value="0">Pending</option>
                        <option value="3">Submitted</option>
                        <option value="1">Approved</option>
                        <option value="2">Rejected</option>
                      </select>
                    </td>
                    <td> </td>
                    <td>
                       <select class="search-block-new-table column_filter small-form-control" name="q_planname" id="q_planname" onchange="filterData();">
                            <option value="">All</option>`+option+`            
                          </select>
                    </td>
                  
                 

                </tr>`);



       $('input.column_filter').on( 'keyup click', function () 
        {
             filterData();
        });
   });
   
  
    // <select class="search-block-new-table column_filter small-form-control" name="q_vstatus" id="q_vstatus" onchange="filterData();">
    //                     <option value="">All</option>
    //                     <option value="1">Active</option>
    //                     <option value="0">Block</option>
    //                     </select>


   function filterData()
   {
   table_module.draw();
   }
   
   function statusChange(data)
   {
       var type = data.attr('data-type');
       var alert_text = 'Do you really want to '+ type + ' this seller?'
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
                     sweetAlert('Success!','Seller activated successfully.','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','activate');
                     sweetAlert('Success!','Seller deactivated successfully.','success');
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
          title: 'Do you really want to approve this user?',
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


  function callImageViewer(){
        
      smartPhotoInit = new SmartPhoto(".js-img-viwer");

      console.log(smartPhotoInit);

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
  }//end



    function featured_seller(data)
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
          if(response.status=='SUCCESS')
          {
            if(response.data=='ACTIVE')
            {
              $(ref)[0].checked = true;  
              $(ref).attr('data-type','unfeatured');
              swal('Success!','Seller status changed to featured.','success');

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','featured');
              swal('Success!','Seller status changed to unfeatured.','success');

            }            
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
          }  
        }
      });  
  }  

</script>



<script>
  //verfiy user email functionalty
  $(document).on("click",".verifyuserbtn",function() {
      var user_id = $(this).attr('user_id');
      var email = $(this).attr('email');
      var completed = $(this).attr('completed');

      $("#seller_id").val(user_id);     
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
      
    var user_id = $("#seller_id").val();    
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
    <input type="hidden" name="seller_id" id="seller_id" value="">
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
<!----------------end verify user modal----------------------------->

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