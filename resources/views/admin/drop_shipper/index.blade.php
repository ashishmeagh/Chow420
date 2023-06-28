    @extends('admin.layout.master')                

    @section('main_content')
    <!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    
<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$page_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                    @php
                     $user = Sentinel::check();
                    @endphp

                    @if(isset($user) && $user->inRole('admin'))
                       <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                    @endif
                      
                    <li class="active">Manage {{$module_title or ''}}</li>
                    
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
                                        <th>
                                        <div class="checkbox checkbox-success">
                                            {{-- <input class="checkboxInputAll" id="checkbox0" type="checkbox">
                                            <label for="checkbox0">  </label> --}}
                                            <input type="checkbox" name="checked_record" id="checked_record_all" class="checkboxInputAll" type="checkbox"/><label for="checked_record_all"></label>
                                        </div>
                                          </th>
                                            
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Product Name</th>
                                            <th>Product Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </form>
          </div>
</div>
</div>
<!-- END Main Content -->

<script type="text/javascript">

  var module_url_path  = "{{ $module_url_path or '' }}";

  /*function show_details(url)
  { 
      window.location.href = url;
  }*/ 

  /*Script to show table data*/

  var table_module = false;

  $(document).ready(function()
  {
      table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
     
      bFilter: false ,
      ajax: {
      'url':'{{ $module_url_path.'/get_records'}}',
      'data': function(d)
        {
          d['column_filter[q_pname]']         = $("input[name='q_pname']").val()
          d['column_filter[q_name]']          = $("input[name='q_name']").val()
          d['column_filter[q_email]']         = $("input[name='q_email']").val()
          d['column_filter[q_price]']         = $("input[name='q_price']").val()
        }
      },
      columns: [
      {
       
        render : function(data, type, row, meta) 
        {
        return '<div class="checkbox checkbox-success"><input type="checkbox" '+
        ' name="checked_record[]" '+  
        ' value="'+row.enc_id+'" id="checkbox'+row.id+'" class="case checkboxInput"/><label for="checkbox'+row.id+'">  </label></div>';
        },
        "orderable": false,
        "searchable":false
      },
      
    
      {data: 'name', "orderable": true, "searchable":false},
      {data: 'email', "orderable": true, "searchable":false},
      {data: 'product_name', "orderable": true, "searchable":false},
      {data: 'price', "orderable": true, "searchable":false}

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

      $("input.toggleSwitch").change(function(){
          statusChange($(this));
       });   

       $("input.toggleSwitchFeatured").change(function(){
          featured_category($(this));
       });   

    });



    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                   
                    <td><input type="text" name="q_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                      <td><input type="text" name="q_email" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                       <td><input type="text" name="q_pname" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>

                      <td><input type="text" name="q_price" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
    

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


  
$("input.checkboxInputAll").click(function()
{
    if($('#checked_record_all').is(':checked'))
    {
       $("input.checkboxInput").prop('checked',true);
    }
    else
    {
      $("input.checkboxInput").prop('checked',false);
    }
});

</script> 

@stop                    


