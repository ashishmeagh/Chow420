@extends('seller.layout.master')
@section('main_content')



<style type="text/css">
    .form-lbls {
    display: inline-block; position: relative; margin-bottom: 10px;
}
.top-space-home{margin-top: 20px;}
.form-lbls .errors-frm {
    position: absolute;
    display: block;
    left: 0px;
        top: 53px; line-height: 14px;
    font-size: 13px;
}
.form-lbls label{display: block; font-weight: 300; margin-bottom: 0px; font-size: 14px;}
.form-lbls input{font-size: 13px; height: 33px; padding: 5px 10px;}
.form-lbls.space-right-inx{margin-right: 30px;}
.top-space-home .btn-info {
    color: #fff;
    background-color: #873dc8;
    border-color: #873dc8;
}
.top-space-home .btn-info:hover { 
    color: #fff;
    background-color: #9223a2;
    border-color: #9223a2;
}
.top-space-home .btn-info:focus, .top-space-home .btn-info.focus {
    color: #fff;
    background-color: #9223a2;
    border-color: #9223a2;
}
</style>

<div class="my-profile-pgnm">
  {{isset($page_title)?$page_title:''}}


      <ul class="breadcrumbs-my">
        <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
       {{--  <li><i class="fa fa-angle-right"></i></li> --}}
       {{--  <li><a href="#">Age Restricted Orders</a></li> --}}
        <li><i class="fa fa-angle-right"></i></li>
        <li>Age Restricted Cancelled Orders</li>
      </ul>
<br/>




</div>
  <div class="new-wrapper">
    @include('front.layout.flash_messages')

    @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif



 

     <!------------------------------------------------>
 
   {{--   @if(Request::segment(3)!="" && Request::segment(3)=="delivered") --}}
     <div class="">
      <div class="top-space-home">
        <input type="hidden" name="excelstatus" id="excelstatus" value="{{ Request::segment(3) }}">
          <div class="form-lbls space-right-inx">
            <label class="lblforms" for="from">From : </label>
            <input type="text" class="space-right-padding column_filter" id="from" name="from" placeholder="From Date">
            <span class="errors-frm" id="from_err"></span>
          </div>
          <div class="form-lbls">
              <label class="lblforms" for="to">To :</label>
              <input type="text" class="column_filter" id="to" name="to" placeholder="To Date">
              <span class="errors-frm" id="to_err"></span>
          </div>

          <a href="javascript:void(0)" class="btn btn-info uploads-in searchbtn" title="Search"><i class="fa fa-search" onclick="filterrecords();filterData();"></i></a>

          <a href="#" class="btn btn-info uploads-in" id="exportbtn" title="Export">Export Excel</a>

           <a href="#" class="btn btn-info uploads-in" id="exportbtncsv" title="Export CSV">Export CSV</a>
        </div>
    </div>  
   {{--  @endif --}}
    <!------------------------------------------------>




    <div class="order-main-dvs table-order main-content-div">
      <div class="table-responsive">
        <table class="table seller-table" id="table_module">
          <thead>
            <tr>
                <th>Order ID</th>
                <th>Transaction ID</th>
                <th width="150px">Date</th>
                <th>Buyer</th>
                <th>Price</th>
                <th>Payment Status</th>
                <th>Order Status</th>
                <th width="150px">Action</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>

  </div>
</div>
<script type="text/javascript"> var module_url_path  = "{{ $module_url_path or '' }}";  </script>

