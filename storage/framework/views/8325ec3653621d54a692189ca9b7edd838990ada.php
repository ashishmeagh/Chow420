<?php $__env->startSection('main_content'); ?>
<div class="container">
	<div class="contair-chow">
		<div class="titleusershare">
			Investor Tracker
		</div>
		<div class="emailusershare">
			<form action="post" id="user-share-search-form">
				<?php echo e(csrf_field()); ?>

				<input type="text" name="email" id="email" placeholder="Enter email address" />
				<button type="submit" class="gobutton" id="search-email">Go</button>
				<span>Track the value of your shares</span>
			</form>
		</div>
		<div class="name-user-shares" style="display: none;">
			Hello <span id="first-name">First Name</span>
		</div>
		<div class="box-user-shares" style="display: none;">
			<span class="count-share-usr" id="shares-owned">0</span>
			<div class="titlebox-user-shares">Shares</div>
		</div>
		<div class="box-user-shares widthauto" style="display: none;">
			<div class="count-arrow-usr-sr">
				<i class="fa fa-sort-asc"></i>
				<span id="percent-change">0%</span>
			</div>
			<span class="count-share-usr" id="price-per-share">$ 0</span>
			
			<div class="titlebox-user-shares" >Price per share</div>
		</div>
		<div class="box-user-shares" style="display: none;">
			<span class="count-share-usr" id="share-value">$ 0</span>
			<div class="titlebox-user-shares">Share value</div>
		</div>
		<div class="contant-txt-usr-sr" id="description" style="display: none;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus nihil perferendis temporibus dicta, neque molestias quas, corporis voluptatum, facilis ab et maxime consectetur rerum vel id voluptate iusto, rem laudantium quam modi error. Vel quod, odit sequi repellendus nemo excepturi.</div>
	</div>

</div>

<script>
	var URL = "<?php echo e(url('/')); ?>";
	$(document).ready(function(){
		$("#search-email").on("click", function(e){
			e.preventDefault();
			if($("#email").val()=='')
			{
				swal('',"Please enter the email address",'warning');  
				return false;
			}

			var formdata = new FormData($('#user-share-search-form')[0]);
	      	
	      	$.ajax({
	                  
				url: URL+'/investortracker/search_users_shares',
				data: formdata,
				contentType:false,
				processData:false,
				method:'POST',
				cache: false,
				dataType:'json',
				beforeSend: function() {
                	showProcessingOverlay();
	          	},
	          	success:function(response)
	          	{
	            	hideProcessingOverlay(); 
	             	if('success' == response.status)
	             	{
	                	
	                	$('#first-name').html(response.data.first_name+",").parent().show();
	                	$('#shares-owned').html(response.data.shares_owned).parent().show();
	                	$('#price-per-share').html('$'+response.data.price_per_share).parent().show();
	                	$('#percent-change').html(response.data.percent_change + "%");
	                	$('#share-value').html('$'+response.data.share_value).parent().show();
	                	$('#description').html(response.data.description).show();
	              	}
	              	else
	              	{
	              		
	                	$('#first-name').html('').parent().hide();
	                	$('#shares-owned').html('').parent().hide();
	                	$('#price-per-share').html('').parent().hide();
	                	$('#percent-change').html('');
	                	$('#share-value').html('').parent().hide();
	                	$('#description').html('').hide();
	                	swal('',response.description,response.status);
	              	}  
	          	}
	          
	        }); 
		});
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>