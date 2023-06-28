<?php $__env->startSection('main_content'); ?>
<style>
/*css added for making title as h1*/
h1{
    font-size: 30px;
    text-align: left;
    font-weight: 600;
    margin-bottom: 30px;
}
</style>

<?php $brand = app('App\Models\BrandModel'); ?>
 
 
 <?php
    if($isMobileDevice==1){

        $device_count = 2;
    }
    else {
        $device_count = 5;
    }

?>


<div class="shop-by-brand-main">
	<div class="container">




   <?php if(isset($banner_images_data) && !empty($banner_images_data)): ?>
     <?php if(isset($banner_images_data['banner_image7_desktop']) && !empty($banner_images_data['banner_image7_desktop']) && isset($banner_images_data['banner_image7_mobile']) && !empty($banner_images_data['banner_image7_mobile'])): ?> 
        <div class="adclass-maindiv">
         <a <?php if(isset($banner_images_data['banner_image7_link7'])): ?>  href="<?php echo e($banner_images_data['banner_image7_link7']); ?>" target="_blank" 
                <?php else: ?>  href="#" <?php endif; ?>>
            <figure class="cw-image__figure">
               <picture>

                 <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image7_mobile']) && isset($banner_images_data['banner_image7_mobile'])): ?> 
                  <source type="image/png" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image7_mobile']); ?>" media="(max-width: 621px)">
                  <source type="image/jpg" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image7_mobile']); ?>" media="(max-width: 621px)">
                   <source type="image/jpeg" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image7_mobile']); ?>" media="(max-width: 621px)">   
                 <?php endif; ?>
                 
                 <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image7_desktop']) && isset($banner_images_data['banner_image7_desktop'])): ?>    
                  <source type="image/png" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image7_desktop']); ?>" media="(min-width: 622px) and (max-width: 834px)">
                  <source type="image/jpg" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image7_desktop']); ?>" media="(min-width: 622px) and (max-width: 834px)">
                  <source type="image/jpeg" srcset="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image7_desktop']); ?>" media="(min-width: 622px) and (max-width: 834px)">
                 <?php endif; ?>

                  <?php if(file_exists(base_path().'/uploads/banner_images/'.$banner_images_data['banner_image7_desktop']) && isset($banner_images_data['banner_image7_desktop'])): ?> 
                        <img class="cw-image cw-image--loaded obj-fit-polyfill lozad" alt="slider image" aria-hidden="false" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" data-src="<?php echo e(url('/')); ?>/uploads/banner_images/<?php echo e($banner_images_data['banner_image7_desktop']); ?>">
                  <?php endif; ?>  

                </picture>
            </figure>
          </a>
        </div>    
     <?php endif; ?>    
   <?php endif; ?>  







		
		


		<!------------------featured brand section added here----------->

		  <?php
	      if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count)
	      $class = 'butn-def viewall-product';
	      else
	      $class = 'butn-def';  
	      ?>

        
	      <div class="border-home-brfands"></div>
	        <?php if(isset($arr_featured_brands) && count($arr_featured_brands)>0): ?>  
	        <div class="shopbrandlistmaindv">
	        <div class="toprtd viewall-btns-idx">Top brands
	       
	        <div class="clearfix"></div>
	        </div>
	        <div class="featuredbrands-flex smallsize-brand-img brand-imgsection-class">

	       <ul 
	        <?php if(isset($arr_featured_brands) && count($arr_featured_brands)<=$device_count): ?>
	        class="f-cat-below7" 
	        <?php elseif(isset($arr_featured_brands) && count($arr_featured_brands)>$device_count): ?>
	        id="flexiselDemo3"
	        <?php endif; ?>
	        >          

	          <?php $__currentLoopData = $arr_featured_brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured_brands): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	            <li>
	              <div class="top-rated-brands-list">
	                 <?php
	                  $brand_name = isset($featured_brands['name'])?$featured_brands['name']:'';
	                  $brandname = str_replace(" ", "-", $brand_name);    

	                 ?> 


	                <a href="<?php echo e(url('/')); ?>/search?brands=<?php echo e(isset($brandname)?
	                           $brandname:''); ?>" class="brands-citcles">
	                  <div class="img-rated-brands">
	                      <?php if(file_exists(base_path().'/uploads/brands/'.$featured_brands['image']) && isset($featured_brands['image'])): ?>
	                      <img data-src="<?php echo e(url('/')); ?>/uploads/brands/<?php echo e($featured_brands['image']); ?>" alt="<?php echo e($brand_name); ?>" src="<?php echo e(url('/assets/images/Pulse-1s-200px.svg')); ?>" class="lozad"/>
	                      <?php endif; ?>
	                    <div class="content-brands">                       
	                        <div class="titlebrds"><?php echo e(isset( $featured_brands['name'])?ucwords($featured_brands['name']):''); ?></div>                           
	                    </div>
	                </div>
	              </a>
	            </li>            
	          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	        </ul> 
	      </div>
	      </div>
	     <?php endif; ?> 

	     <div class="clearfix"></div> <br/>
