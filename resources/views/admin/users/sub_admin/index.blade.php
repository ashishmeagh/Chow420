@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/css/smartphoto.min.css">

    <style>
      .title-imgd.newbr.imgfroms {
    float: none;
}
label.viewchecklist {
    position: relative;
    padding-left: 20px;
}
label.viewchecklist .fa{
    position: absolute;
    left: 0px;
    top: 2px
} 
div#report_sectionmodal{padding-right: 0px;}
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
            <a href="{{ $module_url_path.'/create'}}" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add New {{ str_singular($module_title) }}"><i class="fa fa-plus"></i> </a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 
            {{--  <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a>   --}}
            <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
         </div>
         <br/>
         <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-striped"  id="table_module">
              <thead>
                  <tr>
                     <th>
                        <div class="checkbox checkbox-success">
                          <input class="checkboxInputAll" id="checkbox0" type="checkbox">
                          <label for="checkbox0">  </label>
                        </div>
                     </th>
                     <th>Name</th>
                     {{-- <th>Email</th> --}}
                     <th>Location</th>
                     
                     <th>Status</th>
                     <th>Module Access</th>
                     <th width="200px">Action</th>
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
        <h5 class="modal-title" id="exampleModalLabel" align="center">Module Access</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewdetails">
         
        <div class="row" id="show_modules">
          

        </div>
         
          
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
       <div class="modal-footer">      
        <button type="button" class="btn btn-default" id="closebtn" data-dismiss="modal" aria-label="Close">Close</button>
       </div>
    </div>
   </div> 
