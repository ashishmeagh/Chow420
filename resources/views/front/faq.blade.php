@extends('front.layout.master',['page_title'=>'FAQ'])
@section('main_content')

<style type="text/css">
  
.faqsec .panel-title > a,.faqsec .panel-title > a:focus {
  display: block;
  position: relative;
  outline:none;
}
.faqsec .panel-title > a:after {
  content: "\f078"; /* fa-chevron-down */
  font-family: 'FontAwesome';
  position: absolute;
  right: 0;
  top:-6px;

  width: 30px;
  height: 30px;
  border-radius: 50%;
  text-align: center;
  line-height: 26px;
  border:1px solid #e6e5eb;
  color:#333;
}
.faqsec .panel-title > a[aria-expanded="true"]:after {
  content: "\f077"; /* fa-chevron-up */
  background-color:#873dc8;
  color:#fff;
}

.faqsec {margin-top:0px; margin-bottom: 30px;}
.faqsec .panel-group {box-shadow: 0px 2px 15px 0px rgba(0,0,0,0.1),0px 10px 30px 0px rgba(0,0,0,0.05);}
.faqsec .panel-group .panel {border:none; box-shadow:none;}
.faqsec .panel-heading {background:#fff; padding:15px; border-bottom:1px solid #e6e5eb}
.faqsec .panel-body {background-color:#f8f8fa; border-left:3px solid #873dc8; border-bottom:1px solid #e6e5eb; line-height:25px; font-weight:normal; font-size:14px;}
.faqsec .panel-default {margin-top:0px;}
.faqttl {font-weight:600;}
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
@media (max-width: 768px) { 
  .sfw-footer.contactpgsfw li.help-cont{font-size: 17px;}
}
@media (max-width:575px) {
  .faqsec .panel-title > a {line-height:26px; padding-right:50px;}
  .faqsec .panel-heading {padding:10px;}
 
}
.our-mission-abts
{
  margin-top: 40px;
}
/*css added for making title as h1*/
h1 {
    float: left;
    color: #fff;
    margin-top: 13px;
    font-size: 30px;
    padding-top: 0px;
}
</style>

{{-- <div class="aboutus-chow contact-usbanner"></div>
 --}}
 
 <div class="container">
   <div class="our-mission-abts">
    <ul class="sfw-footer contactpgsfw">
    {{--<li class="help-cont" style="margin-top: 0px">
        FAQ (Frequently Asked Questions)
      </li> --}}
    <li style="margin-top: 0px">
        <h1>FAQ (Frequently Asked Questions)</h1>
    </li> 
      
    </ul>
    <div class="clearfix"></div>
</div>

</div>
<section class="faqsec">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          {{-- <h3 class="faqttl">FAQ's</h3> --}}
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  
                  @if(isset($faq_arr) && (!empty($faq_arr)))
                      @php
                        $i=0;
                      @endphp
                      @foreach($faq_arr as $faq)
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="heading-{{ $faq['id'] }}">
                            <h4 class="panel-title">
                              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $faq['id'] }}" @if($i==0) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse-{{ $faq['id'] }}"   
                                 @if($i==0) @else class="collapsed" @endif>
                                <span>@php echo  $faq['question']  @endphp</span>
                              </a>
                            </h4> 
                          </div>
                  
                          <div id="collapse-{{ $faq['id'] }}"  @if($i==0) class="panel-collapse collapse in" @else class="panel-collapse collapse" @endif  role="tabpanel" aria-labelledby="heading-{{ $faq['id'] }}">
                            <div class="panel-body">
                             @php echo  $faq['answer'] @endphp
                            </div>
                          </div>
                        </div>

                       @php
                        $i++;
                        @endphp
                    @endforeach
                  @endif




                 
            </div><!---Panel group end here----->
        </div> <!-----end of col-sm-12----------->
      </div>
         <div class="pagination-chow"> 
            @if(!empty($arr_pagination))
                {{$arr_pagination->render()}}    
            @endif 
        </div>

    </div> <!-----end of container----------->
</section>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

@endsection



