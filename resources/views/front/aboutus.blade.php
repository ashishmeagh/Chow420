@extends('front.layout.master',['page_title'=>'About'])
@section('main_content')
<style>
/*css added for making title to h1*/     
h1 {
    font-size: 37px;
}
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

<div class="middle-area min-height">
  <div class="main-contactuspage-design">



<div class="aboutus-chow"></div>

 <div class="container">
    <div class="our-mission-abts">
    <div class="leftmission"> <img src="{{url('/')}}/assets/front/images/chowicon.png" alt="About Us" /></div>
    <div class="rightmission">
       {{--  <div class="titleourmission">{{ ucwords($res_cms[0]->meta_keyword) }}</div>   --}}
        <h1>{{ ucwords($res_cms[0]->meta_keyword) }}</h1> 
    <div class="ourmissintext"><?php echo html_entity_decode($res_cms[0]->meta_desc); ?></div>
    </div>
    <div class="clearfix"></div>
</div>
</div>


<div class="about-floatleft-main">
    
    
    <div class="container">
      
        <div class="newsabotudtxt">{!! $res_cms[0]->page_desc !!}</div>
    </div>
    <div class="clearfix"></div>
</div>



 <!-- <div class="about-floatleft-main">
    <div class="about-floatleft-left">
        <img src="{{url('/')}}/assets/front/images/press-about.jpg" alt="" />
    </div>
    <div class="about-floatleft-right">
        <div class="title-releases">Press Releases</div>
        <div class="newsabout">The Latest News</div>
        <div class="dateabouts">04/29/2019</div>
        <div class="newsabotudtxt">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid autem, dolorum sapiente veniam rerum. Enim dolorum blanditiis rerum quasi hic!</div>
    </div>
    <div class="clearfix"></div>
</div>  -->



<!-- <div class="about-floatleft-main floatrights-abouts">
 
    <div class="about-floatleft-right">
        <div class="title-releases">Consectetur Adipisicing</div>
        <div class="newsabout">We're always here for our customers.</div>
        <div class="newsabotudtxt"> Nulla maxime quis fuga quaerat quo, minus ipsam provident explicabo harum cumque sunt, delectus, quae obcaecati deserunt perspiciatis facilis sed doloremque maiores amet perferendis totam eveniet temporibus vitae aliquam optio! Ad tempora, voluptatem dolores, repellendus, similique incidunt non aut autem, consectetur suscipit possimus.
        </div>
    </div>
       <div class="about-floatleft-left">
        <img src="{{url('/')}}/assets/front/images/about-cultures.jpg" alt="" />
    </div>
    <div class="clearfix"></div>
</div> -->

<!-- <div class="about-floatleft-main">
    <div class="about-floatleft-left">
        <img src="{{url('/')}}/assets/front/images/big-top-about.jpg" alt="" />
    </div>
    <div class="about-floatleft-right">
        <div class="title-releases">Our Culture</div>
        <div class="newsabout">Lorem ipsum dolor sit</div>
        <div class="newsabotudtxt">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid autem, dolorum sapiente veniam rerum. Enim dolorum blanditiis rerum quasi hic!</div>
    </div>
    <div class="clearfix"></div>
</div> -->


<!-- <div class="container">
    <div class="mapabouts">
        <img src="{{url('/')}}/assets/front/images/maps-base.gif" alt="">
    </div>
</div> -->


           
  </div>
</div>

@endsection