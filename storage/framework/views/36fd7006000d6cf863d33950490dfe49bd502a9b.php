                  
  <?php $__env->startSection('main_content'); ?>
  <style>
  .new_dispute{color:red;}
  </style>
  <!-- BEGIN Page Title -->
  <link rel="stylesheet" type="text/css" href="<?php echo e(url('/')); ?>/assets/common/data-tables/latest/dataTables.bootstrap.min.css">
    
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
  .main-leftforms {
    position: relative;
}
.main-leftforms .form-lbls input {
    padding: 5px 10px;
    font-size: 14px;
    border: none;
    background-color: #f1f1f1;
}

.form-lbls input{padding: 5px 10px; font-size: 14px;}
  .lblforms{    display: block;
    margin-bottom: 0px;
    font-size: 14px;}
  .errors-frm{
    position: absolute;
    left: 0px;
    top: 41px;
    font-size: 13px;
    line-height: 14px;
  }
  .status-completed {
    background-color: #009930;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    /* font-family: 'open_sanssemibold'; */
    color: #fff;
}
.status-shipped{
    background-color: #e95151;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    /* font-family: 'open_sanssemibold'; */
    color: #fff;
}
.status-dispatched{
    background-color: #f3ba39;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    /* font-family: 'open_sanssemibold'; */
    color: #fff;
}
.status-shipping{
    background-color: #825c06;
    display: inline-block;
    padding: 3px 13px;
    border-radius: 20px;
    font-size: 12px;
    /* font-family: 'open_sanssemibold'; */
    color: #fff;
}

.space-right-padding{margin-right: 20px;}
.ui-widget.ui-widget-content{ z-index: 9999 !important;}
</style>




