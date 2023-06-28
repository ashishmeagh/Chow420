@extends('seller.layout.master') 
@section('main_content')
<style>
input[type=checkbox] {
    visibility: visible;
}

  .select-style select{font-size: 14px;}
  .search-header{display: none;}
  body table.dataTable {
    clear: both;
    margin-top: 6px !important;
    margin-bottom: 6px !important;
    max-width: 100% !important;
}
.completedmodl .ordr-calltnal-title{
font-size: 22px;    line-height: 28px;
}
.completedmodl .okbuttons{
  margin-top: 40px;
}
.completedmodl .okbuttons .btns-pending{
  display: inline-block;
    text-align: center;
    color: #666;
    font-size: 14px;
    border: 1px solid #666;
    padding: 8px 30px;
    border-radius: 3px;
}
.completedmodl .okbuttons .btns-pending:hover{
  color: #fff;
  background-color: #873dc8;
}
.modal-dialog.ordercancellationmodal.completedmodl {
    max-width: 400px;
}
.prodname{
  width: 120px;
}



  @media
    only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {
    table, thead, tbody, th, td, tr {
      display: block;
    }
    thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }
    tr.searchinput-data{
      position: static;
    }
    tr.searchinput-data td{width: 93% !important; border: none;}
    tr.searchinput-data td input{width: 100%;}
    tr.searchinput-data .select-style{width: 100%;}
    .searchinput-data td:before{ display: none; }
    tr {
      margin: 0 0 1rem 0; 
      border: 1px solid #ddd;
      box-shadow: 0 1px 0 #ccc; border-radius: 3px;
    }
     .table > thead > tr > td.remove-border{ 
display: none;
      border-top: none !important; border-bottom: none !important;}
    td.dataTables_empty:before{ display: none; padding: 9px 18px 7px;}
      .table > tbody > tr > td{font-size: 14px;}
    tr:nth-child(odd) {
      background: #f9f9f9;
    border: 1px solid #ccc;
    }
    .table > tbody > tr > td{ 
      padding: 23px 18px 7px;
      border-top: 1px solid #ececec;
    }
    td {
      border: none;
      border-bottom: none;
      position: relative;
      padding-left: 50%;     
    }

    td:before {
      position: absolute;
      top: 4px;
      left: 17px;
      width: 45%;font-weight: 600;
      padding-right: 10px; font-size: 14px;
      white-space: nowrap;
    }
    .search-header{display: block;}

    td:nth-of-type(1):before { content: "Product"; }
    td:nth-of-type(2):before { content: "Brand"; }
    td:nth-of-type(3):before { content: "Name"; }
    td:nth-of-type(4):before { content: "Price"; }
    td:nth-of-type(5):before { content: "Age"; }
    td:nth-of-type(6):before { content: "Error Message"; }
    td:nth-of-type(7):before { content: "Status"; }
    td:nth-of-type(8):before { content: "Product Approved / Disapproved Status"; }
    td:nth-of-type(9):before { content: "Action"; }
  }


.modal-content {
    padding: 40px;
}
.ordr-calltnal-title {
    margin-bottom: 90px;
}
.modal-content .btns-pending{
    display: inline-block;
    text-align: center;
    color: #fff;
    font-size: 14px;
    border: 1px solid #873dc8;
    padding: 9px 40px;
    border-radius: 3px;
    background-color: #873dc8;
}
.modal-dialog {
    max-width: 400px;
    width: 100%;
}

</style>


<div class="my-profile-pgnm">
   Sell Products

    <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Sell Products</li>
    </ul>
</div>

@php 
  
   $user_subscriptionstatus = isset($user_subscribed)?$user_subscribed:'';
   $res_active_product_count = isset($res_active_product)?$res_active_product:'0';

