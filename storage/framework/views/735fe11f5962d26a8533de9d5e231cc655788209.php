<?php

if(isset($site_setting_arr) && !empty($site_setting_arr) && $site_setting_arr['event_status']==1){
 ?>

<?php


 if(isset($arr_events) && !empty($arr_events))
  {

?>


<div class="full-width-borders fr-marqee-main">
<div class="">
  

<ul id="flexiselDemoTop">

     <?php
       foreach($arr_events as $events)
        {
      ?>

    <li>
        <div class="li-marqee-m">
          <div class="mainmarqees">
             
              <div class="mainmarqees-right">
                   
                         <?php echo $events['msg']; ?>
                    
                     <div class="clearfix"></div>

                    <?php if(isset($site_setting_arr['event_date_status']) && $site_setting_arr['event_date_status']==1): ?>
                      <div class="time-ago-class">
                        <?php
                         echo \Carbon\Carbon::parse($events['created_at'])->diffForHumans()
                        ?>
                      </div>
                    <?php endif; ?>


              </div>
                 <div class="clearfix"></div>
            </div>
        </div>
    </li>

    <?php
     } //foreach
   ?>
  </ul>
  </div>
  </div>

 <?php
  }//if isset
 ?>


<?php
}//if eventstatus is 1

?>


<script type="text/javascript">
  

  $("#flexiselDemoTop").flexisel({
      visibleItems: 4,
      itemsToScroll: 1,
      infinite: false,
     /* infinite: true,*/
      animationSpeed: 300,
      autoPlay: {
      enable: true,
      interval: 5000,
      pauseOnHover: true
      },
       responsiveBreakpoints: {
      portrait: {
      changePoint:480,
      visibleItems: 1,
      itemsToScroll: 1
      },
      landscape: {
      changePoint:640,
      visibleItems: 2,
      itemsToScroll: 1
      },
      tablet: {
      changePoint:768,
      visibleItems: 3,
      itemsToScroll: 1
      },
       ipadpro: {
      changePoint:1199,
      visibleItems: 3,
      itemsToScroll: 1
      },
      laptop: {
          changePoint: 1370,
          visibleItems: 4,
          itemsToScroll: 1
      }
      }
  });

</script>