<!-- Page Content --> 
  <div id="page-wrapper">
      <div class="container-fluid">
          <div class="row bg-title">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title"><?php echo e(isset($page_title) ? $page_title : ''); ?></h4> </div>
              <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                  <ol class="breadcrumb">

                  <?php
                    $user = Sentinel::check();
                  ?>

                  <?php if(isset($user) && $user->inRole('admin')): ?>

                    <li><a href="<?php echo e(url(config('app.project.admin_panel_slug').'/dashboard')); ?>">Dashboard</a></li>
                    
                  <?php endif; ?>
                      
                      <li class="active">Manage <?php echo e(isset($module_title) ? $module_title : ''); ?></li>
                  </ol>
              </div>
              <!-- /.col-lg-12 -->
          </div>
           
    <div class="row">
      <div class="col-sm-12">
          <div class="white-box">
                        <?php echo $__env->make('admin.layout._operation_status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                         <form class="form-horizontal" id="frm_manage" method="POST" action="<?php echo e(url($module_url_path.'/multi_action')); ?>">
                          <?php echo e(csrf_field()); ?>

                         <div class=" pl-left" >
                

                             <!------------------------------------------------>
                             <div class="main-leftforms">
                              <div class="order-date-dv-cls"><b>Date</b></div>
                                <div class="form-lbls">
                                  <input type="text" class="space-right-padding column_filter" id="from" name="from" placeholder="From Date">
                                  <span class="errors-frm" id="from_err"></span>
                                </div>
                                <div class="form-lbls">
                                    <input type="text" class="column_filter" id="to" name="to" placeholder="To Date">
                                    <span class="errors-frm" id="to_err"></span>
                                </div>
                                 <a href="javascript:void(0)" class="btn btn-info uploads-in searchbtn upld-buttons" title="Search">
                                    <img src="<?php echo e(url('/')); ?>/assets/images/search-icons.svg" onclick="filterrecords();filterData();" alt=""></a>

                            


                               <a href="#" class="btn btn-info uploads-in upld-buttons" id="exportbtncsv" title="Export as csv">
                                <i style="font-size:19px;" class="fa fa-share-square-o" aria-hidden="true"></i>
                              </a>
                              

                               <div class=" pull-right">
                                <a href="javascript:void(0)" onclick="javascript:location.reload();" class="btn btn-outline btn-info btn-circle show-tooltip btn-refresh" title="Refresh"><i class="fa fa-refresh"></i> </a> 
                              </div>
                              </div>

                             

                              <!------------------------------------------------>
                             
                              </div>

                             
                           <br>
                           <br>
                            <div class="table-responsive">
                            <input type="hidden" name="multi_action" value="" />
                                <table id="table_module" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>User Type</th>
                                            <th>Hear About</th>
                                            <th>Date</th>
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

  var module_url_path  = "<?php echo e(isset($module_url_path) ? $module_url_path : ''); ?>"; 

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
      'url':'<?php echo e($module_url_path.'/get_records'); ?>',
      'data': function(d)
        {
          d['column_filter[q_name]']          = $("input[name='q_name']").val()
          d['column_filter[q_hear_about]']    = $("input[name='q_hear_about']").val()
          d['column_filter[q_from]']          = $("input[name='from']").val()
          d['column_filter[q_to]']            = $("input[name='to']").val()
          d['column_filter[q_usertype]']      = $("input[name='q_usertype']").val()

       } 
      },
      columns: [
     
      {data: 'user_name', "orderable": true, "searchable":false},
      {data: 'user_type', "orderable": true, "searchable":false},
      {data: 'hear_about', "orderable": true, "searchable":false},
      {data: 'created_at', "orderable": true, "searchable":false},

      
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
    });



    /*search box*/
     $("#table_module").find("thead").append(`<tr>   
                    <td><input type="text" id="q_name" name="q_name" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td><input type="text" id="q_usertype" name="q_usertype" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
                    <td><input type="text" id="q_hear_about" name="q_hear_about" placeholder="Search" class="search-block-new-table column_filter form-control" /></td>
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



 
<!-- Modal My-Review-Ratings-Add End -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

  var module_url_path = "<?php echo e($module_url_path); ?>"

</script>    


 

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <script>
    var j = jQuery.noConflict();
    j( function() {
        j( "#from" ).datepicker(

            { dateFormat: 'dd M yy' }
          );
    } );

     j( function() {
        j( "#to" ).datepicker(

            { dateFormat: 'dd M yy' }
          );
    } );


   function filterrecords(){

      var from = $("#from").val();
      var to = $("#to").val(); 
      if(from=="")
      {
        $("#from_err").html('Please select from date');
        $("#from_err").css('color','red');
        return false;
      }else{
        $("#from_err").html('');
      }
      if(to=="")
      {
        $("#to_err").html('Please select to date');
        $("#to_err").css('color','red');
        return false;
      }else{
        $("#to_err").html('');
      }
      if(from!="" && to!=""){
         var fromdate = moment(from).format('YYYY-MM-DD');
         var todate = moment(to).format('YYYY-MM-DD');

         if(fromdate>todate)
         {
          $("#from_err").html('From date should not be greater than to date');
          $("#from_err").css('color','red');
          return false;
         }



        return true;
      }else{
        return false;
      }
   }

   $(document).on('click','#exportbtn',function(){
      var from = $("#from").val();
      var to = $("#to").val(); 
      if(from && to)
      {
          var fromdate = moment(from).format('YYYY-MM-DD');
          var todate = moment(to).format('YYYY-MM-DD');
           if(fromdate>todate)
          {
            $("#from_err").html('From date should not be greater than to date');
            $("#from_err").css('color','red');
            return false;
          }else{
            window.location.href = module_url_path+'/exportcsv/'+from+'/'+to;
          }
       
      }
      else
      {
        filterrecords();
      }


      // if(from && to){
      //   window.location.href = module_url_path+'/export/'+from+'/'+to;
      // }else{
      //   filterrecords();
      // }
   });

     $(document).on('click','#exportbtncsv',function(){
      var from = $("#from").val();
      var to = $("#to").val(); 
      if(from && to)
      {
          var fromdate = moment(from).format('YYYY-MM-DD');
          var todate = moment(to).format('YYYY-MM-DD');
           if(fromdate>todate)
          {
            $("#from_err").html('From date should not be greater than to date');
            $("#from_err").css('color','red');
            return false;
          }else{
            window.location.href = module_url_path+'/exportcsv/'+from+'/'+to;
          }
       
      }
      else
      {
        filterrecords();
      }


      // if(from && to){
      //   window.location.href = module_url_path+'/export/'+from+'/'+to;
      // }else{
      //   filterrecords();
      // }
   });


</script>


<?php $__env->stopSection(); ?>                    
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>