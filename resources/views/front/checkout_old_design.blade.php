@extends('front.layout.master')
<script type="text/javascript" src="https://js.squareupsandbox.com/v2/paymentform">
</script>
@section('main_content')

<!-- <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/server.js"></script> -->
<!-- <script>
   document.addEventListener("DOMContentLoaded", function(event) {
    if (SqPaymentForm.isSupportedBrowser()) {
      paymentForm.build();
      paymentForm.recalculateSize(); 
    }
  });
  </script> -->
<div class="cart-section-block">
    <a href="{{url('/')}}/my_bag" class="cart-step-one">
        <div class="step-one step-active complited-act">
            <span class="num-step num-step-hide">1</span>
            <span class="step-tick"> </span>
            <span class="name-step-confirm">Shopping Cart</span>
        </div>
        <div class="clearfix"></div> 
    </a>
   
    <a href="{{url('/')}}/checkout" class="cart-step-one">
      
        <div class="step-one step-active">
            <span class="num-step font-style"> </span>
            <span class="name-step-confirm">Payment & Billing </span>
        </div>
        <div class="clearfix"></div>
    </a>
    <a href="javascript:void(0)" class="cart-step-one">
        <div class="step-one last-cart-step">
            <span class="num-step font-style"> </span>
            <span class="name-step-confirm">Order Placed</span>
        </div>
        <div class="clearfix"></div>
    </a>
    <div class="clearfix"></div>
</div>

