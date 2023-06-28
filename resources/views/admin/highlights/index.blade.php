@extends('admin.layout.master')                
@section('main_content')
<!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
<!-- Page Content -->
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h4 class="page-title">Manage {{$module_title or ''}}</h4>
      </div>
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



            @if(isset($get_highlights) && count($get_highlights)<=2)
               <a href="{{ url($module_url_path.'/create') }}" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Add Highlight"><i class="fa fa-plus"></i> </a> 
            @endif

            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" class="btn btn-circle btn-success btn-outline show-tooltip" title="Multiple Activate"><i class="ti-unlock"></i></a> 
            <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Block"><i class="ti-lock"></i> </a> 

             <a  href="javascript:void(0);" onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');" class="btn btn-circle btn-danger btn-outline show-tooltip" title="Multiple Delete"><i class="ti-trash"></i> </a> 

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
                            <input type="checkbox" name="checked_record" id="checked_record_all" class="checkboxInputAll" type="checkbox"/><label for="checked_record_all"></label>
                        </div>
                    </th>
                     <th>Image</th>
                     <th>Title</th>
                     <th>Description</th>
                     <th>Status</th>
                     <th>Action</th>
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


<div class="modal fade" id="reject_product_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="hidden_product_id" id="hidden_product_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Reject Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason &nbsp;</div>
          <textarea id="reason" name="reason" class="form-control" rows="5"></textarea>
          <span id="reason_err"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectprodbtn" id="rejectprodbtn">Reject</button>
      </div>
    </div>
  </div> 
</div>


<div class="modal fade" id="remove_from_chows_choice_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="hidden_product_id" id="hidden_product_id_chowschoice" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Remove Product From Chow's Choice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason &nbsp;</div>
          <textarea id="reason_for_removal" name="reason_for_removal" class="form-control" rows="5" data-parsley-required="true" data-parsley-required-message="Please enter reason for removal."></textarea>
          <span id="reason_for_removal_err"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger removeprodbtn" id="removeprodbtn">Remove</button>
      </div>
    </div>
  </div> 
</div>





