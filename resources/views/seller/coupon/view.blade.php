@extends('seller.layout.master')
@section('main_content')
 <link href="{{url('/')}}/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />


<style>
.list-order-list {
    padding: 20px;
}
.classordermain .productnames.prodct-nms-slr{color: #000}
.list-order-list-left {
    height: auto;
}
.order-id-main-left {
    float: none;
}
.list-order-list-right {
    margin-left: 140px;
}
.productnames {
    float: left;
}
.classordermain .ordr-id-nm{
    margin-left: 110px;
}
.classordermain{margin-bottom:20px;}
.classordermain .productnames{margin-top:6px; margin-right: 5px; color: #9b9b9b;}
.classordermain .productnames span{color: #000;}
.classordermain .price-order-my{ margin-left: 80px; margin-top:0px;}
.order-id-main-right.activeposin{
position: absolute; top:10px; right:10px;
}
.classordermain .ordr-id-nm{font-size: 16px;}
.classordermain .price-order-my{font-size: 23px;}
.morecontent span {
  display: none;
}
.morelink {
    display: block;
     color: #887d7d;
}
.morelink:hover,.morelink:focus{
  color: #887d7d;
}
.morelink.less
{
   color: #887d7d;
}
.whitecol{
  color:white!important;
}
</style> 
{{-- {{dd($arr_coupon_data)}} --}}
<div class="my-profile-pgnm">
{{$page_title}}
<ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/seller/coupon"> Coupon Code</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Coupon Details</li>
    </ul>
</div>
    <div class="new-wrapper">
        <div class="order-main-dvs">
            <div class="buyer-order-details ">
                <div class="order-id-main-right activeposin">
                @if($arr_coupon_data['is_active']==1)
                <div class="status-completed">Active</div>
                @else          
                <div class="status-shipped">Block</div>
                @endif
            </div>
        <div class="order-id-main">
            <div class="order-id-main-left classordermain">
                <div class="productnames prodct-nms-slr">Coupon Code:</div>   <div class="ordr-id-nm">{{$arr_coupon_data['code'] or 'NA'}}</div>
             
                <div class="clearfix"></div>
            </div>
            
            <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Discount:</span> 
                     {{ isset($arr_coupon_data['discount'])?$arr_coupon_data['discount'].'%':'NA'}}
                </div> 
                <div class="clearfix"></div>
            </div>

             <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Type:</span> 

                    @if(isset($arr_coupon_data['type']) && $arr_coupon_data['type']==1)
                      Multiple Times

                    @elseif(isset($arr_coupon_data['type']) && $arr_coupon_data['type']==0)
                      One Time

                    @endif    

               </div> 
                <div class="clearfix"></div>
            </div>


              <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>Start Date:</span> 

                    @if(isset($arr_coupon_data['type']) && $arr_coupon_data['type']==1 && $arr_coupon_data['start_date']!='0000-00-00')
                     
                      {{ date('Y-m-d',strtotime($arr_coupon_data['start_date'])) }}

                    @elseif(isset($arr_coupon_data['type']) && $arr_coupon_data['type']==1 && $arr_coupon_data['start_date']=='0000-00-00')    
                        NA


                     @elseif(isset($arr_coupon_data['type']) && $arr_coupon_data['type']==0 && $arr_coupon_data['start_date']=='0000-00-00')  

                       NA     

                    @endif    

               </div> 
                <div class="clearfix"></div>
            </div>



              <div class="order-id-main-left classordermain">
                <div class="productnames"> <span>End Date:</span> 

                   @if(isset($arr_coupon_data['type']) && $arr_coupon_data['type']==1 && $arr_coupon_data['end_date']!='0000-00-00')
                        {{ date('Y-m-d',strtotime($arr_coupon_data['end_date'])) }}

                    @elseif(isset($arr_coupon_data['type']) && $arr_coupon_data['type']==1 && $arr_coupon_data['end_date']=='0000-00-00')    
                        NA

                    @elseif(isset($arr_coupon_data['type']) && $arr_coupon_data['type']==0 && $arr_coupon_data['end_date']=='0000-00-00')    
                        NA    

                    @endif    

               </div> 
                <div class="clearfix"></div>
            </div>


            
            <div class="clearfix"></div>
        </div> 

  


     <div class="button-subtotal">
        
       <div class="button-subtotal-right">
         <a href="{{ url('/') }}/seller/coupon" class="butn-def cancelbtnss">Back</a>
       </div>
    
       <div class="clearfix"></div>
     </div>
     </div>
   </div>
</div>
</div>


 <script type="text/javascript">
    $(document).ready(function(){
        $('#lightgallery').lightGallery();
        $('#lightgallery2').lightGallery();
    });
    </script>
    <script type="text/javascript"  src="{{url('/')}}/assets/front/js/lightgallery-all.min.js"></script>
@endsection