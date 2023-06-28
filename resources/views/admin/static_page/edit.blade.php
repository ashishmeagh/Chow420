@extends('admin.layout.master')                
@section('main_content')
<!-- Page Content -->
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
            
            <li><a href="{{$module_url_path}}">{{$module_title or ''}}</a></li>
            <li class="active">Edit CMS</li>
         </ol>
      </div>
      <!-- /.col-lg-12 -->
   </div>
   <!-- .row -->
   <div class="row">
      <div class="col-sm-12">
         <div class="white-box">
            @include('admin.layout._operation_status')
            {!! Form::open([ 'url' => $module_url_path.'/update/'.$enc_id,
            'method'=>'POST',
            'enctype' =>'multipart/form-data',   
            'class'=>'form-horizontal', 
            'id'=>'validation-form' 
            ]) !!} 
            <ul  class="nav nav-tabs">
               @include('admin.layout._multi_lang_tab')
            </ul>
            <div id="myTabContent1" class="tab-content">
               @php 
                  $page_slug =''; 
               @endphp

               @if(isset($arr_lang) && sizeof($arr_lang)>0)
               @foreach($arr_lang as $lang)
               <?php 
                  /* Locale Variable */  
                  $locale_page_title = "";
                  $locale_meta_keyword = "";
                  $locale_meta_desc = "";
                  $locale_page_desc = "";
                  $page_slug ='';
                 // $locale_menuinfooter ="";
                  
                  
                  if(isset($arr_static_page['translations'][$lang['locale']]))
                  {
                      $locale_page_title = $arr_static_page['translations'][$lang['locale']]['page_title'];
                      $locale_meta_keyword = $arr_static_page['translations'][$lang['locale']]['meta_keyword'];
                      $locale_meta_desc = $arr_static_page['translations'][$lang['locale']]['meta_desc'];
                      $locale_page_desc = $arr_static_page['translations'][$lang['locale']]['page_desc'];

                      $page_slug = isset($arr_static_page['page_slug'])?$arr_static_page['page_slug']:'';

                      // $locale_menuinfooter = isset($arr_static_page['translations'][$lang['locale']]['menuin_footer'])?$arr_static_page['translations'][$lang['locale']]['menuin_footer']:'';

                  }
                  ?>
                  <input type="hidden" name="pageslug" value="{{ $page_slug }}">
               <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}"
                  id="{{ $lang['locale'] }}">
                  <div class="form-group row">
                     <label class="col-md-2 col-form-label" for="page_title">Page Title
                     @if($lang['locale'] == 'en') 
                     <i class="red">*</i>
                     @endif
                     </label>
                     <div class="col-md-10">
                        @if($lang['locale'] == 'en')        
                        {!! Form::text('page_title_'.$lang['locale'],$locale_page_title,['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Page Title']) !!}
                        @else
                        {!! Form::text('page_title_'.$lang['locale'],$locale_page_title,['class'=>'form-control','placeholder'=>'Page Title']) !!}
                        @endif    
{{--                         <span class='red'>{{ $errors->first('page_name') }}</span>
 --}}                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-md-2 col-form-label" for="meta_keyword">Meta Keyword
                     @if($lang['locale'] == 'en') 
                     <i class="red">*</i>
                     @endif
                     </label>
                     <div class="col-md-10">
                        @if($lang['locale'] == 'en')        
                        {!! Form::text('meta_keyword_'.$lang['locale'],$locale_meta_keyword,['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Meta Keyword']) !!}
                        @else
                        {!! Form::text('meta_keyword_'.$lang['locale'],$locale_meta_keyword,['class'=>'form-control','placeholder'=>'Meta Keyword']) !!}
                        @endif
{{--                         <span class='red'>{{ $errors->first('meta_keyword_') }}</span>
 --}}                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-md-2 col-form-label" for="meta_desc">Meta Description
                     @if($lang['locale'] == 'en') 
                     <i class="red">*</i>
                     @endif
                     </label>
                     <div class="col-md-10">
                        @if($lang['locale'] == 'en')        
                        {!! Form::textarea('meta_desc_'.$lang['locale'],$locale_meta_desc,['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Meta Description']) !!}
                        @else
                        {!! Form::textarea('meta_desc_'.$lang['locale'],$locale_meta_desc,['class'=>'form-control','placeholder'=>'Meta Description']) !!}
                        @endif
                       {{--  <span class='red'>{{ $errors->first('meta_desc_'.$lang['locale']) }}</span> --}}
                     </div>
                  </div>

                <!--   <div class="form-group row">
                        <label class="col-md-2 col-form-label">Menu In Footer</label>
                          <div class="col-md-10">
                              @php
                                if(isset($locale_menuinfooter) && $locale_menuinfooter!='')
                                {
                                  $locale_menuinfooter= $locale_menuinfooter;
                                } 
                                else
                                {
                                  $locale_menuinfooter = '0';
                                }
                              @endphp
                              @if($lang['locale'] == 'en')
                              <input type="checkbox" name="menuin_footer_{{$lang['locale']}}" id="menuin_footer" value="{{ $locale_menuinfooter }}" data-size="small" class="js-switch " @if($locale_menuinfooter =='1') checked="checked" @endif data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_footer();" />
                              @else
                                <input type="checkbox" name="menuin_footer_{{$lang['locale']}}" id="menuin_footer" value="{{ $locale_menuinfooter }}" data-size="small" class="js-switch " @if($locale_menuinfooter =='1') checked="checked" @endif data-color="#99d683" data-secondary-color="#f96262" onchange="return toggle_footer();" />
                              @endif
                          </div>    
                     </div>  -->
 


                  @if($page_slug=="chowcms")

                     <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="page_desc">Page URL
                        @if($lang['locale'] == 'en') 
                        <i class="red">*</i>
                        @endif
                        </label>
                        <div class="col-md-10">
                           @if($lang['locale'] == 'en')        
                           {!! Form::text('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','data-parsley-required'=>'true','data-parsley-maxlength'=>'255','placeholder'=>'Page URL']) !!}
                           @else
                           {!! Form::text('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','placeholder'=>'Page URL']) !!}
                           @endif    
                        </div>
                  </div>


                  @else

                  <div class="form-group row">
                     <label class="col-md-2 col-form-label" for="page_desc">Page Content
                     @if($lang['locale'] == 'en') 
                     <i class="red">*</i>
                     @endif
                     </label>
                     <div class="col-md-10">
                        @if($lang['locale'] == 'en')        
                        {!! Form::textarea('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','data-parsley-required'=>'true','rows'=>'20','placeholder'=>'Page Content']) !!}
                        @else
                        {!! Form::textarea('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','placeholder'=>'Page Content']) !!}
                        @endif
                      {{--   <span class='red'>{{ $errors->first('page_desc_'.$lang['locale']) }}</span> --}}
                     </div>
                  </div>
                 @endif 


              
                

               </div>
               @endforeach
               @endif
            </div>
            <br>
            <div class="form-group row">
               <div class="col-md-10">
                  <button type="submit" onclick="saveTinyMceContent();" class="btn btn-success waves-effect waves-light m-r-10" value="Update">Update</button>
                  <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
               </div>
            </div>
            {!! Form::close() !!}
         </div>
      </div>
   </div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
  
   function saveTinyMceContent()
   {
     if($('#validation-form').parsley().validate()==false) return;
 
    // tinyMCE.triggerSave(); 
     tinymce.triggerSave();

   }
