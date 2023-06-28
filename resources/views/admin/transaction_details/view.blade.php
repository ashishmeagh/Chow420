@extends('admin.layout.master')                
@section('main_content')
<style>
th.bgnm-change {
    background-color: #fff;
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
         
         <li><a href="{{ url(config('app.project.admin_panel_slug').'/transaction') }}">Transactions</a></li>
         <li class="active">{{$page_title or ''}}</li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>

@php 
 //dd($arr_transaction_detail);
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

                @if(!empty($arr_transaction_detail))
                  <div class="row-class bottom-space-margn">
                     <div class="row">
                       @if(!empty($arr_transaction_detail[0]['order_no']))
                        <div class="col-md-6">
                          <div class="h-four-class">
                        <h4>Order No : <span>{{isset($arr_transaction_detail[0]['order_no'])?$arr_transaction_detail[0]['order_no']:''}} </span></h4>
                          </div>
                        </div>
                        @endif

                         @if(!empty($arr_transaction_detail[0]['transaction_status']))
                        <div class="col-md-6">  
                                
                                @php
                                  if($arr_transaction_detail[0]['transaction_status']=="0")
                                    $status = "<label class='label label-warning'>Pending</label>";
                                  else if($arr_transaction_detail[0]['transaction_status']=="1")
                                    $status = "<label class='label label-success'>Success</label>";
                                  else if($arr_transaction_detail[0]['transaction_status']=="2")
                                    $status = "<label class='label label-danger'>Failed</label>";
                                @endphp
                                                           
                        <h4>Transaction Status : {!!$status!!}</h4>
                        </div>
                        @endif


                        @if(!empty($arr_transaction_detail[0]['buyer_details']) && count($arr_transaction_detail[0]['buyer_details'])>0)
                           <div class="col-md-6">
                            <div class="h-four-class">
                             <h4>Buyer : <span>{{ $arr_transaction_detail[0]['buyer_details']['first_name'].' '.$arr_transaction_detail[0]['buyer_details']['last_name'] }}</span></h4> 
                             </div>
                          </div>
                        @endif 
                    </div>
                  </div>
                @endif
                                       

                      @if(!empty($arr_transaction_detail[0]['order_details']) && count($arr_transaction_detail[0]['order_details'])>0)

 
                       <div class="table-responsive">           
                           <table class="table table-striped table-bordered">
                            <tr>
                              <th colspan="4" class="bgnm-change"><h3>Shipping Details:</h3></th>
                            </tr>
                            <tr>
                           {{--  <th><b>Name</b></th>
                            <td>{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_first_name'].' '.$arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_last_name'] }}</td> --}}
                            {{-- <th><b>Mobile</b></th>
                            <td>
                              @if(isset($arr_transaction_detail[0]['buyer_details']['phone']) && $arr_transaction_detail[0]['buyer_details']['phone']!="")
                               {{ $arr_transaction_detail[0]['buyer_details']['phone']}}
                               @else
                               NA
                               @endif
                             </td> --}}
                         
                            
                            <th><b>Email</b></th>
                            <td>
                                @if(isset($arr_transaction_detail[0]['buyer_details']['email']) && $arr_transaction_detail[0]['buyer_details']['email']!="")
                                {{ $arr_transaction_detail[0]['buyer_details']['email']}}
                                @else
                                 NA
                                @endif
                            </td>
                          </tr>
                          <tr>
                             <th><b>Address</b></th>
                            <td colspan="3">
                                 @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_address1']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_address1']!="")
                                {{ $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_address1']}} 
                                @endif

                                @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_city']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_city']!="")
                                 ,{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_city']}}
                                @endif

                                @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingstatedetail']['name']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingstatedetail']['name']!="")
                                 ,{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingstatedetail']['name']}}
                                @endif


                                @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingcountrydetail']['name']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingcountrydetail']['name']!="")
                                 ,{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['get_shippingcountrydetail']['name']}}
                                @endif
                              

                                @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_zipcode']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_zipcode']!="")
                                 ,{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['shipping_zipcode']}}
                                @endif

                           
                           </td>
                          </tr>
                         
                          
                           <tr>
                              <th colspan="4"><h3>Billing Details:</h3></th>
                            </tr>
                            
                           <tr>
                            {{-- <th><b>Mobile</b></th>
                            <td>  
                                @if(isset($arr_transaction_detail[0]['buyer_details']['phone']) && $arr_transaction_detail[0]['buyer_details']['phone']!="")
                                 {{ $arr_transaction_detail[0]['buyer_details']['phone']}}
                                 @else
                                 NA
                                 @endif
                             </td> --}}
                            <th><b>Email</b></th>
                            <td>
                                @if(isset($arr_transaction_detail[0]['buyer_details']['email']) && $arr_transaction_detail[0]['buyer_details']['email']!="")
                                {{ $arr_transaction_detail[0]['buyer_details']['email']}}
                                @else
                                NA
                                @endif
                            </td>
                          </tr>
                           <tr>
                            <th><b>Address</b></th>
                            <td colspan="3">
                                 @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_address1']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_address1']!="")
                                   {{ $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_address1']}} 
                                @endif

                                @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_city']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_city']!="" )
                                 ,{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_city']}}
                                @endif 

                                @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingstatedetail']['name']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingstatedetail']['name']!="")
                                 ,{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingstatedetail']['name']}}
                                @endif 

                                @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingcountrydetail']['name']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingcountrydetail']['name']!="")
                                 ,{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['get_billingcountrydetail']['name']}}
                                @endif 

                                @if(isset($arr_transaction_detail[0]['order_details'][0]['address_details']['billing_zipcode']) && $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_zipcode']!="")
                                 ,{{ $arr_transaction_detail[0]['order_details'][0]['address_details']['billing_zipcode']}}
                                @endif 

                             
                           </td>
                          </tr>
                         

                           </table>
                       </div>
                     @endif 

                      <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                               <th>Product Name</th>
                               <th>Dispensary Name</th>                             
                               <th>Quantity</th>
                               <th>Unit Price($)</th>
                               <th>Shipping Charges($)</th>
                               <th>Total Amount($)</th>
                            </tr>
                          </thead>
                      {{-- <tbody> 

                      @if(!empty($arr_transaction_detail[0]) && count($arr_transaction_detail[0])>0)
                           @foreach($arr_transaction_detail[0]['order_details'] as $order_detail)
                            <tr>
                                <td>{{ isset($order_detail['order_product_details'][0]['product_details']['product_name'])?$order_detail['order_product_details'][0]['product_details']['product_name']:''  }}</td>
                                <td>{{ $order_detail['seller_details']['first_name'].''.$order_detail['seller_details']['last_name'] }}</td>
                                <td>{{ $order_detail['order_product_details'][0]['quantity'] }}</td>                            
                                <td>{{ num_format($order_detail['order_product_details'][0]['unit_price'])}}</td>
                                 <td>{{ num_format($order_detail['order_product_details'][0]['unit_price']*$order_detail['order_product_details'][0]['quantity']) }}</td>
                               
                            </tr>
                          @endforeach
                        @endif 
                        </tbody>  --}}

                      <tbody> 

                      @if(!empty($arr_transaction_detail[0]['order_details']) && count($arr_transaction_detail[0]['order_details'])>0)

                           @php $late ='';  $shippingcharges =0; @endphp

                           @foreach($arr_transaction_detail[0]['order_details'] as 
                           $order_detail)

                              @php
                                $couponcode = isset($order_detail['couponcode'])?$order_detail['couponcode']:'';
                                $discount = isset($order_detail['discount'])?$order_detail['discount']:'';
                                $seller_discount_amt = isset($order_detail['seller_discount_amt'])?$order_detail['seller_discount_amt']:'';
                                $sellername = get_seller_details($order_detail['seller_id']);
                              @endphp

  
                              @foreach($order_detail['order_product_details'] as $order_product_detail) 

                                @php
                                      $order_status= $order_detail['order_status'];
                                      $createdatdate= $order_detail['created_at'];
                                      $orderdate =  date ( 'Y-m-d' , strtotime ( 
                                      $order_detail['created_at'] . ' + 7 days' ));
                                      $currentdate = date('Y-m-d');

                                     if($currentdate>$orderdate && $order_detail['order_status']=="2")
                                     {
                                      $late = '<span class="status-shipped">Late</span>';
                                     }
                                     else
                                     {
                                      $late ='';
                                     }
                                @endphp



                                  <tr>
                                      <td>{{ isset($order_product_detail['product_details']['product_name'])?$order_product_detail['product_details']['product_name']:''  }}</td>
                                      <td>
                                         {{-- {{ $order_detail['seller_details']['first_name'].' '.$order_detail['seller_details']['last_name'] }} --}}

                                         {{ isset($order_detail['seller_details']['seller_detail']['business_name'])?$order_detail['seller_details']['seller_detail']['business_name']:$order_detail['seller_details']['first_name'] }}

                                          @php echo $late; @endphp
                                       </td>
                                      <td>{{ $order_product_detail['quantity'] }}</td>                            
                                      <td> @if(isset($order_product_detail['unit_price'])) ${{ num_format($order_product_detail['unit_price'])}} @endif</td>

                                      <td> @if(isset($order_product_detail['shipping_charges'])) ${{ num_format($order_product_detail['shipping_charges'])}} @endif</td>
                                       <td> 

                                          @php 
                                            $shippingcharges =0;
                                            if(isset($order_product_detail['shipping_charges']) && !empty($order_product_detail['shipping_charges']))
                                            {
                                              $shippingcharges = $order_product_detail['shipping_charges'];
                                            }
                                          @endphp
                                          @if(isset($order_product_detail['unit_price'])) 

                                           ${{ num_format($order_product_detail['unit_price']*$order_product_detail['quantity']+$shippingcharges) }} 
                                          
                                          @endif
                                        </td>

                                        
                                  </tr> 

                             @endforeach 
                          @endforeach
                        @endif 

                        @if(!empty($arr_transaction_detail[0]['order_details']) && count($arr_transaction_detail[0]['order_details'])>0)
                        @foreach($arr_transaction_detail[0]['order_details'] as 
                           $order_detail)

                              @php
                                $couponcode = isset($order_detail['couponcode'])?$order_detail['couponcode']:'';
                                $discount = isset($order_detail['discount'])?$order_detail['discount']:'';
                                $seller_discount_amt = isset($order_detail['seller_discount_amt'])?$order_detail['seller_discount_amt']:'';
                                $sellername = get_seller_details($order_detail['seller_id']);

                              if(isset($couponcode) && !empty($couponcode) && isset($seller_discount_amt) && !empty($seller_discount_amt))
                              {
                              @endphp
                             <tr>
                                 <td colspan="5"><b>Couponcode ({{ $couponcode }}) ({{ $discount}})% </b> : </td>
                               
                                 <td> {{ isset($seller_discount_amt)? '-$'.number_format($seller_discount_amt,2):'-' }}</td>
                             </tr>
                             @php 
                              } //end couponcode
                             @endphp



                             @php
                                $sellername = '';
                                $delivery_title = isset($order_detail['delivery_title'])?$order_detail['delivery_title']:'';
                                $delivery_day = isset($order_detail['delivery_day'])?$order_detail['delivery_day']:'';
                                $delivery_cost = isset($order_detail['delivery_cost'])?$order_detail['delivery_cost']:'';
                                $sellername = get_seller_details($order_detail['seller_id']);

                              if(isset($delivery_title) && !empty($delivery_title) && isset($delivery_cost) && !empty($delivery_cost))
                              {


                                  // $deliverday = isset($order_detail['delivery_day'])? date('l jS \, F Y', strtotime($order_detail['created_at']. ' + '.$order_detail['delivery_day'].' days')):'';

                                 $deliverday = isset($order_detail['delivery_day'])? date('l, M. d Y', strtotime($order_detail['created_at']. ' + '.$order_detail['delivery_day'].' days')):'';

                              @endphp
                             <tr>
                                 <td colspan="5">
                                     Dispensary : {{ $sellername or '' }}
                                     <br/>
                                     Delivery Option Title : {{ $delivery_title }}   
                                     <br/>
                                     Delivery Option Date : {{ $deliverday or '' }}
                                    
                                  </td>
                               
                                 <td> {{ isset($delivery_cost)? '$'.number_format($delivery_cost,2):'-' }}</td>
                             </tr>
                             @php 
                              } //end couponcode
                             @endphp


                            <!---------------tax------------------------------>

                            @php
                                $sellername = '';
                                $tax = isset($order_detail['tax'])?$order_detail['tax']:'';
                                $sellername = get_seller_details($order_detail['seller_id']);

                              if(isset($tax) && !empty($tax))
                              {

                             @endphp
                             <tr>
                                 <td colspan="5">
                                     Dispensary : {{ $sellername or '' }} (Tax)
                                 </td>
                               
                                 <td> {{ isset($tax)? '$'.number_format($tax,2):'-' }}</td>
                             </tr>
                             @php 
                              } //end couponcode
                             @endphp


                             
                         @endforeach   

                            <tr>
                            <th colspan="5">Wallet Amount Used</th>
                            @php
                                $get_wallet_amountused_fororder = get_wallet_amountused_fororder($arr_transaction_detail[0]['user_id'],$arr_transaction_detail[0]['order_no']);
                             @endphp
                            <th>$ {{ $get_wallet_amountused_fororder or '' }}</th>
                          </tr>

                             <tr>
                                 <td colspan="5"> <b>Total : </b> </td>
                               
                                 <td> ${{ isset($arr_transaction_detail[0]['total_price'])? number_format($arr_transaction_detail[0]['total_price'],2):'-' }}</td>
                             </tr>
                         @endif 


                        </tbody>

                     </table>

                     <div class="form-group row">
                        <div class="col-10">
                           <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                     </div>
                                             
                  </div>
               </div>
            </div>
         </div>
      </div>
<!-- END Main Content -->
@stop