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

  {{-- <div class="title-details-faq"><b><h3>{{$category_name or ''}}<h3></b></div>

    @if(isset($faq_arr) && count($faq_arr)>0)

	   @foreach($faq_arr as $key=> $faq)

	    <div class="what-cbd-faq-details">{!!$faq['question']!!}</div>

        <div class="what-cbd-faq-details-text">{!!$faq['answer']!!}</div>

	    <div class="update-date-faq">{{isset($faq['created_at'])? date('d M Y',strtotime($faq['created_at'])):''}} | {{isset($faq['created_at'])?date("g:i A",strtotime($faq['created_at'])):''}}</div>

	   

	   @endforeach 

    @endif --}}
  

  
  

 <div class="main-div-faq-see-all">
    <div class="left-faq-see-all">
    	<div class="title-faq-see-basic">{{$category_name or ''}}</div>
    	 <a href="{{ url('/') }}/helpcenter" class="backhomepage"><i class="fa fa-angle-left"></i> Back Home</a>
    </div>
    <div class="right-faq-see-all">
    


    @if(isset($faq_arr) && count($faq_arr)>0)

	    @foreach($faq_arr as $key=> $faq)

		    <div class="cbd-article-item-is">	
				<a href="{{url('/helpcenter/helpcenter_details/').'/'.base64_encode($faq['id'])}}" class="link-all-faq-title">
					<span class="titlewhatis-cbd">{!!$faq['question']!!}</span>
					<span class="arrowwhatis-cbd"><i class="fa fa-angle-right" ></i></span>
			    </a>
			    <div class="description-article-itms">{!!$faq['answer']!!}</div>
			    <div class="updatelast-date">{{isset($faq['created_at'])? date('d M Y',strtotime($faq['created_at'])):''}} | {{isset($faq['created_at'])?date("g:i A",strtotime($faq['created_at'])):''}}</div>
			</div>

        @endforeach 

    @endif
    

    </div>
    <div class="clearfix"></div>

 </div>


</div>




<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

@endsection