<div class="space-60">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="top-breadcrum-list">
                   <a href="{{url('/')}}/search">Shop</a> <span>/</span> <a href="#">Shiping method</a> <span>/</span> <div class="breadcm-span">Payment Method</div>
                </div>
                <div class="titlecheckouts">
                    Payment method
                </div>
                <div class="transactions-div">All transactions are secure and encripted. Credit card information is never stored. </div>
                <form method="POST" id="nonce-form">
                    {{csrf_field()}}
                    <div class="whitebox-checkouts">
                        <div class='faq_acc'>
                            <ul>
                                <li class='has-sub active'>
                                    <a href='#'><span class="cirlsd"></span>
                                        <span class="payls"><img src="{{url('/')}}/assets/front/images/creditcardimg.jpg" alt="" /></span>
                                        <span class="bcart-b">
                                            <img src="{{url('/')}}/assets/front/images/cart-pg-icn.jpg" alt="" />
                                        </span>
                                    </a>
                                    <ul  style="display:block;">
                                        <li>                                            
                                            <div class="main-chktouts">
                                                <div class="img-cartcout">
                                                    <img src="{{url('/')}}/assets/front/images/cart-debit-cart.jpg" alt="" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Card Number</label>
                                                    <input type="text" name="text" id="sq-card-number" class="input-text check-oicns" placeholder="Card Number">
                                                </div>
                                                <div class="main-inlines">
                                                    <div class="form-group firstform">
                                                        <label for="">Card Holder’s Name</label>
                                                        <input type="text" id="sq-postal-code" name="text" class="input-text" placeholder="Card Holder’s Name" data-parsley-required="true" data-parsley-pattern="^[A-Za-z]*$">
                                                    </div>
                                                    <div class="form-group sectform">
                                                        <label for="">Exp. Date</label>
                                                        <input type="text" id="sq-expiration-date" name="text" class="input-text" placeholder="03/18">
                                                    </div>
                                                    <div class="form-group sectform">
                                                        <label for="">CVC</label>
                                                        <input type="text" id="sq-cvv" name="text" class="input-text" placeholder="CVC">
                                                    </div>
                                                    
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>     
                                        </li>
                                    </ul>
                                </li>

                                <input type="hidden" id="amount" name="amount" value="{{isset($subtotal)?num_format($subtotal):0}}">

                                @php
                                    $login_user = Sentinel::check();
                                    if($login_user){

                                        $user_id = $login_user->id;
                                    }
                                @endphp

                                <input type="hidden" id="buyer_id" name="buyer_id" value="{{isset($user_id)?$user_id:0}}">
                                <input type="hidden" id="card-nonce" name="nonce">
                               <!--  <li class='has-sub'>
                                   <a href='#'><span class="cirlsd"></span>
                                    <span class="payls"><img src="images/paypal.jpg" alt="" /></span>
                                   </a>
                                   <ul>
                                      <li>
                                           
                                      <div class="paypal-ckouts">
                                         <a href="#"> Click to connect to paypal</a> (You won't be charged until the order is placed.) By clicking Continue to paypal, you agree that your payment method provided above will be charged 359.88/year unless you cancel. Learn about how to cancel.
                                      </div>
                                      <a href="#" class="butn-def">Continue to Payment</a>
                                      </li>
                                   </ul>
                                </li> -->
                            </ul>
                        </div>

                        
                        {{-- <div class="button-rev pull-right">
                            <button type="button" class="butn-def checkout-btn" id="sq-creditcard" onclick="onGetCardNonce(event)">Complete order</button>
                            </form>
                        </div> --}}
                    </div>


                    <div class="titlecheckouts ba-address">Shipping & Billing address</div>
 
                    <div class="whitebox-checkouts nonewt-bx">
                        <div class='faq_acc'>
                            <ul>
                                <li class='has-sub active' >
                                    <a href='#'><span class="cirlsd"></span> 
                                        <span class="title-billg">Shipping address</span>
                                    </a>
                                    <ul style="display: block;">
                                        <li>
                                            <div class="form-billng">
                                                <div class="row">
                            
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">First Name</label>
                                                            <input type="text" name="shipping_first_name" class="input-text" placeholder="First Name" value="{{isset($user_details['first_name'])?$user_details['first_name']:''}}" id="shipping_first_name" data-parsley-required="true" data-parsley-pattern='^[a-zA-Z]+$'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Last Name</label>
                                                            <input type="text" name="shipping_last_name" class="input-text" placeholder="First Name" value="{{isset($user_details['last_name'])?$user_details['last_name']:''}}" id="shipping_last_name" data-parsley-required="true" data-parsley-pattern='^[a-zA-Z]+$'>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                         <div class="form-group">
                                                            <label for="">Email Address</label>
                                                            <input type="email" name="shipping_email" class="input-text" placeholder="Email Address" value="{{isset($user_details['email'])?$user_details['email']:''}}" id="shipping_email"  data-parsley-trigger="change" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Mobile Number</label>
                                                            <input type="text" name="shipping_mobileno" class="input-text" placeholder="Mobile Number" value="{{isset($user_details['phone'])?$user_details['phone']:''}}" id="shipping_mobileno" data-parsley-required="true" data-parsley-trigger="keyup" data-parsley-type="number" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Address(Line 1)</label>
                                                            <input type="text" name="shipping_streetaddress1" class="input-text" placeholder="Street-Address(Line 1)" value="{{isset($user_details['user_addresses']['address'])?$user_details['user_addresses']['address']:''}}"  id="shipping_streetaddress1" data-parsley-required="true">
                                                        </div> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Apt, suite, Bldg</label>
                                                            <input type="text" name="shipping_streetaddress2" class="input-text" placeholder="Apt, suite, Bldg" id="shipping_streetaddress2" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    
                                                   {{--  <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Country</label>
                                                            <div class="select-style">
                                                                <select class="frm-select country" name="shipping_country" id="shipping_country" data-parsley-required="true">
                                                                    <option value="">--Select Country--</option>
                                                                    @php
                                                                    if(!empty($res_country_arr) && count($res_country_arr)>0){
                                                                      foreach($res_country_arr as $country){
                                                                        $country_id = $country['id'];
                                                                        $country_name = $country['name'];
                                                                     @endphp   
                                                                        <option value="{{ $country_id }}">{{ $country_name }}</option> 
                                                                     @php
                                                                      }
                                                                    }

                                                                    @endphp
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    --}}                  


                                                      <div class="col-md-6">
                                                         <div class="form-group">
                                                            <label for="">City</label>
                                                            <input type="text" name="shipping_city" class="input-text" placeholder="City"  id="shipping_city" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                     
                                                    <!-- state dropdown-->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">State</label>
                                                            <div class="select-style">
                                                                <select class="frm-select state" name="shipping_state" id="shipping_state" required="">
                                                                    <option value="">--Select state--</option>
                                                                    @if(isset($statearr) && count($statearr)>0)
                                                                     @foreach($statearr as $v)
                                                                      <option value="{{ $v->id }}">{{ $v->state_title }}</option>
                                                                     @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                  {{--   <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">City</label>
                                                            <div class="select-style">
                                                                <select class="frm-select city" name="shipping_city" id="shipping_city" data-parsley-required="true">
                                                                    <option value="">--Select City--</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

 --}}
                                                  


                                                    <div class="col-md-6">
                                                         <div class="form-group">
                                                            <label for="">Post Code / Zip Code</label>
                                                            <input type="text" name="shipping_zipcode" class="input-text" placeholder="Post Code / Zip Code"  id="shipping_zipcode" data-parsley-required="true" data-parsley-trigger="keyup" data-parsley-type="number">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="check-nones">
                                        <div class="check-box">
                                            <input type="checkbox"  class="css-checkbox" id="checkboxnew" name="check_address" value="0">
                                            <label class="css-label radGroup2" for="checkboxnew">Want to Use Different Billing Address?</label>

                                            <div class="main-box-checkbox">
                                                <div class="form-billng">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Company Name</label>
                                                                <input type="text" name="billing_companyname" class="input-text" placeholder="Company Name"  id="billing_companyname" >
                                                                <span id="billing_companyname_err" class="err_msg"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Address(Line 1)</label>
                                                                <input type="text" name="billing_streetaddress1" class="input-text" placeholder="Street-Address(Line 1)" id="billing_streetaddress1" >
                                                                <span id="billing_streetaddress1_err" class="err_msg"></span>
                                                            </div>
                                                         </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Apt, suite, Bldg</label>
                                                                <input type="text" name="billing_streetaddress2" class="input-text" placeholder="Apt, suite, Bldg" id="billing_streetaddress2" >
                                                                <span id="billing_streetaddress2_err" class="err_msg"></span>
                                                            </div>
                                                        </div>
                                                     
                                                        {{-- <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Country</label>
                                                                <div class="select-style">
                                                                    <select class="frm-select country_billing" name="billing_country" id="billing_country" >
                                                                        <option value="">--Select Country--</option>
                                                                            @php
                                                                            if(!empty($res_country_arr) && count($res_country_arr)>0)
                                                                            {
                                                                                foreach($res_country_arr as $country){
                                                                                $country_id = $country['id'];
                                                                                $country_name = $country['name'];
                                                                            @endphp   
                                                                                <option value="{{ $country_id }}">{{ $country_name }}</option> 
                                                                            @php
                                                                              }
                                                                            }

                                                                        @endphp
                                                                    </select>
                                                                </div>
                                                                <span id="billing_country_err" class="err_msg"></span>
                                                            </div>
                                                        </div> --}}

                                                     <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">City</label>
                                                                <input type="text" name="billing_city" class="input-text" placeholder="City" id="billing_city">
                                                                <span id="billing_city_err" class="err_msg"></span>
                                                            </div>
                                                        </div>    


                                                    <div class="col-md-6">
                                                     <div class="form-group">
                                                      <label for="">State</label>
                                                       <div class="select-style"> 
                                                          <select class="frm-select state_billing" name="billing_state" id="billing_state" >
                                                                <option value="">--Select state--</option>
                                                                @if(isset($statearr) && count($statearr)>0)
                                                                @foreach($statearr as $v)
                                                                  
                                                                   <option value="{{ $v->id }}">{{ $v->state_title }}</option>
                                                                @endforeach
                                                                @endif
                                                              
                                                               </select>
                                                            </div>
                                                           <span id="billing_state_err" class="err_msg"></span>
                                                        </div>
                                                    </div>

                                                       {{--  <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">City</label>
                                                                <div class="select-style">
                                                                    <select class="frm-select city_billing" name="billing_city" id="billing_city" >
                                                                        <option value="">--Select City--</option>
                                                                    </select>
                                                                </div>
                                                                <span id="billing_city_err" class="err_msg"></span>
                                                            </div>
                                                        </div> --}}

                                                        

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Post Code / Zip Code</label>
                                                                <input type="text" name="billing_zipcode" class="input-text" placeholder="Post Code / Zip Code" id="billing_zipcode">
                                                                <span id="billing_zipcode_err" class="err_msg"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Phone Number</label>
                                                                <input type="text" name="billing_phoneno" class="input-text" placeholder="Phone Number" id="billing_phoneno" >
                                                                <span id="billing_phoneno_err" class="err_msg"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Email Address</label>
                                                                <input type="text" name="billing_email" class="input-text" placeholder="Email Address" id="billing_email" >
                                                                <span id="billing_email_err" class="err_msg"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </li>        
                            </ul>                
                        </div>
                    </div>
                    {{-- 
                    <div class="check-box">
                        <input type="checkbox" checked="checked" class="css-checkbox" id="checkbox4" name="radiog_dark1" />
                        <label class="css-label radGroup2" for="checkbox4">Subscribe to our newsleter.</label>
                    </div> --}}
                    <div class="returnmain">
                        <a href="{{url('/')}}/my_bag" class="returnslink pull-left"><i class="fa fa-angle-left"></i>  Return to shipping method</a>
                        <div class="button-rev pull-right">
                             {{-- <button type="button" class="butn-def" id="btn-checkout">Complete order</button>  --}}
                            <button type="button" class="butn-def checkout-btn" id="sq-creditcard" onclick="onGetCardNonce(event)">Complete order</button> 
                             
                        </div>
                        <div class="clearfix"></div>
                    </div>
                 </form>    
            </div>   
            <div class="col-md-4">
                <div class="titlecart-sidebar">Order Summary</div>
                <div class="whitebox-sidebar">
                    @if(count($arr_final_data) > 0)
                        @foreach($arr_final_data as $product_arr)
                            @foreach($product_arr['product_details'] as $product)

                                <div class="box-selectscarts">
                                    <div class="prodct-left-cart"> <div class="counts-pro">{{isset($product['item_qty'])?$product['item_qty']:'0'}}</div>

                                    @php
                                        if(isset($product['product_image'][0]['image']) && $product['product_image'][0]['image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_image'][0]['image']))
                                        {
                                            $product_img = url('/uploads/product_images/'.$product['product_image'][0]['image']);
                                        }
                                        else
                                        {                  
                                            $product_img = url('/assets/images/default-product-image.png');
                                        }
                                    @endphp
                                    <img src="{{$product_img}}" alt="" />

                                    </div>
                                    <div class="prodct-midal-cart">
                                        <div class="titlecartsmdls">{{isset($product['product_name'])?$product['product_name']:'N/A'}}</div>
                                        <div class="subpoints">{{isset($product_arr['seller_details']['first_name'])?$product_arr['seller_details']['first_name']:''}} {{isset($product_arr['seller_details']['last_name'])?$product_arr['seller_details']['last_name']:''}}</div>
                                    </div>
                                    <div class="prodct-right-cart">$ {{isset($product['total_price'])?num_format($product['total_price']):'0'}}</div>
                                </div>
                            @endforeach                           
                        @endforeach
                    @endif
                    <!-- <div class="border-sidebr"></div>
                    <div class="giftapply">
                        <input type="text" placeholder="Gift card or dicsount code" />
                        <a href="#" class="applybtns">Apply</a>
                    </div> -->
                    <div class="border-sidebr"></div>
                    <div class="subtotal">
                        <div class="subtotal-left">Subtotal</div>
                        <div class="subtotal-right">$ {{num_format($subtotal)}}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="subtotal">
                        <div class="subtotal-left">Shipping</div>
                        <div class="subtotal-right">$ {{num_format(0)}}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="border-sidebr"></div>
                    <div class="subtotal">
                        <div class="subtotal-left">Total</div>
                        <div class="subtotal-right"><span>$ {{num_format($subtotal)}}</span></div>
                        <div class="clearfix"></div>
                    </div>                                   
                </div>
            </div><!--end of order summary-->


        </div>     
    </div>
