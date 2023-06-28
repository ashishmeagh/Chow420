@extends('admin.layout.master')                
@section('main_content')

 <link href="{{url('/')}}/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />

<style type="text/css">
  .morecontent span {display: none;}
  .morelink {display: block;color: #887d7d;}
  .morelink:hover,.morelink:focus{color: #887d7d;}
  .morelink.less{color: #887d7d;}
  .show-h3{margin-top: 0px;}
  .comments-mains.sub-reply{border-radius: 5px;}
  .txt-commnts{color: #888888;}
  .comments-mains-right.move-top-mrg {margin-top: 11px;}
</style>
<!-- Page Content -->
<div id="page-wrapper"> 
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">{{$page_title or ''}}</h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
          <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
          <li><a href="{{$module_url_path or ''}}">{{$module_title or ''}}</a></li>
          <li class="active">{{$page_title or ''}}</li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>

<!-- .row -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box">

         @include('admin.layout._operation_status')
          <div class="row">
            <div class="col-sm-12 col-xs-12">
                 <h3>
                    <span 
                       class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action" >
                    </span>
                 </h3>
            </div>
          </div>
          
                    
            <div class="row">
                  <div class="col-sm-12">
                  <div class="myprofile-main">
                       <div class="myprofile-lefts">State Name</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['name']) && $arr_data['name']!="")
                          {{ ucfirst($arr_data['name']) }}
                          @else
                           NA
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts">State Abbrevation</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['shortname']) && $arr_data['shortname']!="")
                          {{ ucfirst($arr_data['shortname']) }}
                          @else
                           NA
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Country Name</div>
                       <div class="myprofile-right">
                        @if(isset($arr_data['country_details']['name']) && $arr_data['country_details']['name'])
                        {{ucfirst($arr_data['country_details']['name'])}}
                        @else
                        NA
                        @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts"> Restricted Categories </div>
                       <div class="myprofile-right">
                         @if(isset($restrict_categories) && $restrict_categories!="")
                          {{$restrict_categories}}
                         @else
                          NA 
                         @endif 
                        </div>
                       <div class="clearfix"></div>
                  </div>


                    <div class="myprofile-main">
                       <div class="myprofile-lefts">State Law</div>
                       <div class="myprofile-right">
                         @if(isset($arr_data['text']) && $arr_data['text']!="")
                          {{$arr_data['text']}}
                         @else
                          NA 
                         @endif 
                        </div>
                       <div class="clearfix"></div>
                  </div>

                  {{--  <div class="myprofile-main">
                       <div class="myprofile-lefts">Tax Percentage %</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['tax_percentage']) && $arr_data['tax_percentage']!="")
                          {{ number_format($arr_data['tax_percentage'],2) }} %
                          @else
                           NA
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div> --}}

                </div>

               </div><!--end of row--->
             
</div><!--end of class=white-box--->



  <div class="form-group row">
    <div class="col-10">
       <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path or ''}}/view_states/{{ base64_encode($arr_data['country_id']) }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  </div>

</div>
</div>      
</div>
</div>



<!-- END Main Content -->
@stop