</div>



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
         d['column_filter[q_name]']                      = $("input[name='q_name']").val()
         //d['column_filter[q_email]']                     = $("input[name='q_email']").val()
         //d['column_filter[q_user_type]']                 = $("select[name='q_user_type']").val()
         d['column_filter[q_status]']                    = $("select[name='q_status']").val()
         d['column_filter[q_state]']                     = $("input[name='q_state']").val()
         d['column_filter[q_country]']                   = $("input[name='q_country']").val()
        
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
     {data: 'user_name', "orderable": true, "searchable":false},
     
     /*{data: 'email', "orderable": true, "searchable":false},*/
     
    /* {data: 'country_name', "orderable": true, "searchable":false},
     
     {data: 'state_name', "orderable": true, "searchable":false},*/

      {data: 'location', "orderable": true, "searchable":false},

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
             
              if(row.module_count > 0)
              {
                 return '<i class="fa fa-eye" aria-hidden="true" title="View module access permission" data-id="'+row.id+'" onclick="showModules(this);"></i>';
              }
              else
              {
                 return '--';
              }
          
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
                    <td></td>
                    <td><input type="text" name="q_name" placeholder="Search" class="search-block-new-table column_filter small-form-control" /></td>
   
                    <td>
                      
                    </td>
                  
                    <td>
                      <select class="search-block-new-table column_filter small-form-control" name="q_status" id="q_status" onchange="filterData();">

                        <option value="">All</option>
                        <option value="1">Active</option>
                         <option value="0">Block</option>
                       
                      </select>
                    </td>

                    <td>
                     
                    </td>

                </tr>`);



       $('input.column_filter').on( 'keyup click', function () 
        {
             filterData();
        });
   });
   

 // <select class="search-block-new-table column_filter small-form-control" name="q_vstatus" id="q_vstatus" onchange="filterData();">
 //                        <option value="">All</option>
 //                        <option value="1">Active</option>
 //                        <option value="0">Block</option>
 //                        </select>


   function filterData()
   {
   table_module.draw();
   }
   
   function statusChange(data)
   {
       var type = data.attr('data-type');
       var alert_text = 'Do you really want to '+ type + ' this buyer?'
     swal({
          title: alert_text,
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
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
                     sweetAlert('Success!','Sub admin activated successfully.','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','activate');
                     sweetAlert('Success!','Sub admin deactivated successfully.','success');
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
          else
          {
            $(data).trigger('click');
          }
       })
   } 


   function approve_user(ref)
   {  
      swal({
          title: 'Are you sure to approve this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {
              var enc_id = ref.attr('data-enc_id');
              $.ajax({
               url:module_url_path+'/approve',
               type:'GET',
               data:{enc_id:enc_id},
               dataType:'json',
               beforeSend : function()
               { 
                 showProcessingOverlay();        
               },        
               success:function(response)
               {
                  hideProcessingOverlay();
                  
                  swal({
                    title: response.description,
                    type: response.status,
                    showCancelButton: false,
                    confirmButtonColor: "#8d62d5",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                  },
                  function(isConfirm,tmp)
                  {
                    if(isConfirm==true)
                    {
                      location.reload();
                    }
                  });
               }
             });
          }
        });
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





  




</script>


<script>
  //verfiy user email functionalty

 
  $(document).on("click",".verifyuseremailbtn",function() {
      
    var user_id = $("#buyer_id").val();    
    var email = $("#email").val();
   
    if(user_id && email)
    { 
       swal({
          title: 'Do you really want to verify email of this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {

            $.ajax({
                url: module_url_path+'/verifyuseremail',
                type:"GET",
                data: {user_id:user_id,email:email},             
                dataType:'json',
                beforeSend: function(){    
                 showProcessingOverlay();           
                },
                success:function(response)
                {
                  hideProcessingOverlay(); 
                  if(response.status == 'SUCCESS')
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
                      }

                    });
                  }
                  else
                  {                
                    //swal('Error',response.description,'error');

                        swal({
                            title: 'Error',
                            text: response.description,
                            type: 'error',
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                         },
                        function(isConfirm,tmp)
                        {                       
                          if(isConfirm==true)
                          {
                              window.location.reload();
                          }

                        });
                   
                  }//else  
                }  
             }); // end of ajax

            }
          })// end of confirm box

        } //if user id and note
  });

</script>



<script>
  
   //function for resend activation email
    $(document).on("click",".resendactivationemail",function() { 
      var user_id = $(this).attr('user_id');
      var email = $(this).attr('email');
      var completed = $(this).attr('completed');
      var code = $(this).attr('code');

       if(user_id && email)
      { 
        if(completed=="1"){
          swal('','This user is already having verified email .','warning');
        }else{

        swal({
          title: 'Do you really want to send verification email to this user?',
          type: "warning",
          showCancelButton: true,
          // confirmButtonColor: "#DD6B55",
          confirmButtonColor: "#8d62d5",
          confirmButtonText: "Yes, do it!",
          closeOnConfirm: false
        },
        function(isConfirm,tmp)
        {
          if(isConfirm==true)
          {

            $.ajax({
                url: module_url_path+'/sendverificationemail',
                type:"GET",
                data: {user_id:user_id,email:email,code:code,completed:completed},        
                dataType:'json',
                beforeSend: function(){    
                 showProcessingOverlay();           
                },
                success:function(response)
                {
                  hideProcessingOverlay(); 
                  if(response.status == 'SUCCESS')
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
                      }

                    });
                  }
                  else
                  {                
                    //swal('Error',response.description,'error');

                        swal({
                            title: 'Error',
                            text: response.description,
                            type: 'error',
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                         },
                        function(isConfirm,tmp)
                        {                       
                          if(isConfirm==true)
                          {
                              window.location.reload();
                          }

                        });
                   
                  }//else  
                }  
             }); // end of ajax

            }
          })// end of confirm box
       }//else of completed 

     } //if user id and email
         
  });


  function showModules(ref)
  {
      var html = '';
      var user_id = $(ref).attr('data-id');

      $.ajax({
             method   : 'GET',
             dataType : 'JSON',
             data     : {user_id:user_id},
             url      : module_url_path+'/module_access',
             success  : function(response)
             {                         
                $(response).each(function(index) 
                {

                  $("#report_sectionmodal").modal('show');

                   html +='<div class="col-md-4"><label class="viewchecklist"> <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>'
                          +response[index].module_details.module_name+
                         '</label></div>';

                   $('#show_modules').html(html);   

                }); 
             }
      });

  }


</script>


@stop