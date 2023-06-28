@extends('front.layout.master')
@section('main_content')
<div class="main-exp-tech-opn cms-pages">
  <div class="container">
	{!! $cms_page_arr['page_desc'] or '' !!}
</div>
</div>
@endsection