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
<div class="my-profile-pgnm">
    {{$page_title}}
    <ul class="breadcrumbs-my">
        <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
        <li><i class="fa fa-angle-right"></i></li>
        <li><a href="{{url('/')}}/seller/delivery_options"> Delivery Options</a></li>
        <li><i class="fa fa-angle-right"></i></li>
        <li>{{$page_title}}</li>
    </ul>
</div>
<div class="new-wrapper">
    <div class="order-main-dvs">
        <div class="buyer-order-details ">
            <div class="order-id-main">
                <div class="order-id-main-left classordermain">
                    <div class="productnames prodct-nms-slr">Delivery options title:</div>
                    <div class="ordr-id-nm">{{$delivery_options['title'] or 'NA'}}</div>
                    <div class="clearfix"></div>
                </div>
                <div class="order-id-main-left classordermain">
                    <div class="productnames prodct-nms-slr">Delivery options day:</div>
                    <div class="ordr-id-nm">{{$delivery_options['day'] or 'NA'}}</div>
                    <div class="clearfix"></div>
                </div>
                <div class="order-id-main-left classordermain">
                    <div class="productnames prodct-nms-slr">Delivery options cost:</div>
                    <div class="ordr-id-nm">{{$delivery_options['cost'] or 'NA'}}</div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="button-subtotal">
        <div class="button-subtotal-right">
            <a href="{{ url('/') }}/seller/delivery_options" class="butn-def cancelbtnss">Back</a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
</div>
</div>
</div>
@endsection