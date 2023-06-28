                  

  <?php $__env->startSection('main_content'); ?>
  <!-- BEGIN Page Title -->
  <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">

  <script src="<?php echo e(url('/')); ?>/vendor/ckeditor/ckeditor/ckeditor.js"></script>  
  <style type="text/css">
  
  </style>
<!-- Page Content -->
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">
                      <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                      <li class="active">Manage <?php echo e(isset($module_title) ? $module_title : ''); ?></li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
         
         
 
    <div class="row">

      <div class="col-sm-12">

          <div class="white-box">
                        <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                         <form class="form-horizontal" id="frm_manage" method="POST" action="<?php echo e(url($module_url_path.'/multi_action_state')); ?>">
                          <?php echo e(csrf_field()); ?>



                         <div class=" pull-right" >
                            <a href="<?php echo e(url($module_url_path.'/create_state/'.$enc_id)); ?>" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add More"><i class="fa fa-plus"></i> </a> 

                             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Unlock"><i class="ti-unlock"></i></a> 

                              <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Lock"><i class="ti-lock"></i> </a> 

                           
                            <a class="btn btn-inverse waves-effect waves-light" href="<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                             
                             
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
                                                <input class="checkboxInputAll" id="checkbox0" type="checkbox">
                                                <label for="checkbox0">  </label>
                                              </div>
                                          </th>                                            
                                          <th>State Name</th>
                                          <th>State Abbrevation</th>
                                          <th>Status</th>
                                          <th>Documents Required</th>
                                          <th>Is Buyer Restricted</th>
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

      <!------------------start of document required modal----------------------------------->
<div class="modal fade" id="document_required_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="state_id" id="state_id" value="">
    <input type="hidden" name="ref" id="ref" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Required Documents</h5>
        <button type="button" class="close close_doc_listing_modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Enter comma seperated list of required documents&nbsp;<i class="red">*</i></div>  
          <textarea id="req_doc" name="req_doc" rows="5" class="form-control"></textarea>
          <span id="err_req_doc"></span>
      </div>  <!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger docreqbtn" id="docreqbtn">Save</button>
      </div>
    </div>
  </div>
</div>
<!-------------------end of documents required modal------------------------------------->


<!------------------start of required documents listing modal----------------------------------->
<div class="modal fade" id="required_documents_listing_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="state_id" id="state_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Required Documents</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row">
          <div class="title-imgd" id="doc_list">
          </div>  <!------row div end here------------->         
      </div><!------body div end here------------->
    </div>
  </div>
</div>
</div>
<!------------------end of required documents listing modal----------------------------------->


<!-----------------------------model for restricted state--------------------------------->

<div class="modal fade" id="state_restricted_model" tabindex="-1" role="dialog" aria-labelledby="StateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <form id="state_restricted_form">
    <?php echo e(csrf_field()); ?>


      <input type="hidden" name="restricted_state_id" id="restricted_state_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="StateModalLabel" align="center">Restricted State Text</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body admin-modal-new">
          <div class="title-imgd">
            
             <label>Add Text</label>
             <textarea rows="5" name="state_restricted_text" id="state_restricted_text" class="form-control" data-parsley-required-message="Please enter text" data-parsley-required="true" placeholder="Enter text"></textarea>

            

          </div>  <!------row div end here------------->         
      <!------body div end here------------->
      <div class="clearfix"></div>
        <button type="button" class="btn btn-info" id="btn_text_add">Add</button>
    

    </div>
  </div>
  </form>
</div>
</div>


<!-- ---------------------------------------------------------------------------------------->
      

<!-- END Main Content -->



