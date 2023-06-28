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
.qty-bld{
  color: #000000 !important;
}
</style>
<!-- Page Content -->
<div id="page-wrapper"> 
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">{{$page_title or ''}}</h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">

          @php
            $user = Sentinel::check();
          @endphp

          @if(isset($user) && $user->inRole('admin'))

            <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>

          @endif
           
         <li><a href="{{ url(config('app.project.admin_panel_slug').'/order') }}">Order</a></li>
         <li class="active">{{$page_title or ''}}</li>
      </ol>
   </div>
   <!-- /.col-lg-12 --> 
</div>

@php
$late = '';
 if(isset($arr_order_detail) && !empty($arr_order_detail))
 {
     $created_at  = date($arr_order_detail[0]['created_at']);
     $orderdate =  date ( 'Y-m-d' , strtotime ( $created_at . ' + 7 days' ));
     $currentdate = date('Y-m-d');
     if($currentdate>$orderdate && $arr_order_detail[0]['order_status']=="2")
     {
        $late='<span class="status-shipped">Late</span>';
     }
     else
     {
       $late='';
     }
 }
@endphp



<!-- .row -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box">
         @include('admin.layout._operation_status')
          <div class="row">
            <div class="col-sm-12 col-xs-12">
                 <h3>
                    <span 
                       class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action" >
                    </span>
                 </h3>
            </div>
          </div>
          <?php // dd($arr_order_detail); ?>

                @if(!empty($arr_order_detail) && count($arr_order_detail)>0)
                     <div class="row-class">
                       @if(!empty($arr_order_detail[0]['seller_details']) && count($arr_order_detail[0]['seller_details'])>0)
                        <div class="h-four-class">
                        <h4>Order No : <span>{{isset($arr_order_detail[0]['order_no'])?$arr_order_detail[0]['order_no']:''}} </span></h4>

                          <!----------pending age verificaiton tag added-------------->
                          @if($arr_order_detail[0]['order_status']==2)
                            @if(isset($arr_order_detail[0]['buyer_age_restrictionflag']) && $arr_order_detail[0]['buyer_age_restrictionflag']==1)
                              <div class="status-dispatched pull-right"> Pending Age Verification</div>
                            @endif
                          @endif 
                          <!--------end of pending age vierificaiton tag---------------->

 

                         <h4>Order Date : <span>{{isset($arr_order_detail[0]['created_at'])? date('d M Y',strtotime($arr_order_detail[0]['created_at'])):''}} |   {{isset($arr_order_detail[0]['created_at'])?date("g:i A",strtotime($arr_order_detail[0]['created_at'])):''}}</span> </h4>
                         @if($arr_order_detail[0]['order_status']==0)

                          <h4>Order Status : <div class="status-shipped">Cancelled</div> </h4>
                          <h4>Cancellation Time : <span>{{isset($arr_order_detail[0]['order_cancel_time'])?date("d M Y",strtotime($arr_order_detail[0]['order_cancel_time'])):''}}   |   {{isset($arr_order_detail[0]['order_cancel_time'])?date("g:i a",strtotime($arr_order_detail[0]['order_cancel_time'])):''}}</span> </h4>
                          <h4>Cancellation Reason : <span> {{isset($arr_order_detail[0]['order_cancel_reason'])?$arr_order_detail[0]['order_cancel_reason']:'N/A'}}</span> </h4>

                        @endif
                        </div>
                        @endif

                        @if(!empty($arr_order_detail[0]['buyer_details']) && count($arr_order_detail[0]['buyer_details'])>0)
                           <div class="h-four-class">
                             <h4 class="spc-mrgns">Buyer : <span>{{ $arr_order_detail[0]['buyer_details']['first_name'].' '.$arr_order_detail[0]['buyer_details']['last_name'] }}</span></h4> 
                          </div>
                        @endif


                        @if(!empty($arr_order_detail[0]['buyer_details']) && count($arr_order_detail[0]['buyer_details'])>0)
                           <div class="h-four-class">
                            <h4 class="spc-mrgns">Buyer Age : <span>
                              @php
                                if (isset($arr_order_detail[0]['buyer_details']['date_of_birth']) && $arr_order_detail[0]['buyer_details']['date_of_birth'] != "")
                                {
                                    $dob = $arr_order_detail[0]['buyer_details']['date_of_birth'];
                                    $age = (date('Y') - date('Y',strtotime($dob))) . " Years";
                                }
                                else {
                                    $age = " NA";
                                }
                              @endphp
                                  
                              {{$age}} 

                            </span></h4> 
                          </div>
                        @endif

                        @if(isset($arr_order_detail[0]['buyer_details']['email']) && $arr_order_detail[0]['buyer_details']['email']!='')

                          <div class="h-four-class">
                            <h4 class="spc-mrgns">Email : <span>
                              @php
                              
                                if (isset($arr_order_detail[0]['buyer_details']['email']) && $arr_order_detail[0]['buyer_details']['email'] != "")
                                {
                                    $email = $arr_order_detail[0]['buyer_details']['email'];
                                }
                                else {
                                    $email = " NA";
                                }
                              @endphp
                                  
                              {{$email}} 

                            </span></h4> 
                          </div>

                        @endif


                    </div>
                @endif

             @if(!empty($arr_order_detail[0]['address_details']) && count($arr_order_detail[0]['address_details'])>0)






                <div class="row">
                  <div class="col-md-12">
                    <div class="title-chow-sw bordershipping">Shipping Details:</div>
                  </div>
                  {{-- <div class="col-md-6">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Name</div>
                           <div class="myprofile-right">
                             {{ $arr_order_detail[0]['buyer_details']['first_name'].' '.$arr_order_detail[0]['buyer_details']['last_name'] }}
                           </div>
                           <div class="clearfix"></div>
                      </div>
                  </div> --}}
                {{--   <div class="col-md-6">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Mobile</div>
                           <div class="myprofile-right">
                               @if(isset($arr_order_detail[0]['buyer_details']['phone']))
                               {{ $arr_order_detail[0]['buyer_details']['phone']}}
                               @else
                               NA
                               @endif
                           </div>
                           <div class="clearfix"></div>
                      </div>
                  </div> --}}
                  <div class="col-md-6">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Email</div>
                           <div class="myprofile-right">
                            @if(isset($arr_order_detail[0]['buyer_details']['email']))
                            {{ $arr_order_detail[0]['buyer_details']['email']}}
                            @else
                            NA
                            @endif
                           </div>
                           <div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Address</div>
                           <div class="myprofile-right">



                                @if(isset($arr_order_detail[0]['address_details']['shipping_address1']) && $arr_order_detail[0]['address_details']['shipping_address1']!="")
                                {{ $arr_order_detail[0]['address_details']['shipping_address1'].', '}} 
                                @endif

                                @if(isset($arr_order_detail[0]['address_details']['shipping_city']) && $arr_order_detail[0]['address_details']['shipping_city']!="")
                                 {{ $arr_order_detail[0]['address_details']['shipping_city'].', '}}
                                @endif 

                                @if(isset($arr_order_detail[0]['address_details']['get_shippingstatedetail']['name']) && $arr_order_detail[0]['address_details']['get_shippingstatedetail']['name']!="")
                                 {{ $arr_order_detail[0]['address_details']['get_shippingstatedetail']['name'].', '}}
                                @endif   


                                @if(isset($arr_order_detail[0]['address_details']['get_shippingcountrydetail']['name']) && $arr_order_detail[0]['address_details']['get_shippingcountrydetail']['name']!="")
                                 {{ $arr_order_detail[0]['address_details']['get_shippingcountrydetail']['name'].', '}}
                                @endif  

                               
                                @if(isset($arr_order_detail[0]['address_details']['shipping_zipcode']) && $arr_order_detail[0]['address_details']['shipping_zipcode']!="")
                                 {{ $arr_order_detail[0]['address_details']['shipping_zipcode']}}
                                @endif 
                              
                               
                           </div>
                           <div class="clearfix"></div>
                      </div>
                  </div>
         
                 
                  @if($arr_order_detail[0]['order_status']!=2)                  
                    <div class="col-md-6">
                        <div class="myprofile-main">
                             <div class="myprofile-lefts">Tracking #</div>
                             <div class="myprofile-right">{{ $arr_order_detail[0]['tracking_no'] or 'N/A'}}</div>
                             <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="myprofile-main">
                             <div class="myprofile-lefts">Shipping Company <br/> Name </div>
                             @php
                              if($arr_order_detail[0]['shipping_company_name'])
                                $shippingcompany_name = $arr_order_detail[0]['shipping_company_name'];
                              else
                                $shippingcompany_name = 'NA';
                             @endphp
                             <div class="myprofile-right"> {{ $shippingcompany_name }}</div>
                             <div class="clearfix"></div>
                        </div>
                    </div> 
                  @endif


                </div>



                <div class="mrgs-styls">
                <div class="row">
                  <div class="col-md-12">
                    <div class="title-chow-sw bordershipping">Billing Details:</div>
                  </div>
                 {{--  <div class="col-md-6">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Mobile</div>
                           <div class="myprofile-right">{{ $arr_order_detail[0]['address_details']['billing_phone']}}</div>
                           <div class="clearfix"></div>
                      </div>
                  </div> --}}
                  {{-- <div class="col-md-6">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Email</div>
                           <div class="myprofile-right">{{ $arr_order_detail[0]['address_details']['billing_email']}}</div>
                           <div class="clearfix"></div>
                      </div>
                  </div> --}}
                  <div class="col-md-12">
                      <div class="myprofile-main">
                           <div class="myprofile-lefts">Address</div>
                           <div class="myprofile-right">
                              @if(isset($arr_order_detail[0]['address_details']['billing_address1']) && $arr_order_detail[0]['address_details']['billing_address1']!="")
                                {{ $arr_order_detail[0]['address_details']['billing_address1'].', '}} 
                                @endif

                                 @if(isset($arr_order_detail[0]['address_details']['billing_city']) && $arr_order_detail[0]['address_details']['billing_city']!="")
                                 {{ $arr_order_detail[0]['address_details']['billing_city'].', '}}
                                @endif

                                @if(isset($arr_order_detail[0]['address_details']['get_billingstatedetail']['name']) && $arr_order_detail[0]['address_details']['get_billingstatedetail']['name']!="")
                                 {{ $arr_order_detail[0]['address_details']['get_billingstatedetail']['name'].', '}}
                                @endif   

                                 @if(isset($arr_order_detail[0]['address_details']['get_billingcountrydetail']['name']) && $arr_order_detail[0]['address_details']['get_billingcountrydetail']['name']!="")
                                 {{ $arr_order_detail[0]['address_details']['get_billingcountrydetail']['name'].', '}}
                                @endif  
                             

                                 @if(isset($arr_order_detail[0]['address_details']['billing_zipcode']) && $arr_order_detail[0]['address_details']['billing_zipcode']!="")
                                 {{ $arr_order_detail[0]['address_details']['billing_zipcode']}}
                                @endif
                             
                           </div>
                         
                           <div class="clearfix"></div>
                      </div>
                        <div class="myprofile-main">
                        @if(isset($arr_order_detail[0]['note']) && $arr_order_detail[0]['note'] != '')
                           <div class="myprofile-lefts">Order note</div>
                             <div class="myprofile-right">
                                {{$arr_order_detail[0]['note']}}
                             </div>
                           @endif
                         </div>
                  </div>
                </div>
               </div>

               @endif

 

                <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                               <th>Product Name</th>
                                  
                                <th>Dropshipper Email </th> 
                                <th>Dropshipper Price </th>   
                                 <th>Dispensary Name </th>                        
                               <th>Quantity</th>
                               <th>Unit Price($)</th>
                               <th>Subtotal Amount($)</th>
                            </tr>
                          </thead>
                          <tbody>

                      @if(!empty($arr_order_detail) && count($arr_order_detail)>0)
                        @php
                         $subtotal = $shippingtotal=0;  
                         $orderdropshipper_id = $orderproduct_id=$dropshippername= $dropshipperemail= $dropshipperprice='';
                         $getdropshipperinfo =[];
                        @endphp
                           @foreach($arr_order_detail as $product_detail)
                          

                            @php 
                               $orderdropshipper_id = $orderproduct_id=$dropshippername= $dropshipperemail= $dropshipperprice='';
                               $getdropshipperinfo =[];


                              $subtotal  += $product_detail['total_amount']; 
                            @endphp

                            @foreach($product_detail['order_product_details'] as $product)
                            @php 
                               $shippingtotal  += $product['shipping_charges']; 

                                 $orderdropshipper_id = isset($product['dropshipper_id'])?$product['dropshipper_id']:'';

                                $orderproduct_id = isset($product['product_id'])?$product['product_id']:'';

                                if(isset($orderdropshipper_id) && isset($orderproduct_id))
                                {
                                  $getdropshipperinfo = get_dropshipper_info($orderdropshipper_id,$orderproduct_id);
                                  if(isset($getdropshipperinfo) && !empty($getdropshipperinfo))
                                  {
                                       $dropshippername = isset($getdropshipperinfo['name'])?$getdropshipperinfo['name']:'';
                                       $dropshipperemail = isset($getdropshipperinfo['email'])?$getdropshipperinfo['email']:'';
                                       // $dropshipperprice = isset($getdropshipperinfo['unit_price'])?$getdropshipperinfo['unit_price']:'';
                                  }//if getdropshipperinfo 

                                  $dropshipperprice = isset($product['dropshipper_price'])?$product['dropshipper_price']:''; 
                                  
                                }//if dropshipper id and product id






                            @endphp
                            <tr>
                                <td>{{ $product['product_details']['product_name'] }}</td>
                                <td> 
                                   @if(isset($dropshipperemail) && !empty($dropshipperemail))
                                      {{ $dropshipperemail }}
                                   @else
                                      {{ 'NA' }}
                                   @endif  
                                </td>
                                <td>
                                    @if(isset($dropshipperprice) && !empty($dropshipperprice))
                                      {{ num_format($dropshipperprice) }}
                                   @else
                                      {{ 'NA' }}
                                   @endif  
                                   
                                </td>
                                <td>
                                  {{-- {{ $product_detail['seller_details']['first_name'].' '.$product_detail['seller_details']['last_name'] }} --}}

                                  {{ isset($product_detail['seller_details']['seller_detail'])?$product_detail['seller_details']['seller_detail']['business_name']:$product_detail['seller_details']['first_name'] }}

                                  @php echo $late @endphp
                                </td>

                                 <td><b class="qty-bld">{{ $product['quantity'] }}</b></td>                            
                                 <td> ${{ num_format($product['unit_price'])}}</td>
                                 <td> ${{ num_format($product['unit_price']*$product['quantity']) }}</td>
                            </tr>
                            @endforeach
                          @endforeach
                        @endif 
                        </tbody>
                        <tfoot>

                            @php 

                            $order_id = isset($order_id)?$order_id:'';
                            $orderno = isset($orderno)?$orderno:'';

                            if(isset($orderno) && isset($order_id))
                            {
                              $get_coupncodedata_order = get_coupncodedata_order($orderno,$order_id);
                            }
                            else
                            {
                               $get_coupncodedata_order = get_coupncodedata_order($orderno);
                            }
                            
                            $seller_discounted_amt = 0;



                            if(isset($orderno) && isset($order_id))
                            {
                              $get_deliveryoptiondata_order = get_deliveryoptiondata_order($orderno,$order_id);

                              $get_taxdata_order = get_taxdata_order($orderno,$order_id);
                            }
                            else
                            {
                               $get_deliveryoptiondata_order = get_deliveryoptiondata_order($orderno);
                               $get_taxdata_order = get_taxdata_order($orderno);
                            }
                             $seller_deliveryoption_amt = 0;
                             $seller_tax_amt = 0;






                            // $couponcode = isset($arr_order_detail[0]['couponcode'])?$arr_order_detail[0]['couponcode']:'';
                            // $discount = isset($arr_order_detail[0]['discount'])?$arr_order_detail[0]['discount']:'';
                            // $seller_discount_amt = isset($arr_order_detail[0]['seller_discount_amt'])?$arr_order_detail[0]['seller_discount_amt']:'';

                            // $sellername = get_seller_details($arr_order_detail[0]['seller_id']);
                           // $subtotal = (float)$subtotal - (float)$seller_discount_amt;
                            @endphp 
                            {{-- @if(isset($sellername) && isset($seller_discount_amt) && $seller_discount_amt!='')
                            <tr>
                              <th colspan="6">Coupon : ({{ $couponcode }}) ({{ $discount}}) %: <br/></th>
                              <th>${{ isset($seller_discount_amt)? number_format($seller_discount_amt,2):'-' }}</th>
                            </tr>
                           @endif --}}

                           @if(isset($get_coupncodedata_order) && !empty($get_coupncodedata_order))
                              @foreach($get_coupncodedata_order as $k1=>$v1)

                                @if(isset($v1['couponcode']) && !empty($v1['couponcode']) && isset($v1['seller_discount_amt']) && !empty($v1['seller_discount_amt']) && isset($v1['discount']) && !empty($v1['discount']))
                                <tr>
                                  <th colspan="6">Coupon : ({{ $v1['couponcode'] }}) ({{ $v1['discount']}}) %: <br/></th>
                                  <th>{{ isset($v1['seller_discount_amt'])? '-$'.number_format($v1['seller_discount_amt'],2):'-' }}</th>
                                </tr>
                                @endif

                                @php
                                  $seller_discounted_amt = $seller_discounted_amt+$v1['seller_discount_amt'];
                                @endphp

                              @endforeach
                           @endif


                           <!----------code for delivery option data---------------------->

                            @if(isset($get_deliveryoptiondata_order) && !empty($get_deliveryoptiondata_order))
                              @foreach($get_deliveryoptiondata_order as $k1=>$v1)

                                @if(isset($v1['title']) && !empty($v1['title']) && isset($v1['cost']) && !empty($v1['cost']) && isset($v1['day']) && !empty($v1['day']))

                                 @php 
                                   $sellername ='';

                                   // $deliverday = isset($v1['day'])? date('l jS \, F Y', strtotime($arr_order_detail[0]['created_at']. ' + '.$v1['day'].' days')):'';

                                   $deliverday = isset($v1['day'])? date('l, M. d Y', strtotime($arr_order_detail[0]['created_at']. ' + '.$v1['day'].' days')):'';



                                  $sellername = isset($arr_order_detail[0]['seller_id'])? get_seller_details($arr_order_detail[0]['seller_id']):'';

                                 @endphp

                                <tr>
                                  <th colspan="6"> 
                                     Dispensary : {{ $sellername or '' }}
                                     <br/>
                                     Delivery Option Title : {{ $v1['title'] or '' }}  
                                      <br/>
                                      Delivery Option Date : {{ $deliverday or '' }}
                                  </th>
                                  <th>
                                    {{ isset($v1['cost'])? '$'.number_format($v1['cost'],2):'-' }}
                                  </th>
                                </tr>
                                @endif

                                @php
                                  $seller_deliveryoption_amt = $seller_deliveryoption_amt+ (float)$v1['cost'];
                                @endphp

                              @endforeach
                           @endif
                           <!----------code for delivery option data---------------------->

                           


                           <!----------code for tax data---------------------->

                            @if(isset($get_taxdata_order) && !empty($get_taxdata_order))
                              @foreach($get_taxdata_order as $k1=>$v1)

                                @if(isset($v1['tax']) && !empty($v1['tax']))

                                 @php 
                                   $sellername ='';
                                   $sellername = isset($arr_order_detail[0]['seller_id'])? get_seller_details($arr_order_detail[0]['seller_id']):'';

                                 @endphp

                                <tr>
                                  <th colspan="6"> 
                                     Dispensary : {{ $sellername or '' }} (Tax)
                                 
                                  </th>
                                  <th>
                                    {{ isset($v1['tax'])? '$'.number_format($v1['tax'],2):'-' }}
                                  </th>
                                </tr>
                                @endif

                                @php
                                  $seller_tax_amt = $seller_tax_amt+ (float)$v1['tax'];
                                @endphp

                              @endforeach
                           @endif
                           <!----------code for tax data----------------------> 




                          <tr>
                            <th colspan="6">Shipping Charges</th>
                            <th>${{ num_format($shippingtotal,2)}}</th>
                          </tr>
                          <tr>
                            <th colspan="6">Wallet Amount Used</th>
                            @php
                                $get_wallet_amountused_fororder = get_wallet_amountused_fororder($arr_order_detail[0]['buyer_id'],$orderno);
                             @endphp
                            <th>$ {{ $get_wallet_amountused_fororder or '' }}</th>
                          </tr>
                          <tr>
                            <th colspan="6" style="font-weight:600;">Total Amount($)</th>
                            @php 
                              if(isset($seller_discounted_amt) && !empty($seller_discounted_amt)){
                                $subtotal = (float)$subtotal - (float)$seller_discounted_amt;
                              }else{
                                $subtotal = $subtotal;
                              }


                              // code for delivery option data

                              if(isset($seller_deliveryoption_amt) && !empty($seller_deliveryoption_amt)){
                                $subtotal = (float)$subtotal + (float)$seller_deliveryoption_amt;
                              }else{
                                $subtotal = $subtotal;
                              }

                                // code for tax data

                              if(isset($seller_tax_amt) && !empty($seller_tax_amt)){
                                $subtotal = (float)$subtotal + (float)$seller_tax_amt;
                              }else{
                                $subtotal = $subtotal;
                              }



                            @endphp
                            <th style="font-weight:600;">${{ num_format($subtotal,2)}}</th>
                          </tr>
                          @if(isset($transaction_data['cashback']) && !empty($transaction_data['cashback']))
                          <tr>
                            <th colspan="6">Cashback Amount</th>
                            <th>{{ $transaction_data['cashback'] or '' }}</th>
                          </tr>
                          @endif
                        </tfoot>
                     </table>
                </div>

                     <div class="form-group row">
                        <div class="col-6">
                          @php
                            if(isset($arr_order_detail[0]['created_at']))
                            {
                             $order_date = date("Y-m-d",strtotime($arr_order_detail[0]['created_at']));
                             $request_date = date('Y-m-d', strtotime($order_date. ' + 3 days'));
                             // $current_date =date("Y-m-d");

                            // if($current_date<$request_date) {
                            @endphp
                            
                              @if(isset($arr_order_detail[0]['order_status']) && ($arr_order_detail[0]['order_status']!='0' && $arr_order_detail[0]['order_status']!='1'))

                                <a data-order_id="{{$arr_order_detail[0]['id']}}"  class="btn btn-success waves-effect waves-light m-r-10" id="btn_cancel_order">Cancel Order</a>            
                              @endif 
                            @php
                            // }
                          }
                          @endphp
                           <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="col-6 text-right">
                           @if(isset($arr_order_detail[0]['transaction_details']['transaction_status']) && !empty($arr_order_detail[0]['transaction_details']['transaction_status']) && $arr_order_detail[0]['transaction_details']['transaction_status'] == 1 && isset($arr_order_detail[0]['order_status']) && !empty($arr_order_detail[0]['order_status']) && $arr_order_detail[0]['order_status'] == 1) 


                          {{--  <a class="btn btn-inverse waves-effect waves-light colorbuttonfs" href="{{$module_url_path}}/seller_invoice/{{$enc_id}}/{{base64_encode($arr_order_detail[0]['transaction_details']['id'])}}">Pay To Seller
                           </a> --}}


                         @endif
                        </div>
                     </div>
                    
                                             
                  </div>
               </div>
            </div>
         </div>
      </div>
