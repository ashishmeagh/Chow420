  

<?php $__env->startSection('main_content'); ?>


<!--Datepicker js-->
    

<style type="text/css">
    .r-icon-stats i {
    width: 66px;
    height: 66px;
    padding: 20px;
    text-align: center;
    color: #fff;
    font-size: 24px;
    display: inline-block;
    border-radius: 100%;
    vertical-align: top;
    background: #edf1f5;
}

.r-icon-stats .bodystate {
    padding-left: 20px;
    display: inline-block;
    vertical-align: middle;
}
</style>
<!-- Page Content -->
  <div class="div-heightsmallheight">
        <div id="page-wrapper" class="pgwrapper">
          
            <div class="container-fluid">

                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
  
                <div class="row">
                    <!-- <div class="col-md-4 col-sm-6">
                        <div class="white-box dashbrd">
                            <div class="r-icon-stats">
                                <i class="ti-wallet bg-info"></i>
                                <div class="bodystate">
                                    <h1 class="counter text-right m-t-15 text-megna"><?php echo e(isset($counts_arr['total_trades']) ? $counts_arr['total_trades'] : 0); ?></h1>
                                    <span class="text-muted">
                                    All Trades</span>
                                </div>
                            </div>
                        </div>
                    </div> -->

                     <div class="col-md-4 col-sm-6">
                        <a href="<?php echo e(url(config('app.project.admin_panel_slug').'/buyers')); ?>">
                            <div class="white-box dashbrd">
                                <div class="r-icon-stats">
                                    <i class="ti-user bg-info"></i>
                                    <div class="bodystate">
                                        <h1 class="counter m-t-15 text-megna"><?php echo e(isset($counts_arr['total_buyer']) ? $counts_arr['total_buyer'] : 0); ?></h1>
                                        <span class="text-muted"><b>Total Buyer</b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <a href="<?php echo e(url(config('app.project.admin_panel_slug').'/sellers')); ?>">
                            <div class="white-box dashbrd">
                                <div class="r-icon-stats">
                                    <i class="ti-user bg-info"></i>
                                    <div class="bodystate">
                                        <h1 class="counter m-t-15 text-megna"><?php echo e(isset($counts_arr['total_seller']) ? $counts_arr['total_seller'] : 0); ?></h1>
                                        <span class="text-muted"><b>Total Dispensary</b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                    <div class="col-md-4 col-sm-6">
                        <a href="<?php echo e(url(config('app.project.admin_panel_slug').'/first_level_categories')); ?>">
                            <div class="white-box dashbrd table-responsive">
                                <div class="r-icon-stats">
                                    <i class="ti-list bg-info"></i>
                                    <div class="bodystate">
                                        <h1 class="counter text-center m-t-15 text-megna"><?php echo e(isset($counts_arr['all_categories']) ? $counts_arr['all_categories'] : 0); ?></h1>
                                        <span class="text-muted"><b>Categories</b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>    
                    <div class="clearfix"></div>      

                     <div class="col-md-4 col-sm-6">
                       
                            <div class="white-box dashbrd table-responsive">
                                <div class="r-icon-stats">
                                     <i class="ti-cloud-down"></i>
                                    <div class="bodystate">
                                        <h1 class="text-center m-t-15 text-megna">
                                         $ <?php echo e(isset($total_soldprice) ? $total_soldprice : 0); ?></h1>
                                        <span class="text-muted"><b>Total cost of goods sold</b></span>
                                    </div>
                                </div>
                            </div>
                        
                    </div>    
                    <div class="clearfix"></div>       

                      <div class="col-md-4 col-sm-6">
                        
                            <div class="white-box dashbrd table-responsive">
                                <div class="r-icon-stats">
                                    <i class="ti-check-box"></i>
                                    <div class="bodystate">
                                        <h1 class="text-center m-t-15 text-megna">$ <?php echo e(isset($total_productsum) ? $total_productsum : 0); ?></h1>
                                        <span class="text-muted"><b>Total cost of goods available</b></span>
                                    </div>
                                </div>
                            </div>
                       
                    </div>    
                    <div class="clearfix"></div>       



                </div>    
                       
               
            </div>
            <!-- /.container-fluid -->
            <div class="clearfix"></div>            
        </div>
        <!-- /#page-wrapper -->
    </div>    
 </div> 

<?php $__env->stopSection(); ?>     
<?php $__env->startSection('extra_js'); ?>       

 
<script type="text/javascript">
        $.toast({
            heading: 'Welcome to '+ '<?php echo e(config('app.project.name')); ?>'+ ' Admin',
            text: 'Manage your website from here.',
            position: 'top-right',
            loaderBg: '#8d62d5',
            icon: 'info',
            hideAfter: 3500,
            stack: 6
        })
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>