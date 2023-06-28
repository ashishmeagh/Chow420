@extends('buyer.layout.master')
@section('main_content')
 
 <style>
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

    td:nth-of-type(1):before { content: "Order No"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(2):before { content: "Transaction ID";  font-family: 'nunito_sansbold';}
    td:nth-of-type(3):before { content: "Date"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(4):before { content: "Price ($)"; font-family: 'nunito_sansbold'; }
    td:nth-of-type(5):before { content: "Status";  font-family: 'nunito_sansbold';}
  }

  .status-pendgt
  {
    background-color: #ccc8c1;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    color: #fff;
  }

 </style>
<div class="my-profile-pgnm">
  {{isset($page_title)?$page_title:''}}
    <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}">Home</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Wallet (Chowcash)</li>
    </ul>
</div>
<div class="chow-homepg">Chow420 Home Page</div>
<div class="new-wrapper">
    <div class="order-main-dvs table-order space-none-order-div">


      <div class="selr-wlts-head rw-selr-wlts-head flexnone">

       
        <div class="wallet-totl" title="">
         <div class="shippedorder-yellow">(Pending)</div>
         <div class="icon-wallets">
            <img src="{{ url('/') }}/assets/seller/images/wallet-inprogress .png" alt="">
          </div>
          <div class="inprogress-amount">           
            <span>$</span>{{ $pending_wallet_amount or '' }} 
          </div>
          <div class="clearfix"></div>             
          <div class="pointstxt-innr yellow-foter">Unshipped referrals</div>
        </div>


        <div class="wallet-totl" title="">
          <div class="shippedorder-green">(Settled)</div>
          <div class="icon-wallets">
            <img src="{{ url('/') }}/assets/seller/images/wallet-icon-seller-pg.png" alt="">
          </div>
          <div class="price-wallet"><span>$</span> {{ $remain_wallet_amount or '' }}
          </div>
          <div class="clearfix"></div>          
          <div class="pointstxt-innr greenm-foter">Shipped referrals, refunds and completed reviews. You can now apply this to future orders</div>
      </div>




      <!------------wallet icon---------------------->
      <!-- <div class="selr-wlts-head rw-selr-wlts-head">
        {{-- <div class="wallet-totl wallet-buyers-panel col-lg-3 col-md-3 col-sm-12" title="">
         <div class="shippedorder-yellow">Total Collected Wallet Amount</div>
         <div class="icon-wallets">
            <img src="{{ url('/') }}/assets/seller/images/wallet-inprogress.png" alt="">
          </div>
          <div class="inprogress-amount">           
            <span>$</span> {{ $total_wallet_amount or '' }} 
              
          </div>
          <div class="clearfix"></div>    
         
        </div> --}}
       
        <div class="wallet-totl" title="">
           <div class="shippedorder-yellow">(Pending)</div>
        {{--  <div class="shippedorder-yellow">Total Collected Wallet Amount</div> --}}
         <div class="icon-wallets">
            <img src="{{ url('/') }}/assets/seller/images/wallet-inprogress.png" alt="">
          </div>
          <div class="inprogress-amount">           
            <span>$</span> {{ $pending_wallet_amount or '' }} 
              
          </div>
          <div class="clearfix"></div>            
        </div>
        <span>Unshipped referrals</span>


        {{-- <div class="wallet-totl wallet-buyers-panel col-lg-3 col-md-3 col-sm-12" title="">
         <div class="shippedorder-yellow">Used Wallet Amount</div>
         <div class="icon-wallets">
            <img src="{{ url('/') }}/assets/seller/images/wallet-inprogress.png" alt="">
          </div>
          <div class="inprogress-amount">           
            <span>$</span> {{ $used_wallet_amount or '' }} 
              
          </div>
          <div class="clearfix"></div>          
        </div> --}}
     
        <span>(Settled)</span>
         <div class="wallet-totl wallet-buyers-panel col-lg-3 col-md-3 col-sm-12" title="">
          {{--  <div class="shippedorder-yellow">Remaining Wallet Amount</div> --}}
           <div class="icon-wallets">
              <img src="{{ url('/')}}/assets/seller/images/wallet-icon-seller-pg.png">
            </div>
            <div class="inprogress-amount">           
              <span>$</span> {{ $remain_wallet_amount or '' }} 
                
            </div>
            <div class="clearfix"></div>          
          </div>
          <span>Shipped referrals, refunds and completed reviews. You can now apply this to future orders</span>

         </div> -->
      </div>



     <span> NOTE: Settled funds in your wallet can only be applied to future transactions at checkout</span><br/><br/>
      <!-----------wallet icon----------------------->


      <div class="table-responsive">
            <table class="table seller-table" id="table_module">
              <thead>
                  <tr>
                      <th>Type</th>
                      <th>Amount For</th>
                      <th>Amount($)</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
          </table>
      </div>
      <div class="pagination-chow pagination-bottom-space">
            {{-- {{$arr_pagination->render()}} --}}
      </div>
    </div>
</div>

<script type="text/javascript"> 
var module_url_path  = "{{ $module_url_path or '' }}";  </script>

<script type="text/javascript">
    var table_module = false;


    $(document).ready(function()
    {
      
      table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
      bFilter: false,
      //"order":[3,'Asc'],

      ajax: {
      'url': module_url_path+'/get_buyer_wallet',
      'data': function(d)
       {        
          d['column_filter[q_type]']     = $("input[name='q_type']").val()         
          d['column_filter[q_amount]'] = $("input[name='q_amount']").val()
          d['column_filter[q_orderno]'] = $("input[name='q_orderno']").val()
         
       }
      },

      columns: [
      {
        render(data, type, row, meta)
        {
             return row.type;
        },
        "orderable": false, "searchable":false
      },               
                   
      {data: 'typeid', "orderable": false, "searchable":false},       
      {data: 'amount', "orderable": false, "searchable":false}, 
      {
         data : 'status',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.status == '0')
           {            
             return `<div class="status-pendgt">Pending</div>`
           }
           else if(row.status == '1')
           {            
             return `<div class="status-completed">Credited</div>`
           }
           else if(row.status == '2')
           {
             return `<div class="status-shipped">Debited</div>`

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
  /*search box*/
  // <input type="text" name="q_order_date" placeholder="Search" onchange="filterData();" class="input-text datepicker" />
  


   $("#table_module").find("thead").append(`<tr>          
          <td></td>             
         <td><input type="text" name="q_orderno" placeholder="Search" class="input-text column_filter" /></td>
          <td><input type="text" name="q_amount" placeholder="Search" class="input-text column_filter" /></td>           
           

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
@endsection