<!-- END Main Content -->



<!--------------------start of modal-------------------------------------->
<div class="modal fade" id="cancel_order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="model_order_id" id="model_order_id" value="">
    <div class="modal-content">
      <div class="modal-header mdl-boder-btm">
        <h3 class="modal-title" id="exampleModalLabel" align="center">Cancel Order</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cancel_order_modal_body">
        <div class="mainbody-mdls">        
          {{-- 
          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"> <b>Cancel Dat : </b></div>
             <div class="mainbody-mdls-fd-right" id="to"></div>
             <div class="clearfix"></div>
          </div>

          <div class="mainbody-mdls-fd">
             <div class="mainbody-mdls-fd-left"><b>Product Link :</b></div>
             <div class="mainbody-mdls-fd-right link-http" id="link"></div>
             <div class="clearfix"></div>
          </div> --}}

          <div class="mainbody-mdls-fd">
             <div class="form-group"> 
                <label>Cancellation Reason :</label>
                <textarea id="model_order_cancel_reason" rows="5" class="form-control" placeholder="Please enter your order cancellation reason..." maxlength="300"></textarea>

               <div class="report-note">Note: Only 300 characters allowed.</div>  

               <span id="msg_err"></span>

             </div>
             <div class="clearfix"></div>
          </div>

        </div>
      
      </div>
      <div class="modal-footer">
        <div class="sre-product">
        
          <img src="{{ url('/') }}/assets/images/loader.gif" id="loaderimg" width="50" height="50" style="display: none" />
          <a  class="btn btn-success waves-effect waves-light m-r-10" id="cancel_order_model_btn" onclick="cancelOrder($(this));">Confirm Cancellation</a>

        </div>
      </div>
    </div>
  </div>
