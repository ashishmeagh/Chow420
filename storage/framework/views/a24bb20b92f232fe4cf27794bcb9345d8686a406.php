<?php if(isset($arr_lang) && sizeof($arr_lang)>0): ?>
    <?php $__currentLoopData = $arr_lang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php echo e($lang['locale']=='en'?'active':''); ?>">
            <?php 
                $is_linked_enabled = $lang['locale']=='en'?TRUE:FALSE;
            ?>
        	<a href="#<?php echo e($lang['locale']); ?>" 
                    <?php if(isset($edit_mode) && $edit_mode==TRUE): ?>
                        data-toggle="tab"
                    <?php else: ?>
                       <?php echo e($lang['locale']=='en'?'data-toggle="tab"':''); ?> 
                    <?php endif; ?>
                > 
        		<i class="fa fa-home"></i> 
        		<?php echo e($lang['title']); ?> 
        	</a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>