<script type="text/javascript">

  var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>";

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
      'url':'<?php echo e($module_url_path.'/get_states/'.$enc_id); ?>',
      'data': function(d)
        {
          
          d['column_filter[q_name]']          = $("input[name='q_name']").val()
          d['column_filter[q_tax_percentage]']= $("input[name='q_tax_percentage']").val()
          d['column_filter[q_status]']        = $("select[name='q_status']").val()
          d['column_filter[q_documents_required]']        = $("select[name='q_documents_required']").val()

          d['column_filter[q_buyer_restricted]'] = $("select[name='q_buyer_restricted']").val()
       
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
    

      {data: 'name', "orderable": true, "searchable":true},
      {data: 'shortname', "orderable": true, "searchable":true},
     // {data: 'tax_percentage', "orderable": true, "searchable":true},
      

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
          return row.build_documents_required_btn;
        },
        "orderable": false, "searchable":false
      },
      {
        render : function(data, type, row, meta) 
        {
          return row.build_buyer_restricted_btn;
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

      $("input.toggleSwitch_doc").change(function(){
          docstatusChange($(this));
          
       }); 

       $("input.toggleSwitch_buyerrestricted").change(function(){
          buyer_restricted_statusChange($(this));
          
       });    

      $("input.is_visible").change(function(){
          
          statusIsVisible($(this));
       });  

       

    });




    /*search box*/
     $("#table_module").find("thead").append(`<tr>
                   <td></td>
                    <td><input type="text" name="q_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td></td>
                    
                    <td>
                       <select class="search-block-new-table column_filter form-control" name="q_status" id="q_status" onchange="filterData();">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                        </select>
                    </td>


                     <td>
                       <select class="search-block-new-table column_filter form-control" name="q_documents_required" id="q_documents_required" onchange="filterData();">
                        <option value="">Select Documents Status</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        </select>
                    </td>

                    <td>
                       <select class="search-block-new-table column_filter form-control" name="q_buyer_restricted" id="q_buyer_restricted" onchange="filterData();">
                        <option value="">Select Restricted Status</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        </select>
                    </td>
                       
                       
                    <td></td>

                </tr>`);



       $('input.column_filter').on( 'keyup click', function () 
        {
             filterData();
        });

    

  });


 function get_documents_list(state_id="")
 {
      if(state_id!="")
      {  
        $.ajax({
          url:module_url_path+'/get_required_documents',
          type:'GET',
          data:{id:state_id},
          dataType:'json',
          success: function(response)
          {
            if(response.status=='SUCCESS')
            {
              if(response.data)
              {
                  $("#doc_list").html(response.data);
                  $("#required_documents_listing_modal").modal('show');
              }
            }
            else
            {
              sweetAlert('Error','Something went wrong!','error');
            }  
          }
        }); 
     } 

 }

  function filterData()
  {
    table_module.draw();
  }

  function confirm_delete(ref,event)
  {
    var delete_param = "State";
    confirm_action(ref,event,'Do you really want to delete this record?',delete_param);
  }

 
  function statusChange(data)
  {
    var ref = data; 
    var type = ref.attr('data-type');
    var enc_id = ref.attr('data-enc_id');
    var id = ref.attr('data-id');

   
      $.ajax({
        url:module_url_path+'/'+type,
        type:'GET',
        data:{id:enc_id},
        dataType:'json',
        success: function(response)
        {
          if(response.status=='SUCCESS')
          {
            if(response.data=='ACTIVE')
            {
              $(ref)[0].checked = true;  
              $(ref).attr('data-type','deactivate_state');
              swal('Success','Status activated successfully','success');

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','activate_state');
              swal('Success','Status deactivated successfully','success');
            }

            
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
          }  
        }
      });  
  } 

    function docstatusChange(data)
  {
    var ref    = data; 
    var type   = ref.attr('data-type');
    var enc_id = ref.attr('data-enc_id');
    var id     = ref.attr('data-id');


     if(type!="" && type=='documents_required')
     {
         $('#state_id').val(enc_id);  
         $(ref)[0].checked = true;  
         $(ref).attr('data-type','documents_not_required');
         $("#document_required_modal").modal('show'); 
     }
   
     if(type!="" && type=='documents_not_required')
     { 

        swal({
                  title: 'Do you really want to make documents not required for this state?',
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
                        url:module_url_path+'/'+type,
                        type:'GET',
                        data:{id:enc_id},
                        dataType:'json',
                        success: function(response)
                        {
                          if(response.status=='SUCCESS')
                          {
                                
                              $(ref)[0].checked = false;  
                              $(ref).attr('data-type','documents_required');
                              swal('Success','Documents required status deactivated successfully','success');
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
                      $(ref).trigger('click');
                     /* $(ref)[0].checked = true;  
                      $(ref).attr('data-type','documents_required');*/
                  }
               })//end of sweet confirm box  
         }  
  } //end function


function buyer_restricted_statusChange(data)
{ 
      var ref    = data; 
      var type   = ref.attr('data-type');
      var enc_id = ref.attr('data-enc_id');
      var id     = ref.attr('data-id');

      if(type && type=="buyer_restricted")
      { 
         var title = "restrict buyer";
      }
      else
      {
         var title = "unrestrict buyer";
      }
      
      swal({
          title: 'Do you really want to '+title+' for this state?',
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
                url:module_url_path+'/'+type,
                type:'GET',
                data:{id:enc_id},
                dataType:'json',
                success: function(response)
                {
                      if(response.status=='SUCCESS')
                      {
                        if(response.data=='Restricted')
                        {
                          $(ref)[0].checked = false;  
                          $(ref).attr('data-type','buyer_restricted');
                          swal('Success','Buyer for this state is unrestricted successfully','success');


                        }else
                        {
                          $(ref)[0].checked = true;  
                          $(ref).attr('data-type','buyer_unrestricted');
                           swal('Success','Buyer for this state is restricted successfully','success');

                        }

                      }
                      else
                      {
                        sweetAlert('Error','Something went wrong!','error');
                      }  
                              
                }//success
              }); 
          }
          else
          {
              $(ref).trigger('click');
          }

       })//end of sweet confirm box 
        
}//buyer restricted state




