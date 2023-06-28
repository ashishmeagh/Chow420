@extends('seller.layout.master')
@section('main_content')

<style type="text/css">
   .error-whitspace{
    display: block; white-space: nowrap; font-size: 14px;
  }
 .form-group .dropdown-menu{    padding: 20px 10px;position: absolute !important; width: 100%;}
   .form-group .dropdown-menu li{
    display: block;
  }
  .form-group .dropdown-menu li a{
    padding: 10px 10px;
  }
  hr {
  border: 0;
  clear:both;
  display:block;
  width: 96%;               
  background-color:#717171;
  height: 1px;
}
.err{
    color: #e00000;
    font-size: 13px;
}
.readonly_div{ background-color: #eee;}

</style>


 <div class="my-profile-pgnm">
  Add Coupon Code
 
     <ul class="breadcrumbs-my">
     <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/seller/coupon">Coupon Code</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Add Coupon Code</li>
    </ul>
</div>
<div class="new-wrapper">

<div class="main-my-profile"> 
   <div class="innermain-my-profile add-product-inrs space-o">
    <form id="validation-form">
        {{ csrf_field() }}
  
       <div class="row">  
         <h4> <span id="showerr"></span> </h4>

          <div class="col-md-12">
                 <div class="form-group">
                    <label for="code">Code <span>*</span></label>
                    <input type="text" name="code" id="code" class="input-text" placeholder="Enter coupon code" data-parsley-required-message="Please enter coupon code" data-parsley-required ='true'>
                </div>
          </div>

           <div class="col-md-12">
                 <div class="form-group">
                    <label for="code">Discount (%)<span>*</span></label>
                    <input type="text" data-parsley-pattern="^[0-9.]+$" name="discount" id="discount" class="input-text" placeholder="Enter discount" data-parsley-required-message="Please enter coupon code discount" data-parsley-required ='true' data-parsley-min="1" data-parsley-max="100" data-parsley-pattern-message="Please enter valid discount">
                </div>
          </div>

           
     
            

            <div class="col-md-6">
              <div class="form-group">
                <label class="" for="type"> Type <span class="red">*</span></label>                   
                  <div class="radio-btns radiobuttoninline">
                    <div class="radio-btn">                                  
                      <input type="radio" name="type" class="shipping_type" id="type" data-parsley-required="true" value="1" data-parsley-errors-container=".type_err" data-parsley-required-message="Please select any one type" onchange="return showdates(this.value)">
                      <label for="type">Multiple Times</label> 
                      <div class="check"></div>
                    </div>
                    <div class="radio-btn">
                      <input type="radio" name="type" class="shipping_type" id="type1" data-parsley-required="true" value="0" data-parsley-errors-container=".type_err" data-parsley-required-message="Please select any one shipping type" onchange="return showdates(this.value)"> 
                      <label for="type1">One Time</label>
                      <div class="check"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="type_err"></div>
                  </div>                                                    
                <span>{{ $errors->first('type') }}</span>
              </div> 
            </div>

          
          <div class="col-md-8" id="showstartdate">
                 <div class="form-group">
                    <label for="start_date">Start Date<span>*</span></label>
                    <input type="text" name="start_date" id="start_date" class="input-text" placeholder="Select start date" data-parsley-required-message="Please select start date" 
                    onkeydown="return false">
                    <span id="start_err"></span>
                </div>
          </div>

            <div class="col-md-8" id="showenddate">
                 <div class="form-group">
                    <label for="end_date">End Date<span>*</span></label>
                    <input type="text" name="end_date" id="end_date" class="input-text" placeholder="Select end date" data-parsley-required-message="Please select end date" onkeydown="return false">
                </div>
          </div>

        
           

       
            <input type="hidden" id="checkbox5" name="is_active" value="1" />
         
 
                       
            <div class="col-md-12">
                <div class="button-list-dts">
                    <a href="javascript:void(0)" class="butn-def" id="btn_add">Add Coupon</a>
                    <a href="{{ url('/') }}/seller/coupon" class="butn-def cancelbtnss">Back</a>
                   
                </div>
            </div>
       </div>
   </form>
   </div>
</div>
</div>

<script>
  function showdates(val)
  {
    var val = val;

    if(val=='0')
    {
      $("#showstartdate").hide();
      $("#showenddate").hide();

       

    }else{
      $("#showstartdate").show();
      $("#showenddate").show();

      $("#start_date").attr('data-parsley-required',true);
      $("#end_date").attr('data-parsley-required',true);
    }
  }
</script>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

<script type="text/javascript">
  var SITE_URL  = "{{ url('/')}}";
  var last_row  = ""; 
  var i = 1;
  


  $(document).ready(function()
  {
     



    var csrf_token = $("input[name=_token]").val(); 


    $('#btn_add').click(function()
    {
          var radioValue = $("input[name='type']:checked").val();
         
         if(radioValue==1)
         {
         }else
         {
           $("#start_date").removeAttr('data-parsley-required');
           $("#end_date").removeAttr('data-parsley-required');
         }


        if($('#validation-form').parsley().validate()==false) return;
        formdata = new FormData($('#validation-form')[0]);

      // var type = $("#type").val(); 
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val(); 
        var flag1 =0;

       if(radioValue==1)
       {
            if(start_date!="" && end_date!="")
            {

              var startdate = moment(start_date).format('YYYY-MM-DD');
              var enddate = moment(end_date).format('YYYY-MM-DD');

               if(startdate>enddate)
              {

                $("#start_err").html('Start date should not be greater than end date');
                $("#start_err").css('color','red');
                flag1 =1;
              }
            }
       }
       else{
       
        $("#start_err").html('');
         flag1 =0;

       }
        
      
       if(flag1==0){
       
        $.ajax({                  
          url: SITE_URL+'/seller/coupon/save',
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
                         title:'Success',
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

      }else{
          return false;
      }
       

    });
      
 
  });
 
 

</script>

<link href="{{ url('/') }}/assets/seller/css/jquery-ui.css" rel="stylesheet" type="text/css" />
 
<link rel="stylesheet" href="/resources/demos/style.css">
{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 --}}<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#start_date" ).datepicker(
        { dateFormat: 'dd M yy' ,
          minDate: 0
        }
      );
  } );
</script>
<script>
  $( function() {
    $( "#end_date" ).datepicker(
        { dateFormat: 'dd M yy',
          minDate: 0

        }
      );
  } );
</script>
@endsection