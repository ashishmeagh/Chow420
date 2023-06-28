@extends('seller.layout.master')
@section('main_content')
<style type="text/css">
.sms-bank-details {
    color: #ab0d0d;
    background-color: #f9efef;
    padding: 10px;
    border-radius: 3px;
    margin-top: 20px;
    border: 1px solid #eac9c9;
    margin-bottom: 30px;
    box-shadow: 0px 2px 22px -8px #ffcece;
}

@media
    only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {
     table,  thead,  tbody,  th,  td,  tr {
      display: block;
    }
     thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }
     tr.searchinput-data{
      position: static;
    }
     tr.searchinput-data td{width: 93% !important; border: none;}
     tr.searchinput-data td input{width: 100%;}
     tr.searchinput-data .select-style{width: 100%;}
    .searchinput-data td:before{ display: none; }
     tr {
      margin: 0 0 1rem 0; 
      border: 1px solid #ddd;
      box-shadow: 0 1px 0 #ccc; border-radius: 3px;
    }
      .table > thead > tr > td.remove-border{ 
display: none;
      border-top: none !important; border-bottom: none !important;}
     td.dataTables_empty:before{ display: none; padding: 9px 18px 7px;}
      
     tr:nth-child(odd) {
      background: #f9f9f9;
    border: 1px solid #ccc;
    }
     .table > tbody > tr > td{ 
      padding: 23px 18px 7px;
      border-top: 1px solid #ececec;
    }
     td {
      border: none;
      border-bottom: none;
      position: relative;
      padding-left: 50%; font-size: 14px;
    }

     td:before {
      position: absolute;
      top: 4px;
      left: 17px;
      width: 45%;font-weight: 600;
      padding-right: 10px; font-size: 14px;
      white-space: nowrap;
    }
     .search-header{display: block;}

     td:nth-of-type(1):before { content: "Order No"; }
     td:nth-of-type(2):before { content: "Transaction ID"; }  
     td:nth-of-type(3):before { content: "Amount"; }
     td:nth-of-type(4):before { content: "Status"; }
  }

</style>

<div class="my-profile-pgnm">
 Wallet (Chowcash)
   <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Wallet (Chowcash)</li>
    </ul>
</div> 

  @php


    $approve_verification_status = $seller_details['approve_verification_status'];

    $registered_name = $seller_details['registered_name'];
    $account_no = $seller_details['account_no'];
    $routing_no = $seller_details['routing_no'];
    $switft_no = $seller_details['switft_no'];
    $paypal_email = $seller_details['paypal_email'];
    if( (isset($registered_name) && $registered_name!='') && (isset($account_no) && $account_no!='') && (isset($routing_no) && $routing_no!='') && (isset($switft_no) && $switft_no!='') && $approve_verification_status=='1'){
    @endphp
      
    @php    
    }else{
    @endphp
     <div class="new-wrapper">
       {{--   <div class="sms-bank-details">Please enter your all bank details to withdraw the funds</div> --}}

       <div class="sms-bank-details">To withdraw your funds, you must have id proof verified and your bank account details must be updated. Please follow <a href="{{ url('/') }}/seller/bank_detail" target="_blank">link</a> to update bank account details.</div>

     </div>
    @php   
    }
  @endphp


@php 
   $sellercommision='';
   if(isset($site_setting_arr['seller_commission']) && $site_setting_arr['seller_commission']>0)
   {
      $sellercommision = $site_setting_arr['seller_commission'];
   }
