@extends('seller.layout.master')
@section('main_content')


<style type="text/css">
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

     td:nth-of-type(1):before { content: "Name"; }
     td:nth-of-type(2):before { content: "Email"; }  
     td:nth-of-type(3):before { content: "Date"; }
  }
</style>

<div class="my-profile-pgnm">
  Followers
     <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Followers</li>
    </ul>
</div>
    <div class="new-wrapper">
        <div class="order-main-dvs table-order">
            <div class="table-responsive">
                <table class="table seller-table" id="table_module">
                    <thead>
                        <tr>
                            <th>Name</th>
                             <th>Email</th>
                            <th>Date</th>
                        </tr> 
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
    </div>
</div>
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
      "order":[3,'Asc'],

      ajax: {
      'url': module_url_path+'/get_followers',
      'data': function(d)
       {        
          d['column_filter[q_name]'] = $("input[name='q_name']").val()
          d['column_filter[q_email]'] = $("input[name='q_email']").val()
          d['column_filter[q_created_at]']  = $("input[name='q_created_at']").val()
         
          
       }
      },

      columns: [
       {data: 'user_name', "orderable": false, "searchable":false},                              
      {data: 'email', "orderable": false, "searchable":false},         
      {data: 'created_at', "orderable": false, "searchable":false},
     
      {
        render(data, type, row, meta)
        {
             return '';
        },
        "orderable": false, "searchable":false
      },             
    
      
         
      ]
  });

  $('input.column_filter').on( 'keyup click', function () 
  {
      filterData(); 
  });
  /*search box*/
  $("#table_module").find("thead").append(`<tr>          
          <td><input type="text" name="q_name" placeholder="Search" class="input-text column_filter" /></td> 
           <td><input type="text" name="q_email" placeholder="Search" class="input-text column_filter" /></td>   
           <td><input type="text" name="q_created_at" id="datepicker" placeholder="Search" class="input-text column_filter datepicker" onchange="filterData();"/></td>       
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
<link href="{{ url('/') }}/assets/seller/css/jquery-ui.css" rel="stylesheet" type="text/css" />
  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker(
        { dateFormat: 'dd M yy' }
      );
  } );
  </script>





@endsection