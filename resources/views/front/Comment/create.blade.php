@extends('front.layout.master')
@section('main_content')
<div class="slace-tp-bt">
    <div class="container">
      <div class="min-heghts-change">
   <div class="white-box-login signup-main">    
    <div id="status_msg"></div>
      <div class="title-edit-address">Add Comment</div>
      <div class="row">  
      <form id="frm-product_comment">
        {{ csrf_field() }}
        <input type="hidden" name="product_id" value="{{$product_id}}">
 
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
           <div class="form-int">
              <input type="text"  placeholder="Comment"  class="clearField" id="comment" name="comment" data-parsley-required="true"/>
          </div>
        </div>

      </div>
       <div class="clearfix"></div>
        <div class="button-edit-two">
          <button type="type" class="button-login small-button" id="btn-update">Add</button>          
          <a href="{{$back_path}}">
            <button type="button" class="button-login small-button back-gray-ship pull-right">Back</button>
        </a>

        <div class="clearfix"></div>        
        </div>

    </div>
    </div>
</div>
</div>

<script type="text/javascript">
  $('#btn-update').click(function(){

    if($('#frm-product_comment').parsley().validate()==false) return;
        
        var form_data = $('#frm-product_comment').serialize();      

        if($('#frm-product_comment').parsley().isValid() == true )
        {         
          $.ajax({
            url:SITE_URL+'/buyer/comment/store',
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
              $('#btn-update').html('ADD');

              if(typeof response =='object')
              {
                if(response.status && response.status=="SUCCESS")
                {
                  var success_HTML = '';
                  success_HTML +='<div class="alert alert-success alert-dismissible">\
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                           <span aria-hidden="true">&times;</span>\
                       </button>'+response.description+'</div>';

                  $('#frm-product_comment')[0].reset();
                  $('#status_msg').html(success_HTML);
                   window.location.href = SITE_URL;
                  
                }
                else
                {                    
                  var error_HTML = '';   
                   error_HTML+='<div class="alert alert-danger alert-dismissible">\
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                           <span aria-hidden="true">&times;</span>\
                       </button>'+response.description+'</div>';
                   
                   $('#status_msg').html(error_HTML);

                }
              }
            }
          });
        }
  });
</script>
@endsection
