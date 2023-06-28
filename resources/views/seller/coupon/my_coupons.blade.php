@extends('seller.layout.master') 
@section('main_content')
  
<style>
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
      background: #fff;
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
      padding-left: 50%;     
    }

    td:before {
      position: absolute;
      top: 4px;
      left: 17px;
      width: 45%;font-weight: 600;
      padding-right: 10px; font-size: 12px;
      white-space: nowrap;
    }
    .search-header{display: block;}

    td:nth-of-type(1):before { content: "Product"; }
    td:nth-of-type(2):before { content: "Brand"; }
    td:nth-of-type(3):before { content: "Name"; }
    td:nth-of-type(4):before { content: "Price"; }
    td:nth-of-type(5):before { content: "Age"; }
    td:nth-of-type(6):before { content: "Error Message"; }
    td:nth-of-type(7):before { content: "Status"; }
    td:nth-of-type(8):before { content: "Product Approved / Disapproved Status"; }
    td:nth-of-type(9):before { content: "Action"; }
  }


.modal-content {
    padding: 40px;
}
.ordr-calltnal-title {
    margin-bottom: 90px;
}
.modal-content .btns-pending{
    display: inline-block;
    text-align: center;
    color: #fff;
    font-size: 14px;
    border: 1px solid #873dc8;
    padding: 9px 40px;
    border-radius: 3px;
    background-color: #873dc8;
}
.modal-dialog {
    max-width: 400px;
    width: 100%;
}

</style>


<div class="my-profile-pgnm">
  Coupon codes

    <ul class="breadcrumbs-my">
      <li><a href="{{url('/')}}/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li>Coupon codes</li>
    </ul>
</div>


