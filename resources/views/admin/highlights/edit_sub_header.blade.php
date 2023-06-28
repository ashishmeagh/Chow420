@extends('admin.layout.master')                

@section('main_content') 
<script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script> 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{$page_title or ''}}</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    @php
                        $user = Sentinel::check();
                    @endphp
                    @if(isset($user) && $user->inRole('admin'))
                        <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                    @endif
                
                    <li><a href="#">Highlights</a></li>
                    <li class="active">{{$module_title or ''}}</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h4> <span id="showerr"></span> </h4>
                <div class="white-box">
                    <div class="white-box">
               @include('admin.layout._operation_status')


              @if(isset($arr_data['site_setting_id']))
                {!! Form::open([ 


                     'url' => $module_url_path.'/update_sub_header/'.base64_encode($arr_data['site_setting_id']),
                     'method'=>'POST',   
                     'class'=>'form-horizontal', 
                     'id'=>'validation-form',
                     'enctype' =>'multipart/form-data'
                     ]) !!}
              @else 
                  {!! Form::open([ 

                     'url' => $module_url_path.'/update_sub_header/0',
                     'method'=>'POST',   
                     'class'=>'form-horizontal', 
                     'id'=>'validation-form',
                     'enctype' =>'multipart/form-data'
                     ]) !!}
              @endif

               <div class="row"> 
                    <div class="col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="description">Sub-header<i class="red">*</i></label>
                        <div class="col-md-10">                                       
                           <textarea name="description" id="description" class="form-control" placeholder=""  >{{ $arr_data['highlight_sub_header'] or '' }}</textarea>
                           <script>
                              CKEDITOR.replace( 'description' );
                          </script> 
                          <span class="error_title red"></span>
                        </div>
                          
                      </div>
                    </div>    
               </div>

               <div class="input-group">
                          <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Update" id="btn_update">Update</button>
                     </div>
                     {!! Form::close() !!}
            </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <script type="text/javascript">
    $(document).ready(function(){

       $("#btn_update").click(function(event) {        
            var ckeditor_title = CKEDITOR.instances['description'].getData();
            var formdata = new FormData($('#validation-form')[0]);
            formdata.set('description',ckeditor_title); 


            if(ckeditor_title == ""){
                $(".error_title").html("Please enter sub-header");
               return false;
            } else {
              return true;
            }
        
      
      });

     });


    </script>
@stop