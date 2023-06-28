 
<?php $__env->startSection('main_content'); ?>



<div class="my-profile-pgnm">
  <?php echo e($page_title); ?>

    <ul class="breadcrumbs-my">
      <li><a href="<?php echo e(url('/')); ?>/seller/dashboard">Dashboard</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><?php echo e($page_title); ?></li>
    </ul>
</div>

<div class="new-wrapper">
  <div class="button-list-dts myproduct-mrg">
    <a href="<?php echo e($module_url_path); ?>/create" class="butn-def" >Add Delivery Options</a>
  </div>

  <div class="myproductstbls">
    <div class="table-responsive">
       <table class="table seller-table" id="table_module">
           <thead>
               <tr>
                   <th class="text-center">Title</th>
                   <th class="text-center">Length of Delivery (day)</th>
                   <th class="text-center">Amount($)</th>
                   <th class="text-center">Status</th>
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

var table_module = false;
var product_imageurl_path = ""
$(document).ready(function () {
    table_module = $('#table_module').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        bFilter: false,
        ajax: {
            'url': SITE_URL + '/seller/delivery_options/get_records',
            'data': function (d) {

                d['column_filter[q_title]']     = $("input[name='q_title']").val()
                d['column_filter[q_day]']       = $("input[name='q_day']").val()
                d['column_filter[q_cost]']      = $("input[name='q_product_age']").val()
                d['column_filter[q_status]']    = $("select[name='q_status']").val()
            }
        },
        columns: [{
                data: 'title',
                "orderable": false,
                "searchable": false
            },
            {
                data: 'day',
                "orderable": false,
                "searchable": false
            },
            {
                data: 'cost',
                "orderable": false,
                "searchable": false
            },
            {
                render: function (data, type, row, meta) {
                    return row.build_status_btn;
                },
                "orderable": false,
                "searchable": false
            },
            {
                render: function (data, type, row, meta) {
                    return row.build_action_btn;
                },
                "orderable": false,
                "searchable": false
            }
        ]
    });

    $("input.toggleSwitch").change(function(){
        statusChange($(this));
    });
   
    $('#table_module').on('draw.dt',function(event) {

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

    $("#table_module").find("thead").append(`<tr class="searchinput-data">
    
                    <td><input type="text" name="q_title" placeholder="Title" class="input-text column_filter" /></td>
                    <td><input type="text" name="q_day" placeholder="Day" class="input-text column_filter" /></td>
                    <td ><input type="text" name="q_cost" placeholder="Amount" class="input-text column_filter" /></td> 
                        
                    <td><div class="select-style">
                      <select class="column_filter frm-select" name="q_status" id="status" onchange="filterData();">
                            <option value="">All</option>
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                      </select></div>
                    </td>
                     <td></td>
                </tr>`);

    $('input.column_filter').on('keyup click', function () {
        filterData();
    });
});

function filterData() {
    table_module.draw();
}

var module_url_path = "<?php echo e(url('/')); ?>/seller/delivery_options"

function statusChange(data) {

    swal({
            title: 'Do you really want to update status of this Delivery Option?',
            type: "warning",
            showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            confirmButtonColor: "#8d62d5",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: false
        },
        function (isConfirm, tmp) {
            if (isConfirm == true) {
                var ref = data;
                var type = data.attr('data-type');
                var enc_id = data.attr('data-enc_id');
                var id = data.attr('data-id');

                $.ajax({
                    url: module_url_path + '/' + type,
                    type: 'GET',
                    data: {
                        id: enc_id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 'SUCCESS') {
                            if (response.data == 'ACTIVE') {
                                $(ref)[0].checked = true;
                                $(ref).attr('data-type', 'deactivate');
                                sweetAlert('success', 'Status update successfully', 'success');
                                location.reload(true);

                            } else {
                                $(ref)[0].checked = false;
                                $(ref).attr('data-type', 'activate');
                                sweetAlert('success', 'Status update successfully', 'success');
                                location.reload(true);
                            }
                        } else {
                            //sweetAlert('Error','Something went wrong!','error');
                            if (response.msg) {

                                swal({
                                    title: response.msg,
                                    type: "warning",
                                    confirmButtonColor: "#873dc8",
                                    confirmButtonText: "Ok",
                                    closeOnConfirm: false
                                },
                                function (isConfirm, tmp) {
                                    if (isConfirm == true) {
                                        window.location.reload();
                                    }
                                })
                            }
                        }
                    }
                });
            } else {
                $(data).trigger('click');
            }
        })
    }
    function confirm_delete(ref,event) {
        var delete_param = "delivery option";
        confirm_action(ref,event,'Do you really want to delete this Delivery Option?', delete_param);
    }
</script>
 <?php $__env->stopSection(); ?>
<?php echo $__env->make('seller.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>