<div class="new-wrapper">
  <div class="button-list-dts myproduct-mrg">
  
   <a href="{{ url('/') }}/seller/coupon/create" class="butn-def cancelbtnss" style="color: #fff;
    background-color: #873dc8;border-color: #873dc8;">Add Coupon</a> 
   
  </div>
     





  <div class="myproductstbls">
    <div class="table-responsive">
       <table class="table seller-table" id="table_module">
           <thead>
               <tr>
                   <th>Code</th>
                   <th>Type</th>
                   <th>Discount</th>
                   <th>Start Date</th>
                   <th>End Date</th>
                   <th>Make Public</th>
                   <th>Status</th>
                   <th class="text-center">Action</th>
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
         var delete_param = "Product";
         confirm_action(ref,event,'Do you really want to delete this Product?',delete_param);
       }

        function browseImage(ref)
        {
          var upload_block = $(ref).closest('div.upload-block');
          $(upload_block).find('input[type="file"]').trigger('click');
        }

        function removeBrowsedImage(ref)
        {


          var upload_block = $(ref).closest('div.upload-block');
          
          $(upload_block).find('input.file-caption').val("");
          $(upload_block).find("div.btn-file-remove").hide();
          $(upload_block).find('input[type="file"]').val("");
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

    $("#btn-bulk").click(function(){
      if($('#form_import').parsley().validate()==false) return;

         $.ajax({
              
            url: SITE_URL+'/seller/product/importExcel',
            data: new FormData($('#form_import')[0]),
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
              
                $(".modal").removeClass("in");
                $(".modal-backdrop").remove();
                hideProcessingOverlay();
                $("#MyBulkAdd").hide();
               if('success' == data.status)
               {            
                  $('#form_import')[0].reset();
                    swal({
                          // title: data.status,
                           title: 'Success',
                           text: data.description,
                           type: data.status,
                          // confirmButtonText: "OK",
                          // closeOnConfirm: false
                        },
                       function(isConfirm,tmp)
                       {
                         if(isConfirm==true)
                         {  
                            location.reload();
                            // window.location = data.link;
                         }
                       });
                }
                else
                {
                  // swal('Warning',data.description,data.status);
                   swal('Alert!',data.description); 
                   $('#form_import')[0].reset();
                   $(".btn-file-remove").hide();
                }  
            }
            
          });   
    });

    /*************************************/

  /*Script to show table data*/

  var module_url_path ="{{ url('/') }}/seller/coupon"
   
   var table_module = false;
   var product_imageurl_path = "{{ $product_imageurl_path }}"
   $(document).ready(function()
   {
     table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,      
      bFilter: false ,
      ajax: {
      'url': SITE_URL+'/seller/coupon/get_records',
      'data': function(d)
        {
         
          d['column_filter[q_status]']               = $("select[name='q_status']").val()
          d['column_filter[q_code]']                 = $("input[name='q_code']").val()
          d['column_filter[q_discount]']             = $("input[name='q_discount']").val()
          d['column_filter[q_type]']                 = $("select[name='q_type']").val()
          d['column_filter[q_availability_status]']  = $("select[name='q_availability_status']").val()


       }
      },
      columns: [       
      
      {data: 'code', "orderable": false, "searchable":false}, 
      {data: 'type', "orderable": false, "searchable":false}, 
      {data: 'discount', "orderable": false, "searchable":false},  
      {data: 'start_date', "orderable": false, "searchable":false},    
      {data: 'end_date', "orderable": false, "searchable":false},    


      {
        render : function(data, type, row, meta) 
        {
           return row.build_coupon_availability_btn;
        },
        "orderable": false, "searchable":false
      },

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


    $("input.toggleSwitch1").change(function(){
       copounstatusChange($(this));
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


      $("input.toggleSwitch1").change(function(){
       copounstatusChange($(this));
      });



   }); 
  
   /*search box*/
     $("#table_module").find("thead").append(`<tr class="searchinput-data">
                    <td><input type="text" name="q_code" placeholder="Code" class="input-text column_filter" /></td>
                    <td><div class="select-style">
                      <select class="column_filter frm-select" name="q_type" id="q_type" onchange="filterData();">
                           
                            <option value="-1">All</option>
                            <option value="0">One Time</option>
                            <option value="1">Multiple Times</option>
                      </select></div></td>
                    <td><input type="text" name="q_discount" placeholder="Discount" class="input-text column_filter" /></td>
                    <td width="10%"></td> 

                    <td class='remove-border'></td>   


                    <td>

                      <div class="select-style">
                        <select class="column_filter frm-select" name="q_availability_status" id="q_availability_status" onchange="filterData();">
                           
                            <option value="-1">All</option>
                            <option value="0">Private</option>
                            <option value="1">Public</option>

                        </select>
                      </div>

                    </td> 

                    
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

 function statusChange(data)
 {

     swal({
          title: 'Do you really want to update status of this coupon?',
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
                    //sweetAlert('Error','Something went wrong!','error');
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
   }//function status change 
  


 function copounstatusChange(data)
 {
      var type    = data.attr('data-type');
      var msg     = '';

      if(type == 'coupon_public')
      {
         msg = 'Do you really want to make coupon code public?';
      }
      else if(type == 'coupon_private')
      {
        msg = 'Do you really want to make coupon code private?';
      }

      swal({
          title: msg,
          type: "warning",
          showCancelButton: true,
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
           var id      = data.attr('data-id');
           
             $.ajax({
               url:module_url_path+'/'+type,
               type:'GET',
               data:{id:enc_id},
               dataType:'json',
               success: function(response)
               {
                  if(response.status=='SUCCESS'){

                   if(response.data=='PUBLIC')
                   {
                     $(ref)[0].checked = true;  
                     $(ref).attr('data-type','coupon_private');
                     sweetAlert('success','Coupon code has been done public','success');
                     location.reload(true);
           
                   }else
                   {
                     $(ref)[0].checked = false;  
                     $(ref).attr('data-type','coupon_public');
                     sweetAlert('success','Coupon code has been done private','success');
                     location.reload(true);
                   }
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
   }//function status change 
      

</script>
 @endsection