</div>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/front/js/accordian.js"></script>


<script type="text/javascript">
    $('#btn-checkout').click(function()
    { 
        if($('#frm-checkout').parsley().validate()==false) return;
        var flag1=0;  var flag2=0;var flag3=0;var flag4=0;var flag5=0;var flag6=0;
        var flag7=0; var flag8=0; var flag9=0;

        if ($("#checkboxnew").is(':checked')) {

            var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i

            if($('#billing_companyname').val()=="")
            {
                flag1 =1;
                $("#billing_companyname_err").html('This value is required.');
                
            }else{
                flag1 =0;
                $("#billing_companyname_err").html('');

            }
            if($('#billing_email').val()=="")
            {    
                flag2 =1;
                $("#billing_email_err").html('This value is required.');
            }
            else if($("#billing_email").val()!="")
            {
                if(!pattern.test($('#billing_email').val()))
                {
                   flag2 =1;
                    $("#billing_email_err").html('This value should be a valid email.'); 
                }else{
                    flag2 =0;
                    $("#billing_email_err").html(''); 
                }
            }   
            else{
                flag2 =0;
                $("#billing_email_err").html('');
            }

            if($('#billing_phoneno').val()=="")
            {
                flag3 =1;

                $("#billing_phoneno_err").html('This value is required.');
            }else{

                flag3 =0;
                $("#billing_phoneno_err").html('');
            }
              if($('#billing_zipcode').val()=="")
            {   flag4=1;
                $("#billing_zipcode_err").html('This value is required.');
            }else{
                flag4=0;
                $("#billing_zipcode_err").html('');
            }
            /*  if($('#billing_country').val()=="")
            {
                flag5=1;
                $("#billing_country_err").html('This value is required.');
            }else{
                flag5=0;
                $("#billing_country_err").html('');
            }*/
            if($('#billing_state').val()=="")
            {
                flag6=1;
                $("#billing_state_err").html('This value is required.');
            }else{
                flag6=0;
                $("#billing_state_err").html('');
            }
              if($('#billing_city').val()=="")
            {
                flag7=1;
                $("#billing_city_err").html('This value is required.');
            }else{
                flag7=0;
                $("#billing_city_err").html('');
            }
            if($('#billing_streetaddress1').val()=="")
            {
                flag8=1;
                $("#billing_streetaddress1_err").html('This value is required.');
            }else{
                 flag8=0;
                $("#billing_streetaddress1_err").html('');
            }
            if($('#billing_streetaddress2').val()=="")
            {
                 flag9=1;
                $("#billing_streetaddress2_err").html('This value is required.');
            }else{
                 flag9=0;
                $("#billing_streetaddress2_err").html('');
            }

            $("#checkboxnew").val('1');   


        }
        else{
            $("#billing_email_err").html(" ");
            $("#billing_phoneno_err").html(" ");
            $("#billing_zipcode_err").html(" ");
           // $("#billing_country_err").html(" ");
            $("#billing_state_err").html(" ");
           // $("#billing_city_err").html(" ");
            $("#billing_streetaddress1_err").html(" ");
            $("#billing_streetaddress2_err").html(" ");
            $("#billing_companyname_err").html(" ");

            $("#checkboxnew").val('0');  

        }
        if(flag1=='0' &&  flag2=='0' && flag3=='0' && flag4=='0' && flag5=='0' && flag6=='0' && flag7=='0' && flag8=='0' && flag9=='0')
        {

               

        }       
        else
        {
            return false;
        }
    });