@endphp
<div class="new-wrapper">
  <div class="button-list-dts myproduct-mrg">
{{--     @if(isset($arr_seller) && count($arr_seller) > 0 && $arr_seller['approve_verification_status'] == 1)
 --}}    

  {{--   @if(isset($arr_seller) && count($arr_seller) > 0 && ($arr_seller['approve_verification_status'] == 1) && isset($user_arr) && ($user_arr['approve_status']==1) ) --}}
 
    @if(isset($arr_seller) && count($arr_seller) > 0 && ($arr_seller['approve_status'] == 1) && isset($user_arr) && ($user_arr['approve_status']==1) )


     @if(isset($user_subscriptionstatus) && $user_subscriptionstatus=='1') 
        <!---------sunscription actived------------------------------->
           @php 
             $user_product_count =  $user_arr['product_count'];
             $user_product_limit =  $user_arr['product_limit'];

             $mem_product_count = 0;
             if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
             {
                $mem_product_count = $user_subscriptiontabledata[0]['get_membership_details']['product_count'];
                $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';


             // if($user_product_count==$user_product_limit)
              if($res_active_product_count==$product_limit)
              {
             
              @endphp

           
                <!---------Reach proudct count value------------->

                <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#reachProductCount" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>
                {{-- <a href="#" class="butn-def" data-toggle="modal" data-target="#reachProductCount" data-backdrop="false">Bulk Add</a> --}}
                <!---------Reach product count value----------->


              @php 

             }//if product count greater than membership product count
            // elseif($user_product_count<=$user_product_limit)
             elseif($res_active_product_count<=$product_limit)
             {
               //add here
              @endphp

                   {{--   <a href="{{ url('/') }}/seller/product/create" class="butn-def cancelbtnss" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a> --}}
                    @if(isset($seller_documents_verification_status) && $seller_documents_verification_status=='0') 
                       <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsNotUploaded" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                   @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='2') 

                        <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsRejected" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                      @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='3') 

                        <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsSubmitted" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                       @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='1') 

                      
                       <a href="{{ url('/') }}/seller/product/create" class="butn-def cancelbtnss" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a> 

                      @endif
                    {{--  <a href="#" class="butn-def"  data-toggle="modal" data-target="#MyBulkAdd">Bulk Add</a> --}}
              
              @php
             }//else of less product count value 
           } //if user subscripton data
          @endphp

        <!---------sunscription actived------------------------------->
{{-- 
        @elseif($user_subscriptionstatus!='1' && isset($get_cancelmembershipdata) && 
        !empty($get_cancelmembershipdata))  --}}
        <!----sunscription cancelled but subscription date is greater than current date------>

        @elseif($user_subscriptionstatus!='1' && isset($get_cancelmembershipdata) && 
        !empty($get_cancelmembershipdata) && empty($user_subscriptiontabledata)) 
        <!----sunscription cancelled   hrere new conditon for user subscription empty condition added for if user select free plan then he can not add more products than his limit----->

           @php 

             $user_product_count =  $user_arr['product_count'];
             $user_product_limit =  $user_arr['product_limit'];
             $currendate = date('Y-m-d');

             $mem_product_count = 0;
             // if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata) && $get_cancelmembershipdata['is_cancel']=='1' && $currendate<=$get_cancelmembershipdata['current_period_enddate'])

             if(isset($get_cancelmembershipdata) && !empty($get_cancelmembershipdata) && $get_cancelmembershipdata['is_cancel']=='1' && $currendate<=$get_cancelmembershipdata['current_period_enddate']   && $get_cancelmembershipdata['membership']!="1")  
             {
              //&& $get_cancelmembershipdata['membership']!="1" cond added if user cancel free mem plan then he can not add more products

                $mem_product_count = $get_cancelmembershipdata['get_membership_details']['product_count'];

                $product_limit = isset($get_cancelmembershipdata['product_limit'])?$get_cancelmembershipdata['product_limit']:'0';

             // if($user_product_count==$user_product_limit)
              if($res_active_product==$product_limit)
              {

              @endphp

           
                <!---------Reach proudct count value------------->

                <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#reachProductCount" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>
               {{--  <a href="#" class="butn-def" data-toggle="modal" data-target="#reachProductCount" data-backdrop="false">Bulk Add</a> --}}
                <!---------Reach product count value----------->


              @php 

             }//if product count greater than membership product count
            // elseif($user_product_count<=$user_product_limit)
            elseif($res_active_product<=$product_limit)
             { 
               // add here
              @endphp
               
                 {{--     <a href="{{ url('/') }}/seller/product/create" class="butn-def cancelbtnss" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a> --}}
                    @if(isset($seller_documents_verification_status) && $seller_documents_verification_status=='0') 

                       <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsNotUploaded" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                   @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='2') 

                        <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsRejected" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                      @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='3') 

                        <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsSubmitted" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                      @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='1') 

                       <a href="{{ url('/') }}/seller/product/create" class="butn-def cancelbtnss" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a> 

                      @endif
                    {{--  <a href="#" class="butn-def"  data-toggle="modal" data-target="#MyBulkAdd">Bulk Add</a> --}}
              
              @php
             }//else of less product count value 
           } //if user subscripton data
          @endphp

        <!---------sunscription actived------------------------------->

     @elseif($user_subscriptionstatus!='1' && isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata) && $user_subscriptiontabledata[0]['membership']=="1")   
          <!---------Free membership----------->

             @php 
             
             $user_product_count =  $user_arr['product_count'];
             $user_product_limit =  $user_arr['product_limit'];


             $mem_product_count = 0;
             if(isset($user_subscriptiontabledata) && !empty($user_subscriptiontabledata))
             {
                $mem_product_count = $user_subscriptiontabledata[0]['get_membership_details']['product_count'];

                 $product_limit = isset($user_subscriptiontabledata[0]['product_limit'])?$user_subscriptiontabledata[0]['product_limit']:'0';


              //if($user_product_count==$user_product_limit)
              if($res_active_product==$product_limit)
              {
             
              @endphp

           
                <!---------Reach proudct count value------------->

                <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#reachProductCount" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>
              {{--   <a href="#" class="butn-def" data-toggle="modal" data-target="#reachProductCount" data-backdrop="false">Bulk Add</a> --}}
                <!---------Reach product count value----------->


              @php 

             }//if product count greater than membership product count
             //elseif($user_product_count<=$user_product_limit)
             elseif($res_active_product<=$product_limit)
             {
               // add here
              @endphp

                    @if(isset($seller_documents_verification_status) && $seller_documents_verification_status=='0') 

                       <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsNotUploaded" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                   @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='2') 

                        <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsRejected" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                      @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='3') 

                        <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#documentsSubmitted" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>

                      @elseif(isset($seller_documents_verification_status) && $seller_documents_verification_status=='1') 

                      
                       <a href="{{ url('/') }}/seller/product/create" class="butn-def cancelbtnss" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a> 

                      @endif



                    {{--  <a href="#" class="butn-def"  data-toggle="modal" data-target="#MyBulkAdd">Bulk Add</a>
               
                   {{-   <a href="{{ url('/') }}/seller/product/create" class="butn-def cancelbtnss" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a> --}}
                    {{--  <a href="#" class="butn-def"  data-toggle="modal" data-target="#MyBulkAdd">Bulk Add</a> --}}
              
              @php
             }//else of less product count value 
           } //if user subscripton data
          @endphp


          <!--------end of-Free membership----->


     @else
         <!---------sunscription not active------------------------------->

        <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#NoSubscriptionActive" data-backdrop="false" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>
       {{--  <a href="#" class="butn-def" data-toggle="modal" data-target="#NoSubscriptionActive" data-backdrop="false">Bulk Add</a> --}}

         <!---------sunscription not active------------------------------->

     @endif  


    @else
     <!---------profile not active------------------------------->
      <a href="#" class="butn-def cancelbtnss" data-toggle="modal" data-target="#profileNotUpdate" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Product</a>
     {{--  <a href="#" class="butn-def" data-toggle="modal" data-target="#profileNotUpdate" >Bulk Add</a> --}}
     <!---------profile not active------------------------------->

    @endif

  </div>
     


<div id="NoSubscriptionActive"  class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" >
          <button type="button" class="close" data-dismiss="modal">
            <img src="{{ url('/') }}/assets/seller/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title"> Please select membership plan .</div>
            <div class="button-list-dts btn-order-cnls okbuttons">
              <a href="{{ url('/') }}/seller/membership" class="btns-pending">
                 OK
              </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div> <!--  No subscription active --> 


<div id="reachProductCount"  class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" >
          <button type="button" class="close" data-dismiss="modal">
            <img src="{{ url('/') }}/assets/seller/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">You’ve reached the product limit for this plan, please upgrade. <br/> </div>
            <div class="button-list-dts btn-order-cnls okbuttons">
              <a href="{{ url('/') }}/seller/membership" class="btns-pending">
                 OK
              </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div> <!--  reach product count --> 

<div id="documentsNotUploaded"  class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog my-product-add-chow">
        <!-- Modal content-->
        <div class="modal-content" >
          <button type="button" class="close" data-dismiss="modal">
            <img src="{{ url('/') }}/assets/seller/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">You haven't uploaded documents yet, please upload. <br/> </div>
            <div class="button-list-dts btn-order-cnls okbuttons">
              <a href="{{ url('/') }}/seller/profile" class="btns-pending">
                 OK
              </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div> <!--  reach product count --> 

<div id="documentsSubmitted"  class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog my-product-add-chow">
        <!-- Modal content-->
        <div class="modal-content" >
          <button type="button" class="close" data-dismiss="modal">
            <img src="{{ url('/') }}/assets/seller/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">Your documents are not approved yet. <br/> </div>
            <div class="button-list-dts btn-order-cnls okbuttons">
              <a href="{{ url('/') }}/seller/profile" class="btns-pending">
                 OK
              </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div> <!--  reach product count --> 



<div id="documentsRejected"  class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog my-product-add-chow">
        <!-- Modal content-->
        <div class="modal-content" >
          <button type="button" class="close" data-dismiss="modal">
            <img src="{{ url('/') }}/assets/seller/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">Your documents has been rejected. <br/> </div>
            <div class="button-list-dts btn-order-cnls okbuttons">
              <a href="{{ url('/') }}/seller/profile" class="btns-pending">
                 OK
              </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div> <!--  reach product count --> 



  <div class="myproductstbls">
    <div class="table-responsive">
       <table class="table seller-table" id="table_module">
           <thead>
               <tr>
                   <th>Image</th>
                   <th>Brand</th>
                   <th >Name</th>
                   <th>Price</th>
                  {{--  <th>Age</th> --}}
                   <th>Error Message</th>
                   <th>Status</th>
                   <th>Product Approved / Disapproved Status</th>
                   <th style="white-space: nowrap;" >Is out of stock</th>
                   <th class="text-center">Spectrum Type</th>
                   <th class="text-center">Action</th>
               </tr>
           </thead>
           <tbody>           
           </tbody>
       </table>
      </div>
  </div>


<!-- 

<div class="col-md-12">
    <div class="pagination-chow pagination-center mg-space">
          <ul> 
              <li><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
              <li><a href="#">1</a></li>
              <li><a href="#" class="active">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
          </ul>
      </div>
</div> -->

</div>


<!-- Modal Business Details  Start -->
<div id="MyBulkAdd"  class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">
              <img src="{{ url('/') }}/assets/seller/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">Add your product in bulk</div>

            <div class="business-details-main-dv seller-pflviw">
               <form method="post" enctype="multipart/form-data" id="form_import">
                 {{ csrf_field() }}
                <div class="user-box form-group">
                    <label for="">Upload file <span>*</span></label>
                    <div class="upload-block">
                        <input type="file" style="visibility:hidden; height: 0;"  name="import_file" id="import_file"/>
                        <div class="input-group ">
                            <input type="text" class="form-control file-caption  kv-fileinput-caption" disabled="disabled" data-parsley-required="true" data-parsley-required-message="Please upload file"/>
                            <div class="btn btn-primary btn-file btn-gry">
                                <a class="file" onclick="browseImage(this)">
                                    <img src="{{ url('/') }}/assets/seller/images/upload-add-busines.png" alt=""  />
                                </a>
                            </div>
                            <div class="btn btn-primary btn-file btn-file-remove remove" style="border-right:1px solid #fbfbfb !important;display:none;">
                                 <a  class="file" onclick="removeBrowsedImage(this)">
                                  <i class="fa fa-trash"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
             
                <a class="download-template" href="{{ url('/') }}/seller/product/exportExcel" >Download Template </a>
              </div>
                <div class="button-list-dts btn-order-cnls">
                   <button type="button" id="btn-bulk" class="butn-def">Submit</button>
                </div>
            </div>
           </form>
          <div class="clearfix"></div>
        </div>
 </div> <!-- end of bulk upload modal --->


 <!-- Modal Profile is not completed -->
<div id="profileNotUpdate"  class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal completedmodl">
        <!-- Modal content-->
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal">
            <img src="{{ url('/') }}/assets/seller/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">To sell products on Chow, you need to have a complete and approved seller profile.</div>
            <div class="button-list-dts btn-order-cnls okbuttons">
              <!-- <button type="button" id="btn-bulk" class="butn-def">Ok</button> -->
              <a href="{{ url('/') }}/seller/profile" class="btns-pending">
                                OK
                                </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div> <!--  End Profile is not completed --> 

<script type="text/javascript">

       function confirm_delete(ref,event)
       {
         var delete_param = "Product";
         confirm_action(ref,event,'Do you really want to delete this Product?',delete_param);
       }

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
      $(document).ready(function(){

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

    $("#btn-bulk").click(function(){
      if($('#form_import').parsley().validate()==false) return;

         $.ajax({
              
            url: SITE_URL+'/seller/product/importExcel',
            data: new FormData($('#form_import')[0]),
            contentType:false,
            processData:false,
            method:'POST',
            cache: false, 
            dataType:'json',
            beforeSend: function() {
              showProcessingOverlay();
            },
            success:function(data)
            {
              
                $(".modal").removeClass("in");
                $(".modal-backdrop").remove();
                hideProcessingOverlay();
                $("#MyBulkAdd").hide();
               if('success' == data.status)
               {            
                  $('#form_import')[0].reset();
                    swal({
                          // title: data.status,
                           title: 'Success',
                           text: data.description,
                           type: data.status,
                          // confirmButtonText: "OK",
                          // closeOnConfirm: false
                        },
                       function(isConfirm,tmp)
                       {
                         if(isConfirm==true)
                         {  
                            location.reload();
                            // window.location = data.link;
                         }
                       });
                }
                else
                {
                  // swal('Warning',data.description,data.status);
                   swal('Alert!',data.description); 
                   $('#form_import')[0].reset();
                   $(".btn-file-remove").hide();
                }  
            }
            
          });   
    });

    /*************************************/

  /*Script to show table data*/

  var module_url_path ="{{ url('/') }}/seller/product"
   
   var table_module = false;
   var product_imageurl_path = "{{ $product_imageurl_path }}"
   $(document).ready(function()
   {
     table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,      
      bFilter: false ,
      ajax: {
      'url': SITE_URL+'/seller/product/get_records',
      'data': function(d)
        {
          d['column_filter[q_product_name]']   = $("input[name='q_product_name']").val()
          d['column_filter[q_product_price]']  = $("input[name='q_product_price']").val()
          d['column_filter[q_product_age]']    = $("input[name='q_product_age']").val()
          d['column_filter[q_status]']         = $("select[name='q_status']").val()
          d['column_filter[q_admin_status]']   = $("select[name='q_admin_status']").val()
          d['column_filter[q_brand_name]']     = $("input[name='q_brand_name']").val()
          d['column_filter[spectrum]']         = $("select[name='spectrum']").val()
       }
      },
      columns: [       
       {
              "orderable":false,
              "searchable":false,
              render : function(data, type, row, meta) 
              {
                if(row.image){
                  var src = product_imageurl_path+'/'+row.image;   
                }else{
                  var src = SITE_URL+'/assets/images/default-product-image.png';
                }
                             
                return '<img src="'+src+'" width="100" height="100"/>';
              },
       },
      {data: 'bname', "orderable": false, "searchable":false}, 
      {data: 'product_name', "orderable": false, "searchable":false}, 
      {data: 'unit_price', "orderable": false, "searchable":false},    
     // {data: 'age_restriction', "orderable": false, "searchable":false},  
      /* {
              "orderable":false,
              "searchable":false,
              render : function(data, type, row, meta) 
              {
                var age = row.age; 
                if(age)     
                return age;
                else
                return 'NA';  
              },
       },*/  
       {
              "orderable":false,
              "searchable":false,
              render : function(data, type, row, meta) 
              {
                var src = row.error_message;      
                return src;
              },
       },

     /* {
         data : 'is_active',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.is_active == '0')
           {
            
             return `<div class="status-shipped">Block</div>`

           }
           else if(row.is_active == '1')
           {
             return `<div class="status-completed">Active</div>`

           }          
         },
         "orderable": false,
         "searchable":false
       }, */


       
       

       {
       render : function(data, type, row, meta) 
       {
         return row.build_status_btn;
       },
       "orderable": false, "searchable":false
       },

      {
         data : 'is_approve',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.is_approve == '0')
           {
            
             return `<div class="status-dispatched">Pending Approval</div>`

           }
           else if(row.is_approve == '1')
           {
             return `<div class="status-completed">Approved</div>`

           }    
            else if(row.is_approve == '2')
           {
             return `<div class="status-shipped">Disapproved</div>`

           }          
         },
         "orderable": false,
         "searchable":false
       }, 


       {
         render : function(data, type, row, meta) 
         {
           return row.build_outofstock_btn;
         },

         "orderable": false, "searchable":false
       },

     {
       render : function(data, type, row, meta) 
       {
         return row.spectrum;
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
    
    $("input.toggleSwitch").change(function(){
       statusChange($(this));
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


      $('input.toggleOutofstock').change(function(){

        toggle_stock_change($(this));

       });

      function toggle_stock_change (ref) {

        if($(ref).is(":checked"))
         {
           var status  = 1;
           var status_app_disapp = "Do you really want make this product as Out of stock?";
         }
         else
         {
           var status  = 0;
           var status_app_disapp = "Do you really want to remove this product from out of stock?";
         }
         
          var product_id = $(ref).attr('data-enc_id');  
                  

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {

                     // star product approve , disapprove
                     //var product_id = $(this).attr('data-enc_id');  
                     $.ajax({
                         method   : 'GET',
                         dataType : 'JSON',
                         data     : {status:status,product_id:product_id},
                         url      : module_url_path+'/toggleOutofstock',
                          beforeSend: function(){    
                           showProcessingOverlay();           
                          },
                         success  : function(response)
                         {     
                           hideProcessingOverlay();                     
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
                   // end product approve,disapprove  
               }

               else
                {
                  $(ref).trigger('click');
                }
             });



      }
















































       /*$('input.toggleOutofstock').change(function(){

         if($(this).is(":checked"))
         {
           var status  = 1;
           var status_app_disapp = "Do you really want make this product as Out of stock?";
         }
         else
         {
           var status  = 0;
           var status_app_disapp = "Do you really want to remove this product from out of stock?";
         }
         
          var product_id = $(this).attr('data-enc_id');  
                  

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {

                     // star product approve , disapprove
                     //var product_id = $(this).attr('data-enc_id');  
                     $.ajax({
                         method   : 'GET',
                         dataType : 'JSON',
                         data     : {status:status,product_id:product_id},
                         url      : module_url_path+'/toggleOutofstock',
                          beforeSend: function(){    
                           showProcessingOverlay();           
                          },
                         success  : function(response)
                         {     
                           hideProcessingOverlay();                     
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
                   // end product approve,disapprove  
               }
             });

      });*/ //end of out of stock button   
      

   }); 
  
   /*search box*/
     $("#table_module").find("thead").append(`<tr class="searchinput-data">
                    <td><div class='search-header'>Search</div></td>
                    <td><input type="text" name="q_brand_name" placeholder="Brand" class="input-text column_filter" /></td>
                    <td><input type="text" name="q_product_name" placeholder="Name" class="input-text column_filter" /></td>
                    <td width="10%"><input type="text" name="q_product_price" placeholder="Price" class="input-text column_filter" /></td> 
                  
                    <td class='remove-border'></td>   
                    <td><div class="select-style">
                      <select class="column_filter frm-select" name="q_status" id="q_status" onchange="filterData();">
                           
                            <option value="-1">All</option>
                            <option value="0">Block</option>
                            <option value="1">Active</option>
                      </select></div>
                    </td>    
                    <td><div class="select-style">
                      <select class="column_filter frm-select" name="q_admin_status" id="q_admin_status" onchange="filterData();">
                            <option value="-1">All</option>
                            <option value="0">Pending Approval</option>
                            <option value="1">Approved</option>
                            <option value="2">Disapproved</option>
                      </select></div>
                    </td> 
                     <td></td>   
                    <td><div class="select-style">
                      <select class="column_filter frm-select" name="spectrum" id="spectrum" onchange="filterData();">
                            <option value="">All</option>
                            <option value="0">Full Spectrum</option>
                            <option value="1">Broad Spectrum</option>
                            <option value="2">Isolate</option>
                      </select></div>
                    </td>

                     <td></td>   
                    
                </tr>`);

       $('input.column_filter').on( 'keyup click', function () 
        {
             filterData();
        });
   });
   
   function filterData()
   {
   table_module.draw();
   }

 function statusChange(data)
 {

     swal({
          title: 'Do you really want to update status of this product?',
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
           var ref     = data;  
           var type    = data.attr('data-type');
           var enc_id  = data.attr('data-enc_id');
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
                     sweetAlert('success','Status update successfully','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','activate');
                     sweetAlert('success','Status update successfully','success');
                     location.reload(true);
                   }
                 }
                 else
                 {
                    //sweetAlert('Error','Something went wrong!','error');
                         if(response.msg)
                         {
                                
                                 swal({
                                  title: response.msg,
                                  type: "warning",
                                  confirmButtonColor: "#873dc8",
                                  confirmButtonText: "Ok",
                                  closeOnConfirm: false
                                },
                                function(isConfirm,tmp)
                                {
                                  if(isConfirm==true)
                                  {  window.location.reload();
                                  }
                                })

                        }
                 }  
               }
             }); 
          } 
          else
          {
            $(data).trigger('click');
          }
       })
   }//function status change 
  


      

</script>
 @endsection