<script type="text/javascript">
    var table_module = false;
    var order_type = false; 
    var order_type = "{{ $order_type or '' }}";
    $(document).ready(function()
    {

      table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
      bFilter: false,
      "order":[4,'Asc'],

      ajax: {
      'url': module_url_path+'/get_order_details',
      'data': function(d)
       { 
          
          d['column_filter[q_order_no]']        = $("input[name='q_order_no']").val()         
          d['column_filter[q_transaction_id]']  = $("input[name='q_transaction_id']").val()
          d['column_filter[q_price]']           = $("input[name='q_price']").val()
          d['column_filter[q_payment_status]']  = $("select[name='q_payment_status']").val()
          d['column_filter[q_order_date]']      = $("input[name='q_order_date']").val()
          d['column_filter[q_from]']            = $("input[name='from']").val()
          d['column_filter[q_to]']              = $("input[name='to']").val()
          d['column_filter[q_buyer_name]']      = $("input[name='q_buyer_name']").val()
          d['column_filter[q_orderdate]']       = $("input[name='q_orderdate']").val()


           
       }
      },

      columns: [
      {
        render(data, type, row, meta)
        {
             return row.order_no;
        },
        "orderable": false, "searchable":false
      },                            
      {data: 'transaction_id', "orderable": false, "searchable":false},         
      {data: 'created_at', "orderable": false, "searchable":false},
      {data: 'buyername', "orderable": false, "searchable":false},

     
      {
        render(data, type, row, meta)
        {
             return '<i class="fa fa-dollar"></i>'+(+row.total_amount).toFixed(2);
        },
        "orderable": false, "searchable":false
      },             
     
      {
         data : 'transaction_status',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.transaction_status == 'Pending')
           {
            
             return `<div class="status-dispatched">`+row.transaction_status+`</div>`

           }
           else if(row.transaction_status == 'Paid')
           {
             return `<div class="status-completed">`+row.transaction_status+`</div>`

           }
           else if(row.transaction_status == 'Failed')
           {
             return `<div class="status-shipped">`+row.transaction_status+`</div>`
           }
           // else
           // {
           //    return `<span class="label label-warning">Pending</span>`
           // }
         },
         "orderable": false,
         "searchable":false
       },
        
       {
         data : 'order_status',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.order_status == 'Ongoing')
           {
            
             return `<div class="status-dispatched">`+row.order_status+`</div>`

           }
           else if(row.order_status == 'Shipped')
           {
             return `<div class="status-dispatched">`+row.order_status+`</div>`

           }else if(row.order_status == 'delivered')
           {
             return `<div class="status-completed">`+row.order_status+`</div>`
           }        
           else if(row.order_status == 'Dispatched')
           {
             return `<div class="status-dispatched">`+row.order_status+`</div>`

           }                
           else
           {
              return `<div class="status-shipped">`+row.order_status+`</div>`
           }
         },
         "orderable": false,
         "searchable":false
       },


    
      
      {data: 'build_action_btn', "orderable": false, "searchable":false},     
      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData();
  }); 
  /*search box*/
  // <input type="text" name="q_order_date" placeholder="Search" onchange="filterData();" class="input-text datepicker column_filter" />

  $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_order_no" placeholder="Search" class="input-text column_filter" /></td>             
          <td><input type="text" name="q_transaction_id" placeholder="Search" class="input-text column_filter" /></td>   
         <td>
             <input type="text" name="q_orderdate" id="q_orderdate" placeholder="Search" onchange="filterData();" class="input-text datepicker column_filter" />
         </td>     
         <td>
            <input type="text" name="q_buyer_name" placeholder="Search" class="input-text column_filter" />
         </td>
        
          <td><input type="text" name="q_price" placeholder="Search" class="input-text column_filter" /></td>           
           <td width="12%">
            <div class="select-style">
              <select class="column_filter frm-select" name="q_payment_status" id="q_payment_status" onchange="filterData();">
                    <option value="">All</option>
                    <option value="0">Pending</option>
                    <option value="1">Paid</option>
                    <option value="2">Failed</option>
              </select>
            </div>
          </td> 
          <td>
            
          </td>     
          <td></td>     

      </tr>`);

  $('input.column_filter').on( 'keyup click', function () 
  {
       filterData();
  });
  });

  function filterData()
  {
    table_module.draw();
  }


  function confirm_order_status(ref)
  {
    var tracking_no           = $(ref).data('tracking_no');
    var shipping_company_name = $(ref).data('shipping_company_name');
    var enc_id                = $(ref).data('enc_id');

    if(tracking_no == '' && shipping_company_name == '')
    {
      swal({
          title:'Alert!',
          text: 'Please add tracking # & shipping company name first!',
         // type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Go to order detail page",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            window.location = module_url_path+'/view/'+enc_id+'#shipping_details';             
          }           
       });

      return false;
    }
    else
    { 
        var actionname = $(ref).data('id');
        var actionlink = $(ref).data('href');
        
        var msgtitle = 'Do you really want to '+actionname+' this order?';
        if(actionname=="ship"){
          var msgtitle = "Ship Now?";
            swal({
            //  title: 'Do you really want to '+actionname+' this order?',
              title: msgtitle,
              type: "warning",
              showCancelButton: true,
            //   confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: false
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                //showProcessingOverlay();
                window.location= actionlink;
                 
              }           
           });

        }
         else if(actionname=="deliver")
        {
          var msgtitle ='Has this item been delivered?';
          window.location= actionlink;
        }
        else{
          var msgtitle ='Do you really want to '+actionname+' this order?';
            swal({
            //  title: 'Do you really want to '+actionname+' this order?',
              title: msgtitle,
              type: "warning",
              showCancelButton: true,
            //   confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: false
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                //showProcessingOverlay();
                window.location= actionlink;
                 
              }           
           });

        }
    
        
    }

  }
  
</script>

<link href="{{ url('/') }}/assets/seller/css/jquery-ui.css" rel="stylesheet" type="text/css" />
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
   $( function() {
    $( ".datepicker" ).datepicker(
        { dateFormat: 'dd M yy' }
      );
  } );


  $( function() {
    $( "#from" ).datepicker(
        { dateFormat: 'dd M yy' }
      );
  } );
  $( function() {
    $( "#to" ).datepicker(
        { dateFormat: 'dd M yy' }
      );
  } );


   function filterrecords(){

      var from = $("#from").val();
      var to = $("#to").val(); 
      if(from=="")
      {
        $("#from_err").html('Please select from date');
        $("#from_err").css('color','red');
        return false;
      }else{
        $("#from_err").html('');
      }
      if(to=="")
      {
        $("#to_err").html('Please select to date');
        $("#to_err").css('color','red');
        return false;
      }else{
        $("#to_err").html('');
      }



      if(from!="" && to!="")
      {

        var fromdate = moment(from).format('YYYY-MM-DD');
        var todate = moment(to).format('YYYY-MM-DD');

         if(fromdate>todate)
        {
          $("#from_err").html('From date should not be greater than to date');
          $("#from_err").css('color','red');
          return false;
        }

        return true;
      }else{
        return false;
      }
   } 

   $(document).on('click','#exportbtn',function(){


      var from = $("#from").val();
      var to = $("#to").val(); 
      
      //var excelstatus = $("#excelstatus").val();

      var excelstatus = 'cancelled';

      if(from && to && excelstatus)
      {
          var fromdate = moment(from).format('YYYY-MM-DD');
          var todate = moment(to).format('YYYY-MM-DD');
           
          if(fromdate>todate)
          {
            $("#from_err").html('From date should not be greater than to date');
            $("#from_err").css('color','red');
            return false;
          }else{
            window.location.href = module_url_path+'/export/'+from+'/'+to+'/'+excelstatus;
          }
       
      }
      else
      {
        filterrecords();
      }
   });


   $(document).on('click','#exportbtncsv',function(){
      var from = $("#from").val();
      var to = $("#to").val(); 
      //var excelstatus = $("#excelstatus").val();

      var excelstatus = 'cancelled';
      
      if(from && to && excelstatus)
      {

          var fromdate = moment(from).format('YYYY-MM-DD');
          var todate = moment(to).format('YYYY-MM-DD');
           if(fromdate>todate)
          {
            $("#from_err").html('From date should not be greater than to date');
            $("#from_err").css('color','red');
            return false;
          }else{
            window.location.href = module_url_path+'/exportcsv/'+from+'/'+to+'/'+excelstatus;
          }
       
      }
      else
      {
        filterrecords();
      }
   });

   


  </script>
@endsection