@extends('admin.layout.master')                

@section('main_content') 
<!-- Page Content -->


<style type="text/css">
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
  .error
  {
    color:red;
  }
  .noteallowed{    font-size: 13px;
    color: #873dc8;
    letter-spacing: 0.5px;}
    .clone-divs.none-margin {
    margin-bottom: 0px;
}
</style> 


<link href="{{ url('/') }}/assets/admin/css/fSelect.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ url('/') }}/assets/admin/js/fSelect.js"></script>

<script>
(function($) {
    $(function() {
      $('.selectuser').fSelect({
        placeholder: 'Select dispensary',
        numDisplayed: 3,
        overflowText: '{n} selected',
        noResultsText: 'No results found',
        searchText: 'Search',
        showSearch: true,
        showSelectAll: true
    });

     $('.selectbuyer').fSelect({
        placeholder: 'Select buyer',
        numDisplayed: 3,
        overflowText: '{n} selected',
        noResultsText: 'No results found',
        searchText: 'Search',
        showSearch: true,
        showSelectAll: true
    });  

     $('.selectnewsletteremail').fSelect({
        placeholder: 'Select newsletter email',
        numDisplayed: 3,
        overflowText: '{n} selected',
        noResultsText: 'No results found',
        searchText: 'Search',
        showSearch: true,
        showSelectAll: true
    });   


 });
})(jQuery);

</script>



  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    @php
                       $user = Sentinel::check();
                    @endphp

                    @if(isset($user) && $user->inRole('admin'))
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                    @endif
                      
                      <li><a href="{{$module_url_path or ''}}">{{$module_title or ''}}</a></li>
                     {{--  <li class="active">Create {{$module_title or ''}}</li> --}}
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
         
    <!-- .row -->  
                <div class="row">
                  
                    <div class="col-sm-12">
                     <h4> <span id="showerr"></span> </h4>
                        <div class="white-box">
                        @include('admin.layout._operation_status')
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" class="form-horizontal" id="validation-form" onsubmit="return false;">
                                    {{ csrf_field() }}



                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="product_name"> Newsletter Template<i class="red">*</i></label>
                                    <div class="col-md-6">                                       
                                     
                                       <select class="form-control" name="template_id" data-parsley-required ='true' data-parsley-required-message="Please select template">
                                          <option value="">Select</option>
                                          @if(isset($arr_newslettertemplate))
                                            @foreach($arr_newslettertemplate as $newsletter)
                                              <option value="{{ $newsletter['id'] }}">{{ $newsletter['newsletter_name'] }}</option>
                                            @endforeach
                                          @endif

                                       </select>
                                    </div>
                                      <span>{{ $errors->first('template_id') }}</span>
                                  </div> 

                                   <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="seller_id"> Select User<i class="red">*</i></label>
                                    <div class="col-md-3">
                                      <select class="form-control selectuser" name="seller_id[]" data-parsley-required-message="Please select dispensary" multiple="multiple">
                                          <option value="">Select Dispensary</option>
                                          @if(isset($arr_seller))
                                            @foreach($arr_seller as $seller)
                                              <option value="{{ $seller['email'] }}">{{ $seller['email'] }}</option>
                                            @endforeach
                                          @endif

                                       </select>
                                        <span>{{ $errors->first('seller_id') }}</span>
                                    </div>
                                     
                                    <div class="col-md-3">
                                      <select class="form-control selectbuyer" name="buyer_id[]" data-parsley-required-message="Please select buyer" multiple="multiple">
                                          <option value="">Select Buyer</option>
                                          @if(isset($arr_buyer))
                                            @foreach($arr_buyer as $buyer)
                                              <option value="{{ $buyer['email'] }}">{{ $buyer['email'] }}</option>
                                            @endforeach
                                          @endif

                                       </select>
                                        <span>{{ $errors->first('buyer_id') }}</span>
                                    </div>
                                     

                                    <div class="col-md-3">
                                      <select class="form-control selectnewsletteremail" name="newsletteremail_id[]" data-parsley-required-message="Please select newsletter email" multiple="multiple">
                                          <option value="">Select Emails</option>
                                          @if(isset($arr_newsletter_email))
                                            @foreach($arr_newsletter_email as $newsletteremail)
                                              <option value="{{ $newsletteremail['email'] }}">{{ $newsletteremail['email'] }}</option>
                                            @endforeach
                                          @endif

                                       </select>
                                        <span>{{ $errors->first('newsletteremail_id') }}</span>
                                    </div>


                                  </div>
                                  
                                  

                                     <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" value="Add" id="btn_add">Send Newsletter</button>
                                
                                              
                                        <!-- form-group -->
                                   </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div> 
</div>
<!-- END Main Content -->
<script type="text/javascript">


  var module_url_path  = "{{ $module_url_path or ''}}";

  $(document).ready(function() 
  {
    var module_url_path  = "{{ $module_url_path or ''}}";
    var csrf_token = $("input[name=_token]").val(); 
 
     $('#btn_add').click(function()
    {
      if($('#validation-form').parsley().validate()==false) return;

       var seller_id = $("#seller_id").val();
       var buyer_id = $("#buyer_id").val();
       var newsletteremail_id = $("#newsletteremail_id").val();

   


      var formdata =  new FormData($('#validation-form')[0]);
     
      $.ajax({
                  
          url: module_url_path+'/save',
          data: formdata,
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
          beforeSend : function()
          { 
            showProcessingOverlay();        
          },
          success:function(data)
          {
             hideProcessingOverlay(); 
             if('success' == data.status)
             {
              
                $('#validation-form')[0].reset();

                  swal({
                         title: 'Success',
                         text: data.description,
                         type: data.status,
                         confirmButtonText: "OK",
                         closeOnConfirm: false
                      },
                     function(isConfirm,tmp)
                     {
                       if(isConfirm==true)
                       {
                          window.location = data.link;
                       }
                     });
              }         
              else
              {
                 swal('Alert!',data.description,data.status);
              }  
          }
          
        });   

    });

  });

</script>
@stop