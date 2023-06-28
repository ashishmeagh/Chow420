  @extends('admin.layout.master')                

  @section('main_content')
  <!-- BEGIN Page Title -->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css"> 
    <style>
      .readmorebtndecode.btn.btn-default, .readmorebtnanswerdecode.btn.btn-default, .readmorebtnanswer.btn.btn-default, .readmorebtn.btn.btn-default{background: transparent  !important;padding: 0 10px !important; border: none  !important; text-decoration: underline !important; color: #797979 !important;
     font-size: 13px !important;}
     .readmorebtndecode.btn.btn-default:hover, .readmorebtnanswerdecode.btn.btn-default:hover, .readmorebtnanswer.btn.btn-default:hover, .readmorebtn.btn.btn-default:hover{
      color: #333 !important; background: transparent  !important;  padding: 0 10px !important;
    border: none  !important; text-decoration: none !important; }
      .readmorebtndecode.btn.btn-default:focus, .readmorebtnanswerdecode.btn.btn-default:focus, .readmorebtnanswer.btn.btn-default:focus, .readmorebtn.btn.btn-default:focus{color: #333 !important; background: transparent  !important;  padding: 0 10px !important; border: none  !important; text-decoration: none !important;     }
      /*.readmorebtndecode.btn.btn-default b {font-weight: normal;}*/
    </style>
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
                             <a href="{{ url($module_url_path.'/create') }}" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add More"><i class="fa fa-plus"></i> </a> 
                            
                               <a href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Activate"><i class="ti-unlock"></i> </a> 

                                <a href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Deactivate"><i class="ti-lock"></i> </a> 

                             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 

                             <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
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
                                            <input type="checkbox" name="checked_record" id="checked_record_all" class="checkboxInputAll" type="checkbox"/><label for="checked_record_all"></label>
                                        </div>
                                          </th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
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




  var module_url_path  = "{{ $module_url_path or ''}}"; 

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
          d['column_filter[q_category]']  = $("input[name='q_category']").val()
          d['column_filter[q_status]']    = $("select[name='q_status']").val()

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

      {data: 'category', "orderable": true, "searchable":false},
      
      {
       render : function(data, type, row, meta) 
       {
         return row.build_status_btn;
       },
       "orderable": false, "searchable":false
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
          featured_brand($(this));
       });   
   
    });
 


    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td><input type="text" name="q_category" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    
                    <td>
                      <select name="q_status" id="q_status" class="form-control" onchange="filterData()">
                        <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                      </select>
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

  function confirm_delete(ref,event)
  {
    var delete_param = "Help Center category";
    confirm_action(ref,event,'Do you really want to delete this record?',delete_param);
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


  function statusChange(data)
   {

     swal({
          title: 'Do you really want to update status of this help center category?',
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
           var ref = data; 
           var type = data.attr('data-type');
           var enc_id = data.attr('data-enc_id');
           var id = data.attr('data-id');
           
             $.ajax({
               url:module_url_path+'/'+type,
               type:'GET',
               data:{id:enc_id},
               dataType:'json',
               success: function(response)
               {
                 if(response.status=='SUCCESS'){
                   if(response.data=='ACTIVE')
                   {
                     $(ref)[0].checked = true;  
                     $(ref).attr('data-type','deactivate');
                     sweetAlert('success','Status update successfully','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','activate');
                     sweetAlert('success','Status update successfully','success');
                     location.reload(true);
                    
                   }
                 }
                 else
                 {
                   sweetAlert('Error','Something went wrong!','error');
                 }  
               }
             }); 
          } 
          else{
              $(data).trigger('click');
          }
       })
   } 








</script>

@stop                    