@endphp




  <div class="new-wrapper">
    @include('front.layout.flash_messages')

    <div class="order-main-dvs table-order main-content-div">

      <div class="selr-wlts-head rw-selr-wlts-head">

       
        <div class="wallet-totl" title="In progress transactions are for products that have been shipped.Seller commission is {{ $sellercommision }}% of sale">
         <div class="shippedorder-yellow">Shipped Orders (In Progress)</div>
         <div class="icon-wallets">
            <img src="{{url('/')}}/assets/seller/images/wallet-inprogress .png" alt="" />
          </div>
          <div class="inprogress-amount">           
            <span>$</span> {{ isset($ship_wallet_amount)?num_format($ship_wallet_amount):'00.00' }}
              
          </div>
          <div class="clearfix"></div>    
          <div class="percent-wallets-yellow">{{ $sellercommision }}% (excl. tax)</div>
        </div>




        <div class="wallet-totl" title="Dispensary commission : {{ $sellercommision }}% of sale">
          <div class="shippedorder-green">Delivered Orders (Settled)</div>
          <div class="icon-wallets">
            <img src="{{url('/')}}/assets/seller/images/wallet-icon-seller-pg.png" alt="" />
          </div>
          <div class="price-wallet"><span>$</span>
            @php
                $showamt ='00.00';
               if(isset($referal_wallet_amount) && $referal_wallet_amount>0)
               {
                 $showamt = $wallet_amount + $referal_wallet_amount;
               }
               else if(isset($wallet_amount))
               {
                $showamt = $wallet_amount;
               } 
            @endphp
               {{  isset($showamt)?num_format($showamt):'00.00' }}

              {{-- {{isset($wallet_amount)?num_format($wallet_amount):'00.00'}} --}}
          </div>
          <div class="clearfix"></div>
          <div class="percent-wallets-green">{{ $sellercommision }}% (excl. tax)</div>
        </div>

       

       

      </div>



  
  <h3>Previous uncleared refund amount: ${{$refund_balance_amount or ''}}</h3>
  <h3>Referal uncleared wallet amount: ${{$referal_wallet_amount or ''}}</h3>


<div class="withdrawal-request-txt">
   @php

    $bothwallet_amount='';

    $registered_name = $seller_details['registered_name'];
    $account_no = $seller_details['account_no'];
    $routing_no = $seller_details['routing_no'];
    $switft_no = $seller_details['switft_no'];
    $paypal_email = $seller_details['paypal_email'];
    if( (isset($registered_name) && $registered_name!='') && (isset($account_no) && $account_no!='') && (isset($routing_no) && $routing_no!='') && (isset($switft_no) && $switft_no!='') && $approve_verification_status=='1'){


        if($referal_wallet_amount>0)
         {
             $bothwallet_amount =  (float)$wallet_amount+(float)$referal_wallet_amount;
         }
         else{
             $bothwallet_amount =  (float)$wallet_amount;
         }  


    @endphp

    {{--  <button type="button" class="withdraw-btn" onclick="withdraRequest('Do you really want to send withdrawal request of amount ${{ $wallet_amount or '' }} ?')" >Withdraw</button> --}}
     <button type="button" class="withdraw-btn" onclick="withdraRequest('Do you really want to send withdrawal request of amount ${{ $bothwallet_amount or '' }} ?')" >Withdraw</button>
    @php    
    }


  @endphp

    {{-- <button type="button" class="withdraw-btn" onclick="withdraRequest('Do you really want to send withdrawal request of amount ${{ $wallet_amount or '' }} ?')"  {{ $class }}>Withdraw</button> --}}



