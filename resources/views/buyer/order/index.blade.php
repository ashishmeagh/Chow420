
@extends('buyer.layout.master')
@section('main_content')
@inject('ordermodel','App\Models\OrderModel') 

<style>
    .dispute_pending
    {
        color:red;
    }
    .dispute_approved
    {
       color:green; 
    }
.rtablehead.order-no-plc{
  
}
/*#table_module_wrapper .row{margin-left: 0px; margin-right: 0px;}*/



   @media
    only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {

    /* Force table to not be like tables anymore */
    table, thead, tbody, th, td, tr {
      display: block;
    }

    /* Hide table headers (but not display: none;, for accessibility) */
    thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }

    tr {
         margin: 0 0 1rem 0;
         border: 1px solid #ddd;
         box-shadow: 0 1px 0 #ccc;
         border-radius: 3px;
      }
      
    tr:nth-child(odd) {
      background: #f9f9f9;border: 1px solid #ccc;
    }
    
    td {
      /* Behave  like a "row" */
      border: none;     font-size: 14px !important;
         border-bottom: 1px solid #ececec;
      position: relative;
      padding-left: 50%;     padding: 23px 18px 7px !important;
          border-top: none !important;
    }

    td:before {
      /* Now like a table header */
      position: absolute;
      /* Top/left values mimic padding */
      top: 4px;
      left: 17px;
      width: 45%;
      padding-right: 10px;
      white-space: nowrap; font-size: 14px;
    }

    td:nth-of-type(1):before { content: "Order ID"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(2):before { content: "Date";  font-family: 'nunito_sansbold';}
    td:nth-of-type(3):before { content: "Dispensary"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(4):before { content: "Price ($)"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(5):before { content: "Is Age Restricted";  font-family: 'nunito_sansbold';}
    td:nth-of-type(6):before { content: "Status"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(7):before { content: "Action";  font-family: 'nunito_sansbold';}
  }
a.eye-actn{
  margin-left: 0px;
}
</style>


<!-- Modal My-Review-Ratings-Add Start -->
<div id="raiseDispute" class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <form id="frm-raiseDispute">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="{{url('/')}}/assets/front/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">Add Dispute Details</div>

                <input type="hidden" name="order_id" id="order_id" value="">
                <input type="hidden" name="order_no" id="order_no" value="">
                <div class="form-group">
                    <label for="">Message</label>
                    <textarea name="message" id="message" placeholder="Enter Your Message" data-parsley-required="true" data-parsley-required-message="Please enter message." data-parsley-minlength="20"></textarea>
                </div>

            <div class="button-list-dts btn-order-cnls">
                <a class="butn-def" id="btn-raiseDispute">Submit</a>
            </div>
            <div class="clr"></div>
        </div>
       </form>  
    </div>
</div>
<!-- Modal My-Review-Ratings-Add End -->


<div class="my-profile-pgnm">
  {{isset($page_title)?$page_title:''}}s 

  <ul class="breadcrumbs-my">
    <li><a href="{{url('/')}}">Home</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    <li> Orders</li>
  </ul>

</div>
<div class="chow-homepg">Chow420 Home Page</div>
@php 
$enc_id=""; 
@endphp
 
<div class="new-wrapper">
    <div class="order-main-dvs table-order">
        <div class="table-responsive">
           <table class="table seller-table" id="table_module">
                 <thead>
                  <tr>

                    <th width="150px"><strong>Order ID</strong></th>
                    <th width="150px"><strong>Date</strong></th>
                    <th width="150px"><strong>Dispensary</strong></th>
                    <!-- <th width="150px"><strong>Time</strong></th> -->
                   {{--  <th><strong>Shipping Address</strong></th> --}}
                    <th width="15%"><strong>Price ($)</strong></th>
                    <th width="150px"><strong>Is Age Restricted</strong></th>
                    <th width="150px"><strong>Status</strong></th>
                    <th width="220px"><strong>Action</strong></th> 
                </thead>
                <tbody>

                {{-- <tbody>

                @if(isset($order_arr) && sizeof($order_arr)>0)
                    @foreach($order_arr as $order)
                        @php 
                            $trans_status = $status_class = "";
                            if($order['order_status']==0) 
                            { 
                                $trans_status  = "Cancelled";
                                $status_class  = "status-shipped";
                            }
                            else if($order['order_status']==1)
                            {
                                $trans_status  = "Completed";
                                $status_class  = "status-completed";
                            }  
                            else if($order['order_status']==2)
                            {
                                $trans_status  = "Ongoing";
                                $status_class  = "status-dispatched";
                            }
                                     


                            $sum_total_amount = $ordermodel->where('order_no','=',$order['order_no'])->get()->pluck('total_amount')->sum()
                         
                        @endphp
                        <tr>
                            <td>{{isset($order['order_no'])?$order['order_no']:''}}</td>
                            <td>{{isset($order['created_at'])?us_date_format($order['created_at']):''}}</td>
                            <td>{{isset($order['created_at'])?time_format($order['created_at']):''}}</td>

                            <td>{{isset($order['address_details']['shipping_address1'])?$order['address_details']['shipping_address1']:''}} {{isset($order['address_details']['shipping_city'])?','. $order['address_details']['shipping_city']:''}} {{isset($order['address_details']['state_details']['state_title'])?','.$order['address_details']['state_details']['state_title']:''}}</td>


                            <td>$ 
                            {{isset($order['total_amount'])?number_format($order['total_amount'],2):''}}

                            </td>                            
                            <td>{{$trans_status}}</td>
                            <td>
                              <a href="{{url('/')}}/buyer/order/view/{{isset($order['id'])?base64_encode($order['id']):''}}" class="eye-actn"><i class="fa fa-eye"></i></a>
                                                          
                                 @if($order['dispute_details']==null && $order['order_status']=="1")
                              <a href="javascript:void(0)" onclick="raiseDispute($(this))" data-order_id = "{{isset($order['id'])?$order['id']:''}}"  data-order_no = "{{isset($order['order_no'])?$order['order_no']:''}}"   class="btns-just-opend">Raise Dispute</a>
                              @elseif(isset($order['dispute_details']['dispute_status']) && $order['dispute_details']['dispute_status']=='0')
                              <a href="javascript:void(0)" class="btns-pending">Pending</a>
                              @elseif(isset($order['dispute_details']['dispute_status']) && $order['dispute_details']['dispute_status']=='1')
                              <a href="{{url('/')}}/buyer/dispute/{{isset($order['id'])?base64_encode($order['id']):''}}" class="btns-approved">Closed</a>
                              @endif  
                             
                            </td>

                    @endforeach 

                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>No data available in table</td>
                        <td></td>
                        <td></td>
                        <td></td> 

                  </tbody> 
                    
                @endif  --}}
          {{--  </div> --}}
             </tbody> 
        </table>
        </div>
       </div>

       {{--  <div class="pagination-chow pagination-center">           
            @if(!empty($arr_pagination))
                {{$arr_pagination->render()}}    
            @endif 

        </div> --}}
                          
    </div>
</div>


 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Order note:</h4>
      </div>
      {{-- <form class="signup-form" method="post" action="{{$module_url_path.'/submit_order_note'}}" > --}}
      <form class="signup-form" id="note_form"  >
        {{ csrf_field() }}

        <div class="modal-body" style="height: 130px;"> 
          <div class="md-form">
              {{-- <label for="materialContactFormMessage">Order note :  </label> --}}
              <div id="order_note_show" > </div>
              <input type="hidden" name="order_id" class="modal_order_id" >
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>

    </div>
  </div>


    {{-- <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Order note:</h4>
        </div>
        <div class="modal-body">
              <div id="order_note_show" > </div>
        </div>
        
      </div>
      
    </div> --}}



</div>


<script type="text/javascript">
    function raiseDispute(ref)
    {
        var order_id = $(ref).attr('data-order_id');
        var order_no = $(ref).attr('data-order_no'); 
        $("#raiseDispute #order_id").val(order_id);
        $("#raiseDispute #order_no").val(order_no);
        $("#raiseDispute").modal('show');
    }
 
    
    $("#btn-raiseDispute").click(function()
    {
      if($('#frm-raiseDispute').parsley().validate()==false) return;
      var order_id   = $("#raiseDispute #order_id").val();
      var order_no   = $("#raiseDispute #order_no").val();

      var message    = $("#raiseDispute #message").val();
      var csrf_token = "{{ csrf_token()}}";

        $.ajax({
              url: SITE_URL+'/buyer/dispute/raise',
              type:"POST",
              data: {order_id:order_id,order_no:order_no,message:message,_token:csrf_token},             
              dataType:'json',
              beforeSend: function(){   
              showProcessingOverlay();         
              },
              success:function(response)
              {
                 hideProcessingOverlay();
                if(response.status == 'success')
                { 
                  swal({
                          title: 'Success',
                          text: response.description,
                          type: 'success',
                          confirmButtonText: "OK",
                          closeOnConfirm: true
                       },
                      function(isConfirm,tmp)
                      {                       
                        if(isConfirm==true)
                        {
                            window.location.reload();
                            $(this).removeClass('active');
                        }

                      });
                }
                else
                {                
                  swal('Error',response.description,'error');
                }  
              }  
      }); 

    }); 

</script> 


<script type="text/javascript">

  var module_url_path  = "{{ $module_url_path or '' }}";  

</script>

<script type="text/javascript">
    var table_module = false;

    $(document).ready(function()
    {
      
      table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
      bFilter: false,
      "order":[4,'Asc'],

      ajax: {
      'url': SITE_URL+'/buyer/order/get_myorders',
      'data': function(d)
       {        
          d['column_filter[q_order_no]']   = $("input[name='q_order_no']").val()     
          d['column_filter[q_order_date]']   = $("input[name='q_order_date']").val()         
    
         
          d['column_filter[q_price]']      = $("input[name='q_price']").val()
          
         // d['column_filter[q_payment_status]']  = $("select[name='q_payment_status']").val()
          d['column_filter[q_order_status]']  = $("select[name='q_order_status']").val()

          d['column_filter[q_order_date]']    = $("input[name='q_order_date']").val()
          d['column_filter[q_seller_name]']   = $("input[name='q_seller_name']").val()
          d['column_filter[q_buyerageflag]']  = $("select[name='q_buyerageflag']").val()
         
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
      {data: 'date', "orderable": false, "searchable":false},
      {data: 'seller_business_name', "orderable": false, "searchable":false},
    
      {
        render(data, type, row, meta)
        {
             return '<i class="fa fa-dollar"></i>'+(+row.total_amount).toFixed(2);
        },
        "orderable": false, "searchable":false
      },             
      {data: 'buyer_age_restrictionflag', "orderable": false, "searchable":false},
      {
         data : 'order_status',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.order_status == 'Ongoing')
           {
            
             return `<div class="status-dispatched">`+row.order_status+`</div>`

           }else if(row.order_status == 'Shipped' || row.order_status == 'Pending Age Verification')
           {
            
             return `<div class="status-dispatched">`+row.order_status+`</div>`

           }
           else if(row.order_status == 'Delivered')
           {
             return `<div class="status-completed">`+row.order_status+`</div>`

           }
           else if(row.order_status == 'Cancelled')
           {
             return `<div class="status-shipped">`+row.order_status+`</div>`
           }
           else if(row.order_status == 'Dispatched')
           {
             return `<div class="status-dispatched">`+row.order_status+`</div>`
           }
        
         },
         "orderable": false,
         "searchable":false
       },
       {
        render : function(data, type, row, meta) 
        {
          return row.build_action_btn;
        },
        "orderable": false, "searchable":false
      }
     ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData();
  });
  /*search box*/
  // <input type="text" name="q_order_date" placeholder="Search" onchange="filterData();" class="input-text datepicker" />
  


   $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_order_no" placeholder="Search" class="input-text column_filter" /></td>             
          <td></td>  
          <td><input type="text" name="q_seller_name" placeholder="Search" class="input-text column_filter" /></td>      
        
          <td><input type="text" name="q_price" placeholder="Search" class="input-text column_filter" /></td>   
          <td>
               <div class="select-style">
                <select class="column_filter frm-select" name="q_buyerageflag" id="q_buyerageflag" onchange="filterData();">
                    <option value="">All</option>
                    <option value="1">Yes</option> 
                    <option value="0">No</option>                 
                </select>
               </div>
          </td>        
          <td>
            <div class="select-style">
              <select class="column_filter frm-select" name="q_order_status" id="q_order_status" onchange="filterData();">
                    <option value="">All</option>
                    <option value="0">Cancelled</option>
                    <option value="1">Delivered</option>
                    <option value="2">Ongoing</option>
                    <option value="3">Shipped</option>
              </select>
              </div>
          </td>     

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
</script>

<style>
  .dataTables_empty{
    text-align: center;
  }
</style>


 <script >
    
    function order_note(ref) {

      var order_note = $(ref).data('order_note');

      document.getElementById("order_note_show").innerHTML = order_note ? order_note : 'NA';

      $('#myModal').modal('show');
    } 
  </script>

@endsection
