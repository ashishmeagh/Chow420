@extends('front.layout.master',['page_title'=>'Services'])
@section('main_content')
<div class="middle-area min-height">
  <div class="main-contactuspage-design">



<div class="aboutus-chow"></div>
<div class="container">
    <div class="our-mission-abts">
    <div class="leftmission"> <img src="{{url('/')}}/assets/front/images/chowicon.png" alt="" /></div>
    <div class="rightmission">
        <div class="titleourmission">{{ ucwords($res_cms[0]->meta_keyword) }}</div>
    <div class="ourmissintext"><?php echo html_entity_decode($res_cms[0]->meta_desc); ?></div>
    </div>
    <div class="clearfix"></div>
</div>
</div>


<div class="about-floatleft-main">
   
    <div class="container">
        <!-- <div class="title-releases">Press Releases</div>
        <div class="newsabout">The Latest News</div>
        <div class="dateabouts">04/29/2019</div> -->
        <div class="newsabotudtxt">{!! $res_cms[0]->page_desc !!}</div>   
    </div>
    <div class="clearfix"></div>
</div>



<!--<div class="about-floatleft-main floatrights-abouts">
 
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