</div>
      <div class="table-responsive">
        <table class="table seller-table" id="table_module">
          <thead>
            <tr>
                <th>Order No</th>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Status</th>
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
    $(document).ready(function()
    {
      table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,  
      searching: false,

      ajax: {
      'url': module_url_path+'/get_wallet_details',
      'data': function(d)
       { 
          d['column_filter[q_order_no]']     = $("input[name='q_order_no']").val()         
          d['column_filter[q_transaction_id]']  = $("input[name='q_transaction_id']").val()
          d['column_filter[q_price]']        = $("input[name='q_price']").val()
          d['column_filter[q_withdrawrequest]'] = $("select[name='q_withdrawrequest']").val()

          
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
      {
        render(data, type, row, meta)
        {
             return '<i class="fa fa-dollar"></i>'+(+row.total_amount).toFixed(2);
        },
        "orderable": false, "searchable":false
      },  

      {
         data : 'withdraw_reqeust_status',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.withdraw_reqeust_status == '0')
           {            
             return `<div class="status-pendgt">In Wallet</div>`
           }
           else if(row.withdraw_reqeust_status == '1')
           {            
             return `<div class="status-dispatched">Requested</div>`
           }
           else if(row.withdraw_reqeust_status == '2')
           {
             return `<div class="status-completed">Withdrawn</div>`

           }          
         },
         "orderable": false,
         "searchable":false
       },           
        
      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData();
  });  
 
  $("#table_module").find("thead").append(`<tr>          
          <td>
          <input type="text" name="q_order_no" placeholder="Search" class="input-text column_filter" />
          </td>             
          <td><input type="text" name="q_transaction_id" placeholder="Search" class="input-text column_filter" /></td>    
          <td></td>
           <td>
              <div class="select-style">
                <select class="column_filter frm-select" name="q_withdrawrequest" id="q_withdrawrequest" onchange="filterData();">
                        <option value="">All</option>
                        <option value="0">In Wallet</option>
                        <option value="1">Requested</option>
                        <option value="2">Withdrawn</option>
                </select>
            </div>    
           </td>   
      
      </tr>`);

   // <td><input type="text" name="q_price" placeholder="Search" class="input-text column_filter" /></td>

  $('input.column_filter').on( 'keyup click', function () 
  {
       filterData();
  });
  });

  function filterData()
  {
    table_module.draw();
  }

  function withdraRequest(msg) {
    var msg = msg || false;

    var module_url_path = "{{ $module_url_path }}";
    var wallet_amount = '{{ $wallet_amount or ''}}';
    var refund_balance_amount = '{{ $refund_balance_amount or ''}}';
    var referal_wallet_amount = '{{ $referal_wallet_amount or '' }}';

    var seller_id = '{{ $seller_id or ''}}';
    var min_seller_amt = '{{ config('app.project.seller_min_withdraw_amount') }}';

    var checkwalletamt = parseFloat(wallet_amount) + parseFloat(referal_wallet_amount);

   // if(wallet_amount == '' || wallet_amount == '0')
    if(checkwalletamt == '' || checkwalletamt == '0')
    {
      swal('Alert!','Insufficient funds in your wallet.');
      return false;
    }
    // alert(wallet_amount)
    if((refund_balance_amount != '0') && parseFloat(refund_balance_amount)>parseFloat(wallet_amount))
    {
      rembal_uncleared = parseFloat(refund_balance_amount) - parseFloat(wallet_amount);
      swal('Alert!','You have $'+refund_balance_amount+' uncleared refund amount. Add $'+rembal_uncleared+' more to clear it first !');
      return false;
    }

    if(seller_id == '' || seller_id == '0')
    {
      swal('Alert!','Something went wrong');
      return false;
    }
    
    // if(parseFloat(wallet_amount) <= parseFloat(min_seller_amt))
    if(parseFloat(checkwalletamt) <= parseFloat(min_seller_amt))
    {
      swal('Alert!','You can not withdraw less than $'+min_seller_amt);
      return false;
    }


    swal({
          title: msg,
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#5cc970",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
            $.ajax({
              url:module_url_path+'/withdraw_request',
              type:'POST',
              data:{_token:'{{csrf_token()}}',wallet_amount:wallet_amount,seller_id:seller_id,referal_wallet_amount:referal_wallet_amount},
              dataType:'json',
              beforeSend: function() {
                showProcessingOverlay();
              },
              success: function(response)
              {
                hideProcessingOverlay();   
                if(response.status=='success'){
                  swal({
                       title: "Success!",
                       text: response.description,
                       type: response.status,
                       confirmButtonText: "OK",
                       closeOnConfirm: false
                    },
                   function(isConfirm,tmp)
                   {
                     if(isConfirm==true)
                     {
                        window.location = window.location.href;
                     }
                   });
                }
                else
                {
                  // sweetAlert('Error','Something went wrong!','error');
                  swal('error',response.description,'error');
                }  
              }
            });   
          }
        });

  }
  
</script>

@endsection