<hr>
		<!-----------------end of featured brand section----------------->

		
		<div class="brands-sections">
			<div class="brands">
			<ul class="letters">
				<li class="active"><a href="#viewall">All</a></li>
				<?php 
				$range_arr = range("A","Z");
				?>

				<!--commented for showing only those records which has brand-->
				 

				 <?php if(isset($brandarr) && !empty($brandarr)): ?>
				 <?php $__currentLoopData = $brandarr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				    <li><a href="#brands-<?php echo e($brand['char']); ?>"  id="<?php echo e($brand['char']); ?>"><?php echo e($brand['char']); ?></a>
				    </li>
				 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				 <?php endif; ?> 

				
			</ul> 
			<div class="brands-list">

				  <?php if(isset($brandarr) && !empty($brandarr)): ?>
				     <?php $__currentLoopData = $brandarr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         				<div class="brand-list show" id="brands-<?php echo e($range['char']); ?>-page"> 
							<h2><?php echo e($range['char']); ?></h2>

							<ul id="sethtml_<?php echo e($range['char']); ?>" class="sethtml">

								<?php
									$url = '';
									if(!empty($range['name'])){
										foreach($range['name'] as $brands){
										// $url = url('search?brands='.base64_encode($brands['name'])); 	
										 $brand_name = str_replace(" ", "-", $brands['name']);		
										 $url = url('search?brands='.$brand_name); 			

									?>
									    <li><a href="<?php echo e($url); ?>"><?php echo e($brands['name']); ?></a></li>
									<?php
								        } //foreach
									 }//if not empty brandlist
									 else{
									 	echo "<li><a href='javascript:void(0)'>Not Availiable</a></li>"; 
									 }
								?>

							</ul>
							
							<div class="clearfix"></div>

     					</div>
					 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				 <?php endif; ?> 
				
				
			</div>
			</div>
		</div>

	</div>
</div>



<?php $__env->stopSection(); ?>


<!-- page script start -->

<?php $__env->startSection("page_script"); ?>
  
<!-------------script added for featured brand section------------------------>
<script type="text/javascript" language="javascript" src="<?php echo e(url('/')); ?>/assets/front/js/jquery.flexisel.js"></script>


<script type="text/javascript">
	
    $(document).ready(function(){

        var screenWidth = window.screen.availWidth;
        if(parseInt(screenWidth) < parseInt(768)){
          $("#flexiselDemo3").removeAttr('id');
        }
    });


	 $(window).load(function() {
	 	 $("#flexiselDemo3").flexisel({
          visibleItems: 5,
          itemsToScroll: 1,
          animationSpeed: 200,
          autoPlay: {
          enable: true,
          interval: 5000,
          pauseOnHover: true
      }
      });

	 });





$('.brands').on('click', '.letters li:not(.disabled) a', function(e) {
	e.preventDefault();
	$(this).closest("ul").find("li").each(function(e) {
		$(this).removeClass("active");
	});

	$(this).parent().addClass("active");
	var attr = $(this).attr("href");
	var range = $(this).attr("id");
	
	if(attr === "#viewall") {
		$(".brand-list").addClass("show");
	}
	else {
		$(".brand-list")
		  .removeClass("show")
	      .removeClass("active");
		$(attr + '-page').addClass("active");
	}


});

</script>

<!-------------end of script added for featured brand section------------------------>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.master',['page_title'=>'Shop by Brand'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>