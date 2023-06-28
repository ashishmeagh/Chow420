  

 


<style type="text/css">
  .username-review{
    position: relative;
  }
  .username-review .editreviews{
   position: absolute;
   right: 0;
   top: 0;
  }
</style>


   <?php
     $login_user = Sentinel::check();
     $product_id = $productid;

      $total_reviews = get_total_reviews($product_id);
      $avg_rating  = get_avg_rating($product_id);

      $emoji=[];



   ?>
                 





                    


                 







<!--

<script> 


        

  $(document).on('click','.editreviews',function(){

      var reviewid = $(this).attr('reviewid');
      var reviewuser = $(this).attr('reviewuser');
      var reviewproduct = $(this).attr('reviewproduct');
      var reviewrating = $(this).attr('reviewrating');

      var reviewtitle = $(this).attr('reviewtitle');
      var reviewdesc = $(this).attr('reviewdesc');

      $("#ReviewRatingsAddModal #product_id").val(reviewproduct);
      $("#ReviewRatingsAddModal #review_id").val(reviewid);

      $("#ReviewRatingsAddModal").modal('show');

      $("#title").val(reviewtitle);
      $("#review").val(reviewdesc);
      $("#rating_modal").val(reviewrating);
      document.getElementById('rating_modal').style.display='block';
      
  }); 

//function for update review
$('.btn_send_review_modal').click(function()
      { 


        var rating = $("#rating_modal").val();
        alert(rating);

        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          return false; 
        }

        if($('#frm-add-review-modal').parsley().validate()==false) return;

        var form_data   = $('#frm-add-review-modal').serializeArray(); 
        form_data.push({name: 'rating_modal', value: rating});

        alert(form_data);
         var csrf_token = "<?php echo e(csrf_token()); ?>";
     
        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/update',
            type:"POST",
            data: form_data,             
            dataType:'json',
            beforeSend: function(){ 
            // showProcessingOverlay();
             $('.btn_send_review_modal').prop('disabled',true);
             $('.btn_send_review_modal').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');

            },
            success:function(response)
            {
             //  hideProcessingOverlay();
              $('.btn_send_review_modal').prop('disabled',false);
              $('.btn_send_review_modal').html('Send Review');
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
                        $(this).addClass('active');

                      }

                    });
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); 
           return false;
     }); 
</script>              
-->


<?php  ?>

