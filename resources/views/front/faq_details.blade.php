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

{{-- <div class="searchbox-faq maxwidth-searchs">
  <input type="" name="" placeholder="Search our Help Center" />
</div> --}}

  <div class="title-details-faq"><b>{{$faq_arr['get_faq_category']['faq_category'] or ''}}</b></div>

  <div class="what-cbd-faq-details">{!! $faq_arr['question'] !!}</div>
  <div class="update-date-faq">{{isset($faq_arr['created_at'])? date('d M Y',strtotime($faq_arr['created_at'])):''}} | {{isset($faq_arr['created_at'])?date("g:i A",strtotime($faq_arr['created_at'])):''}}</div>

  <div class="description-text-content">
    {!! $faq_arr['answer']!!}
  </div>

</div>




<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

@endsection



