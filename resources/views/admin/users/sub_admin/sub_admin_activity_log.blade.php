@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    
    <style>
      .title-imgd.newbr.imgfroms {
    float: none;
}
.id-images{margin-left: 0px;}
.id-images .img-forntsimg{margin-left: 0px;}
.img-forntsimg.id-images{margin-left: 0px;}
.img-forntsimg.id-images .img-forntsimg{margin-left: 0px;}
      .img-forntsimg{margin-left: 110px;word-break: break-all;}
      .title-imgd{float: left;}
      .modal-dialog.maxwdths{
            max-width: 650px;
      }
     .divadrs-class .title-imgd.newbr.imgfroms{display: block;float: none;}
      .divadrs-class .address-inx-age{margin-left: 110px;}
      .chwstatus.text-right.right-side-status{position: static; margin-bottom: 20px;}
    </style>
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">Manage {{$module_title or ''}}</h4>
      </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">
            <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
            <li class="active">Manage {{$module_title or ''}}</li>
         </ol>
      </div>
   </div>
   <!-- BEGIN Main Content -->
   <div class="col-sm-12">
      <div class="white-box">
         @include('admin.layout._operation_status')
         {!! Form::open([ 'url' => $module_url_path.'/multi_action',
         'method'=>'POST',
         'enctype' =>'multipart/form-data',   
         'class'=>'form-horizontal', 
         'id'=>'frm_manage' 
         ]) !!}
         {{ csrf_field() }}
         <div class="pull-right">
           {{--  <a href="{{ $module_url_path.'/create'}}" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add New {{ str_singular($module_title) }}"><i class="fa fa-plus"></i> </a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a>  --}}
            {{--  <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a>   --}}
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
         </div>
         <br/>
         <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                     {{-- <th>
                        <div class="checkbox checkbox-success">
                          <input class="checkboxInputAll" id="checkbox0" type="checkbox">
                          <label for="checkbox0">  </label>
                        </div>
                     </th> --}}
                     <th>Name</th>
                     <th>Title</th>
                     <th>Message</th>
                     <th>Action Performed</th>
                    
                     
                  </tr>
                
              </thead>
              <tbody>
              </tbody>
            </table>
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>

<div class="modal fade" id="report_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="id" id="id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Activity Log Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewdetails">
          <label><b>Message :</b></label>
          <span id="showmessage"></span>
          {{-- <label><b>Link :</b></label>
          <span id="showlink"></span> --}}
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
       <div class="modal-footer">      
        <button type="button" class="btn btn-default" id="closebtn" data-dismiss="modal" aria-label="Close">Close</button>
       </div>
    </div>
   </div> 
</div>


<script>
function myFunction()
{
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
</script>


<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "{{ $module_url_path }}";
   var base_url = "{{ url('/')}}";
 
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
         d['column_filter[q_name]']      = $("input[name='q_name']").val()
         d['column_filter[q_title]']     = $("input[name='q_title']").val()
        
        
       }
     },
     columns: [
 /*    {
       render : function(data, type, row, meta) 
       {
       return '<div class="checkbox checkbox-success"><input type="checkbox" '+
               ' name="checked_record[]" '+  
               ' value="'+row.enc_id+'" id="checkbox'+row.id+'" class="case checkboxInput"/><label for="checkbox'+row.id+'">  </label></div>';
       },
       "orderable": false,
       "searchable":false
     },*/
     {data: 'user_name', "orderable": true, "searchable":false},
     
     {data: 'title', "orderable": true, "searchable":false},
     
     {data: 'message', "orderable": true, "searchable":false},
     
     {data: 'action', "orderable": true, "searchable":false}
  
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

      $('input.toggleTrusted').change(function(){

         if($(this).is(":checked"))
         {
           var status  = 'trusted';
         }
         else
         {
          var status  = 'not-trusted';
         }
         
         var user_id = $(this).attr('data-enc_id');  
        
         $.ajax({
             method   : 'GET',
             dataType : 'JSON',
             data     : {status:status,user_id:user_id},
             url      : module_url_path+'/mark_as_trusted',
             success  : function(response)
             {                         
              if(typeof response == 'object' && response.status == 'SUCCESS')
              {
                swal('Done', response.message, 'success');
              }
              else
              {
                swal('Oops...', response.message, 'error');
              }               
             }
         });
      }); 

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                   
                    <td><input type="text" name="q_name" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>

                    <td></td>

                    <td></td>
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
   
   
  $(function(){
    $("input.checkboxInputAll").click(function(){
       var is_checked = $("input.checkboxInputAll").is(":checked");
      if(is_checked)
      {
         $("input.checkboxInput").prop('checked',true);
      }
      else
      {
        $("input.checkboxInput").prop('checked',false);
      }
     }); 
  });


  $(document).on('click','.readmorebtn',function(){
   var reason = $(this).attr('message');
   var link = $(this).attr('link');
   if(reason)
   {
      $("#report_sectionmodal").modal('show');
      $("#showmessage").html(reason);
     // $("#showlink").html(link);
   }

});


</script>


@stop