</div>
<!-----------------end of modal---------------------->

<script>
// onclick="cancelOrder($(this));"
$(document).on('click','#btn_cancel_order',function(){
  $("#cancel_order_modal").modal('show'); 
  var order_id = $(this).attr('data-order_id');
  $('#model_order_id').val(order_id);
     
});

</script>




<script>
  

 function cancelOrder(ref)
{
  if($('#model_order_cancel_reason').val()=='')
  {
    $('<span>Please enter the cancellation reason.. </span>').css('color','red').insertAfter('#model_order_cancel_reason').fadeOut(5000);
    return false;
  }
  swal({
    title: 'Do you really want to cancel this order?',
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
      var module_url_path  = "{{ $module_url_path or ''}}";
      // alert(module_url_path);
      var order_id   = $('#model_order_id').val();
      var order_cancel_reason =  $('#model_order_cancel_reason').val();
      var csrf_token = "{{ csrf_token()}}";

      var logged_in_user  = "{{Sentinel::check()}}";


      if(logged_in_user)
      {

        $.ajax({
          url: module_url_path+'/cancel',
          type:"POST",
          data: {order_id:order_id,order_cancel_reason:order_cancel_reason,_token:csrf_token},             
          dataType:'json',
          beforeSend: function(){     
          showProcessingOverlay();
            $('#btn_cancel_order').prop('disabled',true);
            $('#btn_cancel_order').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');       
          },
          success:function(response)
          {
            hideProcessingOverlay();
            $('#btn_cancel_order').prop('disabled',false);
            $('#btn_cancel_order').html('Cancel Order');

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
                      $(this).addClass('active');

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
    }
  })
}

</script>
@stop