<div class="comment-view-only" id="showreviewdiv" style="max-height: 300px;overflow-y: auto;">
    <?php if(isset($arr_product['review_details']) && sizeof($arr_product['review_details']) ): ?>
    <?php $__currentLoopData = $arr_product['review_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
            $review_at = "";
            $review_at = date('h:i - M d, Y', strtotime($review['updated_at']));
            if(isset($review['user_details']['profile_image']) && $review['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$review['user_details']['profile_image'])) {

                $user_profile_img = url('/uploads/profile_image/'.$review['user_details']['profile_image']);
            }
            else {                  
                $user_profile_img = url('/assets/images/no_image_available.jpg');
            }  
            if(isset($review['rating']) && $review['rating'] > 0) {

                $img_rating = "";

                // if($review['rating']=='1') $img_rating = "star-rate-one.svg";
                // else if($review['rating']=='2')  $img_rating = "star-rate-two.svg";
                // else if($review['rating']=='3')  $img_rating = "star-rate-three.svg";
                // else if($review['rating']=='4')  $img_rating = "star-rate-four.svg";                                  
                // else if($review['rating']=='5')  $img_rating = "star-rate-five.svg";
                // else if($review['rating']=='0.5')  $img_rating = "star-rate-zeropointfive.svg";
                // else if($review['rating']=='1.5')  $img_rating = "star-rate-onepointfive.svg";
                // else if($review['rating']=='2.5')  $img_rating = "star-rate-twopointfive.svg";
                // else if($review['rating']=='3.5')  $img_rating = "star-rate-threepointfive.svg";
                // else if($review['rating']=='4.5')  $img_rating = "star-rate-fourpointfive.svg";

                  $img_rating = isset($review['rating'])?get_avg_rating_image($review['rating']):'';
            } 
        ?>
        <div class="comment-view-only-white prfileimgnone">
            <?php 
                $setname = '';
                if(isset($review['user_details']) && ($review['user_details']['first_name']=="" || $review['user_details']['last_name']==""))  {

                    if($review['user_details']['user_type']=="seller") {

                        $setname = "Seller";
                    }
                    else {

                        $setname = "Buyer";
                    }
                }
                else if(isset($review['user_details']) && ($review['user_details']['first_name']!="" || $review['user_details']['last_name']!=""))  {

                   // $setname = $review['user_details']['first_name']." ".$review['user_details']['last_name'];
                    $setname = $review['user_details']['first_name'];
                }
                else  if(isset($review['user_name']) && $review['user_name']!="")  {
                    $setname = isset($review['user_name'])?$review['user_name']:'';
                }
                else {
                    $setname ='User';
                }
            ?>

            
            <div class="review-main-avatar">
                <div class="review-main-avatar-left">
                    <div class="rvw-circle-cw"><img src="<?php echo e(url('/')); ?>/assets/front/images/check-buyer-icon.svg" /></div>
                    
                    <?php
                       $initate_latter =  strtoupper($setname[0]);
                    ?>
                    <?php echo e($initate_latter); ?>

                </div>
                <div class="review-main-avatar-right">
                    <div class="namereviews">
                        <span>
                            
                            
                            <?php echo e(isset($setname)?ucwords(strtolower($setname)):''); ?>


                            <?php if($login_user == true && $review['buyer_id']==$login_user->id): ?>
                                <?php 

                                // if($review['rating']==1)
                                // {$star = "one";}
                                // else if($review['rating']==2)
                                // {$star = "two";}
                                // else if($review['rating']==3)
                                // {$star = "three";}
                                // else if($review['rating']==4)    
                                // {$star = "four";}
                                // else if($review['rating']==5)    
                                // {$star = "five";}
                                // else if($review['rating']==0.5)    
                                // {$star = "zeropointfive";}
                                // else if($review['rating']==1.5)    
                                // {$star = "onepointfive";}
                                // else if($review['rating']==2.5)    
                                // {$star = "twopointfive";}
                                // else if($review['rating']==3.5)    
                                // {$star = "threepointfive";}
                                // else if($review['rating']==4.5)    
                                // {$star = "fourpointfive";} 

                                $star = isset($review['rating'])?get_avg_rating_image($review['rating']):'';

                                ?>
                                <a title="Edit Review" class="fa fa-edit editreviews " id="editreviews_<?php echo e($review['id']); ?>" reviewuser="<?php echo e($review['buyer_id']); ?>" reviewproduct="<?php echo e($review['product_id']); ?>"  reviewid="<?php echo e($review['id']); ?>" reviewtitle="<?php echo e($review['title']); ?>" reviewdesc="<?php echo e($review['review']); ?>" reviewrating="<?php echo e($review['rating']); ?>" star="<?php echo e($star); ?>" emoji="<?php echo e(isset($review['emoji'])?$review['emoji']:''); ?>">
                                </a>
                            <?php endif; ?> 
                        </span>
                        <span class="verified-buyerclass">Verified Buyer</span>
                    </div>
                    <div class="lisitng-detls-rate" title="<?php echo e($review['rating']); ?> Rating">
                                      

                        <img src="<?php echo e(url('/')); ?>/assets/front/images/star/<?php echo e(isset($img_rating)?$img_rating.'.svg':''); ?>" alt="">                  
                    </div>
                    <div class="titleofsub">
                        <?php
                        $reviwe_title = isset($review['title']) ? $review['title'] : '-';
                        ?>
                        <?php echo e($reviwe_title); ?>

                    </div>
                    <div class="commentofsub" id="hidecontent_<?php echo e($review['id']); ?>">
                        <?php if(isset($review['review']) && strlen($review['review'])>100): ?>
                            <?php echo substr($review['review'],0,100) ?>
                            <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore(<?php echo e(isset($review['id'])?$review['id']:''); ?>)">See more</span>
                        <?php else: ?>
                        <?php 
                            if(isset($review['review']))
                            echo $review['review']; 
                            else
                            echo '';
                        ?>
                        <?php endif; ?>
                    </div>
                    <span class="show-more-content" style="display: none" id="show-more-content_<?php echo e(isset($review['id'])?$review['id']:''); ?>">
                    <?php
                        if(isset($review['review']))
                        echo $review['review']; 
                        else
                        echo ''; 
                    ?>
                    <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless(<?php echo e(isset($review['id'])?$review['id']:''); ?>)"  id="show-less_<?php echo e(isset($review['id'])?$review['id']:''); ?>">See less</span>
                </span>

                 <script>
                    function showmore(id)
                    {
                      $('#show-more-content_'+id).show();
                       $('#show-less_'+id).show();
                       $("#hidecontent_"+id).hide();
                    }
                    
                     function showless(id)
                    {
                       $('#show-more-content_'+id).hide();
                       $('#show-less_'+id).hide();
                       $("#hidecontent_"+id).show();
                    }
                    
                </script>
                <div class="showemoji">
                    <?php if(isset($review['emoji']) && !empty($review['emoji'])): ?>
                    <div class="top-rated-div">
                        This helped with my:
                                

                               

                        <ul class="list-inline">
                            <?php 
                                $emoji = explode(",",$review['emoji']);
                                // dump($review);
                                $exploded = [];
                                foreach($emoji as $kk=>$vv)
                                {
                                $exploded = explode(".",$vv);
                            ?>
                                <li>
                                    <img src="<?php echo e(url('/')); ?>/assets/images/<?php echo e($vv); ?>" width="32px"> 
                                    <label><?php echo e(isset($exploded[0])?ucwords(str_replace("_"," ",$exploded[0])):''); ?></label>
                                </li>
                                <?php 
                            }
                                ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                </div>
                <div class="clearfix"></div>
            </div>
            

            
            <div class="comment-view-only-white-right">

                <div class="title-user-name username-review"> 
                </div>
                   
                

            </div>
            <div class="clearfix"></div>
            <div class="clearfix"></div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="whitebox-list space-o-padding">
        <div class="titledetailslist pull-left">No Reviews (0)</div>
    </div>
    <?php endif; ?>
    <div class="clearfix"></div>
                     
</div>

<?php  ?>
