@extends('front.layout.master')
@section('main_content')
<div class="slace-tp-bt">
    <div class="container">
      <div class="min-heghts-change">
   <div class="white-box-login signup-main">    
    <div id="status_msg"></div>
      <div class="title-edit-address">Edit Address</div>
      <div class="row">  
      <form id="frm-shipping-addr">
        {{ csrf_field() }}
        <input type="hidden" id="lat" name="lat" value="{{$addr_details_arr['lat'] or ''}}">
        <input type="hidden" id="lng" name="lng" value="{{$addr_details_arr['lng'] or ''}}">

       <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="form-int">
              <div class="select-style border-input">
                @php
                $country_id = isset($addr_details_arr['country_id'])?$addr_details_arr['country_id']:0;
                @endphp
                  <select class="frm-select" id="country" name="country" data-parsley-required="true">
                    <option value=""> Select Country </option>
                    @if(isset($countries_arr) && count($countries_arr)>0)
                    @foreach($countries_arr as $country)
                     <option data-iso="{{$country['iso']}}" value="{{$country['id']}}" @if($country['id']==$country_id) selected="selected" @endif>{{isset($country['name'])?ucfirst(strtolower($country['name'])):'--'}}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
           <div class="form-int">
              <input type="text"  placeholder="Location" value="{{$addr_details_arr['address'] or ''}}" class="clearField" id="address" name="address" data-parsley-required="true"/>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
           <div class="form-int">
              <input type="text"  value="{{$addr_details_arr['state'] or ''}} " class="clearField" id="state" name="state" readonly="true" placeholder="State" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
           <div class="form-int">
              <input type="text" placeholder="City" value="{{$addr_details_arr['city'] or ''}}" class="clearField" id="city" name="city" readonly="true"/>
          </div>
        </div>        
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
           <div class="form-int">
              <input type="text" placeholder="Post Code" value="{{$addr_details_arr['post_code'] or ''}}" class="clearField" id="post_code" name="post_code" readonly="true" />
          </div>
        </div>       
      </div>
       <div class="clearfix"></div>
        <div class="button-edit-two">
          <button type="type" class="button-login small-button" id="btn-update">Update</button>          
        </div>
    </div>
    </div>
</div>
</div>

<script type="text/javascript">
  $('#btn-update').click(function(){

    if($('#frm-shipping-addr').parsley().validate()==false) return;
        
        var form_data = $('#frm-shipping-addr').serialize();      

        if($('#frm-shipping-addr').parsley().isValid() == true )
        {         
          $.ajax({
            url:SITE_URL+'/shipping-address',
            data:form_data,
            method:'POST',
            
            beforeSend : function()
            {
              showProcessingOverlay();
              $('#btn-update').prop('disabled',true);
              $('#btn-update').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
              hideProcessingOverlay();
              $('#btn-update').prop('disabled',false);
              $('#btn-update').html('UPDATE');

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {

                  var success_HTML = '';
                  success_HTML +='<div class="alert alert-success alert-dismissible">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>'+response.message+'</div>';

                        $('#status_msg').html(success_HTML);
                    
                     // window.setTimeout(function(){ location.href = SITE_URL+'/login' },1000);
                }
                else
                {                    
                    var error_HTML = '';   
                    error_HTML+='<div class="alert alert-danger alert-dismissible">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>'+response.message+'</div>';
                    
                    $('#status_msg').html(error_HTML);
                }
              }
            }
          });
        }
  });
</script>
@endsection

@section('extra_js')
<script src="http://maps.googleapis.com/maps/api/js?key={{$general_setting_arr['data_value'] or ''}}&libraries=places" type="text/javascript"></script>
<script type="text/javascript" src="{{url('/')}}/assets/js/autocomplete_js.js"></script>
<script type="text/javascript">
  

  $(document).ready(function(){
    handlerchangeCountryRestriction($('#country'),'selected');
    var country_id = ($('select[name=country]').val());
  });

  var incr = 1;
  var glob_options = {};
  glob_options.types = [];
  
  $("#country").on('change',function(){      
      $('.clearField').val('');          
      handlerchangeCountryRestriction($(this),'selected');
      var country_id = ($('select[name=country]').val());
  });

  $('#address').on('keyup keypress', function(e) 
   {
     var keyCode = e.keyCode || e.which;
     if (keyCode === 13) { 
       e.preventDefault();
       return false;
     }
   });
</script>

@endsection