@extends('front.layout.master',['page_title'=>'Seller Policy'])
@section('main_content')
<style>
/*css added for making title to h1*/
h1{
    font-size: 30px;
    font-weight: 600;
}
</style>
  
<div class="terms-pg-section">
   <div class="container">
       {{--<div class="title-terms">{{ isset($res_cms[0]->page_title)?ucwords($res_cms[0]->page_title):'' }}</div> --}}
        <h1>{{ isset($res_cms[0]->page_title)?ucwords($res_cms[0]->page_title):'' }}</h1> 
        <div class="last-txts">Last updated: {{ isset($res_cms[0]->updated_at)?date('d M Y',strtotime($res_cms[0]->updated_at)):'' }}</div>
        <div class="border-terms"></div>
        {!! isset($res_cms[0]->page_desc)?$res_cms[0]->page_desc:'' !!}
   </div>
</div>


@endsection