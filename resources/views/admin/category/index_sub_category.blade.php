    @extends('admin.layout.master')                    
    @section('main_content')

    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/data-tables/latest/dataTables.bootstrap.min.css">
    <!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">{{$module_title or ''}}</h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                    
                      <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
                      <li ><a href="{{$module_url_path or ''}}" >Categories</a></li>
                      <li class="active">{{$module_title or ''}}</li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>

    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-sm-12">

          <div class="white-box">
          @include('admin.layout._operation_status')
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url($module_url_path.'/multi_action') }}">

            {{ csrf_field() }}

            <div class="col-md-10">
            
          </div>
          <div class="pull-right">
            <a href="{{ url($module_url_path.'/create/'.base64_encode($parent_id)) }}" class="btn btn-outline btn-info btn-circle show-tooltip" title="Add New Sub Category"><i class="fa fa-plus"></i></a> 
            
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 

            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 

            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip" title="Refresh"><i class="fa fa-refresh"></i> </a>
          </div>
 
           <div class="clearfix"></div>
           <br>
          <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="table1" >
              <thead>
                <tr>
                  <th>
                     <div class="checkbox checkbox-success">
                        <input id="checkbox3" type="checkbox">
                        <label for="checkbox3">  </label>
                      </div>
                  </th>
                  <th>Category</th>
                  <th>Status</th> 
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
        
                @if(sizeof($arr_category)>0)
                  @foreach($arr_category as $category)
                  <tr>
                    <td> 
                      <div class="checkbox checkbox-success">
                         <input type="checkbox" name="checked_record[]" value="{{ base64_encode($category['id']) }}" class="case"/><label for="checkbox3">  </label>
                      </div>
                       
                    </td>
                    <td> {{ $category['category_title'] }} </td> 
                     <td>
                  @if($category['is_active']==1)
                      
                      <input type="checkbox" checked data-size="small"  data-enc_id="{{base64_encode($category['id'])}}"  id="status_{{$category['id']}}" class="js-switch toggleSwitch" data-type="deactivate" data-color="#99d683" data-secondary-color="#f96262" />
                    
                   @else
                      <input type="checkbox" data-size="small" data-enc_id="{{base64_encode($category['id'])}}"  class="js-switch toggleSwitch" data-type="activate" data-color="#99d683" data-secondary-color="#f96262" />
                    </a>
                   @endif

                </td>
                    <td>
                    <a class="btn btn-outline btn-info btn-circle show-tooltip" href="{{ url($module_url_path.'/edit/'.base64_encode($category['id'])) }}" title="Edit"><i class="ti-pencil-alt2"></i></a>
                     
                        &nbsp;  
                        <a class="btn btn-circle btn-danger btn-outline show-tooltip" href="{{ url($module_url_path.'/delete/'.base64_encode($category['id'])) }}"  
                           onclick="confirm_action(this,event,'Are you sure to delete this record?')" 
                           title="Delete">
                          <i class="ti-trash"></i>
                        </a>  
                    </td>
                    
                  </tr>
                  @endforeach
                @endif
                 
              </tbody>
            </table>
          </div>
        <div> </div>
         
          </form>
      </div>
  </div>
</div>

<!-- END Main Content -->
<script type="text/javascript">
function show_details(url)
    { 
       
        window.location.href = url;
    } 

</script>
<script type="text/javascript">
  var module_url_path         = "{{ $module_url_path }}";

  $(document).ready(function(){
   table_module = $('#table1').DataTable({ 
    });

  });

function statusChange(data)
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

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','activate');
            }
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
          }  
        }
      });  
  }

$(function(){

  // add multiple select / deselect functionality
  $("#checkbox3").click(function () {
      $('.case').attr('checked', this.checked);
  });

  // if all checkbox are selected, check the selectall checkbox
  // and viceversa
  $(".case").click(function(){

    if($(".case").length == $(".case:checked").length) {
      $("#checkbox3").attr("checked", "checked");
    } else {
      $("#checkbox3").removeAttr("checked");
    }

  });
});

</script>
@stop                    


