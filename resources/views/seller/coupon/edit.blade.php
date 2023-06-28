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
  .order-id-main-left.classordermain.editproductstext-border {
      float: none;
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 1px solid #e8e8e8;
  }
  .disapprovd-txt{display: inline-block;}
  .productnames.disapprove-reason {
    display: inline-block;
}
.parsley-errors-list {
    position: absolute;
    bottom: -19px;
    color: #e00000;
    left: 0px;
    font-size: 11px;
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
 <script src="{{url('/')}}/vendor/ckeditor/ckeditor/ckeditor.js"></script>

 <div class="my-profile-pgnm">
  Edit Coupon Code
   <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="{{url('/')}}/seller/coupon"> Coupon Code</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Edit Coupon Code</li>
    </ul>
</div> 
<div class="new-wrapper">

  @php
    $remainingstock = 0;
    if(isset($product_inventory) && !empty($product_inventory))
    {
      $remainingstock = $product_inventory['remaining_stock'];
    } 


  @endphp

 
 
<div class="main-my-profile">


   <div class="innermain-my-profile add-product-inrs space-o">
    
     <form id="validation-form" onsubmit="return false">
        {{ csrf_field() }}
   <div class="profile-img-block">
                    
    

        <input type="hidden" name="id" id="id" value="{{ $arr_coupon['id'] }}">
      
    </div> 
       <div class="row">

              <div class="col-md-12">
                  <div class="form-group">
                    <label for="product_name">Code <span>*</span></label>
                    <input type="text" name="code" id="code" class="input-text" placeholder="Enter coupon code" data-parsley-required ='true' data-parsley-required-message="Please enter coupon code " value="{{ $arr_coupon['code'] }}">
                  </div>
              </div>

             <div class="col-md-12">
                 <div class="form-group">
                    <label for="brand">Discount (%) <span>*</span></label>
                    <input type="text" data-parsley-pattern="^[0-9.]+$" name="discount" id="discount" class="input-text" placeholder="Enter Discount"  value="{{ isset($arr_coupon['discount'])?$arr_coupon['discount']:'' }}"  data-parsley-required ='true' data-parsley-required-message="Please enter coupon code discount" data-parsley-min="1" data-parsley-max="100" data-parsley-pattern-message="Please enter valid discount">
                   
                </div>
            </div>

            
                 


            <div class="col-md-6">
              <div class="form-group">
                <label class="" for="type"> Type <span class="red">*</span></label>                   
                  <div class="radio-btns radiobuttoninline">
                    <div class="radio-btn">                                  
                      <input type="radio" name="type" class="shipping_type" id="type" data-parsley-required="true" value="1" data-parsley-errors-container=".type_err" data-parsley-required-message="Please select any one type" onchange="return showdates(this.value)" @if($arr_coupon['type']=='1') checked @endif>
                      <label for="type">Multiple Times</label> 
                      <div class="check"></div>
                    </div>
                    <div class="radio-btn">
                      <input type="radio" name="type" class="shipping_type" id="type1" data-parsley-required="true" value="0" data-parsley-errors-container=".type_err" data-parsley-required-message="Please select any one shipping type" onchange="return showdates(this.value)" @if($arr_coupon['type']==0) checked @endif> 
                      <label for="type1">One Time</label>
                      <div class="check"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="type_err"></div>
                  </div>                                                    
                <span>{{ $errors->first('type') }}</span>
              </div> 
            </div>
            @php 
              $start_date = '';
              if(isset($arr_coupon['start_date']) && $arr_coupon['start_date']!='0000-00-00')
              {
                $start_date = $arr_coupon['start_date'];
              }
              else{
                $start_date = '';
              }


               $end_date = '';
              if(isset($arr_coupon['end_date']) && $arr_coupon['end_date']!='0000-00-00')
              {
                $end_date = $arr_coupon['end_date'];
              }
              else{
                $end_date = '';
              }

            @endphp

            <div class="col-md-8" id="showstartdate" @if($arr_coupon['type']=='1') style="display: block" @else style="display: none" @endif>
                 <div class="form-group">
                    <label for="start_date">Start Date<span>*</span></label>
                    <input type="text" name="start_date" id="start_date" class="input-text" placeholder="Select start date" data-parsley-required-message="Please select start date" value="{{ $start_date }}"   @if($arr_coupon['type']==1 && ($arr_coupon['start_date']=='0000-00-00' || $arr_coupon['start_date']=='')) data-parsley-required="true" @endif>
                    <span id="start_err"></span>
                </div>
          </div>

            <div class="col-md-8" id="showenddate" @if($arr_coupon['type']=='1') style="display: block" @else style="display: none" @endif>
                 <div class="form-group">
                    <label for="end_date">End Date<span>*</span></label>
                    <input type="text" name="end_date" id="end_date" class="input-text" placeholder="Select end date" data-parsley-required-message="Please select end date" value="{{ $end_date }}" @if($arr_coupon['type']==1 && ($arr_coupon['end_date']=='0000-00-00' || $arr_coupon['end_date']=='')) data-parsley-required="true" @endif>
                </div>
          </div>

            <input type="hidden" id="checkbox5" name="is_active" value="{{ isset($arr_coupon['is_active'])?$arr_coupon['is_active']:'' }}" />

      
         
           
            <div class="col-md-12">
                <div class="button-list-dts">
                    <button class="butn-def" id="btn_add" type="button">Update Coupon</button>
                    <a href="{{ url('/') }}/seller/coupon" class="butn-def cancelbtnss">Back</a>
                </div>
            </div>
       </div>
   </form>
   </div>
</div>
</div>


{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

<script type="text/javascript">
  var SITE_URL  = "{{ url('/')}}";

  

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


      //  var type = $("#type").val(); 
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

       }//ifflag1
       else
       {
          return false;
       }//else


      
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
        { dateFormat: 'yy-m-dd',
        minDate: 0

        }
      );
  } );
</script>
<script>
  $( function() {
    $( "#end_date" ).datepicker(
        { dateFormat: 'yy-m-dd', minDate: 0}
      );
  } );
</script>

<script>
  function showdates(val)
  {
    var val = val;

    if(val=='0')
    {
      $("#showstartdate").hide();
      $("#showenddate").hide();

      $("#start_date").removeAttr('data-parsley-required');
      $("#end_date").removeAttr('data-parsley-required');
    }else{
        $("#showstartdate").show();
      $("#showenddate").show();

       if($("#start_date").val()=='')
       {
        $("#start_date").attr('data-parsley-required',true);
       }
       if($("#end_date").val()=='')
       {
        $("#end_date").attr('data-parsley-required',true);
       }
       
    }
  }
</script>
@endsection