<!-- END Main Content -->
<script type="text/javascript">
   var module_url_path         = "{{ $module_url_path }}";
   var product_imageurl_path = "{{ $product_imageurl_path}}";
   var base_url = "{{ url('/') }}";

   function show_details(url)
   { 
      
       window.location.href = url;
   } 
   
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
          d['column_filter[q_title]']            = $("input[name='q_title']").val()
          d['column_filter[q_description]']      = $("input[name='q_description']").val()
          d['column_filter[q_status]']           = $("select[name='q_status']").val()
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
      {data: 'image', "orderable": false, "searchable":false}, 
      {data: 'title', "orderable": false, "searchable":false}, 

      {data: 'description', "orderable": false, "searchable":false}, 
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
    
    $("input.toggleSwitch").change(function(){
       statusChange($(this));
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

     $('input.toggleApprove').change(function(){

         if($(this).is(":checked"))
         {
           var status  = 1;
           var status_app_disapp = 'Do you really want to approve status of this product?';
         }
         else
         {
           var status  = 0;
           var status_app_disapp = 'Do you really want to disapprove status of this product?';
         }
         
          var product_id = $(this).attr('data-enc_id');  
                  

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                     // star product approve , disapprove
                     //var product_id = $(this).attr('data-enc_id');  

                    if(status==0)
                    {
                        $("#reject_product_sectionmodal").modal('show');
                        $("#hidden_product_id").val(product_id);

                    }else{ 

                   
                     $.ajax({
                         method   : 'GET',
                         dataType : 'JSON',
                         data     : {status:status,product_id:product_id},
                         url      : module_url_path+'/approvedisapprove',
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
                   // end product approve,disapprove  
                 }//else

               }
             });

      });   



     $('input.toggleChowsChoice').change(function(){

         if($(this).is(":checked"))
         {
           var status  = 1;
           var status_app_disapp = "Do you really want make this product as chow's choice ?";
         }
         else
         {
           var status  = 0;
           var status_app_disapp = "Do you really want to remove this product from chow's choice?";
         }
         
          var product_id = $(this).attr('data-enc_id');  
                  

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {
                     // star product approve , disapprove
                     //var product_id = $(this).attr('data-enc_id');  

                    if(status==0)
                    {
                        $("#remove_from_chows_choice_sectionmodal").modal('show');
                        $("#hidden_product_id_chowschoice").val(product_id);

                    }else{ 

                   
                     $.ajax({
                         method   : 'GET',
                         dataType : 'JSON',
                         data     : {status:status,product_id:product_id},
                         url      : module_url_path+'/toggleChowsChoice',
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
                   // end product approve,disapprove  
                 }//else

               }
             });

      }); // end chows choice button 



     $('input.toggleOutofstock').change(function(){

      toggle_stock_change($(this));

     });

     function toggle_stock_change (ref) {


      if($(ref).is(":checked"))
         {
           var status  = 1;
           var status_app_disapp = "Do you really want make this product as Out of stock?";
         }
         else
         {
           var status  = 0;
           var status_app_disapp = "Do you really want to remove this product from out of stock?";
         }
         
          var product_id = $(ref).attr('data-enc_id');  
                  

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {

                     // star product approve , disapprove
                     //var product_id = $(this).attr('data-enc_id');  
                     $.ajax({
                         method   : 'GET',
                         dataType : 'JSON',
                         data     : {status:status,product_id:product_id},
                         url      : module_url_path+'/toggleOutofstock',
                          beforeSend: function(){    
                           showProcessingOverlay();           
                          },
                         success  : function(response)
                         {     
                           hideProcessingOverlay();                     
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
                   // end product approve,disapprove  
               }
               else
                {
                  $(ref).trigger('click');
                }
             });

     }


   
      
    

   });

   /*search box*/
     $("#table_module").find("thead").append(`<tr>
                    <td></td>
                    <td></td>
                    <td><input type="text" id="q_title" name="q_title" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td><input type="text" id="q_description" name="q_description" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td>
                      <select class="search-block-new-table column_filter small-form-control" name="q_status" id="q_status" onchange="filterData();">
                          <option value="">All</option>
                          <option value="1">Active</option>
                          <option value="0">Block</option>
                      </select>
                    </td>               
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
    var delete_param = "Product";
    confirm_action(ref,event,'Do you really want to delete this Highlight?');
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

  $("input.toggleSwitch").change(function(){
       statusChange($(this));
  });

  function statusChange(data)
   {

     swal({
          title: 'Do you really want to update status of this highlight?',
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
           var ref     = data;  
           var type    = data.attr('data-type');
           var enc_id  = data.attr('data-enc_id');
           var id = data.attr('data-id');

           
             $.ajax({
               url:module_url_path+'/'+type,
               type:'GET',
               data:{id:enc_id},
               dataType:'json',
               success: function(response)
               {
                 if(response.status=='SUCCESS') {
                     sweetAlert('success','Status update successfully','success');
                     location.reload(true);
                 }
                 else
                 {
                   if(response.msg)
                   {               
                    swal({
                      title: response.msg,
                      type: "warning",
                      confirmButtonColor: "#873dc8",
                      confirmButtonText: "Ok",
                      closeOnConfirm: false
                    },
                      function(isConfirm,tmp)
                      {
                        if(isConfirm==true)
                        {  window.location.reload();
                        }
                      })
                    }
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
  
      
</script>


<script>
  
  $(document).on("click",".rejectprodbtn",function() {
      
    var product_id = $("#hidden_product_id").val();
    
    var reason = $("#reason").val();
    if(reason=="")
    {
      $("#reason_err").html('Please enter the reason for rejection');
      $("#reason_err").css('color','red');
    }else{
       $("#reason_err").html('');
        if(product_id && reason)
        { 
      
 
            $.ajax({
                url: module_url_path+'/rejectproduct',
                type:"GET",
                data: {product_id:product_id,reason:reason},             
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
                    swal('Error',response.description,'error');
                  }  
                }  
             }); // end of ajax
      
        } //if user id and note
      } //else    
  });

    $(document).on("click",".removeprodbtn",function() {


    var product_id = $("#hidden_product_id_chowschoice").val();

    var reason     = $("#reason_for_removal").val();

    if(reason=="")
    {
      $("#reason_for_removal_err").html('Please enter the reason for removal');
      $("#reason_for_removal_err").css('color','red');
    }
    else if(reason.length>300)
    {
      $("#reason_for_removal_err").html('Please enter only 300 characters');
      $("#reason_for_removal_err").css('color','red');
    }
    else{
       $("#reason_for_removal_err").html('');
        if(product_id && reason)
        { 
      
 
            $.ajax({
                url: module_url_path+'/removeproduct',
                type:"GET",
                data: {product_id:product_id,reason:reason},             
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
                    swal('Error',response.description,'error');
                  }  
                }  
             }); // end of ajax
      
        } //if user id and note
      } //else    
  });




  $(document).on('click','.showmodalofchowcheck',function(){

     $("#chowcheckmodal").modal('show');
     var countryname = $(this).attr('countryname');
     var statename = $(this).attr('statename');
     var dispensaryname = $(this).attr('dispensaryname');
     var restrictcatgorynames = $(this).attr('restrictcatgorynames');
      $("#countryname").html(countryname); 
      $("#statename").html(statename); 
      $("#dispensaryname").html(dispensaryname); 
      $("#restrictcatgorynames").html(restrictcatgorynames); 
  });




</script>


<div class="modal fade" id="chowcheckmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="id" id="id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div  id="viewdetails">
                <div class="row">
                   <div class="col-md-6">
                    <div class="div-class-ind">
                      <div class="title-imgd newbr imgfroms">Dispensary</div>
                      <div class="id-images" id="dispensaryname"></div>
                      <div class="clearfix"></div>
                    </div>
                   </div>           
               </div>
               <div class="row">
                   <div class="col-md-6">
                    <div class="div-class-ind">
                      <div class="title-imgd newbr imgfroms">Country</div>
                      <div class="id-images" id="countryname"></div>
                      <div class="clearfix"></div>
                    </div>
                   </div>
                   <div class="col-md-6">
                    <div class="div-class-ind">
                      <div class="title-imgd newbr imgfroms">State</div>
                      <div class="img-forntsimg id-images" id="statename"></div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
              </div>
              
              <div class="row">
                   <div class="col-md-12">
                       <div class="div-class-ind">
                          <div class="title-imgd newbr imgfroms">Restricted Categories</div>
                          <div class="id-images" id="restrictcatgorynames"></div>
                          <div class="clearfix"></div>
                        </div>
                   </div>
              </div>


       
        
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
       <div class="modal-footer">      
        <button type="button" class="btn btn-default" id="closebtn" data-dismiss="modal" aria-label="Close">Close</button>
       </div>
    </div>
   </div> 
</div>

<script type="text/javascript">
  function stock_change (ref) {
    
    //checkbox_toggle_stock_change($(this));

       if($(ref).is(":checked"))
         {
           var status  = 1;
           var status_app_disapp = "Do you really want make this product as Out of stock?";
         }
         else
         {
           var status  = 0;
           var status_app_disapp = "Do you really want to remove this product from out of stock?";
         }
         
          var product_id = $(ref).attr('data-enc_id');  
                  

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {

                     // star product approve , disapprove
                     //var product_id = $(this).attr('data-enc_id');  
                     $.ajax({
                         method   : 'GET',
                         dataType : 'JSON',
                         data     : {status:status,product_id:product_id},
                         url      : module_url_path+'/toggleOutofstock',
                          beforeSend: function(){    
                           showProcessingOverlay();           
                          },
                         success  : function(response)
                         {     
                           hideProcessingOverlay();                     
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
                   // end product approve,disapprove  
               }
               else
                {
                  $(ref).trigger('click');
                }
             });
  }
</script>

@stop