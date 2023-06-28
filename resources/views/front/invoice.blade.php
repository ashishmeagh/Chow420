
@php

// $site_logo = get_site_logo();
// $site_logo = url('/uploads/profile_image/'.$site_logo['site_logo']);
// if(file_exists($site_logo)==true && $site_logo!='')


    // if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists($site_setting_arr['site_logo'])){
    // $site_logo = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
    // }else{
    //  $site_logo = url('/').'/assets/front/images/chow-logo.png';
    // }

    if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo'] != '' && file_exists(base_path().'/uploads/profile_image/'.$site_setting_arr['site_logo']))
    {
        $path = url('/uploads/profile_image/'.$site_setting_arr['site_logo']);
        // $path = '/uploads/profile_image/'.$site_setting_arr['site_logo'];
    }
    else
    {                  
        $path = url('/assets/front/images/chow-logo.png');
        // $path = '/assets/front/images/chow-logo.png';
    }

    $type      = pathinfo($path, PATHINFO_EXTENSION);
    $data      = file_get_contents($path);
    $site_logo = 'data:image/'.$type.';base64,'.base64_encode($data);

    // $site_logo = url('/')."/assets/front/images/chow-logo.png";    
    
    // dd($base64);
@endphp
<body style="background-color: #fff;">
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
<table width="100%" bgcolor="#fff" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ddd;font-family:Arial, Helvetica, sans-serif;">
    <tr>
        <td colspan="2" style="padding: 10px 18px;">
            <table bgcolor="#fff" width="100%" border="0" cellspacing="10" cellpadding="0">
                <tr>
                    <td width="40%" style="font-size:40px; color: #fff;"> 
                        <img src="{{$site_logo or ''}}" width="150px" alt=""/>
                        {{-- @if(isset($site_setting_arr['site_logo']) && file_exists($site_setting_arr['site_logo']))  
                        <img src="{{url('/')}}/uploads/profile_image/{{$site_setting_arr['site_logo']}}" width="150px" alt=""/>
                        @else
                         <img src="{{url('/')}}/assets/front/images/chow-logo.png" width="150px" alt=""/>
                        @endif --}}
                    </td>
                    <td width="60%" style="text-align:right; color: #333;">
                        <h3 style="line-height:25px;margin:0px;padding:0px;">Chow420</h3>
                        {{-- <p style="font-size:12px;padding:0px;margin:0px;">**PLEASE DO NOT SEND CHECK OR CASH TO THIS ADDRESS**</p> --}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
   
    <tr>
        <td colspan="2" style="background-color: #d3d7de;padding:10px 10px 10px 30px;font-size:12px;">
           
            
            <table width="100%">
                <tr>
                    <td width="50%">
                         <h3 style="font-size:18px;padding:0;margin:0px;">Order ID: {{isset($order_no)?$order_no:$order_no}} </h3>
                    </td>
                    <td width="50%" style="background-color: #d3d7de;padding:10px;font-size:16px; text-align: right;">
                       <b>Order Date:</b> {{us_date_format(date("Y/m/d"))}}
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

        <td colspan="2" style="padding:10px 30px 10px 30px; font-size:12px;">
            <table width="100%">
             <tbody>
                {{-- <tr>
                <td width="30%" style="font-size:12px; text-align: left; word-break: break-all;"> <h3 style="margin-bottom: 5px;">Order From:</h3>
                <div class = "data_container">
                <b>{{$retailer_data['store_name'] or ''}}</b><br>
                    {{isset($retailer_data['billing_addr'])?$retailer_data['billing_addr']:'N/A'}}
                    </div>
                </td>
                <td  width="40%">&nbsp; </td>
                <td width="30%" style="font-size:12px; text-align: right;  word-break: break-all;"> <h3 style="margin-bottom: 5px;">Order To (Vendor ) :</h3>
                    <div class= "data_container2">
                        <b>{{$maker_addr['company_name'] or 'N/A'}}</b><br>
                        {{isset($maker_addr)?$maker_addr['address']:'N/A'}}
                        <br>
                        {{isset($maker_addr['post_code'])?$maker_addr['post_code']:''}}
                    </div>
                 </td>
                </tr>
                <tr>
                    <td style=" border-bottom: 2px solid #f68525;" colspan="3" height="10px">&nbsp;</td>
                </tr> --}}
                <tr>
                    <td colspan="3">
                        <table width="100%">
                           <tr>                               
                                <td style="font-size:14px;">
                                   <b>Customer Name : </b>
                                    @if(isset($user) && !empty($user))
                                       @if($user->first_name || $user->last_name)
                                        @php 
                                            $first_name = isset($user->first_name)?$user->first_name:"";
                                           $last_name  = isset($user->last_name)?$user->last_name:"";  
                                         @endphp 
                                         {{ $first_name }} {{ $last_name }}                          
                                      @else
                                         {{ $user->email }}
                                      @endif
                                    @endif
                                </td>
                           </tr>
                           <tr>   
                                <td width="50%" style="font-size:12px;"> <h3 style="margin-bottom: 5px;">Shipping Address</h3>
                                <div class="data_container">
                                    {{isset($address['shipping'])?$address['shipping']:'N/A'}}

                                    @if(isset($address['shipping_city']) && !empty($address['shipping_city']))
                                     ,{{$address['shipping_city'] }}
                                    @endif
                                   {{--  {{isset($address['shipping_city'])?", ".$address['shipping_city']:''}} --}}
                                  {{--  
                                    {{isset($address['shipping_state'])?", ".$address['shipping_state']:''}} --}}

                                   {{--  {{isset($address['shipping_country'])?", ".$address['shipping_country']:''}} --}}
                                    {{-- {{isset($address['shipping_zipcode'])?" - ".$address['shipping_zipcode']:''}} --}}
                                      @if(isset($address['shipping_state']) && !empty($address['shipping_state']))
                                        ,{{ $address['shipping_state'] }}
                                      @endif

                                     @if(isset($address['shipping_country']) && !empty($address['shipping_country']))
                                        ,{{ $address['shipping_country'] }}
                                      @endif

                                       @if(isset($address['shipping_zipcode']) && !empty($address['shipping_zipcode']))
                                        ,{{ $address['shipping_zipcode'] }}
                                      @endif


                                </div>
                               </td>

                               <td width="50%" style="font-size:12px;"> <h3 style="margin-bottom: 5px;">Billing Address</h3>
                                <div class="data_container">
                                    {{-- {{isset($address['billing'])?$address['billing']:'N/A'}}
                                    {{isset($address['billing_city'])?", ".$address['billing_city']:''}}
                                    {{isset($address['billing_state'])?", ".$address['billing_state']:''}}
                                    {{isset($address['billing_country'])?", ".$address['billing_country']:''}}
                                    {{isset($address['billing_zipcode'])?" - ".$address['billing_zipcode']:''}} --}}

                                      @if(isset($address['billing']) && !empty($address['billing']))
                                        {{ $address['billing'] }}
                                      @endif

                                      @if(isset($address['billing_city']) && !empty($address['billing_city']))
                                        ,{{ $address['billing_city'] }}
                                      @endif

                                      @if(isset($address['billing_state']) && !empty($address['billing_state']))
                                        ,{{ $address['billing_state'] }}
                                      @endif

                                       @if(isset($address['billing_country']) && !empty($address['billing_country']))
                                       ,{{ $address['billing_country'] }}
                                      @endif

                                        @if(isset($address['billing_zipcode']) && !empty($address['billing_zipcode']))
                                        ,{{ $address['billing_zipcode'] }}
                                      @endif

                                    
                                </div>
                               </td>
                          </tr>
                        </table>
                    </td>
                   
                </tr>
                {{--  <tr>
                    <td style=" border-bottom: 2px solid #148aed;" colspan="3" height="10px">&nbsp;</td>
                </tr> --}}

             </tbody>
            </table>
        </td>
    </tr>

   {{--  <tr>
        <td colspan="2" style="height:10px;">
            &nbsp;
        </td>
    </tr> --}}
    
     <tr> 

        <td colspan="2">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">S.No.</th>
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Product Name</th>
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Sold By</th>

                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Email</th>

                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Unit Price</th>
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Qty.</th>
                     
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Total</th>
                </tr>
               
           @foreach($order as $key => $ord)
                

                <tr>
                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">{{++$sn_no}}</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b>{{$ord['product_name'] or '-'}}</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b>{{$ord['seller_name'] or '-'}}</td>  

                      <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b>{{$ord['seller_email'] or '-'}}</td>    

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">${{isset($ord['unit_price'])?num_format($ord['unit_price']):0}}</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">{{$ord['item_qty'] or 0}}</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">${{isset($ord['total_wholesale_price'])?num_format($ord['total_wholesale_price']):0}}</td>
 
                     
                </tr>


        @endforeach 
               
            </table>
        </td>
    </tr>
  <tr>
    <td colspan="2" style="background-color: #eeeff1" height="10px"></td>
   </tr>
    <tr>
        <td width="80%" style="text-align: right;font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Subtotal
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            ${{isset($sum)?num_format($sum):''}}
        </td>
    </tr>
    <tr>
        <td width="80%" style="text-align: right; font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Shipping Charges
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            ${{isset($shipping_charges_sum)?num_format($shipping_charges_sum):''}}
        </td>
    </tr>

    @php
     if(isset($order_coupondata) && !empty($order_coupondata)){
         $seller_discount_amt_total = 0;
         foreach($order_coupondata as $kk1=>$vv1)
         {
          if(isset($vv1['sellername']) && $vv1['sellername']!='' && isset($vv1['couponcode']) && $vv1['couponcode']!='' && isset($vv1['discount']) && $vv1['discount']!='' &&  isset($vv1['seller_discount_amt']) && $vv1['seller_discount_amt']!='')
          {


            $seller_discount_amt_total = $seller_discount_amt_total + $vv1['seller_discount_amt'];
    @endphp  


    <tr>
        <td width="80%" style="text-align: right;font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            {{isset($vv1['sellername'])?$vv1['sellername']:''}} 
            ({{isset($vv1['couponcode'])?$vv1['couponcode']:''}})
             Discount : {{ isset($vv1['discount'])?$vv1['discount']:''}}%
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            {{ isset($vv1['seller_discount_amt'])? '-$'.num_format($vv1['seller_discount_amt']):''}}
        </td>
    </tr>

    @php 
         }//if
       }//foreach 
     } //if
    @endphp



  @php
 
      $deliverday ='';   $seller_delivery_amt_total = 0;

     if(isset($order_deliveryoptiondata) && !empty($order_deliveryoptiondata))
     {
         $seller_delivery_amt_total = 0;
         foreach($order_deliveryoptiondata as $kk11=>$vv11)
         {

          if(isset($vv11['delivery_title']) && $vv11['delivery_title']!='' && isset($vv11['delivery_cost']) && $vv11['delivery_cost']!='' && isset($vv11['delivery_day']) && $vv11['delivery_day']!='')
          {


           $seller_delivery_amt_total = $seller_delivery_amt_total + $vv11['delivery_cost'];


            $deliverday = isset($vv11['delivery_date'])? date('l jS \, F Y', strtotime($vv11['delivery_date']. ' + '.$vv11['delivery_day'].' days')):'';

    @endphp  


    <tr>
        <td width="80%" style="text-align: right;font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            {{isset($vv11['sellername'])?$vv11['sellername']:''}} 
            ({{isset($vv11['delivery_title'])?$vv11['delivery_title']:''}})
            <br/>
            Delivery Date : {{ $deliverday or '' }}
            {{--  Cost : {{ isset($vv11['delivery_cost'])?$vv11['delivery_cost']:''}} --}}
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            {{ isset($vv11['delivery_cost'])? '$'.num_format($vv11['delivery_cost']):''}}
        </td>
    </tr>

    @php 
         }//if
       }//foreach 
     } //if
    @endphp


   <tr>
      <td width="80%"  style="text-align: right;font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">Wallet Amount Used : </td>
      <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
         {{ isset($wallet_amount_used)? '$'.num_format(str_replace('-','',$wallet_amount_used)) :'' }}</td>
   </tr>

  @php
 
     $seller_tax_amt_total = 0;

     if(isset($seller_taxarr) && !empty($seller_taxarr))
     {
         $seller_tax_amt_total = 0;
         foreach($seller_taxarr as $kk12=>$vv12)
         {

          if(isset($vv12['tax']) && $vv12['tax']>=0 && isset($vv12['sellername']) && $vv12['sellername']!='')
          {


           $seller_tax_amt_total = $seller_tax_amt_total + $vv12['tax'];


 @endphp  


    <tr>
        <td width="80%" style="text-align: right;font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            {{isset($vv12['sellername'])?$vv12['sellername'].'(Tax) ':''}}           
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            {{ isset($vv12['tax'])? '$'.num_format($vv12['tax']):''}}
        </td>
    </tr>

    @php 
         }//if
       }//foreach 
     } //if
    @endphp





    <tr>
        <td width="80%" style="text-align: right; font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Total
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">

            @php 



              $fulltotal =0;
              if(isset($sum) && isset($shipping_charges_sum) && isset($seller_discount_amt_total))
              {
                $fulltotal =  $sum + $shipping_charges_sum - $seller_discount_amt_total;
              }
              else
              { 
                $fulltotal =  $sum + $shipping_charges_sum;
              }


               if(isset($fulltotal) && isset($seller_delivery_amt_total))
              {
                $fulltotal = (float)$fulltotal + (float)$seller_delivery_amt_total;
              }
              else
              { 
                $fulltotal = (float)$fulltotal ;
              }

              if(isset($seller_tax_amt_total))
              {
                $fulltotal = (float)$fulltotal + (float)$seller_tax_amt_total;

              }else
              {
                 $fulltotal = (float)$fulltotal ;
              }

            @endphp

            {{-- ${{isset($sum) && isset($shipping_charges_sum)?num_format($sum + $shipping_charges_sum):''}} --}}

             ${{ isset($fulltotal)?num_format($fulltotal):'' }}





        </td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #eeeff1" height="10px"></td>
    </tr>
  
    <tr>
        <td colspan="2" style="padding: 20px 20px 5px; color: #fff; background-color: #873dc8; text-align: center;"> If you have any questions about this invoice, please contact
        </td>
    </tr>
    <tr>
        {{-- <td colspan="2"style="text-align: center; color: #653b18; font-size: 13px; background-color: #f68525;">
            <b>Email:</b> {{get_admin_email()}},&nbsp;&nbsp;&nbsp; <b>Website:</b> {{config('app.project.invoice_url')}}
        </td> --}}
    </tr>
    <tr>
        <td colspan="2" style="padding: 5px 10px 20px; color: #fff; text-align: center; font-size: 20px; background-color: #873dc8;">
           <b>Thank You For Your Business!</b>
        </td>
    </tr>



</table>
</div>
</body>
