@extends('front.layout.master',['page_title'=>'Contact'])
@section('main_content')

<style>
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
<div class="aboutus-chow contact-usbanner"></div>
<div class="container">
   <div class="our-mission-abts">
    <ul class="sfw-footer contactpgsfw">
      <li class="help-cont">
         {{ ucfirst($res_cms[0]->meta_keyword)}}
      </li>
      
      <li class="emails-contd">
         <div class="titlenumrs">Email Us</div>
         <a href="#"><span>email us</span> <i class="fa fa-envelope emailicnss"></i> </a>
      </li>
    </ul>
    <div class="clearfix"></div>
</div>
<!-- <div class="title-of-contsf">Corporate Inquiries</div>
<div class="corp-email">Ask about our company at <a href="#">corporate@chow420.com</a>.</div>
<div class="title-of-contsf">Seller Opportunities</div>
<div class="corp-email">Ask about our company at <a href="#">seller@chow420.com</a>.</div>
<div class="title-of-contsf">Buyer Opportunities</div>
<div class="corp-email">Ask about our company at <a href="#">buyer@chow420.com</a>.</div> -->
<div class="title-of-contsf">{!! $res_cms[0]->page_desc !!}</div>
</div>


<script type="text/javascript">
   $('#btn_contact_us').click(function()
   {
      
      if($('#frm-contact').parsley().validate()==false) return;

      var form_data = $('#frm-contact').serialize();
      $.ajax({
         url:SITE_URL+'/contact-us/store',
         data:form_data,
         method:'POST',        
         dataType:'json',
         beforeSend : function()
         {
            showProcessingOverlay();
            $('#btn_contact_us').prop('disabled',true);
            $('#btn_contact_us').html('Processing... <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
         },
         success:function(response)
         {
            hideProcessingOverlay();
            $('#btn_contact_us').prop('disabled',false);
            $('#btn_contact_us').html('Submit');

            if(typeof response =='object')
            {
               if(response.status && response.status=="SUCCESS")
               {
                 var success_HTML = '';
                 success_HTML +='<div class="alert alert-success alert-dismissible">\
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                           <span aria-hidden="true">&times;</span>\
                       </button>'+response.description+'</div>';

                  $('#frm-contact')[0].reset();
                  $('#status_msg').html(success_HTML);
                 
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
   });
</script>

@endsection