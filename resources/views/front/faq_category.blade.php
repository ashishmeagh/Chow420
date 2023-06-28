@extends('front.layout.master',['page_title'=>'Help Center'])
@section('main_content')
<style>
  @media (max-width: 650px){
  .headerchnagesmobile .logo-block.mobileviewlogo{
        width: 55vw;
  }
}
@media (max-width: 520px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 53vw;
}
}
@media (max-width: 450px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 45%;
}
}
@media (max-width: 414px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 35%;
}
}
@media (max-width: 350px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 30%;
}
.main-logo {
    width: 70px;
    margin-top: 11px !important;
}
}
</style>
<div class="padding-topbottom">
    <!-- <div class="faq-nw-title text-center">FAQ (Frequently Asked Questions)</div> -->
    <!-- <div class="faq-nw-title text-center">Help Center</div> -->

   {{--  <div class="our-mission-abts helpcenter-white">
        <h1><div class="faq-nw-title text-left">Help Center</div></h1> 
    </div> --}}

    <div class="our-mission-abts">
      <div class="leftmission"> <img src="{{url('/')}}/assets/front/images/chowicon.png" alt="Help Center" /></div>
      <div class="rightmission">
        {{--   <div class="titleourmission">{{ ucwords($res_cms[0]->meta_keyword) }}</div>  --}} 
          <h1>Help Center</h1> 
          <div class="ourmissintext">Many frequently asked questions are answered below. If you have any other questions, please email contact@chow420.com</div>
      </div>
      <div class="clearfix"></div>
   </div>

@if(isset($faq_category_arr) && count($faq_category_arr) > 0)

  @foreach($faq_category_arr as $key=>$faq_category)
   
    <div class="thebasics-sectionmain">
        <div class="thebasic-dv" id="faq_cat_section">
            <div class="the-basics-faq-pt">{{$faq_category['faq_category'] or ''}}</div>

          <!-- if FAQ data is there then n then show see all button -->
          @if(isset($faq_category['get_faq']) && count($faq_category['get_faq'])>0)
            
            <a class="seeall-link" href="{{url('/helpcenter/see_all/').'/'.base64_encode($faq_category['id'])}}">See All</a>
          @else
           <a class="seeall-link" href="{{url('/helpcenter/see_all/').'/'.base64_encode($faq_category['id'])}}" style="display: none;">See All</a>

          @endif

          <div class="clearfix"></div>

        </div>
        <div class="category-body-flex">

          @if(isset($faq_category['get_faq']) && count($faq_category['get_faq'])>0)

            @foreach($faq_category['get_faq']  as $key=>$faq)
 
              <a class="category-items" href="{{url('/helpcenter/helpcenter_details/').'/'.base64_encode($faq['id'])}}">
                
                <div class="inner-category-item">
                  <div class="ctgy-item-left">
                    <span class="ctgy-artcl-title">{!!$faq['question'] !!}</span>
              
                    <span class="ctgy-artcl-date">{{isset($faq['created_at'])? date('d M Y',strtotime($faq['created_at'])):''}} |   {{isset($faq['created_at'])?date("g:i A",strtotime($faq['created_at'])):''}}</span> </span>
                  </div>
                  <div class="ctgy-item-right">
                    <div class="ctgy-btn-arrow-right"><i class="fa fa-angle-right" ></i></div>
                  </div>
                </div>
              </a>

            @endforeach  
          
          @else
            <div class="norecordfound"> No record found </div>
          @endif

        </div>
    </div>
  
  @endforeach

@else
<div class="main-faq-full-height">
      <div class="faq-emt-page">
        <div class="faq-section-image-cw">
           <img src="{{url('/')}}/assets/front/images/no-faq-result.png" alt="">
        </div>
        <div class="faq-section-title-cw">
          No record found
        </div>
       </div>
    </div>
@endif   


</div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

@endsection