</script>

<script type="text/javascript">


    
      // Create and initialize a payment form object
      const paymentForm = new SqPaymentForm({
        postalCode: false,

        // Initialize the payment form elements
        
        //TODO: Replace with your sandbox application ID
        applicationId: "sandbox-sq0idb-e8DS2ixcobu7FBFMh6zRtA",
        inputClass: 'sq-input',
        autoBuild: false,
        // Customize the CSS for SqPaymentForm iframe elements
        inputStyles: [{
            fontSize: '16px',
            lineHeight: '24px',
            padding: '0px',
            placeholderColor: '#a0a0a0',
            backgroundColor: 'transparent',
        }],
        // Initialize the credit card placeholders
        
        cvv: {
            elementId: 'sq-cvv',
            placeholder: 'CVV'
        },
        expirationDate: {
            elementId: 'sq-expiration-date',
            placeholder: 'MM/YY'
        },
        // postalCode: {
        //     elementId: 'sq-postal-code',
        //     placeholder: 'Postal Code'
        // },
        cardNumber: {
            elementId: 'sq-card-number',
            placeholder: 'Card Number'
        },
        // SqPaymentForm callback functions
        callbacks: {
            /*
            * callback function: cardNonceResponseReceived
            * Triggered when: SqPaymentForm completes a card nonce request
            */
            cardNonceResponseReceived: function (errors, nonce, cardData) {
             
            if (errors) {
                // Log errors from nonce generation to the browser developer console.
                //console.error('Encountered errors:');
                errors.forEach(function (error) {
                    swal('Oops..!',error.message,'error');
                    //console.error('  ' + error.message);
                });
                //alert('Encountered errors, check browser developer console for more details');
                return;
            }
               
               // Assign the nonce value to the hidden form field
                document.getElementById('card-nonce').value = nonce;

                // POST the nonce form to the payment processing page
                //document.getElementById('nonce-form').submit();
                // $('.checkout-btn').on('click',function (e) {
                   //('#btn-checkout').click(function()
            //{ 
        if($('#nonce-form').parsley().validate()==false) return;
        var flag1=0;  var flag2=0;var flag3=0;var flag4=0;var flag5=0;var flag6=0;
        var flag7=0; var flag8=0; var flag9=0;

        if ($("#checkboxnew").is(':checked')) {

            var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i

            if($('#billing_companyname').val()=="")
            {
                flag1 =1;
                $("#billing_companyname_err").html('This value is required.');
                
            }else{
                flag1 =0;
                $("#billing_companyname_err").html('');

            }
            if($('#billing_email').val()=="")
            {    
                flag2 =1;
                $("#billing_email_err").html('This value is required.');
            }
            else if($("#billing_email").val()!="")
            {
                if(!pattern.test($('#billing_email').val()))
                {
                   flag2 =1;
                    $("#billing_email_err").html('This value should be a valid email.'); 
                }else{
                    flag2 =0;
                    $("#billing_email_err").html(''); 
                }
            }   
            else{
                flag2 =0;
                $("#billing_email_err").html('');
            }

            if($('#billing_phoneno').val()=="")
            {
                flag3 =1;

                $("#billing_phoneno_err").html('This value is required.');
            }else{

                flag3 =0;
                $("#billing_phoneno_err").html('');
            }
              if($('#billing_zipcode').val()=="")
            {   flag4=1;
                $("#billing_zipcode_err").html('This value is required.');
            }else{
                flag4=0;
                $("#billing_zipcode_err").html('');
            }
            /*  if($('#billing_country').val()=="")
            {
                flag5=1;
                $("#billing_country_err").html('This value is required.');
            }else{
                flag5=0;
                $("#billing_country_err").html('');
            }*/
            if($('#billing_state').val()=="")
            {
                flag6=1;
                $("#billing_state_err").html('This value is required.');
            }else{
                flag6=0;
                $("#billing_state_err").html('');
            }
              if($('#billing_city').val()=="")
            {
                flag7=1;
                $("#billing_city_err").html('This value is required.');
            }else{
                flag7=0;
                $("#billing_city_err").html('');
            }
            if($('#billing_streetaddress1').val()=="")
            {
                flag8=1;
                $("#billing_streetaddress1_err").html('This value is required.');
            }else{
                 flag8=0;
                $("#billing_streetaddress1_err").html('');
            }
            if($('#billing_streetaddress2').val()=="")
            {
                 flag9=1;
                $("#billing_streetaddress2_err").html('This value is required.');
            }else{
                 flag9=0;
                $("#billing_streetaddress2_err").html('');
            }

            $("#checkboxnew").val('1');   


        }
        else{
            $("#billing_email_err").html(" ");
            $("#billing_phoneno_err").html(" ");
            $("#billing_zipcode_err").html(" ");
           // $("#billing_country_err").html(" ");
            $("#billing_state_err").html(" ");
            $("#billing_city_err").html(" ");
            $("#billing_streetaddress1_err").html(" ");
            $("#billing_streetaddress2_err").html(" ");
            $("#billing_companyname_err").html(" ");

            $("#checkboxnew").val('0');  

        }
        if(flag1=='0' &&  flag2=='0' && flag3=='0' && flag4=='0' && flag5=='0' && flag6=='0' && flag7=='0' && flag8=='0' && flag9=='0')
        {

            $.ajax({              
                url: SITE_URL+'/checkout/place_order',
                data: new FormData($('#nonce-form')[0]),
                processData: false,
                method:'POST',
                contentType: false,
                dataType:'json',
                beforeSend: function() {
                    showProcessingOverlay();
                },
                success:function(data)
                {
                
                    hideProcessingOverlay();
                    if( data.status == 'success')
                    {            
                        $('#nonce-form')[0].reset();
                        swal('Order Placed',data.msg,'success');
                        location.href = SITE_URL+'/checkout/order/'+btoa(data.order_no);

                      
                    }
                    else
                    {
                    swal('warning',data.msg,warning);
                    }  
                }      
            });

        }       
        else
        {
            return false;
        }
            }
        }
      });
      //TODO: paste code from step 1.1.4
       paymentForm.build();

      function onGetCardNonce(event) {
       // Don't submit the form until SqPaymentForm returns with a nonce
       event.preventDefault();

       // Request a nonce from the SqPaymentForm object
       paymentForm.requestCardNonce();

    } 

</script>
<script>
    
$('input[name="billing_phoneno"]').keyup(function(e)
{
  if (/\D/g.test(this.value))
  {
    // Filter non-digits from input value.
    this.value = this.value.replace(/\D/g, '');
  }
});

$('input[name="billing_zipcode"]').keyup(function(e)
{
  if (/\D/g.test(this.value))
  {
    // Filter non-digits from input value.
    this.value = this.value.replace(/\D/g, '');
  }
});

</script>
<style type="text/css">
    .err_msg{
        color:red;
    }
</style>
@endsection