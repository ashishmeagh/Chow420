 
<?php $__env->startSection('main_content'); ?>
  
<style>
  .table > tbody > tr > td {
    vertical-align: middle;
    white-space: normal;
    font-size: 15px;
}
  .select-style select{font-size: 14px;}
  .search-header{display: none;}
  body table.dataTable {
    clear: both;
    margin-top: 6px !important;
    margin-bottom: 6px !important;
    max-width: 100% !important;
}
.completedmodl .ordr-calltnal-title{
font-size: 22px;    line-height: 28px;
} 
.completedmodl .okbuttons{
  margin-top: 40px;
}
.completedmodl .okbuttons .btns-pending{
  display: inline-block;
    text-align: center;
    color: #666;
    font-size: 14px;
    border: 1px solid #666;
    padding: 8px 30px;
    border-radius: 3px;
}
.completedmodl .okbuttons .btns-pending:hover{
  color: #fff;
  background-color: #873dc8;
}
.modal-dialog.ordercancellationmodal.completedmodl {
    max-width: 400px;
}
.prodname{
  width: 120px;
}



  @media
    only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {
    table, thead, tbody, th, td, tr {
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

    td:nth-of-type(2):before { content: "Container"; }
    td:nth-of-type(3):before { content: "Title"; }
/*    td:nth-of-type(4):before { content: "Description"; }
*/    
    td:nth-of-type(7):before { content: "Status"; }
    td:nth-of-type(9):before { content: "Action"; }
  }


</style>

<div class="my-profile-pgnm">
     Forum Posts

    <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li> Forum Posts</li>
    </ul>
</div>


<div class="new-wrapper">
  <div class="button-list-dts myproduct-mrg">

    
  
  </div>
     
  <div class="myproductstbls">
    <div class="table-responsive">
       <table class="table seller-table" id="table_module">
           <thead>
               <tr>
                   <th>Container</th>
                     <th>Title</th>
               
                   <th>Type</th>
                   <th>Status</th>
                   <th class="text-center" width="200px">Action</th>
               </tr>
           </thead>
           <tbody>           
           </tbody>
       </table>
      </div>
  </div>




</div>



<script type="text/javascript">

       function confirm_delete(ref,event)
       {
         var delete_param = "Forum Posts";
         confirm_action(ref,event,'Do you really want to delete this forum posts?',delete_param);
       }

        

      $(document).ready(function(){

           $('div.upload-block').find('input[type="file"]').change(function()
            {
              var upload_block = $(this).closest('div.upload-block');
              if($(this).val().length>0)
              {
                $(upload_block).find("div.btn-file-remove").show();

              }

              $(upload_block).find('input.file-caption').val($(this).val());
            });
            

      });

   

    /*************************************/

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
      'url': SITE_URL+'/seller/posts/get_records',
      'data': function(d)
        {
           
          d['column_filter[q_container]']   = $("input[name='q_container']").val()
          d['column_filter[q_title]']       = $("input[name='q_title']").val()
          d['column_filter[q_status]']      = $("select[name='q_status']").val()

       }
      },
      columns: [       
      
       {data: 'container', "orderable": false, "searchable":false},    
      {data: 'title', "orderable": false, "searchable":false}, 
      // {data: 'description', "orderable": false, "searchable":false},  
      {data: 'post_type', "orderable": false, "searchable":false}, 

      {
         data : 'is_active',  
         render : function(data, type, row, meta) 
         { 
           
           if(row.is_active == '0')
           {
            
             return `<div class="status-shipped">Block</div>`

           }
           else if(row.is_active == '1')
           {
             return `<div class="status-completed">Active</div>`

           }          
         },
         "orderable": false,
         "searchable":false
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
   });  
  
   /*search box*/
     $("#table_module").find("thead").append(`<tr class="searchinput-data">
                    <td><input name="q_container" id="q_container" class="column_filter input-text" placeholder="Search"/></td>
                    <td><input name="q_title" id="q_title" class="column_filter input-text" placeholder="Search"/>
                     </td>
                    <td></td>
                     <td><div class="select-style">
                      <select class="column_filter frm-select" name="q_status" id="q_status" onchange="filterData();">
                           
                            <option value="-1">All</option>
                            <option value="0">Block</option>
                            <option value="1">Active</option>
                      </select></div>
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

</script>




<div class="modal fade" id="post_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="id" id="id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel" align="center">Description</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
          <span id="showmessage"></span>
         
      </div><!------body div end here------------->
       <div class="modal-footer">      
        <button type="button" class="btn btn-default" id="closebtn" data-dismiss="modal" aria-label="Close">Close</button>
       </div>
    </div>
   </div> 
</div>



<!-----------------------post title modal-------------------------->

<div class="modal fade" id="title_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog mypostmain-dialog" role="document">
    <input type="hidden" name="id" id="id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Post Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="descriptionmdl-body" id="viewdetails">
          <span id="showtitle"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
       <!-- <div class="modal-footer">      
          <button type="button" class="butn-def" id="closebtn" data-dismiss="modal" aria-label="Close">Close</button>
       </div> -->
    </div>
   </div> 
</div>
<!-----------------end post title modal--------------------------------->



<script type="text/javascript">
  
  $(document).on('click','.readmorebtn',function(){
     var desc = $(this).attr('description');
     if(desc)
     {
        $("#post_sectionmodal").modal('show');
        $("#showmessage").html(desc);
     }

  });



  $(document).on('click','.readmorebtnoftitle',function(){
     var title = $(this).attr('settitle');
     
     if(title)
     {
        $("#title_sectionmodal").modal('show');
        $("#showtitle").html(title);
     }

  }); 




</script>

 <?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>