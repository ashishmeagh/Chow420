  
    @extends('admin.layout.master')                

    @section('main_content')
    <!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    <style>
      .table-responsive {
    overflow-y: visible !important; overflow-x: visible !important;
}
@media all and (max-width:1199px){
  .table-responsive {overflow-y: hidden !important; overflow-x: auto !important;}
}
    </style>
<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/users') }}">Users</a></li>
                      <li class="active">{{$module_title or ''}}</li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
        
    <div class="row">

                    <div class="col-sm-12">
                        <div class="white-box">
                          @include('admin.layout._operation_status')
                         <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url($module_url_path.'/multi_action') }}">
                          {{ csrf_field() }}
                         <div class=" pull-right" >                            
                             <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a> 
                           </div>
                           <br>
                           <br>
                            <div class="table-responsive">
                            <input type="hidden" name="multi_action" value="" />
                                <table id="table_module" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Buyer Name</th>
                                            <th>Trade Reference</th>                    
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            </form>
                        </div>
                    </div>                    
          </div>
</div>
</div>
<!-- END Main Content -->
<input type="hidden" id="module_url_path" value="{{$module_url_path or ''}}">
<input type="hidden" id="seller_id" value="{{$seller_id or ''}}">

<script type="text/javascript">
  var module_url_path  = $('#module_url_path').val();
  var seller_id          = $('#seller_id').val();  
  var table_module = false;

  $(document).ready(function()
  {
      table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
      
      bFilter: false ,
      ajax: {
      'url':module_url_path+'/get_seller_rating_records',
      'data': function(d)
        {
          d['column_filter[q_buyer_name]']   = $("input[name='q_buyer_name']").val(),
          d['column_filter[q_trade_ref]']    = $("input[name='q_trade_ref']").val(),
          d['column_filter[q_rating]']       = $("select[name='q_rating']").val(),
          d["seller_id"]                     = seller_id         
        }
      },
      columns: [
      
      {data: 'user_name', "orderable": false, "searchable":false},
      {data: 'trade_ref', "orderable": false, "searchable":false},            
      {
        render : function(data, type, row, meta) 
        {
          var x;
          var starNumber = row.points;
          var rating = '';
          
          if(row.points==0.5){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star-half-o active-star"></i> 
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                      </span>`;
          }       
          else if(row.points==1){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star"></i>  
                        <i class="fa fa-star"></i>  
                        <i class="fa fa-star"></i>  
                        <i class="fa fa-star"></i>                          
                      </span>`;
          }else if(row.points==1.5){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i title="" class="fa fa-star-half-o active-star"></i>                        
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                      </span>`;
          }else if(row.points==2){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                      </span>`;
          }else if(row.points==2.5){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star-half-o active-star"></i>                 
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                      </span>`;
          }else if(row.points==3){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star active-star"></i> 
                        <i class="fa fa-star active-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                      </span>`;
          }else if(row.points==3.5){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star active-star"></i> 
                        <i class="fa fa-star active-star"></i>
                        <i class="fa fa-star-half-o active-star"></i>
                        <i class="fa fa-star"></i>
                      </span>`;
          }else if(row.points==4){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star active-star"></i> 
                        <i class="fa fa-star active-star"></i>
                        <i class="fa fa-star active-star"></i>
                        <i class="fa fa-star"></i>
                      </span>`;
          }else if(row.points==4.5){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star active-star"></i> 
                        <i class="fa fa-star active-star"></i>
                        <i class="fa fa-star active-star"></i>
                        <i class="fa fa-star-half-o active-star"></i>
                      </span>`;
          }else if(row.points==5){
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star active-star"></i>  
                        <i class="fa fa-star active-star"></i> 
                        <i class="fa fa-star active-star"></i>
                        <i class="fa fa-star active-star"></i>
                        <i class="fa fa-star active-star"></i>
                      </span>`;
          }else{
            rating += `<span class="star-defualt-table">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                      </span>`;
          }

          return rating;
        },  
        "orderable": false, "searchable":false      
      }        
      ]
    });

    $('input.column_filter').on( 'keyup click', function () 
    {
        filterData();
    });

    $('#table_module').on('draw.dt',function(event)
    {
      var oTable = $('#table_module').dataTable();
      var recordLength = oTable.fnGetData().length;
      $('#record_count').html(recordLength);

      var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
           new Switchery($(this)[0], $(this).data());
        });     
    });

    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td><input type="text" name="q_buyer_name" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    <td><input type="text" name="q_trade_ref" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
                    <td><select class="search-block-new-table column_filter small-form-control" name="q_rating" id="q_rating" onchange="filterData();">
                        <option value="">All</option>
                        <option value="0.5">0.5</option>
                        <option value="1">1</option>
                        <option value="1.5">1.5</option>
                        <option value="2">2</option>
                        <option value="2.5">2.5</option>
                        <option value="3">3</option>
                        <option value="3.5">3.5</option>
                        <option value="4">4</option>
                        <option value="4.5">4.5</option>
                        <option value="5">5</option>
                        </select>
                    </td></tr>`);

       $('input.column_filter').on( 'keyup click', function () 
        {
             filterData();
        });


  });

  function filterData()
  {
    table_module.draw();
  }

  function confirm_approve(ref,event)
  {
      confirm_action(ref,event,'Do you really want to Approve this record');
  } 
</script>

@stop                    