</script>
<script>
    // tinymce.init({
    //   selector: 'textarea',
    //   plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
    //   toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
    //   toolbar_mode: 'floating',
    //   tinycomments_mode: 'embedded',
    //   tinycomments_author: 'Author name',
    // });

     // tinymce.init({
     //   selector: 'textarea',
     //   relative_urls: false,
     //   remove_script_host:false,
     //   convert_urls:false,
     //   plugins: [
     //     'link',
     //     'fullscreen',
     //     'contextmenu '
     //   ],
     //   toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
     //   content_css: [
     //     // '//www.tinymce.com/css/codepen.min.css'
     //   ]
     // });
 </script>
 <script type="text/javascript" src="{{url('/assets/admin/js/tiny.js')}}"></script>



 
{{-- <script type="text/javascript" src="{{url('/assets/admin/js/tinyMCE.js')}}"></script>
 --}}
{{-- 
<script src="https://cdn.tiny.cloud/1/4ey986qzaoq9vyzd2ouqnt51bxz71u6o75m7hcrnnzoffekm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}




<!-- 
<script>
   function toggle_footer()
  {
      var menuin_footer = $('#menuin_footer').val();
      if(menuin_footer=='1')
      {
        $('#menuin_footer').val('0');
      }
      else if(menuin_footer=='0')
      {
        $('#menuin_footer').val('1');
      }
  } 
</script> -->
@stop