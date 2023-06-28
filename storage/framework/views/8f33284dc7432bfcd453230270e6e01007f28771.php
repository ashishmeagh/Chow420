
<?php if(isset($arr_tags) && !empty($arr_tags)): ?>
  <div class="tags-section-index-div">
  <div class="tags-section-div">

    <?php
    $tagtitle = $taglink ='';
     foreach($arr_tags as $k=>$v)
      {

        $tagtitle = isset($v['title'])?$v['title']:'';
        $taglink  = isset($v['link'])?$v['link']:'';
    ?>

       <a href="<?php echo e($taglink); ?>" target="_blank"> <?php echo e($tagtitle); ?></a>

     <?php
       }//foreach
     ?>

  </div>
</div>
<?php endif; ?>
