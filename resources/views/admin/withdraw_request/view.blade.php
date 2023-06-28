@extends('admin.layout.master')                
@section('main_content')
<style type="text/css">
  .colorbuttonfs {
    background-color: #873dc8 !important;
    color: #fff !important;
    border: 1px solid #873dc8 !important;
}
.colorbuttonfs:hover {
    background-color: #fff !important;
    color: #873dc8 !important;
    border: 1px solid #873dc8 !important;
}
.colorbuttonfs:focus {
    background-color: #fff !important;
    color: #873dc8 !important;
    border: 1px solid #873dc8 !important;
}
@media all and (max-width: 767px){
  #wrapper {
    width: 100%;
    height: 100%;
    min-height: 100%;
    position: static;
    overflow: visible;
    overflow-x:hidden; 
}
}
</style>
<!-- Page Content -->
<div id="page-wrapper"> 
  <div class="container-fluid">
    <div class="row bg-title">
       <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">{{$page_title or ''}} Withdraw Request</h4>
       </div>
       <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">

            @php
                $user = Sentinel::check();
            @endphp
           
            @if(isset($user) && $user->inRole('admin'))
             <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
            @endif
             
             <li><a href="{{ url(config('app.project.admin_panel_slug').'/withdraw-request') }}">Manage Withdraw</a></li>
             <li class="active">{{$page_title or ''}}</li>
          </ol>
       </div>
       <!-- /.col-lg-12 --> 
    </div>

    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">                    
          <body style="background-color: #eaebec;">
          <style type="text/css">
           .data_container {
            width: 200px;
            word-wrap: break-word;
          }

          .data_container2 {
            word-wrap: break-word;

          }
          </style>
          <div style="margin:0 auto; width:100%;">
          <table width="100%" bgcolor="#fff" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #ddd;font-family:Arial, Helvetica, sans-serif;">
              <tr>
                  <td colspan="2" style="background-color: #f1f1f1;padding:10px 10px 10px 30px;font-size:12px;">
                      <table width="100%">
                          <tr>
                              <td width="50%">
                                  <!--  <h3 style="font-size:18px;padding:0;margin:0px;">Order ID: {{$arr_order_detail['order_no'] or ''}} </h3> -->
                                   @if(!empty($arr_withdraw_request) && count($arr_withdraw_request)>0)
                                       <div class="row">
                                         @if(!empty($arr_withdraw_request['seller_details']) && count($arr_withdraw_request['seller_details'])>0)
                                          <div class="col-md-12">
                                          <!-- <h4><b>Dispensary Name : </b>{{ $arr_withdraw_request['seller_details']['first_name'].' '.$arr_withdraw_request['seller_details']['last_name'] }} </h4> -->

                                          <h4><b>Dispensary Name : </b>{{ $arr_withdraw_request['seller_table_details']['business_name'] }} </h4>

                                          </div>
                                          @endif                       
                                      </div>
                                  @endif
                              </td>
                              <td width="50%" style="background-color: #f1f1f1;color: #333; padding:10px;font-size:14px; text-align: right;">
                                @php

                                if(isset($arr_withdraw_request['created_at']) && !empty($arr_withdraw_request['created_at']))
                                {
                                  $arr_withdraw_request['created_at'];

                                  $date = us_date_format($arr_withdraw_request['created_at']);
                                }
                                 
                                @endphp
                                 <b>Request Date:</b> {{ $date or '--'}}
                                 
                              </td>
                          </tr>

                      </table>
                  </td>
                  
              </tr>


              <tr>
                  <td colspan="2" style="height:10px;">
                      &nbsp;
                  </td>
              </tr>

              <tr>
                  <td colspan="2" style="background-color: #f1f1f1;padding:10px 10px 10px 30px;font-size:12px;">
                      <table width="100%">
                          <tr>
                              <td width="50%">
                                   <h3 style="font-size:18px;padding:0;margin:0px;"><b>Bank Details </b></h3>

                                 {{--   @if(!empty($arr_withdraw_request) && count($arr_withdraw_request)>0)
                                       <div class="row">
                                        <div class="view-rw">
                                         @if(!empty($arr_withdraw_request['seller_table_details']) && count($arr_withdraw_request['seller_table_details'])>0)
                                          <div class="col-md-6">
                                          <h4><span>Registered Name :</span> {{ $arr_withdraw_request['seller_table_details']['registered_name'] or ''}} </h4>
                                          </div>

                                          <div class="col-md-6">
                                          <h4><span>Account No. :</span> {{ $arr_withdraw_request['seller_table_details']['account_no'] or ''}} </h4>
                                          </div>
                                          <div class="col-md-6">
                                          <h4><span>Routing No :</span> {{ $arr_withdraw_request['seller_table_details']['routing_no'] or ''}} </h4>
                                          </div>
                                          <div class="col-md-6">
                                          <h4><span>Swift No :</span> {{ $arr_withdraw_request['seller_table_details']['switft_no'] or ''}} </h4>
                                          </div>
                                          <div class="col-md-6">
                                          <h4><span>Paypal Email :</span> {{ $arr_withdraw_request['seller_table_details']['paypal_email'] or ''}} </h4>
                                          </div>
                                          @endif                       
                                      </div>
                                      </div>
                                  @endif
                               --}}


                                   @if(!empty($arr_withdraw_request) && count($arr_withdraw_request)>0)
                                       <div class="row">
                                        <div class="view-rw">
                                         @if(!empty($arr_withdraw_request) && count($arr_withdraw_request)>0)
                                          <div class="col-md-6">
                                          <h4><span>Registered Name :</span> {{ $arr_withdraw_request['registered_name'] or '-'}} </h4>
                                          </div>

                                          <div class="col-md-6">
                                          <h4><span>Account No. :</span> {{ $arr_withdraw_request['account_no'] or '-'}} </h4>
                                          </div>
                                          <div class="col-md-6">
                                          <h4><span>Routing No :</span> {{ $arr_withdraw_request['routing_no'] or '-'}} </h4>
                                          </div>
                                          <div class="col-md-6">
                                          <h4><span>Swift No :</span> {{ $arr_withdraw_request['switft_no'] or '-'}} </h4>
                                          </div>
                                          <div class="col-md-6">
                                          <h4><span>Paypal Email :</span> {{ $arr_withdraw_request['paypal_email'] or '-'}} </h4>
                                          </div>
                                          @endif                       
                                      </div>
                                      </div>
                                  @endif




                              </td>                              
                          </tr>
                          
                      </table>
                  </td>
                  
              </tr>

              <tr>
                  <td colspan="2" style="height:10px;">
                      &nbsp;
                  </td>
              </tr>
              <tr>
                  <td colspan="2">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                              <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #ccc; padding:12px;">Sr. No.</th>
                              <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #ccc; padding:12px;">Order ID</th>                              
                              <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #ccc; padding:12px;">Amount</th>
                          </tr>

                          @if(isset($arr_withdraw_request['order_details']) && count($arr_withdraw_request['order_details']) > 0) 
                            @php
                               $sr_no = 0; 
                            @endphp
                            
                          @foreach($arr_withdraw_request['order_details'] as $key => $order)                

                            @php                                                         
                              $total_amt =   isset($order['total_amount'])?num_format($order['total_amount']):0;

                              $seller_discount_amt =   isset($order['seller_discount_amt'])?num_format($order['seller_discount_amt']):0;

                              $seller_deliverycost_amt =   isset($order['delivery_cost'])?num_format($order['delivery_cost']):0;

                              $tax =   isset($order['tax'])?num_format($order['tax']):0;

                              if(isset($seller_discount_amt) && $seller_discount_amt>0)
                              {
                                   $total_amt = num_format((float)$total_amt - (float)$seller_discount_amt,2);

                              }else{(float)
                                  $total_amt = $total_amt;

                              }


                              if(isset($seller_deliverycost_amt) && $seller_deliverycost_amt>0)
                              {
                                   $total_amt = num_format((float)$total_amt + (float)$seller_deliverycost_amt,2);

                              }else{(float)
                                  $total_amt = $total_amt;

                              }


                              //  if(isset($tax) && $tax>0)
                              // {
                              //      $total_amt = num_format((float)$total_amt + (float)$tax,2);

                              // }else{(float)
                              //     $total_amt = $total_amt;

                              // }



                            @endphp                                               

                            <tr>
                                <td width="140px" style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px;">{{++$sr_no}}</td>

                                <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px;"><b>{{$order['order_no'] or '--'}} </b></td>

                                <td width="240px" style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px;"><b>${{$total_amt or '--'}}</b></td>    
                               
                            </tr>

                           <!--  <input type="hidden" name="withdraw_table_id" id="withdraw_table_id" value="{{$arr_withdraw_request['id'] or ''}}">                         
                            <input type="hidden" name="seller_id" id="seller_id" value="{{$arr_withdraw_request['seller_id'] or ''}}">
                            <input type="hidden" name="total_pay_amt" id="total_pay_amt" value="{{$arr_withdraw_request['total_amount'] or ''}}"> -->
                    
                        @endforeach 
                      @endif
                         
                      </table>
                  </td>
              </tr>

              <tr>
                  <td width="80%" style="text-align: right; background-color: #717f92;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">
                      Total
                  </td>
                  <td width="20%" style="text-align: center; background-color: #7c8c9e;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">
                      ${{isset($order_total)?num_format($order_total):0}}
                  </td>
              </tr>
              @php
                 $seller_commission ='87';$admin_commission ='13';
                 if(isset($arr_withdraw_request['seller_commission']))
                 {
                   $seller_commission = $arr_withdraw_request['seller_commission'];
                 }
                 if(isset($arr_withdraw_request['admin_commission']))
                 {
                   $admin_commission = $arr_withdraw_request['admin_commission'];
                 }

                //  $seller_commission_per = intval(config('app.project.seller_commision'));
                //  $admin_commission_per  = intval(100 - $seller_commission_per);

                  $seller_commission_per = isset($seller_commission)?$seller_commission:'87';
                  $admin_commission_per  =  isset($admin_commission)?$admin_commission:'13';


                  $admin_commission_amt = num_format($order_total * ($admin_commission_per / 100));
                  $seller_commission_amt = num_format($order_total * ($seller_commission_per / 100));

                    
              @endphp
               <tr>
                  <td width="80%" style="text-align: right; background-color: #717f92;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: ; color: #fff;">
                      Admin Commission ({{ $admin_commission_per }}%)
                  </td>

                  <td width="20%" style="text-align: center; background-color: #7c8c9e;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">

                      ${{$admin_commission_amt or '0'}}
                  </td>
              </tr>
              {{-- {{dd($arr_withdraw_request)}} --}}
             <tr>
                  <td width="80%" style="text-align: right; background-color: #717f92;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: ; color: #fff;">
                     {{--  Seller Commission ({{ config('app.project.seller_commision') }}%) --}}
                      Dispensary Commission ({{ $seller_commission_per }}%)
                  </td>

                  <td width="20%" style="text-align: center; background-color: #7c8c9e;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">

                      ${{$seller_commission_amt or '0'}}
                  </td>
              </tr> 
              <tr>
                  <td width="80%" style="text-align: right; background-color: #717f92;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: ; color: #fff;">
                     {{--  Seller Commission ({{ config('app.project.seller_commision') }}%) --}}
                      Previous Uncleared Refund Amount 
                  </td>

                  <td width="20%" style="text-align: center; background-color: #7c8c9e;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">
                    
                    @if($refund_balance_amount!=0)
                      - ${{$refund_balance_amount or '0'}}
                    @else
                      ${{$refund_balance_amount or '0'}}  
                    @endif
                  </td>
              </tr>


               <tr>
                  <td width="80%" style="text-align: right; background-color: #717f92;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: ; color: #fff;">
                     {{--  Seller Commission ({{ config('app.project.seller_commision') }}%) --}}
                      Previous Uncleared Referal Wallet Amount 
                  </td>

                  <td width="20%" style="text-align: center; background-color: #7c8c9e;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">
                    
                    @if($refund_balance_amount!=0)
                      - ${{$referalwallet_total or '0'}}
                    @else
                      ${{$referalwallet_total or '0'}}  
                    @endif
                  </td>
              </tr>



              <tr>
                  <td width="80%" style="text-align: right; background-color: #717f92;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: ; color: #fff;">
                     {{--  Seller Commission ({{ config('app.project.seller_commision') }}%) --}}
                      Amount Payable to Dispensary 
                  </td>

                  <td width="20%" style="text-align: center; background-color: #7c8c9e;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">

                     {{--  ${{$seller_commission_amt- $refund_balance_amount}} --}}
                      ${{$seller_commission_amt- $refund_balance_amount + $referalwallet_total }}

                  </td>
              </tr>
               @php 
                    if($referalwallet_total!=0)
                     $seller_commission_amt = $seller_commission_amt+$referalwallet_total;
                    else
                      $seller_commission_amt = $seller_commission_amt;
              @endphp


              <input type="hidden" name="admin_com_amt" id="admin_com_amt" value="{{$admin_commission_amt or ''}}">
            <input type="hidden" name="seller_com_amt" id="seller_com_amt" value="{{$seller_commission_amt or ''}}">
            <tr>
              <td colspan="2" height="20px"></td>
            </tr>   
          </table>
          </div>

        <div class="row">
          <div class="col-md-6 text-left">
             <a href="javascript:history.go(-1);" class="btn btn-inverse "><i class="fa fa-arrow-left"></i> Back</a>  
          </div>
          <div class="col-md-6 text-right">
              @if($arr_withdraw_request['status'] == 0)                  
                <a class="btn btn-inverse waves-effect waves-light colorbuttonfs" href="javascript:void(0)" onclick="storeAdminCommission('If you sent ${{ $arr_withdraw_request['request_amt'] - $refund_balance_amount + $referalwallet_total }} amount to dispensary then you can complete it.')">Complete</a>                    
              @elseif($arr_withdraw_request['status'] == 1)                  
                <span class="completedrequestspan" href="javascript:void(0)"> You have completed this request.</span>
              @endif
          </div>
        </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- END Main Content -->

          {{-- </body> --}}
@stop

<script type="text/javascript">
  function storeAdminCommission(msg) 
  {
    var msg = msg || false;

      var csrf_token = "{{ csrf_token()}}";
      var module_url_path = "{{$module_url_path}}";
      var withdraw_table_id = "{{ $enc_id }}";
      var order_total = "{{ $order_total }}";
      var referalwallet_total = "{{$referalwallet_total or '' }}";

      if(withdraw_table_id =='')
      {
        swal('Alert!','Something went wrong, Please try again later !');
        return;
      }

      swal({
          title: msg,
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#5cc970",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {

            $.ajax({
                  url: module_url_path+'/store_admin_commission',
                  type:"POST",
                  data: {_token:csrf_token,withdraw_table_id:withdraw_table_id,order_total:order_total,referalwallet_total:referalwallet_total},             
                 
                  beforeSend: function(){     
                    showProcessingOverlay();      
                  },
                  success:function(response)
                  {
                    hideProcessingOverlay();
                    // console.log(response);
                    // $(".showtabcomments").html(response);
                    if(response.status=='success'){
                      swal({
                        title: response.status,
                        type: response.status,
                        text: response.description,
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
                    else
                    {
                      swal('error',response.description,'error');
                    } 

                  }  

              });
          }
        });
  }
</script>