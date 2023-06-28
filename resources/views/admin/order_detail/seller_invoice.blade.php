@extends('admin.layout.master')                
@section('main_content')
<style type="text/css">
  .colorbuttonfs {
    background-color: #448bed !important;
    color: #fff !important;
    border: 1px solid #448bed !important;
}
.colorbuttonfs:hover {
    background-color: #fff !important;
    color: #448bed !important;
    border: 1px solid #448bed !important;
}
.colorbuttonfs:focus {
    background-color: #fff !important;
    color: #448bed !important;
    border: 1px solid #448bed !important;
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
		         
		        <li><a href="{{ url(config('app.project.admin_panel_slug').'/order') }}">Manage Order</a></li>
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
					<table width="100%" bgcolor="#fff" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #ddd;">
					    <tr>
					        <td colspan="2" style="background-color: #d3d7de;padding:10px 10px 10px 30px;font-size:12px;">
					            <table width="100%">
					                <tr>
					                    <td width="50%">
					                         <h3 style="font-size:18px;padding:0;margin:0px;">Order ID: {{$arr_order_detail['order_no'] or ''}} </h3>
					                    </td>
					                    <td width="50%" style="background-color: #d3d7de;padding:10px;font-size:12px; text-align: right;">
					                    	@php

					                    	if(isset($arr_order_detail['created_at']) && !empty($arr_order_detail['created_at']))
					                    	{
					                    		$arr_order_detail['created_at'];

					                    	 	$date = us_date_format($arr_order_detail['created_at']);

					                    	}
					                    	 
					                    	@endphp
					                       <b>Order Date:</b> {{ $date or ''}}
					                       
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
					                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #448bed; padding:12px 12px 12px 30px;">S.No.</th>
					                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #448bed; padding:12px 12px 12px 30px;">Product Name</th>
					                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #448bed; padding:12px 12px 12px 30px;">Sold By</th>
					                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #448bed; padding:12px 12px 12px 30px;">Qty.</th>
					                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #448bed; padding:12px 12px 12px 30px;">Unit Price</th>
					                     <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #448bed; padding:12px 12px 12px 30px;">Shipping Charges</th>

					                     
					                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:2px solid #448bed; padding:12px 12px 12px 30px;">Total</th>
					                </tr>

					               	@if(isset($arr_order_detail['order_product_details']) && count($arr_order_detail['order_product_details']) > 0)	
					               		@php
					               			$sn_no = 0;
					               			$seller_name = $arr_order_detail['seller_details']['first_name'].' '.$arr_order_detail['seller_details']['last_name'];

					               		@endphp	               		
					           			@foreach($arr_order_detail['order_product_details'] as $key => $ord)                

						                <tr>
						                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">{{++$sn_no}}</td>

						                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b>{{$ord['product_details']['product_name'] or '-'}}</td>

						                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b>{{$seller_name or ''}}</td>    

						                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">{{$ord['quantity'] or 0}}</td>

						                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">${{isset($ord['unit_price'])?num_format($ord['unit_price']):0}}</td>
						                     <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">${{isset($ord['shipping_charges'])?num_format($ord['shipping_charges']):0}}</td>

						                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">
						                    	@php
						                    	  $total_table_amt = $ord['unit_price']*$ord['quantity'];
						                    	  $total_table_amt = $total_table_amt+$ord['shipping_charges'];
						                    	@endphp

						                        {{-- ${{ num_format($ord['unit_price']*$ord['quantity']) }} --}}
						                        ${{ isset($total_table_amt)?num_format($total_table_amt):'' }}
						                    </td>
						                </tr>

						                <input type="hidden" name="order_table_id" id="order_table_id" value="{{$arr_order_detail['id'] or ''}}">
						                <input type="hidden" name="order_no" id="order_no" value="{{$arr_order_detail['order_no'] or ''}}">
										<input type="hidden" name="seller_id" id="seller_id" value="{{$arr_order_detail['seller_id'] or ''}}">
										<input type="hidden" name="total_pay_amt" id="total_pay_amt" value="{{$arr_order_detail['total_amount'] or ''}}">
										
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
					            ${{isset($arr_order_detail['total_amount'])?num_format($arr_order_detail['total_amount']):0}}
					        </td>
					    </tr>
					    @php
					       	$total_amt = isset($arr_order_detail['total_amount'])?num_format($arr_order_detail['total_amount']):0;

					       	if(isset($admin_comission_percent))
					       		$admin_comission_percent = $admin_comission_percent;
					       	else
					       		$admin_comission_percent = '13';

					       	if(isset($seller_percentage))
					       		$seller_percentage = $seller_percentage;
					       	else
					       		$seller_percentage = '87';


					       	$admin_com = (num_format($total_amt) * ($admin_comission_percent/100)); 
					       	
					      	$seller_amt = $total_amt - $admin_com;
					       		
					    @endphp
					     <tr>
					        <td width="80%" style="text-align: right; background-color: #717f92;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: ; color: #fff;">
					            Admin Commission ({{$admin_comission_percent or ''}}%)
					        </td>
 
					        <td width="20%" style="text-align: center; background-color: #7c8c9e;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">

					            ${{$admin_com or '0'}}
					        </td>
					    </tr>
					 	 <tr>
					        <td width="80%" style="text-align: right; background-color: #717f92;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: ; color: #fff;">
					            Seller Commission ({{$seller_percentage or ''}}%)
					        </td>

					        <td width="20%" style="text-align: center; background-color: #7c8c9e;font-size:13px; font-weight: bold; border-right:1px solid #8c9db1;border-bottom:1px solid #8c9db1; padding:12px; text-transform: uppercase; color: #fff;">

					            ${{$seller_amt or '0'}}
					        </td>
					    </tr>
					    <input type="hidden" name="admin_com_amt" id="admin_com_amt" value="{{$admin_com or ''}}">
						<input type="hidden" name="seller_com_amt" id="seller_com_amt" value="{{$seller_amt or ''}}">
						<tr>
							<td colspan="2" height="20px"></td>
						</tr>
					    <tr>
					    	<td colspan="1" class="text-left">
					    		<a href="javascript:history.go(-1);" class="btn btn-inverse "><i class="fa fa-arrow-left"></i> Back</a>	
					    	</td>
					    	<td colspan="1" class="text-right">
					    		<!-- <a class="btn btn-inverse waves-effect waves-light colorbuttonfs" href="javascript:void(0)" onclick="storeAdminCommission()"> Pay</a> -->
					    		<!-- <a class="btn btn-inverse waves-effect waves-light colorbuttonfs" href="javascript:void(0)"> Pay</a> -->
	                        	
	                       	</td>
	                       	
					    </tr>					    				   

					</table>
					</div>
					</body>

          		</div>
       		</div>
    	</div>
 	</div>
</div>
<!-- END Main Content -->
@stop

<script type="text/javascript">
	function storeAdminCommission() 
	{
    	var csrf_token = "{{ csrf_token()}}";
    	var module_url_path = "{{$module_url_path}}";

    	var order_table_id 	= $('#order_table_id').val();
    	var order_no 		= $('#order_no').val();
    	var seller_id 		= $('#seller_id').val();
    	var total_pay_amt 	= $('#total_pay_amt').val();
    	var admin_com_amt 	= $('#admin_com_amt').val();
    	var seller_com_amt 	= $('#seller_com_amt').val();;

    	if(order_table_id =='' || order_no =='' || seller_id =='' || total_pay_amt == '' || admin_com_amt == '' || seller_com_amt == '')
    	{
    		swal('Alert!','Something went wrong, Please try again later !');
    		return;
    	}

	    $.ajax({
	          url: module_url_path+'/store_admin_commission',
	          type:"POST",
	          data: {_token:csrf_token,order_table_id:order_table_id,order_no:order_no,seller_id:seller_id,total_pay_amt:total_pay_amt,admin_com_amt:admin_com_amt,seller_com_amt:seller_com_amt},             
	         
	          beforeSend: function(){            
	          },
	          success:function(response)
	          {
	          	console.log(response);
	            // $(".showtabcomments").html(response);
	          }  

	      });
	}
</script>