/*  function buyer_restricted_statusChange(data)
  { 
      var ref    = data; 
      var type   = ref.attr('data-type');
      var enc_id = ref.attr('data-enc_id');
      var id     = ref.attr('data-id');

      if(type && type=="buyer_restricted")
      { 
        
        var title = "restrict buyer";

        $("#restricted_state_id").val(enc_id);

        $("#state_restricted_model").modal('show');


      }else{
        var title = "unrestrict buyer";

         swal({
          title: 'Do you really want to '+title+' for this state?',
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
                url:module_url_path+'/'+type,
                type:'GET',
                data:{id:enc_id},
                dataType:'json',
                success: function(response)
                {
                      if(response.status=='SUCCESS')
                      {
                        if(response.data=='Restricted')
                        {
                          $(ref)[0].checked = false;  
                          $(ref).attr('data-type','buyer_restricted');
                          swal('Success','Buyer for this state is unrestricted successfully','success');


                        }else
                        {
                          $(ref)[0].checked = true;  
                          $(ref).attr('data-type','buyer_unrestricted');
                           swal('Success','Buyer for this state is restricted successfully','success');

                        }

                      }
                      else
                      {
                        sweetAlert('Error','Something went wrong!','error');
                      }  
                              
                }//success
              }); 
          }
          else
          {
              $(ref).trigger('click');
            
          }
       })//end of sweet confirm box 
      }

  }//buyer restricted state*/





  /*is visible*/
  function statusIsVisible(data)
  {
    var ref = data; 
    var type = ref.attr('data-type');
    var enc_id = ref.attr('data-enc_id');
    var id = ref.attr('data-id');

   
      $.ajax({
        url:module_url_path+'/'+type,
        type:'GET',
        data:{id:enc_id},
        dataType:'json',
        success: function(response)
        {
          if(response.status=='SUCCESS')
          {
            if(response.data=='VISIBLE')
            {
              $(ref)[0].checked = true;  
              $(ref).attr('data-type','deactivate');

            }else
            {
              $(ref)[0].checked = false;  
              $(ref).attr('data-type','activate');
            }

            swal('Success','Status change successfully','success');
          }
          else
          {
            sweetAlert('Error','Something went wrong!','error');
          }  
        }
      });  
  } 

// $("input.checkboxInputAll").click(function()
// {
//     if($('#checked_record_all').is(':checked'))
//     {
//        $("input.checkboxInput").prop('checked',true);
//     }
//     else
//     {
//       $("input.checkboxInput").prop('checked',false);
//     }
// });


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

       $(document).on("click","#rejectdocbutton",function() {
      var user_id = $("#user_id_doc").val();
      var approve_verification_status = $("#approve_verification_status").val();
      $("#seller_id").val(user_id);
      $("#reject_document_sectionmodal").modal('show');
      $("#view_document_section").modal('hide');  
    });     
  
  //function to reject doc
 $(document).on("click",".docreqbtn",function() {
      
      var state_id = $("#state_id").val();
      var req_doc  = $("#req_doc").val();

      if(req_doc=="")
      {
        $("#err_req_doc").html('Please enter required documents.');
        $("#err_req_doc").css('color','red');
      }else{
         $("#err_req_doc").html('');
          if(state_id && req_doc)
          { 
            swal({
                  title: 'Do you really want to make these documents required for this state?',
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
                            url: module_url_path+'/save_required_documents',
                            type:"GET",
                            data: {state_id:state_id,req_doc:req_doc},             
                            dataType:'json',
                            beforeSend: function()
                            {  
                              showProcessingOverlay();             
                            },
                            success:function(response)
                            {
                               hideProcessingOverlay(); 
                                  if(response.status == 'SUCCESS')
                                      { 
                                          $(ref).attr('data-type','documents_required');
                                          swal('Success','Documents required status activated successfully','success');
                                          $("#document_required_modal").modal('hide');
                                          setTimeout(function(){  window.location.reload(); }, 2000);
                                      }
                                      else
                                      {                
                                        swal('Error',response.description,'error');
                                      }  
                            }  
                         }); 
                  }
               })//end of sweet confirm box

           } //if user id and note
      } //else    
    }); 


 $(".close_doc_listing_modal").click(function()
 {
    filterData();
 });


 
  $('#btn_text_add').click(function()
  {
      //var csrf_token = $("input[name=_token]").val(); 

      var csrf_token = $("input[name=_token]").val(); 

      //var type = 'restrict buyer';

      if($('#state_restricted_form').parsley().validate()==false) return;

      formdata = new FormData($('#state_restricted_form')[0]);
    
      $.ajax({
                  
          url: module_url_path+'/add_restricted_text',
      
          data:formdata,
          contentType:false,
          processData:false,
          method:'POST',
          cache: false,
          dataType:'json',
          beforeSend: function() {
            showProcessingOverlay();
          },
          success:function(data)
          {
            hideProcessingOverlay(); 

            if('success' == data.status)
            {
               $("#state_restricted_model").modal('hide');
               
                $('#state_restricted_form')[0].reset();

                  swal({
                         title: 'Success',
                         text: data.description,
                         type: data.status,
                         confirmButtonText: "OK",
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
            else
            {
              swal('Alert!',data.description,data.status);
            }

          }
          
        });   

    });




</script>


<?php $__env->stopSection(); ?>                    



<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>