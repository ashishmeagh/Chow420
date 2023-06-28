<?php
    $search_type =  isset($search_value['search_type']) ?$search_value['search_type']:'';

    $search_term = isset($search_value['search-term'])?$search_value['search-term']:'';

    if($search_type == 'product' || $search_type =='brand')
    {
        $href = url('/').'/search?search_type='.$search_type.'&search-term=';
        $label = $search_type;
    }
    else
    {
        $href = url('/').'/search?search_type=product&search-term=';
        $label = 'Products';
    }
    

   if(isset($cat_id) && $cat_id!='All')  
   {
    $cat_id     =  $cat_id; 

   }
   else
   {
    $cat_id     =  app('request')->input('category_id');   
   }
   $price      =  app('request')->input('price');
   $sub_cat_id = app('request')->input('subcategory');
   $age_restrictions = app('request')->input('age_restrictions');
   $rating     = app('request')->input('rating');
   $seller     = app('request')->input('seller');
   $brand      = app('request')->input('brand');
   $brands     = app('request')->input('brands');
   $sellers    = app('request')->input('sellers');
   $mg         =  app('request')->input('mg');
   $filterby_price_drop =  app('request')->input('filterby_price_drop');
   $product_search      =  app('request')->input('product_search');
   $state      = app('request')->input('state');
   $city       = app('request')->input('city');
   $chows_choice =  app('request')->input('chows_choice');
   $best_seller =  app('request')->input('best_seller');
   $spectrum    =  app('request')->input('spectrum');
   $statelaw = app('request')->input('statelaw');
   $reported_effects = app('request')->input('reported_effects');
   $cannabinoids = app('request')->input('cannabinoids');
   $featured = app('request')->input('featured');




$loggedinuser = 0;
$loged_user = Sentinel::check();

if(isset($loged_user) && $loged_user==true)
{
  $loggedinuser = $loged_user->id;
}
else{
  $loggedinuser = 0;
}

     
?> 


<div class="col-3-list leftSidebar" id="addclasshereforfilter">
  <div class="closebtnslist">
  <span class="toggle-button">
    <span class="closelkds"></span>
    
  </span>
</div>

 <div class="theiaStickySidebar">
 <div id="sidebar">


 <?php if(isset($Product_search_by_brand) && $Product_search_by_brand==1): ?>    
 <?php else: ?> 

  <h1>Brand 
           <?php if(isset($brands)): ?>
            <a href="javascript:void(0)" class="clearfiltr" id="brandfilter" onclick="return clearfilter('brands');">  Clear Filter</a>
           <?php elseif(isset($brand)): ?> 
               <a href="javascript:void(0)" class="clearfiltr" id="brandfilter" onclick="return clearfilter('brand');">  Clear Filter</a>
           <?php endif; ?>
  </h1>
  <?php endif; ?>
         
 <?php if(isset($Product_search_by_brand) && $Product_search_by_brand==1): ?>    
 <?php else: ?> 

<div class="searchbrands">
 
 


   <input type="text" placeholder="Search by Brand" id="searchbybrand" value="<?php if(isset($brands) && isset($brand_details) && isset($brand_details[0]['name'])): ?> <?php echo e($brand_details[0]['name']); ?> <?php elseif(isset($brand) && isset($brand_details) && isset($brand_details[0]['name'])): ?> <?php echo e($brand_details[0]['name']); ?>  <?php endif; ?>" />

  <div id="brandList"></div>
  <span id="branderr"></span>

  <!-------------------if brand is set or brands is set then dont show the search btn------------->
  <?php if(isset($brands)): ?> <?php elseif(isset($brand)): ?> <?php else: ?>
    
  <?php endif; ?>

</div>

<div class="border-list-side"></div>
<?php endif; ?>












<div class="searchbrands">
            <?php
           
            if(isset($seller_details) && isset($sellers))
            {
              $fname =  $seller_details['first_name']; 
              $lname =  $seller_details['last_name']; 
            }

           ?>



</div>



 <!--------------start-caabodies dropdown---------------------->

<?php
    $arr_cannabinoids = get_cannabinoids();
    $arr_cannabinoids_1 = [];
  ?>
<?php if(isset($arr_cannabinoids) && count($arr_cannabinoids) > 0): ?>

<div class="title-list-cart reort-effect" style="margin-top:20px;">Cannabinoids
  <?php
      if(isset($cannabinoids) && !empty($cannabinoids))
      {
        $cannabinoids_1 =  explode("-",$cannabinoids);
      }
    ?>
 

 <?php if(isset($cannabinoids) && !empty($cannabinoids)): ?>
   <a href="javascript:void(0)" class="clearfiltr" id="cannbionoidsfilter" onclick="return clearfilter('cannabinoids');">Clear Filter</a>
  <?php endif; ?>
</div>


<div class="checkbox-dropdown nospace-home"> 
      Select
      <ul class="checkbox-dropdown-list">

        <?php if(isset($arr_cannabinoids) && count($arr_cannabinoids) > 0): ?>
        <?php $__currentLoopData = $arr_cannabinoids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cannabinoidss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li>
                 <div class="checkbox clearfix">
                    <div class="form-check checkbox-theme">
                        <input class="form-check-input" type="checkbox" value="<?php echo e($cannabinoidss['name']); ?>" id="canRememberMe<?php echo e($cannabinoidss['id']); ?>"  name="cannabinoids[]" 
                        onclick="getCheckBoxValuescanobodies()"  <?php if(isset($cannabinoidss) && !empty($cannabinoidss) && isset($cannabinoids_1) && in_array($cannabinoidss['name'], $cannabinoids_1)): ?> checked="checked" <?php endif; ?>>
                        <label class="form-check-label" for="canRememberMe<?php echo e($cannabinoidss['id']); ?>">
                           <?php echo e($cannabinoidss['name']); ?>

                        </label>
                    </div>
                  </div>
                </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
     
      </ul>
 </div>
  <?php endif; ?>

 <!---------------end anobodies dropdown-------------->


 <!--------------start-helped with dropdown---------------------->
<div class="title-list-cart reort-effect">Reported Effects

 <?php if(isset($reported_effects) && !empty($reported_effects)): ?>
   <a href="javascript:void(0)" class="clearfiltr" id="effectsfilter" onclick="return clearfilter('reported_effects');">Clear Filter</a>
  <?php endif; ?>
</div>

<?php
  if(isset($reported_effects) && !empty($reported_effects))
  {
    $reported_effects_1 =  str_replace("_"," ",explode("-",$reported_effects));
  }

?>
  


<div class="checkbox-dropdown nospace-home"> 
      Helped with  
      <ul class="checkbox-dropdown-list">
        <?php /* ?>
        <li>
           <div class="checkbox clearfix">
              <div class="form-check checkbox-theme">
                  <input class="form-check-input" type="checkbox" value="anxiety" id="rememberMe"  name="emojis[]" onclick="getCheckBoxValues()" 
                  <?php if(isset($reported_effects) && !empty($reported_effects) && isset($reported_effects_1) && in_array('anxiety', $reported_effects_1)): ?> checked="checked" <?php endif; ?>>
                  <label class="form-check-label" for="rememberMe">
                     Anxiety
                     <img src='<?php echo url('/'); ?>/assets/images/anxiety.svg' width="32px"/>
                  </label>
              </div>
            </div>
          </li>
          <li>
           <div class="checkbox clearfix">
              <div class="form-check checkbox-theme">
                  <input class="form-check-input" type="checkbox" value="focus" id="rememberMe2"  name="emojis[]" onclick="getCheckBoxValues()"  <?php if(isset($reported_effects) && !empty($reported_effects) && isset($reported_effects_1) && in_array('focus', $reported_effects_1)): ?> checked="checked" <?php endif; ?>>
                  <label class="form-check-label" for="rememberMe2">
                     Focus
                     <img src='<?php echo url('/'); ?>/assets/images/focus.svg' width="32px">
                  </label>
              </div>
            </div>
          </li>
          <li>
           <div class="checkbox clearfix">
              <div class="form-check checkbox-theme">
                  <input class="form-check-input" type="checkbox" value="pain" id="rememberMe3"  name="emojis[]" onclick="getCheckBoxValues()" <?php if(isset($reported_effects) && !empty($reported_effects) && isset($reported_effects_1) && in_array('pain', $reported_effects_1)): ?> checked="checked" <?php endif; ?>>

                  <label class="form-check-label" for="rememberMe3">
                     Pain
                     <img src='<?php echo url('/'); ?>/assets/images/pain.svg' width="32px">
                  </label>
              </div>
            </div>
          </li>
          <li>
           <div class="checkbox clearfix">
              <div class="form-check checkbox-theme">
                  <input class="form-check-input" type="checkbox" value="sleep" id="rememberMe4"  name="emojis[]" onclick="getCheckBoxValues()" <?php if(isset($reported_effects) && !empty($reported_effects) && isset($reported_effects_1) && in_array('sleep', $reported_effects_1)): ?> checked="checked" <?php endif; ?>>
                  <label class="form-check-label" for="rememberMe4">
                    Sleep
                     <img src='<?php echo url('/'); ?>/assets/images/sleep.svg' width="32px">
                  </label>
              </div>
            </div>
          </li>
          <li>
           <div class="checkbox clearfix">
              <div class="form-check checkbox-theme">
                  <input class="form-check-input" type="checkbox" value="skin" id="rememberMe5"  name="emojis[]" onclick="getCheckBoxValues()" <?php if(isset($reported_effects) && !empty($reported_effects) && isset($reported_effects_1) && in_array('skin', $reported_effects_1)): ?> checked="checked" <?php endif; ?>>
                  <label class="form-check-label" for="rememberMe5">
                    Skin
                     <img src='<?php echo url('/'); ?>/assets/images/skin.svg' width="32px">
                  </label>
              </div>
            </div>
          </li>
          <?php */ ?>

          <?php if(isset($get_reported_effects) && !empty($get_reported_effects)): ?>
           <?php $__currentLoopData = $get_reported_effects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
             <div class="checkbox clearfix">
                <div class="form-check checkbox-theme">
                    <input class="form-check-input" type="checkbox" value="<?php echo e($v['title']); ?>" id="rememberMe1<?php echo e($v['id']); ?>"  name="emojis[]" onclick="getCheckBoxValues()" <?php if(isset($reported_effects) && !empty($reported_effects) && isset($reported_effects_1) && in_array($v['title'], $reported_effects_1)): ?> checked="checked" <?php endif; ?>>
                    <label class="form-check-label" for="rememberMe1<?php echo e($v['id']); ?>">
                      <?php echo e(isset($v['title']) ? $v['title'] : ''); ?>

                       <?php if(file_exists(base_path().'/uploads/reported_effects/'.$v['image']) && isset($v['image']) && !empty($v['image'])): ?>
                       <img src='<?php echo e(url('/')); ?>/uploads/reported_effects/<?php echo e($v['image']); ?>' width="32px" title="<?php echo e($v['title']); ?>" />
                       <?php endif; ?> 
                    </label>
                </div>
              </div>
             </li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>  

       
      </ul>
 </div>

<hr/>

 <!---------------end helped with dropdown-------------->


  <!------------------start---chows choice filter----------------->
   
    <div class="title-list-cart">Chow's Choice</div>
    <div class="check-box"> 
        <input type="checkbox" class="css-checkbox" id="chows_choice" name="chows_choice" <?php if(isset($chows_choice) && $chows_choice==true): ?> checked <?php endif; ?> onclick="return filter_by_chows_choice()"  />
        <label class="css-label radGroup4" for="chows_choice">Chow's choice</label>
    </div>

<hr/>

<!----------------------end chows choice filter end------------------>


  <div class="title-list-cart">On Sale</div>
  
    <div class="check-box">
      <input type="checkbox" class="css-checkbox" id="filterby_price_drop" name="filterby_price_drop" <?php if(isset($filterby_price_drop) && $filterby_price_drop==true): ?> checked <?php endif; ?> onclick="return filter_by_price_drop()"  />
      <label class="css-label radGroup2" for="filterby_price_drop">Today's Deals</label>
    </div>

 <div class="border-list-side"></div>
        <?php if(isset($category_arr) && count($category_arr) > 0): ?> 
            <div class="title-list-cart">Category 
              <?php if(isset($cat_id)): ?><a href="javascript:void(0)" class="clearfiltr" id="categoryfilter" onclick="return clearfilter('category');">Clear Filter</a><?php endif; ?>
            </div>
            <ul class="list-cart-abt"> 
            <?php $__currentLoopData = $category_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

               <!-------------------------------------------------------------->
                <?php
                  $link = '';
                  if(isset($category['id'])){

                    $category_name = isset($category['product_type'])?$category['product_type']:'';
                    $category_name = str_replace(" ", "-", $category_name);  
                    $category_name = str_replace("-&-", "-and-", $category_name);  
                    $link = url('search?category_id='.$category_name);
                    // $link = url('search?category_id='.base64_encode($category['id']));
                  } 
                  if(isset($mg)){
                     $link .= '&mg='.$mg;
                  }
                  if(isset($brand)){
                     $link .= '&brand='.$brand;
                  }
                  if(isset($brands)){
                     $link .= '&brands='.$brands;
                  }
                  if(isset($sellers)){
                     $link .= '&sellers='.$sellers;
                  }
                  if(isset($price)){
                     $link .= '&price='.$price;
                  }
                  if(isset($rating)){
                     $link .= '&rating='.$rating;
                  }
                  if(isset($age_restrictions)){
                     $link .= '&age_restrictions='.$age_restrictions;
                  } 
                  if(isset($filterby_price_drop)){
                     $link .= '&filterby_price_drop='.$filterby_price_drop;
                  }    

                 // if(isset($filterby_price_drop)){
                    // $link .= '&filterby_price_drop='.$filterby_price_drop;
                  //}           

                  if(isset($product_search)){
                     $link .= '&product_search='.$product_search;
                  }   
                  if(isset($state)){
                     $link .= '&state='.$state;
                  }  
                  if(isset($city)){
                     $link .= '&city='.$city;
                  }  
                  if(isset($chows_choice)){
                     $link .= '&chows_choice='.$chows_choice;
                  }  
                  if(isset($best_seller)){
                     $link .= '&best_seller='.$best_seller;
                  }  
                  if(isset($spectrum)){
                     $link .= '&spectrum='.$spectrum;
                  }
                  if(isset($statelaw)){
                     $link .= '&statelaw='.$statelaw;
                  }
                   if(isset($reported_effects)){
                     $link .= '&reported_effects='.$reported_effects;
                  } 
                  //dd($cannabinoids);
                  if(isset($cannabinoids)){
                     $link .= '&cannabinoids='.$cannabinoids;
                  }
                  if($featured)
                  {
                    $link .= '&featured='.$featured;
                  }
                  if($category_name == "Skincare-&-Topicals")
                  {
                    // dd($cat_id); 
                  }
                  
                 ?>
                 
                  <li>

                      <a  href="<?php echo e($link); ?>" <?php if(isset($cat_id) && $cat_id == $category_name): ?> class="active"  style='color:#873dc8' <?php endif; ?>><i class="fa fa-angle-left"></i><?php echo e($category['product_type']); ?> </a>
                      
                  </li>

                <!-------------------------------------------------------------->

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
            </ul>
        <?php endif; ?>    
        
          
        <div class="border-list-side"></div>
        <div class="title-list-cart">Price 
           <?php if(isset($price)): ?>
            <a href="javascript:void(0)" class="clearfiltr" id="pricefilter" onclick="return clearfilter('price');">Clear Filter</a>
            <?php endif; ?>
           
          </div>
          <div class="range-t input-bx" for="amount">
            <div id="slider-price-range" class="slider-rang"></div>
            <div class="amount-no" id="slider_price_range_txt"></div>
            <div class="clearfix"></div>
        </div>
 <div class="border-list-side"></div>

        <div class="title-list-cart">Concentration (mg) 
           <?php if(isset($mg)): ?>
          <a href="javascript:void(0)" class="clearfiltr" id="mgfilter" onclick="return clearfilter('mg');">Clear Filter</a>
          <?php endif; ?>
        </div>
        <div class="range-t input-bx" for="amount">
            <div id="slider-price-range2" class="slider-rang"></div>
            <div class="amount-no" id="slider_price_range_txt2"></div>
            <div class="clearfix"></div>
        </div>
        
        <!-- <div class="border-list-side"></div>
        <div class="check-box">
            <input type="checkbox" checked="checked" class="css-checkbox" id="checkbox4" name="radiog_dark" />
            <label class="css-label radGroup2" for="checkbox4">Same Day Delivery</label>
        </div> -->

		<div class="border-list-side"></div>

       
        <div class="radio-btns agerestricted">

           
          
           

         
        </div>


          <!------------------spectrum-filter------------------------------>
          <div class="title-list-cart">Spectrum 
           <?php if(isset($spectrum)): ?>
          <a href="javascript:void(0)" class="clearfiltr" id="spectrumfilter" onclick="return clearfilter('spectrum');">Clear Filter</a>
          <?php endif; ?>
          </div>
          <div class="searchbrands form-group form-box">
            <div class="select-style">

             <?php 
                $spectrumarr = get_spectrums();
              ?>

               <select class="frm-select" name="spectrum" id="searchbyspectrum" placeholder="Search by Spectrum" onchange="return filter_by_spectrum($(this))">
                  <option value="">Select Spectrum</option>
                  <?php if(isset($spectrumarr) && !empty($spectrumarr)): ?>
                    <?php $__currentLoopData = $spectrumarr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spectrum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <option value="<?php echo e($spectrum['name']); ?>" 
                      <?php if(isset($spectrum) 
                      && isset($spectrum_details['name']) 
                      && $spectrum_details['name']==$spectrum['name']): ?> selected <?php endif; ?>>
                       <?php echo e($spectrum['name']); ?>

                     </option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>

 
           



            <div id="spectrumList"></div>
            <span id="spectrumerr"></span>
             </div>
          </div>
          <!-----------------spectrum-filter-------------------------------->



       <!------------------Restricted and allowed-filter------------------------------>
         <hr>
          <div class="title-list-cart">State Laws  <span class="colorbk" data-toggle="tooltip" data-html="true" title="This is only accurate when user logs in"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
           <?php if(isset($statelaw)): ?>
          <a href="javascript:void(0)" class="clearfiltr" id="statelawfilter" onclick="return clearfilter('statelaw');">Clear Filter</a>
          <?php endif; ?>
          </div>
          <div class="searchbrands form-group form-box">
            <div class="select-style">

          
               <select class="frm-select" name="statelaw" id="searchbystatelaw" placeholder="Search by Statelaw" onchange="return filter_by_statelaw($(this))">
                  <option >Select</option>
                   <option value="Allowed" <?php if(isset($statelaw)                      
                      && $statelaw=="Allowed"): ?> selected <?php endif; ?>>Allowed</option>
                    <option value="Restricted"  <?php if(isset($statelaw)                      
                      && $statelaw=="Restricted"): ?> selected <?php endif; ?>>Not Allowed</option>
                </select>

         
             </div>
          </div>
          <!--------------end-Restricted and allowed-filter-------------------------------->   


       <!------------------start---best seller filter----------------->
            <hr>
            <div class="title-list-cart">Best Seller</div>
            <div class="check-box"> 
                <input type="checkbox" class="css-checkbox" id="best_seller" name="best_seller" <?php if(isset($best_seller) && $best_seller==true): ?> checked <?php endif; ?> onclick="return filter_by_best_seller()"  />
                <label class="css-label radGroup3" for="best_seller">Best Seller</label>
            </div>

       <!----------------------best seller fileter end------------------>


          

        <div class="border-list-side"></div>

        <div class="title-list-cart">Customer Ratings 
          <?php if(isset($rating)): ?>
          <a href="javascript:void(0)" class="clearfiltr" id="ratingfilter" onclick="return clearfilter('rating');">Clear Filter</a>
          <?php endif; ?>
        </div>
        <div class="radio-btns">

            <div class="radio-btn" title="5 Ratings">
                <input type="radio" id="f-option" name="rating" value="5" <?php if(isset($rating) && base64_decode($rating)==5): ?> checked="checked" <?php endif; ?> onclick="return filter_by_rating($(this))">
                <label for="f-option">
                   
                  <img src="<?php echo e(url('/')); ?>/assets/front/images/star/5.svg" alt="Five Star Rating">
                </label>
                <div class="check"></div>
            </div>
          
            <div class="radio-btn" title="4 Ratings">
                <input type="radio" id="s-option" name="rating" value="4" <?php if(isset($rating) && base64_decode($rating)==4): ?> checked="checked" <?php endif; ?> onclick="return filter_by_rating($(this))">
                <label for="s-option">
                  
                 <img src="<?php echo e(url('/')); ?>/assets/front/images/star/4.svg" alt="Four Star Rating"> 
                </label>
                <div class="check"><div class="inside"></div></div>
            </div>

            <div class="radio-btn" title="3 Ratings">
                <input type="radio" id="a-option" name="rating" value="3" <?php if(isset($rating) && base64_decode($rating)==3): ?> checked="checked" <?php endif; ?> onclick="return filter_by_rating($(this))">
                <label for="a-option">
                  
                   <img src="<?php echo e(url('/')); ?>/assets/front/images/star/3.svg" alt="Three Star Rating">
                </label>
                <div class="check"><div class="inside"></div></div>
            </div>

            <div class="radio-btn" title="2 Ratings">
                <input type="radio" id="b-option" name="rating" value="2" <?php if(isset($rating) && base64_decode($rating)==2): ?> checked="checked" <?php endif; ?> onclick="return filter_by_rating($(this))">
                <label for="b-option">
                 
                  <img src="<?php echo e(url('/')); ?>/assets/front/images/star/2.svg" alt="Two Star Rating"> 
                </label>
                <div class="check"><div class="inside"></div></div>
            </div>

            <div class="radio-btn" title="1 Rating">
                <input type="radio" id="c-option" name="rating" value="1" 
                  <?php if(isset($rating) && base64_decode($rating)==1): ?> checked="checked" <?php endif; ?> onclick="return filter_by_rating($(this))">
                <label for="c-option">
                 
                  <img src="<?php echo e(url('/')); ?>/assets/front/images/star/1.svg" alt="One Star Rating">
                </label>
                <div class="check"><div class="inside"></div></div>
            </div>

        </div>

        <!------------state-filter------------------------->
             
        <!-------------state-filter--------------------->

         <!------------city-filter------------------------->
             
        <!-------------city-filter--------------------->


      </div>
    </div>
</div>
<script type="text/javascript">
  $(".checkbox-dropdown").click(function () {
    $(this).toggleClass("is-active");
});

$(".checkbox-dropdown ul").click(function(e) {
    e.stopPropagation();
});

</script>

<script>

  function clearfilter(filterby)
  {

     var currenturl = document.URL;
    
     var cat_id = $("#category").val();
     var price = $("#price").val();
     var rating = $("#rating").val();
     var age_restrictions = $("#age_restrictions").val();
     var brands = $("#brands").val(); // search by brands
     var sellers = $("#sellers").val(); // search by sellers
     var brand = $("#brand").val();
     var mg = $("#mg").val();
     var price_drop = $("#price_drop").val();
     var product_search = $("#product_search").val();
     var state = $("#state").val();
     var city = $("#city").val();
   //  var chows_choice = $("#chows_choice").val();
    // var best_seller = $("#best_seller").val();
     var spectrum = $("#spectrum").val();
     var statelaw = $("#statelaw").val();

     var best_sellerval = $("#best_sellerval").val();
     var chows_choiceval = $("#chows_choiceval").val();

     var reported_effectsval = $("#reported_effectsval").val();
     var cannabinoidsval = $("#cannabinoidsval").val();
     var cannabinoids = $("#cannabinoids").val();


     var featured_option = $("#featured_option").val();


      if(filterby=="category")
      {
          $("#category").val('');
      }
      if(filterby=="price")
      {
          $("#price").val('');
      }
       if(filterby=="rating")
      {
          $("#rating").val('');
      }
        if(filterby=="rating")
      {
          $("#rating").val('');
      }
       if(filterby=="age_restrictions")
      {
        $("#age_restrictions").val('');
      }
       if(filterby=="brands")
      {
        $("#brands").val('');
      }
      if(filterby=="sellers")
      {
        $("#sellers").val('');
      }
     if(filterby=="brand")
      {
        $("#brand").val('');
      }
      if(filterby=="mg")
      {
        $("#mg").val('');
      }
       if(filterby=="price_drop")
      {
        $("#price_drop").val('');
      }
       if(filterby=="state")
      {
          $("#state").val('');
      }
        if(filterby=="city")
      {
          $("#city").val('');
      }
      //   if(filterby=="chows_choice")
      // {
      //     $("#chows_choice").val('');
      // }

        if(filterby=="chows_choiceval")
      {
          $("#chows_choiceval").val('');
      }

      //   if(filterby=="best_seller")
      // {
      //     $("#best_seller").val('');
      // }

      if(filterby=="best_sellerval")
      {
          $("#best_sellerval").val('');
      }

       if(filterby=="spectrum")
      {
          $("#spectrum").val('');
      }
      if(filterby=="statelaw")
      {
          $("#statelaw").val('');
      }

      if(filterby=="reported_effects")
      {
          $("#reported_effectsval").val('');
      }

      if(filterby=="cannabinoids")
      {
          $("#cannabinoidsval").val('');
          $("#cannabinoids").val('');
      }

      if(filterby=="featured")
      {
          $("#featured_option").val('');
      }




     var cat_id = $("#category").val();
     var price = $("#price").val();
     var rating = $("#rating").val();
     var age_restrictions = $("#age_restrictions").val();
     var brands = $("#brands").val();  // search by brands
     var sellers = $("#sellers").val(); // search by sellers
     var brand = $("#brand").val();
     var mg = $("#mg").val();
     var price_drop = $("#price_drop").val();

     var product_search = $("#product_search").val();
     var state = $("#state").val();
     var city = $("#city").val();
   //  var chows_choice = $("#chows_choice").val();
    // var best_seller = $("#best_seller").val();
     var spectrum = $("#spectrum").val();
     var statelaw = $("#statelaw").val();

     var best_sellerval = $("#best_sellerval").val();
     var chows_choiceval = $("#chows_choiceval").val();

     var reported_effectsval = $("#reported_effectsval").val();
     var cannabinoidsval = $("#cannabinoidsval").val();

     var featured_option = $("#featured_option").val();


     
     /*****************************************************************/

       var link ='';
       link += SITE_URL+'/search?';


      if(price_drop && price_drop!='false')
      {
        link += 'filterby_price_drop='+price_drop+"&";
      }
     
       if(age_restrictions!=''){
         link += 'age_restrictions='+age_restrictions+"&";
       }       
        if(brands)
       {
         link += 'brands='+brands+"&";
       }
         if(sellers)
       {
         link += 'sellers='+sellers+"&";
       }
        if(cat_id)
       {
         link += 'category_id='+cat_id+"&";
       }
         if(mg)
       {
         link += 'mg='+mg+"&";
       }
       if(price)
       {
         link += 'price='+price+"&";
       }     
         if(rating)
       {
         link += 'rating='+rating+"&";
       }
        if(product_search)
       {
         link += 'product_search='+product_search+"&";
       }
        if(state)
       {
         link += 'state='+state+"&";
       }
        if(city)
       {
         link += 'city='+city+"&";
       }
        if(chows_choiceval && chows_choiceval!='false')
       {
         link += 'chows_choice='+chows_choiceval+"&";
       }
       // if(best_seller && best_seller!='false')
       // {
       //   link += 'best_seller='+best_seller+"&";
       // }
        if(best_sellerval && best_sellerval!='false')
       {
         link += 'best_seller='+best_sellerval+"&";
       }
        if(spectrum)
       {
         link += 'spectrum='+spectrum+"&";
       }
        if(statelaw)
       {
         link += 'statelaw='+statelaw+"&";
       }
        
        if(reported_effectsval)
       {
         link += 'reported_effects='+reported_effectsval+"&";
       }

       if(cannabinoidsval)
       {
         link += 'cannabinoids='+cannabinoidsval+"&";
       }

       if(featured_option)
       {
         link += 'featured='+featured_option+"&";
       }



       link = link.substring(0, link.length -1);
              
       window.location.href = link;




   
     
  }

   function filter_by_age(ref)
  {
      var age_restrictions   = ref.val();
      var price = $("#price").val();
      var category = $("#category").val();
      var rating = $("#rating").val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val(); // search by sellers
      var brand = $("#brand").val(); // search by brand
      var mg = $("#mg").val();
      if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }


      var product_search = $("#product_search").val();
      var state = $("#state").val();
      var city = $("#city").val();
    //  var chows_choice = $("#chows_choice").val();
     // var best_seller = $("#best_seller").val();
      var spectrum = $("#spectrum").val();
      var statelaw = $("#statelaw").val();
      var reported_effects = $("#reported_effects").val();
      var cannabinoids = $("#cannabinoids").val();

      var featured_option = $("#featured_option").val();


       if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }

        if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }


        var link ='';
        if(age_restrictions!=''){
         link = SITE_URL+'/search?age_restrictions='+btoa(age_restrictions);
        }       
        if(brands)
       {
         link += '&brands='+brands;
       }
         if(sellers)
       {
         link += '&sellers='+sellers;
       }
        if(category)
       {
         link += '&category_id='+category;
       }
         if(mg)
       {
         link += '&mg='+mg;
       }
       if(price)
       {
         link += '&price='+price;
       }     
         if(rating)
       {
         link += '&rating='+rating;
       }
        if(filterby_price_drop)
       {
         link += '&filterby_price_drop='+filterby_price_drop ;
       }

        if(product_search)
       {
         link += '&product_search='+product_search ;
       }
       if(state)
       {
         link += '&state='+state ;
       }
       if(city)
       {
         link += '&city='+city ;
       }
        if(spectrum)
       {
         link += '&spectrum='+spectrum;
       }   
        if(chows_choice)
       {
        
         link += '&chows_choice='+chows_choice ;
       }
       //  if(best_seller && best_seller!="false")
       // {
        
       //   link += '&best_seller='+best_seller ;
       // }
        if(best_seller)
       {
         link += '&best_seller='+best_seller ;
       }
        if(statelaw)
       {
         link += '&statelaw='+statelaw;
       } 
         if(reported_effects)
       {
         link += '&reported_effects='+reported_effects;
       } 
      if(cannabinoids)
       {
         link += '&cannabinoids='+cannabinoids;
       } 

        if(featured_option)
        {
           link += '&featured='+featured_option;
        } 

       window.location.href = link;



  }
  
  function filter_by_price_drop()
  {
      
      var age_restrictions = $("#age_restrictions").val();
      var price = $("#price").val();
      var category = $("#category").val();
      var rating = $("#rating").val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val(); // search by sellers
      var brand = $("#brand").val(); // search by brand
      var mg = $("#mg").val();
      if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }
          
      var product_search = $("#product_search").val();    
      var state = $("#state").val();
      var city = $("#city").val();
     // var chows_choice = $("#chows_choice").val();
     // var best_seller = $("#best_seller").val();
      var spectrum = $("#spectrum").val();
      var statelaw = $("#statelaw").val();
      var reported_effects = $("#reported_effects").val();
      var cannabinoids = $("#cannabinoids").val();

      var featured_option = $("#featured_option").val();


      if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }


       if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }



      var link ='';

      if(filterby_price_drop)
      {
        link += SITE_URL+'/search?filterby_price_drop='+filterby_price_drop+"&";
      }
      else{
        link += SITE_URL+'/search?';
      }
        if(age_restrictions!=''){
         link += 'age_restrictions='+age_restrictions+"&";
        }       
        if(brands)
       {
         link += 'brands='+brands+"&";
       }
         if(sellers)
       {
         link += 'sellers='+sellers+"&";
       }
        if(category)
       {
         link += 'category_id='+category+"&";
       }
         if(mg)
       {
         link += 'mg='+mg+"&";
       }
       if(price)
       {
         link += 'price='+price+"&";
       }     
         if(rating)
       {
         link += 'rating='+rating+"&";
       }

       if(product_search)
       {
         link += 'product_search='+product_search+"&" ;
       }

        if(state)
       {
         link += 'state='+state+"&" ;
       }
        if(city)
       {
         link += 'city='+city+"&" ;
       }
       if(spectrum)
       {
         link += 'spectrum='+spectrum+"&" ;
       }
        if(chows_choice)
       {
         link += 'chows_choice='+chows_choice+"&" ;
       }
       //  if(best_seller && best_seller!="false")
       // {
       //   link += 'best_seller='+best_seller+"&" ;
       // }

        if(best_seller)
       {
         link += 'best_seller='+best_seller+"&" ;
       }
       if(statelaw)
       {
         link += 'statelaw='+statelaw+"&" ;
       }
         
       if(reported_effects)
       {
         link += 'reported_effects='+reported_effects+"&";
       }  

       if(cannabinoids)
       {
         link += 'cannabinoids='+cannabinoids+"&";
       }  

       if(featured_option)
       {
         link += 'featured='+featured_option+"&";
       }  


       link = link.substring(0, link.length -1);
       
        
       window.location.href = link;


    

  }//end filter by price drop


  function filter_by_best_seller()
  {
      
      var age_restrictions = $("#age_restrictions").val();
      var price = $("#price").val();
      var category = $("#category").val();
      var rating = $("#rating").val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val(); // search by sellers
      var brand = $("#brand").val(); // search by brand
      var mg = $("#mg").val();
      if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }
          
      var product_search = $("#product_search").val();    
      var state = $("#state").val();
      var city = $("#city").val();
     // var chows_choice = $("#chows_choice").val();
     // var best_seller = $("#best_seller").val();
      var spectrum = $("#spectrum").val();
      var statelaw = $("#statelaw").val();

      var featured_option = $("#featured_option").val();

       if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }

       if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }
      var reported_effects = $("#reported_effects").val();
      var cannabinoids = $("#cannabinoids").val();




      var link ='';

      if(best_seller)
      {
        link += SITE_URL+'/search?best_seller='+best_seller+"&";
      }
      else{
        link += SITE_URL+'/search?';
      }
        if(age_restrictions!=''){
         link += 'age_restrictions='+age_restrictions+"&";
        }       
        if(brands)
       {
         link += 'brands='+brands+"&";
       }
         if(sellers)
       {
         link += 'sellers='+sellers+"&";
       }
        if(category)
       {
         link += 'category_id='+category+"&";
       }
         if(mg)
       {
         link += 'mg='+mg+"&";
       }
       if(price)
       {
         link += 'price='+price+"&";
       }     
         if(rating)
       {
         link += 'rating='+rating+"&";
       }

       if(product_search)
       {
         link += 'product_search='+product_search+"&" ;
       }

        if(state)
       {
         link += 'state='+state+"&" ;
       }
        if(city)
       {
         link += 'city='+city+"&" ;
       }
       if(spectrum)
       {
         link += 'spectrum='+spectrum+"&" ;
       }
        if(chows_choice)
       {
         link += 'chows_choice='+chows_choice+"&" ;
       }
       //  if(best_seller && best_seller!="false")
       // {
       //   link += 'best_seller='+best_seller+"&" ;
       // }
       if(statelaw)
       {
         link += 'statelaw='+statelaw+"&" ;
       }
        if(filterby_price_drop)
       {
         link += 'filterby_price_drop='+filterby_price_drop+"&" ;
       } 

        if(reported_effects)
       {
         link += 'reported_effects='+reported_effects+"&";
       }  

       if(cannabinoids)
       {
         link += 'cannabinoids='+cannabinoids+"&";
       }  


       if(featured_option)
       {
         link += 'featured='+featured_option+"&";
       }


       link = link.substring(0, link.length -1);
       
        
       window.location.href = link;


    

  }//end filter by best seller






  function filter_by_chows_choice()
  {
      
      var age_restrictions = $("#age_restrictions").val();
      var price = $("#price").val();
      var category = $("#category").val();
      var rating = $("#rating").val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val(); // search by sellers
      var brand = $("#brand").val(); // search by brand
      var mg = $("#mg").val();
      if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }
          
      var product_search = $("#product_search").val();    
      var state = $("#state").val();
      var city = $("#city").val();
    //  var chows_choice = $("#chows_choice").val();
     // var best_seller = $("#best_seller").val();
      var spectrum = $("#spectrum").val();
      var statelaw = $("#statelaw").val();
      var reported_effects = $("#reported_effects").val();
      var cannabinoids = $("#cannabinoids").val();

      var featured_option = $("#featured_option").val();


       if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }


       if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }

      var link ='';

      if(chows_choice)
      {
        link += SITE_URL+'/search?chows_choice='+chows_choice+"&";
      }
      else{
        link += SITE_URL+'/search?';
      }
        if(age_restrictions!=''){
         link += 'age_restrictions='+age_restrictions+"&";
        }       
        if(brands)
       {
         link += 'brands='+brands+"&";
       }
         if(sellers)
       {
         link += 'sellers='+sellers+"&";
       }
        if(category)
       {
         link += 'category_id='+category+"&";
       }
         if(mg)
       {
         link += 'mg='+mg+"&";
       }
       if(price)
       {
         link += 'price='+price+"&";
       }     
         if(rating)
       {
         link += 'rating='+rating+"&";
       }

       if(product_search)
       {
         link += 'product_search='+product_search+"&" ;
       }

        if(state)
       {
         link += 'state='+state+"&" ;
       }
        if(city)
       {
         link += 'city='+city+"&" ;
       }
       if(spectrum)
       {
         link += 'spectrum='+spectrum+"&" ;
       }
       //  if(chows_choice && chows_choice!="false")
       // {
       //   link += 'chows_choice='+chows_choice+"&" ;
       // }
        if(best_seller)
       {
         link += 'best_seller='+best_seller+"&" ;
       }
       if(statelaw)
       {
         link += 'statelaw='+statelaw+"&" ;
       }
        if(filterby_price_drop)
       {
         link += 'filterby_price_drop='+filterby_price_drop+"&" ;
       } 

        if(reported_effects)
       {
         link += 'reported_effects='+reported_effects+"&";
       } 

       if(cannabinoids)
       {
         link += 'cannabinoids='+cannabinoids+"&";
       }  

       if(featured_option)
       {
         link += 'featured='+featured_option+"&";
       }

       link = link.substring(0, link.length -1);
       
        
       window.location.href = link;


    

  }//end filter_by_chows_choice





    function filter_by_rating(ref)
  {

      var rating = ref.val();
      var price = $("#price").val();
      var age_restrictions = $("#age_restrictions").val();
      var category = $("#category").val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val();
      var mg = $("#mg").val();
      if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }

       var product_search = $("#product_search").val();  
       var state = $("#state").val();
       var city = $("#city").val();
       //var chows_choice = $("#chows_choice").val();
      // var best_seller = $("#best_seller").val();
       var spectrum = $("#spectrum").val();
       var statelaw = $("#statelaw").val();
       var reported_effects = $("#reported_effects").val();
       var cannabinoids = $("#cannabinoids").val();

       var featured_option = $("#featured_option").val();
 
       
       if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }

      if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }

        var link ='';
        if(rating!=''){
         link = SITE_URL+'/search?rating='+btoa(rating);
        }       
        if(brands)
       {
         link += '&brands='+brands;
       }
         if(sellers)
       {
         link += '&sellers='+sellers;
       }
        if(category)
       {
         link += '&category_id='+category;
       }
         if(mg)
       {
         link += '&mg='+mg;
       }
       if(price)
       {
         link += '&price='+price;
       }     
         if(age_restrictions)
       {
         link += '&age_restrictions='+age_restrictions;
       }    
       if(filterby_price_drop)
       {
         link += '&filterby_price_drop='+filterby_price_drop ;
       } 
       if(product_search)
       {
         link += '&product_search='+product_search ;
       }

        if(state)
       {
         link += '&state='+state ;
       }

        if(city)
       {
         link += '&city='+city ;
       }
       if(chows_choice)
       {
         link += '&chows_choice='+chows_choice ;
       }
       //  if(best_seller && best_seller!="false")
       // {
       //   link += '&best_seller='+best_seller ;
       // }
        if(best_seller)
       {
         link += '&best_seller='+best_seller ;
       }
       if(spectrum)
       {
         link += '&spectrum='+spectrum ;
       }
        if(statelaw)
       {
         link += '&statelaw='+statelaw ;
       }
         if(reported_effects)
       {
         link += '&reported_effects='+reported_effects;
       }    

       if(cannabinoids)
       {
         link += '&cannabinoids='+cannabinoids;
       }  

       if(featured_option)
       {
          link += '&featured='+featured_option;
       }


       window.location.href = link;


  }//end filter by rating



    function filter_by_spectrum(ref)
  {

      var spectrum = ref.val();

      if(spectrum){

      var price = $("#price").val();
      var age_restrictions = $("#age_restrictions").val();
      var category = $("#category").val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val();
      var mg = $("#mg").val();
      if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }

       var product_search = $("#product_search").val();  
       var state = $("#state").val();
       var city = $("#city").val();
      // var chows_choice = $("#chows_choice").val();
       //var best_seller = $("#best_seller").val();
       var rating = $("#rating").val();
       var statelaw = $("#statelaw").val();

      if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }


      if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }

      var reported_effects = $("#reported_effects").val();
      var cannabinoids = $("#cannabinoids").val();

      var featured_option = $('#featured_option').val();



        var link ='';
        if(spectrum!='')
        {
          spectrum = spectrum.replace(/\s+/g, "-"); 
          link = SITE_URL+'/search?spectrum='+spectrum+"&";
        }       
        else{
          link += SITE_URL+'/search?';
         }

        if(brands)
       {
          link += 'brands='+brands+"&";
       }
         if(sellers)
       {
         link += 'sellers='+sellers+"&";
       }
        if(category)
       {
         link += 'category_id='+category+"&";
       }
         if(mg)
       {
         link += 'mg='+mg+"&";
       }
       if(price)
       {
         link += 'price='+price+"&";
       }     
         if(age_restrictions)
       {
         link += 'age_restrictions='+age_restrictions+"&";
       }    
       if(filterby_price_drop)
       {
         link += 'filterby_price_drop='+filterby_price_drop+"&";
       } 
       if(product_search)
       {
         link += 'product_search='+product_search+"&";
       }

        if(state)
       {
         link += 'state='+state+"&";
       }

        if(city)
       {
         link += 'city='+city+"&";
       }
       if(chows_choice)
       {
         link += 'chows_choice='+chows_choice+"&";
       }
       //  if(best_seller && best_seller!="false")
       // {
       //   link += 'best_seller='+best_seller+"&";
       // }
        if(best_seller)
       {
         link += 'best_seller='+best_seller+"&";
       }
       if(rating)
       {
         link += 'rating='+rating+"&";
       }
        if(statelaw)
       {
         link += 'statelaw='+statelaw+"&";
       }

       if(reported_effects)
       {
         link += 'reported_effects='+reported_effects+"&";
       }

       if(cannabinoids)
       {
         link += 'cannabinoids='+cannabinoids+"&";
       }

       if(featured_option)
       {
          link += 'featured='+featured_option+"&";
       }  

        link = link.substring(0, link.length -1);
        window.location.href = link;
    
      }

  }//end filter by spectrum
 

   var loggedinuser="<?php echo e($loggedinuser); ?>";


    function filter_by_statelaw(ref)
  {
   
     if(loggedinuser.trim()=='0' || loggedinuser.trim()==0)
     {
       window.location.href=SITE_URL+'/login';
     }
     else{


      var statelaw = ref.val();

      if(statelaw){

      var price = $("#price").val();
      var age_restrictions = $("#age_restrictions").val();
      var category = $("#category").val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val();
      var mg = $("#mg").val();
      if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }

       var product_search = $("#product_search").val();  
       var state = $("#state").val();
       var city = $("#city").val();
      // var chows_choice = $("#chows_choice").val();
      // var best_seller = $("#best_seller").val();
       var rating = $("#rating").val();
       var spectrum = $("#spectrum").val();

      if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }


      if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }
      var reported_effects = $("#reported_effects").val();
      var cannabinoids = $("#cannabinoids").val();

      var featured_option = $("#featured_option").val();



        var link ='';
        if(statelaw!='')
        {
          link = SITE_URL+'/search?statelaw='+statelaw+"&";
        }       
        else{
          link += SITE_URL+'/search?';
         }

        if(brands)
       {
          link += 'brands='+brands+"&";
       }
         if(sellers)
       {
         link += 'sellers='+sellers+"&";
       }
        if(category)
       {
         link += 'category_id='+category+"&";
       }
         if(mg)
       {
         link += 'mg='+mg+"&";
       }
       if(price)
       {
         link += 'price='+price+"&";
       }     
         if(age_restrictions)
       {
         link += 'age_restrictions='+age_restrictions+"&";
       }    
       if(filterby_price_drop)
       {
         link += 'filterby_price_drop='+filterby_price_drop+"&";
       } 
       if(product_search)
       {
         link += 'product_search='+product_search+"&";
       }

        if(state)
       {
         link += 'state='+state+"&";
       }

        if(city)
       {
         link += 'city='+city+"&";
       }
       if(chows_choice)
       {
         link += 'chows_choice='+chows_choice+"&";
       }
       //  if(best_seller && best_seller!="false")
       // {
       //   link += 'best_seller='+best_seller+"&";
       // }
       if(best_seller)
       {
         link += 'best_seller='+best_seller+"&";
       }
       if(rating)
       {
         link += 'rating='+rating+"&";
       }
        if(spectrum)
       {
         link += 'spectrum='+spectrum+"&";
       }
         if(reported_effects)
       {
         link += 'reported_effects='+reported_effects+"&";
       } 
       if(cannabinoids)
       {
         link += 'cannabinoids='+cannabinoids+"&";
       }  

       if(featured_option)
       {
          link += 'featured='+featured_option+"&";
       }

        link = link.substring(0, link.length -1);
        window.location.href = link;
    
      }
    }//else of with login

  }//end filter by statelaw
   



</script>  
<script>
  

  /**************************************************************************/
     var lowest_mg = $('#lowest_mg').val();
     var highest_mg = $('#highest_mg').val();

      var minmg = $("#minmg").val(); //new added
      var maxmg = $("#maxmg").val(); //new added
    
      

     var mg = $('#mg').val();
     var min_selected_mg = mg.split('-')[0] || lowest_mg;
     var max_selected_mg = mg.split('-')[1] || highest_mg; 
  
      var lowest_mg = min_selected_mg || minmg;   //new added
      var highest_mg = max_selected_mg || maxmg;  //new added


      var age_restrictions = $("#age_restrictions").val();
      var category = $('#category').val();
      var price = $('#price').val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val();
      var rating = $("#rating").val();
      var brand = $("#brand").val();
      if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }

     var product_search = $("#product_search").val();  
     var state = $("#state").val();  
     var city = $("#city").val();  
    // var chows_choice = $("#chows_choice").val();
    // var best_seller = $("#best_seller").val();
     var spectrum = $("#spectrum").val();
     var statelaw = $("#statelaw").val();

      if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }
 

       if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }

      var reported_effects = $("#reported_effects").val();
      var cannabinoids = $("#cannabinoids").val();

      var featured_option = $("#featured_option").val();


   $(function() {
          $("#slider-price-range2").slider({
               range: true,
                min: 1,
               // max: 5000,
               // values: [0, 5000],
              // min: parseInt(lowest_mg),
               max: parseInt(highest_mg),
               values: [parseInt(min_selected_mg), parseInt(max_selected_mg)],
               slide: function(event, ui) {
                   // $("#slider_price_range_txt2").html("<span class='slider_price_min'> " + ui.values[0] + " mg</span>  <span class='slider_price_max'> " + ui.values[1] + " mg </span>");
                  $("#slider_price_range_txt2").html("<span class='slider_price_min'> <input type='text' name='minmg' id='minmg' onkeypress='return ValidNumeric()' onkeyup='changeminmg(this.value)' value='" + ui.values[0] + "'/></span>  <span class='slider_price_max'> <input type='text' name='maxmg' id='maxmg' onkeypress='return ValidNumeric()' onkeyup='changemaxmg(this.value)'   value='" + ui.values[1] + "' /></span><div class='clearfix'></div>");
               },
                stop: function (event, ui) {
                // var curVal = ui.value;
                 var minmg = ui.values[0];
                 var maxmg = ui.values[1];
                 var link ='';

                  if(minmg!='' && maxmg!=''){
                   link = SITE_URL+'/search?mg='+minmg+'-'+maxmg;
                  }       
                  if(brands)
                 {
                   link += '&brands='+brands;
                 }
                   if(sellers)
                 {
                   link += '&sellers='+sellers;
                 }
                  if(category)
                 {
                   link += '&category_id='+category;
                 }
                   if(price) 
                 {
                   link += '&price='+price;
                 }
                   if(age_restrictions)
                 {
                   link += '&age_restrictions='+age_restrictions;
                 }
                   if(rating)
                 {
                   link += '&rating='+rating;
                 }
                 if(filterby_price_drop)
                  {
                    link += '&filterby_price_drop='+filterby_price_drop ;
                  } 
                  if(product_search)
                  {
                    link += '&product_search='+product_search ;
                  }
                   if(state)
                  {
                    link += '&state='+state ;
                  }
                   if(city)
                  {
                    link += '&city='+city ;
                  }
                   if(spectrum)
                  {
                    link += '&spectrum='+spectrum ;
                  }
                   if(chows_choice)
                  {
                    link += '&chows_choice='+chows_choice ;
                  }
                  //   if(best_seller && best_seller!='false')
                  // {
                  //   link += '&best_seller='+best_seller ;
                  // }
                    if(best_seller)
                  {
                    link += '&best_seller='+best_seller ;
                  }
                   if(statelaw)
                  {
                    link += '&statelaw='+statelaw ;
                  }
                  
                  if(reported_effects)
                  {
                    link += '&reported_effects='+reported_effects;
                  }

                  if(cannabinoids)
                  {
                    link += '&cannabinoids='+cannabinoids;
                  }

                  if(featured_option)
                  {
                     link += '&featured='+featured_option;
                  }


                  window.location.href = link;

             
               
               }//stop function


           });
           // $("#slider_price_range_txt2").html("<span class='slider_price_min'>  " + $("#slider-price-range2").slider("values", 0) + " mg</span>  <span class='slider_price_max'> " + $("#slider-price-range2").slider("values", 1) + " mg</span>");

            $("#slider_price_range_txt2").html("<span class='slider_price_min'> <input type='text' name='minmg'  id='minmg'  onkeypress='return ValidNumeric()' onkeyup='changeminmg(this.value)' value='" + $("#slider-price-range2").slider("values", 0) + "' /></span>  <span class='slider_price_max'> <input type='text' name='maxmg' id='maxmg' onkeypress='return ValidNumeric()' onkeyup='changemaxmg(this.value)' value='" + $("#slider-price-range2").slider("values", 1) + "' /> </span><div class='clearfix'></div>");

         });  

function ValidNumeric() {    
    
    var charCode = (event.which) ? event.which : event.keyCode;    
    if (charCode >= 48 && charCode <= 57)    
    { return true; }    
    else    
    { return false; }    
}   
function changeminmg(minmg)
{
  
   var maxmg = $("#maxmg").val();

   /*if(parseInt(minmg)>=parseInt(maxmg))
   {
      var mg = $('#mg').val();
      var min_selected_mg = mg.split('-')[0] || lowest_mg;
      var max_selected_mg = mg.split('-')[1] || highest_mg;  

       $("#slider-price-range2" ).slider('values',0,min_selected_mg);
      $("#minmg").val(min_selected_mg);
        return false;
   }*/

   if(minmg!='' && minmg!=0 && maxmg!='' && parseInt(minmg)<=parseInt(maxmg))
   {
     $("#slider-price-range2" ).slider('values',0,minmg);
     $("#minmg").val(minmg);
      
   

      // var lowest_mg = $('#lowest_mg').val();
      // var highest_mg = $('#highest_mg').val();
      // var mg = $('#mg').val();
      // var min_selected_mg = mg.split('-')[0] || lowest_mg;
      // var max_selected_mg = mg.split('-')[1] || highest_mg; 

      var age_restrictions = $("#age_restrictions").val();
      var category = $('#category').val();
      var price = $('#price').val();
      var brands = $("#brands").val();
      var sellers = $("#sellers").val();
      var rating = $("#rating").val();
      var brand = $("#brand").val();
      if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }

     var product_search = $("#product_search").val();  
     var state = $("#state").val();  
     var city = $("#city").val();  
    // var chows_choice = $("#chows_choice").val();
    // var best_seller = $("#best_seller").val();
     var spectrum = $("#spectrum").val();
     var statelaw = $("#statelaw").val();

      if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }


      if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }

       var reported_effects = $("#reported_effects").val();
       var cannabinoids = $("#cannabinoids").val();

       var featured_option = $("#featured_option").val();


       var link ='';
        if(minmg!='' && maxmg!=''){
         link = SITE_URL+'/search?mg='+minmg.trim()+'-'+maxmg.trim();
        }       
        if(brands)
       {
         link += '&brands='+brands;
       }
         if(sellers)
       {
         link += '&sellers='+sellers;
       }
        if(category)
       {
         link += '&category_id='+category;
       }
         if(price) 
       {
         link += '&price='+price;
       }
         if(age_restrictions)
       {
         link += '&age_restrictions='+age_restrictions;
       }
         if(rating)
       {
         link += '&rating='+rating;
       }
       if(filterby_price_drop)
        {
          link += '&filterby_price_drop='+filterby_price_drop ;
        } 
        if(product_search)
        {
          link += '&product_search='+product_search ;
        }
         if(state)
        {
          link += '&state='+state ;
        }
         if(city)
        {
          link += '&city='+city ;
        }
         if(spectrum)
        {
          link += '&spectrum='+spectrum ;
        }
         if(chows_choice)
        {
          link += '&chows_choice='+chows_choice ;
        }
        //   if(best_seller && best_seller!='false')
        // {
        //   link += '&best_seller='+best_seller ;
        // }
          if(best_seller)
        {
          link += '&best_seller='+best_seller ;
        }
         if(statelaw)
        {
          link += '&statelaw='+statelaw ;
        }
         if(reported_effects)
         {
           link += '&reported_effects='+reported_effects;
         }  

         if(cannabinoids)
         {
           link += '&cannabinoids='+cannabinoids;
         }  

         if(featured_option)
         {
           link += '&featured='+featured_option;
         }


       window.location.href = link;



   }
}

function changemaxmg(maxmg)
{
   var minmg = $("#minmg").val();

    var featured_option = $("#featured_option").val();

   /* if(parseInt(minmg)>=parseInt(maxmg))
   {
      var mg = $('#mg').val();
      var min_selected_mg = mg.split('-')[0] || lowest_mg;
      var max_selected_mg = mg.split('-')[1] || highest_mg;  

      $( "#slider-price-range2" ).slider('values',1,max_selected_mg);
      $("#maxmg").val(max_selected_mg);
        return false;
   }*/



   if(maxmg!='' && maxmg!=0 && minmg!='' && parseInt(maxmg)>=parseInt(minmg))
   {
     $( "#slider-price-range2" ).slider('values',1,maxmg);
     $("#maxmg").val(maxmg);
     $('#highest_mg').val(maxmg);
       

        var link ='';
        if(minmg!='' && maxmg!=''){
         link = SITE_URL+'/search?mg='+minmg.trim()+'-'+maxmg.trim();
        }       
        if(brands)
       {
         link += '&brands='+brands;
       }
         if(sellers)
       {
         link += '&sellers='+sellers;
       }
        if(category)
       {
         link += '&category_id='+category;
       }
         if(price) 
       {
         link += '&price='+price;
       }
         if(age_restrictions)
       {
         link += '&age_restrictions='+age_restrictions;
       }
         if(rating)
       {
         link += '&rating='+rating;
       }
       if(filterby_price_drop)
        {
          link += '&filterby_price_drop='+filterby_price_drop ;
        } 
        if(product_search)
        {
          link += '&product_search='+product_search ;
        }
         if(state)
        {
          link += '&state='+state ;
        }
         if(city)
        {
          link += '&city='+city ;
        }
         if(spectrum)
        {
          link += '&spectrum='+spectrum ;
        }
         if(chows_choice)
        {
          link += '&chows_choice='+chows_choice ;
        }
          if(best_seller)
        {
          link += '&best_seller='+best_seller ;
        }
         if(statelaw)
        {
          link += '&statelaw='+statelaw ;
        }

        if(reported_effects)
        {
         link += '&reported_effects='+reported_effects;
        }  

         if(cannabinoids)
        {
         link += '&cannabinoids='+cannabinoids;
        }  

        if(featured_option)
        {
           link += '&featured='+featured_option;
        }

       window.location.href = link;

   }//maxmg
}


</script>

<script>
  $(document).ready(function() {

  var $toggleButton = $('.toggle-button'),
      $menuWrap = $('.col-3-list'),
      $sidebarArrow = $('.sidebar-menu-arrow');

  // Hamburger button

  $toggleButton.on('click', function() {
      handleOverlayClick();
    $(this).toggleClass('button-open');
    $menuWrap.toggleClass('menu-show');
    $("#main").toggleClass("overlay");
  });

  // Sidebar navigation arrows
  // $('#main').on('click', function() {
  //   $(".closelkds").trigger("click");
  //   $("#main").removeClass("overlay");
  //   closeNav();
  // });

 




  $sidebarArrow.click(function() {
    $(this).next().slideToggle(300);
  });

});

// function for searchbrand button click
$(document).on("click","#searchbrandbtn",function() {
    var searbrandval = $("#searchbybrand").val();
    var sellers = $("#sellers").val();
    var price = $("#price").val();
    var age_restrictions = $("#age_restrictions").val();
    var category_id = $("#category").val();
    var rating = $("#rating").val();
    var mg = $("#mg").val();
    if ($('#filterby_price_drop').is(":checked"))
    {
      var filterby_price_drop = true;
    }
    else{
      var filterby_price_drop = false;
    }

    var product_search = $("#product_search").val();  
    var state = $("#state").val();  
    var city = $("#city").val();  
  //  var chows_choice = $("#chows_choice").val();
    //var best_seller = $("#best_seller").val();
    var spectrum = $("#spectrum").val();
    var statelaw = $("#statelaw").val();

     if ($('#best_seller').is(":checked"))
    {
      var best_seller = true;
    }
    else{
      var best_seller = false;
    }


     if ($('#chows_choice').is(":checked"))
    {
      var chows_choice = true;
    }
    else{
      var chows_choice = false;
    }

    var reported_effects = $("#reported_effects").val();
    var cannabinoids = $("#cannabinoids").val();

    var featured_option = $("#featured_option").val();

   
    if(searbrandval)
    {

      searbrandval = searbrandval.replace(/\s+/g, "-");


        $("#branderr").html('');
        var link='';
        if(searbrandval!=''){
        // link = SITE_URL+'/search?brands='+btoa(searbrandval);
          link = SITE_URL+'/search?brands='+searbrandval;
        }       
       if(sellers)
       {
         link += '&sellers='+sellers;
       }
        if(category)
       {
         link += '&category_id='+category;
       }
         if(price)
       {
         link += '&price='+price;
       }
         if(age_restrictions)
       {
         link += '&age_restrictions='+age_restrictions;
       }
        if(mg)
       {
         link += '&mg='+mg;
       }
         if(rating)
       {
         link += '&rating='+rating;
       }
       if(filterby_price_drop)
      {
        link += '&filterby_price_drop='+filterby_price_drop ;
      } 
       if(product_search)
      {
        link += '&product_search='+product_search ;
      }
       if(state)
      {
        link += '&state='+state ;
      }
        if(city)
      {
        link += '&city='+city ;
      }
        if(spectrum)
      {
        link += '&spectrum='+spectrum ;
      }
       if(chows_choice)
      {
        link += '&chows_choice='+chows_choice ;
      }
       if(best_seller)
      {
        link += '&best_seller='+best_seller ;
      }
        if(statelaw)
      {
        link += '&statelaw='+statelaw ;
      }

      if(reported_effects)
      {
         link += '&reported_effects='+reported_effects;
      }

      if(cannabinoids)
      {
         link += '&cannabinoids='+cannabinoids;
      }

      if(featured_option)
      {
         link += '&featured='+featured_option;
      } 



       window.location.href = link;



    }
    else{
      $("#branderr").html('Please enter brand');
      $("#branderr").css('color','red');
    }
});


// function for search seller button click function 

$(document).on("click","#searchsellerbtn",function() {
    var searchbyseller = $("#searchbyseller").val();

    //var brands = $("#searchbybrand").val();
    var price = $("#price").val();
    var age_restrictions = $("#age_restrictions").val();
    var category_id = $("#category").val();
    var rating = $("#rating").val();
    var brands = $("#brands").val();
    var mg = $("#mg").val();
    if ($('#filterby_price_drop').is(":checked"))
      {
        var filterby_price_drop = true;
      }
      else{
        var filterby_price_drop = false;
      }

    var product_search = $("#product_search").val();  
    var state = $("#state").val();  
    var city = $("#city").val();  
   // var chows_choice = $("#chows_choice").val();
   // var best_seller = $("#best_seller").val();
    var spectrum = $("#spectrum").val();
    var statelaw = $("#statelaw").val();

     if ($('#best_seller').is(":checked"))
      {
        var best_seller = true;
      }
      else{
        var best_seller = false;
      }
 

      if ($('#chows_choice').is(":checked"))
      {
        var chows_choice = true;
      }
      else{
        var chows_choice = false;
      }

      var reported_effects = $("#reported_effects").val();
      var cannabinoids = $("#cannabinoids").val();

      var featured_option = $("#featured_option").val();

    if(searchbyseller)
    {
      $("#sellererr").html('');

        var link='';
        if(searchbyseller!=''){

         searchbyseller = searchbyseller.replace(/\s+/g, "-");
 
         link = SITE_URL+'/search?sellers='+searchbyseller;
        }       
       if(brands)
       {
         link += '&brands='+brands; 
       }
        if(category)
       {
         link += '&category_id='+category;
       }
         if(price)
       {
         link += '&price='+price;
       }
         if(age_restrictions)
       {
         link += '&age_restrictions='+age_restrictions;
       }
        if(mg)
       {
         link += '&mg='+mg;
       }
         if(rating)
       {
         link += '&rating='+rating;
       } 
       if(filterby_price_drop)
       {
         link += '&filterby_price_drop='+filterby_price_drop;
       }

       if(product_search)
      {
        link += '&product_search='+product_search ;
      }

       if(state)
      {
        link += '&state='+state ;
      }
        if(city)
      {
        link += '&city='+city ;
      }
        if(spectrum)
      {
        link += '&spectrum='+spectrum ;
      }
       if(chows_choice)
      {
        link += '&chows_choice='+chows_choice ;
      }
       if(best_seller)
      {
        link += '&best_seller='+best_seller ;
      }
       if(statelaw)
      {
        link += '&statelaw='+statelaw ;
      }

      if(reported_effects)
      {
        link += '&reported_effects='+reported_effects;
      }
      if(cannabinoids)
      {
        link += '&cannabinoids='+cannabinoids;
      }


      if(featured_option)
      {
         link += '&featured='+featured_option;
      } 

       window.location.href = link;

   
    }
    else{
      $("#sellererr").html('Please enter business name');
      $("#sellererr").css('color','red');
    }
});


// function for autosuggest of search by brand
 $('#searchbybrand').keyup(function(){ 
        var query = $(this).val();       
        var sellers = $("#sellers").val();
        var rating = $("#rating").val();
        var category = $("#category").val();
        var age_restrictions = $("#age_restrictions").val();
        var price = $("#price").val();
        var mg = $("#mg").val();
        if ($('#filterby_price_drop').is(":checked"))
        {
          var filterby_price_drop = true;
        }
        else{
          var filterby_price_drop = false;
        }

        var product_search = $("#product_search").val();  
        var state = $("#state").val();  
        var city = $("#city").val();  
      //  var chows_choice = $("#chows_choice").val();
      //  var best_seller = $("#best_seller").val();
        var spectrum =  $("#spectrum").val();
        var statelaw = $("#statelaw").val();

         if ($('#best_seller').is(":checked"))
        {
          var best_seller = true;
        }
        else{
          var best_seller = false;
        }

          if ($('#chows_choice').is(":checked"))
        {
          var chows_choice = true;
        }
        else{
          var chows_choice = false;
        }

        var reported_effects = $("#reported_effects").val();
        var cannabinoids = $("#cannabinoids").val();

        var featured_option = $("#featured_option").val();

        if(query != '')
        {
           var _token = "<?php echo e(csrf_token()); ?>";
           $.ajax({
            url:SITE_URL+'/autosuggest',
            method:"POST",
            data:{query:query, _token:_token,sellers:sellers,rating:rating,category_id:category,age_restrictions:age_restrictions,price:price,mg:mg,filterby_price_drop:filterby_price_drop,product_search:product_search,state:state,city:city,chows_choice:chows_choice,best_seller:best_seller,spectrum:spectrum,statelaw:statelaw,reported_effects:reported_effects,cannabinoids : cannabinoids,featured:featured_option},
            success:function(data){
             $('#brandList').fadeIn();  
             $('#brandList').html(data);
            }
           });
        }else{
           $('#brandList').fadeOut(); 
        }
    });  

     $(document).on('click', '.liclick', function(){  
        var id = $(this).attr('id');
       // $('#searchbybrand').val($(this).text());   //commented
        $('#brandList').fadeOut();  
        $("#branderr").html('');
    });   

     //new function added for autosuggest of brand list
     $(document).on('mouseleave', '#brandList', function(){  
        $('#brandList').fadeOut();  
    });



    /*$(document).on('mouseleave', '#brandList', function(){  
        $('#brandList').fadeOut();  
    });  */

// funciton to get autosuggest list of search by seller name
   $('#searchbyseller').keyup(function(){ 
        var query = $(this).val();    


        var rating = $("#rating").val();
        var category = $("#category").val();
        var age_restrictions = $("#age_restrictions").val();
        var price = $("#price").val();
        var brands = $("#brands").val();
        var brand = $("#brand").val();
        var mg = $("#mg").val();
        if ($('#filterby_price_drop').is(":checked"))
        {
          var filterby_price_drop = true;
        }
        else{
          var filterby_price_drop = false;
        }
        var product_search = $("#product_search").val();  
        var state = $("#state").val();  
        var city = $("#city").val();  
      //  var chows_choice = $("#chows_choice").val();
       // var best_seller = $("#best_seller").val();
        var spectrum =  $("#spectrum").val();
        var statelaw = $("#statelaw").val();

         if ($('#best_seller').is(":checked"))
        {
          var best_seller = true;
        }
        else{
          var best_seller = false;
        }


        if ($('#chows_choice').is(":checked"))
        {
          var chows_choice = true;
        }
        else{
          var chows_choice = false;
        }
        var reported_effects = $("#reported_effects").val();
        var cannabinoids = $("#cannabinoids").val();

        var featured_option = $("#featured_option").val();

        if(query != '')
        {
           var _token = "<?php echo e(csrf_token()); ?>";
           $.ajax({
            // url:SITE_URL+'/autosuggest_by_seller',
             url:SITE_URL+'/autosuggest_by_business',
            method:"POST",
            data:{query:query, _token:_token,category_id:category,rating:rating,age_restrictions:age_restrictions,price:price,brands:brands,brand:brand,mg:mg,filterby_price_drop:filterby_price_drop,product_search:product_search,state:state,city:city,chows_choice:chows_choice,best_seller:best_seller,spectrum:spectrum,statelaw:statelaw,reported_effects:reported_effects,cannabinoids : cannabinoids,featured:featured_option},
            success:function(data){
             $('#sellerList').fadeIn();  
             $('#sellerList').html(data);
            }
           });
        }else{
          $('#sellerList').fadeOut(); 
        }
    });  

     $(document).on('click', '.liclickseller', function(){ 
        var id = $(this).attr('id');
        //$('#searchbyseller').val($(this).text());   // commented
        $('#sellerList').fadeOut();  
        $("#sellerList").html('');

    });  
 

    // new function added for seller business list on mouse leave 
    $(document).on('mouseleave', '#sellerList', function(){  
        $('#sellerList').fadeOut();  
    });


    $(document).ready(function(){     
        var sellers_url = "<?php echo e($sellers); ?>";     
        if(sellers_url=='undefined' || sellers_url.trim()==""){
          $('#searchbyseller').val('');
        }

        var brands_url = "<?php echo e($brands); ?>";
       
         if(brands_url=='undefined' || brands_url.trim()==""){
          $('#searchbybrand').val('');
        }      
    });



       $('#searchbystate').keyup(function(){ 
        var query = $(this).val();    
        var rating = $("#rating").val();
        var category = $("#category").val();
        var age_restrictions = $("#age_restrictions").val();
        var price = $("#price").val();
        var brands = $("#brands").val();
        var brand = $("#brand").val();
        var mg = $("#mg").val();
        if ($('#filterby_price_drop').is(":checked"))
        {
          var filterby_price_drop = true;
        }
        else{
          var filterby_price_drop = false;
        }
        var product_search = $("#product_search").val();  
         var sellers = $("#sellers").val();
         var city = $("#city").val();
        // var chows_choice = $("#chows_choice").val();
        // var best_seller = $("#best_seller").val();
         var spectrum = $("#spectrum").val();
         var statelaw = $("#statelaw").val();

          if ($('#best_seller').is(":checked"))
        {
          var best_seller = true;
        }
        else{
          var best_seller = false;
        }

         if ($('#chows_choice').is(":checked"))
        {
          var chows_choice = true;
        }
        else{
          var chows_choice = false;
        }

         var reported_effects = $("#reported_effects").val();
         var cannabinoids = $("#cannabinoids").val();

         var featured_option = $("#featured_option").val();


        if(query != '')
        {
           var _token = "<?php echo e(csrf_token()); ?>";
           $.ajax({
            // url:SITE_URL+'/autosuggest_by_seller',
             url:SITE_URL+'/autosuggest_by_state',
            method:"POST",
            data:{query:query, _token:_token,category_id:category,rating:rating,age_restrictions:age_restrictions,price:price,brands:brands,brand:brand,mg:mg,filterby_price_drop:filterby_price_drop,product_search:product_search,sellers:sellers,city:city,chows_choice:chows_choice,best_seller:best_seller,spectrum:spectrum,statelaw:statelaw,reported_effects:reported_effects,cannabinoids : cannabinoids,featured:featured_option},
            success:function(data){
             $('#stateList').fadeIn();  
             $('#stateList').html(data);
            }
           });
        }else{
          $('#stateList').fadeOut(); 
        }
    });  
     $(document).on('click', '.liclickstate', function(){ 
        var id = $(this).attr('id');
        //$('#searchbyseller').val($(this).text());   // commented
        $('#stateList').fadeOut();  
        $("#stateList").html('');

    });  
 
    // new function added for state list on mouse leave 
    $(document).on('mouseleave', '#stateList', function(){  
        $('#stateList').fadeOut();  
        $("#searchbystate").val('');
    });
   

     $('#searchbycity').keyup(function(){ 
        var query = $(this).val();    
        var rating = $("#rating").val();
        var category = $("#category").val();
        var age_restrictions = $("#age_restrictions").val();
        var price = $("#price").val();
        var brands = $("#brands").val();
        var brand = $("#brand").val();
        var mg = $("#mg").val();
        if ($('#filterby_price_drop').is(":checked"))
        {
          var filterby_price_drop = true;
        }
        else{
          var filterby_price_drop = false;
        }
         var product_search = $("#product_search").val();  
         var sellers = $("#sellers").val();
         var state = $("#state").val();
        // var chows_choice = $("#chows_choice").val();
         //var best_seller = $("#best_seller").val();
         var spectrum = $("#spectrum").val();
         var statelaw = $("#statelaw").val();

         if ($('#best_seller').is(":checked"))
        {
          var best_seller = true;
        }
        else{
          var best_seller = false;
        }

        if ($('#chows_choice').is(":checked"))
        {
          var chows_choice = true;
        }
        else{
          var chows_choice = false;
        }
        var reported_effects = $("#reported_effects").val();
        var cannabinoids = $("#cannabinoids").val();


        var featured_option = $("#featured_option").val();

        if(query != '')
        {
           var _token = "<?php echo e(csrf_token()); ?>";
           $.ajax({
             url:SITE_URL+'/autosuggest_by_city',
            method:"POST",
            data:{query:query, _token:_token,category_id:category,rating:rating,age_restrictions:age_restrictions,price:price,brands:brands,brand:brand,mg:mg,filterby_price_drop:filterby_price_drop,product_search:product_search,sellers:sellers,state:state,chows_choice:chows_choice,best_seller:best_seller,spectrum:spectrum,statelaw:statelaw,reported_effects:reported_effects,cannabinoids: cannabinoids,featured:featured_option},
            success:function(data){
             $('#cityList').fadeIn();  
             $('#cityList').html(data);
            }
           });
        }else{
          $('#cityList').fadeOut(); 
        }
    });


    $(document).on('click', '.liclickcity', function(){ 
        var id = $(this).attr('id');
        $('#cityList').fadeOut();  
        $("#cityList").html('');

    });   
    
     // new function added for city list on mouse leave 
    $(document).on('mouseleave', '#cityList', function(){  
        $('#cityList').fadeOut();  
        $("#searchbycity").val('');
    });
   

 




// function for autosuggest of search by spectrum
 $('#searchbyspectrum').keyup(function(){ 
        var query = $(this).val();       
        var sellers = $("#sellers").val();
        var rating = $("#rating").val();
        var category = $("#category").val();
        var age_restrictions = $("#age_restrictions").val();
        var price = $("#price").val();
        var mg = $("#mg").val();
        if ($('#filterby_price_drop').is(":checked"))
        {
          var filterby_price_drop = true;
        }
        else{
          var filterby_price_drop = false;
        }

        var product_search = $("#product_search").val();  
        var state = $("#state").val();  
        var city = $("#city").val();  
       // var chows_choice = $("#chows_choice").val();
       // var best_seller = $("#best_seller").val();

         var brands = $("#brands").val();
        var brand = $("#brand").val();
         var statelaw = $("#statelaw").val();

         var featured_option = $("#featured_option").val();

         if ($('#best_seller').is(":checked"))
        {
          var best_seller = true;
        }
        else{
          var best_seller = false;
        }

        if ($('#chows_choice').is(":checked"))
        {
          var chows_choice = true;
        }
        else{
          var chows_choice = false;
        }
        var reported_effects = $("#reported_effects").val();
        var cannabinoids = $("#cannabinoids").val();

        if(query != '')
        {
           var _token = "<?php echo e(csrf_token()); ?>";
           $.ajax({
            url:SITE_URL+'/autosuggestspectrum',
            method:"POST",
            data:{query:query, _token:_token,sellers:sellers,rating:rating,category_id:category,age_restrictions:age_restrictions,price:price,mg:mg,filterby_price_drop:filterby_price_drop,product_search:product_search,state:state,city:city,chows_choice:chows_choice,best_seller:best_seller,brands:brands,brand:brand,statelaw:statelaw,reported_effects:reported_effects,cannabinoids: cannabinoids,featured:featured_option},
            success:function(data){
             $('#spectrumList').fadeIn();  
             $('#spectrumList').html(data);
            }
           });
        }else{
           $('#spectrumList').fadeOut(); 
        }
    });  

     $(document).on('click', '.liclick', function(){  
        var id = $(this).attr('id');
        $('#spectrumList').fadeOut();  
        $("#spectrumerr").html('');
    });   

     //new function added for autosuggest of spectrum list
     $(document).on('mouseleave', '#spectrumList', function(){  
        $('#spectrumList').fadeOut();  
    });








</script>


<script>
  function getCheckBoxValues()
  {
    var chk_emoji = "";

        $('[name="emojis[]"]').each( function ()
        {
           // if($(this).prop('checked') == true)
           // {
               var atLeastOneIsChecked = $('input[name="emojis[]"]:checked').length > 0;

               if($('input[name="emojis[]"]:checked').length > 0)
               {

                if($(this).prop('checked') == true){
                var reported_effects = $("#reported_effects").val();
                var cannabinoids = $("#cannabinoids").val();

               

                chk_emoji += $(this).val()+ "-";
               // alert(chk_emoji);

                $("#reported_effects").val(chk_emoji);

                 var reported_effects = $("#reported_effects").val();
                 var cannabinoids = $("#cannabinoids").val();


                  var price = $("#price").val();
                  var age_restrictions = $("#age_restrictions").val();
                  var category = $("#category").val();
                  var brands = $("#brands").val();
                  var sellers = $("#sellers").val();
                  var mg = $("#mg").val();
                  if ($('#filterby_price_drop').is(":checked"))
                  {
                    var filterby_price_drop = true;
                  }
                  else{
                    var filterby_price_drop = false;
                  }

                   var product_search = $("#product_search").val();  
                   var state = $("#state").val();
                   var city = $("#city").val();
                 
                   var rating = $("#rating").val();
                   var statelaw = $("#statelaw").val();

                   var featured_option = $("#featured_option").val();

                  if ($('#best_seller').is(":checked"))
                  {
                    var best_seller = true;
                  }
                  else{
                    var best_seller = false;
                  }


                  if ($('#chows_choice').is(":checked"))
                  {
                    var chows_choice = true;
                  }
                  else{
                    var chows_choice = false;
                  }
                   var spectrum = $("#spectrum").val();

                  

                    var link ='';
                    if(reported_effects!='')
                    {
                      reported_effects = reported_effects.replace(/\s+/g, "_"); 
                      link += SITE_URL+'/search?reported_effects='+reported_effects+"&";
                    }       
                    else{
                      link += SITE_URL+'/search?';
                     } 

                     if(cannabinoids!='')
                    {
                       link += 'cannabinoids='+cannabinoids+"&";
                    }       
                   

                    if(brands)
                   {
                      link += 'brands='+brands+"&";
                   }
                     if(sellers)
                   {
                     link += 'sellers='+sellers+"&";
                   }
                    if(category)
                   {
                     link += 'category_id='+category+"&";
                   }
                     if(mg)
                   {
                     link += 'mg='+mg+"&";
                   }
                   if(price)
                   {
                     link += 'price='+price+"&";
                   }     
                     if(age_restrictions)
                   {
                     link += 'age_restrictions='+age_restrictions+"&";
                   }    
                   if(filterby_price_drop)
                   {
                     link += 'filterby_price_drop='+filterby_price_drop+"&";
                   } 
                   if(product_search)
                   {
                     link += 'product_search='+product_search+"&";
                   }

                    if(state)
                   {
                     link += 'state='+state+"&";
                   }

                    if(city)
                   {
                     link += 'city='+city+"&";
                   }
                   if(chows_choice)
                   {
                     link += 'chows_choice='+chows_choice+"&";
                   }
                  
                    if(best_seller)
                   {
                     link += 'best_seller='+best_seller+"&";
                   }
                   if(rating)
                   {
                     link += 'rating='+rating+"&";
                   }
                    if(statelaw)
                   {
                     link += 'statelaw='+statelaw+"&";
                   }
                    if(spectrum)
                    {
                      link += 'spectrum='+spectrum+"&" ;
                    }

                    if(featured_option)
                    {
                      link += 'featured='+featured_option+"&" ;
                    }


                    link = link.substring(0, link.length -1);
                    window.location.href = link; 
                  }//if checked true

                }//if length > 0
               else
               {
                    

                  var price = $("#price").val();
                  var age_restrictions = $("#age_restrictions").val();
                  var category = $("#category").val();
                  var brands = $("#brands").val();
                  var sellers = $("#sellers").val();
                  var mg = $("#mg").val();
                  if ($('#filterby_price_drop').is(":checked"))
                  {
                    var filterby_price_drop = true;
                  }
                  else{
                    var filterby_price_drop = false;
                  }

                   var product_search = $("#product_search").val();  
                   var state = $("#state").val();
                   var city = $("#city").val();
                 
                   var rating = $("#rating").val();
                   var statelaw = $("#statelaw").val();

                   var featured_option = $('#featured_option').val();

                  if ($('#best_seller').is(":checked"))
                  {
                    var best_seller = true;
                  }
                  else{
                    var best_seller = false;
                  }


                  if ($('#chows_choice').is(":checked"))
                  {
                    var chows_choice = true;
                  }
                  else{
                    var chows_choice = false;
                  }
                   var spectrum = $("#spectrum").val();
                   var cannabinoids = $("#cannabinoids").val();

                  

                    var link ='';
                   
                    link += SITE_URL+'/search?';
                    

                    if(brands)
                   {
                      link += 'brands='+brands+"&";
                   }
                     if(sellers)
                   {
                     link += 'sellers='+sellers+"&";
                   }
                    if(category)
                   {
                     link += 'category_id='+category+"&";
                   }
                     if(mg)
                   {
                     link += 'mg='+mg+"&";
                   }
                   if(price)
                   {
                     link += 'price='+price+"&";
                   }     
                     if(age_restrictions)
                   {
                     link += 'age_restrictions='+age_restrictions+"&";
                   }    
                   if(filterby_price_drop)
                   {
                     link += 'filterby_price_drop='+filterby_price_drop+"&";
                   } 
                   if(product_search)
                   {
                     link += 'product_search='+product_search+"&";
                   }

                    if(state)
                   {
                     link += 'state='+state+"&";
                   }

                    if(city)
                   {
                     link += 'city='+city+"&";
                   }
                   if(chows_choice)
                   {
                     link += 'chows_choice='+chows_choice+"&";
                   }
                  
                    if(best_seller)
                   {
                     link += 'best_seller='+best_seller+"&";
                   }
                   if(rating)
                   {
                     link += 'rating='+rating+"&";
                   }
                    if(statelaw)
                   {
                     link += 'statelaw='+statelaw+"&";
                   }
                    if(spectrum)
                    {
                      link += 'spectrum='+spectrum+"&" ;
                    }

                    if(featured_option)
                    {
                       link += 'featured='+featured_option+"&" ;
                    }
                     if(cannabinoids!='')
                    {
                       link += 'cannabinoids='+cannabinoids+"&";
                    }  

                    link = link.substring(0, link.length -1);
                    window.location.href = link; 

               }//else

           /* }//if chcekbox checked
            else if($(this).prop('checked') == false)
            {
              alert('not checked');
              var reported_effects = $("#reported_effects").val();
              //alert(reported_effects);
              var wordcount = reported_effects.trim().split('-').length;

              //alert(wordcount);

              if(reported_effects=='')
              {

                    var price = $("#price").val();
                  var age_restrictions = $("#age_restrictions").val();
                  var category = $("#category").val();
                  var brands = $("#brands").val();
                  var sellers = $("#sellers").val();
                  var mg = $("#mg").val();
                  if ($('#filterby_price_drop').is(":checked"))
                  {
                    var filterby_price_drop = true;
                  }
                  else{
                    var filterby_price_drop = false;
                  }

                   var product_search = $("#product_search").val();  
                   var state = $("#state").val();
                   var city = $("#city").val();
                 
                   var rating = $("#rating").val();
                   var statelaw = $("#statelaw").val();

                  if ($('#best_seller').is(":checked"))
                  {
                    var best_seller = true;
                  }
                  else{
                    var best_seller = false;
                  }


                  if ($('#chows_choice').is(":checked"))
                  {
                    var chows_choice = true;
                  }
                  else{
                    var chows_choice = false;
                  }
                   var spectrum = $("#spectrum").val();

                  

                    var link ='';
                   
                      link += SITE_URL+'/search?';
                    

                    if(brands)
                   {
                      link += 'brands='+brands+"&";
                   }
                     if(sellers)
                   {
                     link += 'sellers='+sellers+"&";
                   }
                    if(category)
                   {
                     link += 'category_id='+category+"&";
                   }
                     if(mg)
                   {
                     link += 'mg='+mg+"&";
                   }
                   if(price)
                   {
                     link += 'price='+price+"&";
                   }     
                     if(age_restrictions)
                   {
                     link += 'age_restrictions='+age_restrictions+"&";
                   }    
                   if(filterby_price_drop)
                   {
                     link += 'filterby_price_drop='+filterby_price_drop+"&";
                   } 
                   if(product_search)
                   {
                     link += 'product_search='+product_search+"&";
                   }

                    if(state)
                   {
                     link += 'state='+state+"&";
                   }

                    if(city)
                   {
                     link += 'city='+city+"&";
                   }
                   if(chows_choice)
                   {
                     link += 'chows_choice='+chows_choice+"&";
                   }
                  
                    if(best_seller)
                   {
                     link += 'best_seller='+best_seller+"&";
                   }
                   if(rating)
                   {
                     link += 'rating='+rating+"&";
                   }
                    if(statelaw)
                   {
                     link += 'statelaw='+statelaw+"&";
                   }
                    if(spectrum)
                    {
                      link += 'spectrum='+spectrum+"&" ;
                    }

                    link = link.substring(0, link.length -1);
                    window.location.href = link; 
                
              }//if empty
            } //else if 
           */
        });
    }
</script>



<script>
  function getCheckBoxValuescanobodies()
  {
    // alert('in cab');
    var chk_cannobinodies = "";

        $('[name="cannabinoids[]"]').each( function ()
        {
           // if($(this).prop('checked') == true)
           // {
               var atLeastOneIsChecked = $('input[name="cannabinoids[]"]:checked').length > 0;

               if($('input[name="cannabinoids[]"]:checked').length > 0)
               {

                if($(this).prop('checked') == true){
                var cannabinoids = $("#cannabinoids").val();

                

                chk_cannobinodies += $(this).val()+ "-";
               // alert(chk_emoji);

                $("#cannabinoids").val(chk_cannobinodies);

                 var cannabinoids = $("#cannabinoids").val();


                  var price = $("#price").val();
                  var age_restrictions = $("#age_restrictions").val();
                  var category = $("#category").val();
                  var brands = $("#brands").val();
                  var sellers = $("#sellers").val();
                  var mg = $("#mg").val();
                  if ($('#filterby_price_drop').is(":checked"))
                  {
                    var filterby_price_drop = true;
                  }
                  else{
                    var filterby_price_drop = false;
                  }

                   var product_search = $("#product_search").val();  
                   var state = $("#state").val();
                   var city = $("#city").val();
                 
                   var rating = $("#rating").val();
                   var statelaw = $("#statelaw").val();

                   var featured_option = $("#featured_option").val();

                  if ($('#best_seller').is(":checked"))
                  {
                    var best_seller = true;
                  }
                  else{
                    var best_seller = false;
                  }


                  if ($('#chows_choice').is(":checked"))
                  {
                    var chows_choice = true;
                  }
                  else{
                    var chows_choice = false;
                  }
                   var spectrum = $("#spectrum").val();
                   var reported_effects = $("#reported_effects").val();

                  

                    var link ='';
                    if(cannabinoids!='')
                    {
                      cannabinoids = cannabinoids.replace(/\s+/g, "-"); 
                      link = SITE_URL+'/search?cannabinoids='+cannabinoids+"&";
                    }       
                    else{
                      link += SITE_URL+'/search?';
                     }

                    if(brands)
                   {
                      link += 'brands='+brands+"&";
                   }
                     if(sellers)
                   {
                     link += 'sellers='+sellers+"&";
                   }
                    if(category)
                   {
                     link += 'category_id='+category+"&";
                   }
                     if(mg)
                   {
                     link += 'mg='+mg+"&";
                   }
                   if(price)
                   {
                     link += 'price='+price+"&";
                   }     
                     if(age_restrictions)
                   {
                     link += 'age_restrictions='+age_restrictions+"&";
                   }    
                   if(filterby_price_drop)
                   {
                     link += 'filterby_price_drop='+filterby_price_drop+"&";
                   } 
                   if(product_search)
                   {
                     link += 'product_search='+product_search+"&";
                   }

                    if(state)
                   {
                     link += 'state='+state+"&";
                   }

                    if(city)
                   {
                     link += 'city='+city+"&";
                   }
                   if(chows_choice)
                   {
                     link += 'chows_choice='+chows_choice+"&";
                   }
                  
                    if(best_seller)
                   {
                     link += 'best_seller='+best_seller+"&";
                   }
                   if(rating)
                   {
                     link += 'rating='+rating+"&";
                   }
                    if(statelaw)
                   {
                     link += 'statelaw='+statelaw+"&";
                   }
                    if(spectrum)
                    {
                      link += 'spectrum='+spectrum+"&" ;
                    }

                    if(featured_option)
                    {
                      link += 'featured='+featured_option+"&" ;
                    }
                     if(reported_effects)
                   {
                     link += 'reported_effects='+reported_effects+"&";
                   } 

                    link = link.substring(0, link.length -1);
                    window.location.href = link; 
                  }//if checked true

                }//if length > 0
               else
               {
                    

                  var price = $("#price").val();
                  var age_restrictions = $("#age_restrictions").val();
                  var category = $("#category").val();
                  var brands = $("#brands").val();
                  var sellers = $("#sellers").val();
                  var mg = $("#mg").val();
                  if ($('#filterby_price_drop').is(":checked"))
                  {
                    var filterby_price_drop = true;
                  }
                  else{
                    var filterby_price_drop = false;
                  }

                   var product_search = $("#product_search").val();  
                   var state = $("#state").val();
                   var city = $("#city").val();
                 
                   var rating = $("#rating").val();
                   var statelaw = $("#statelaw").val();

                   var featured_option = $('#featured_option').val();

                  if ($('#best_seller').is(":checked"))
                  {
                    var best_seller = true;
                  }
                  else{
                    var best_seller = false;
                  }


                  if ($('#chows_choice').is(":checked"))
                  {
                    var chows_choice = true;
                  }
                  else{
                    var chows_choice = false;
                  }
                   var spectrum = $("#spectrum").val();
                   var reported_effects = $("#reported_effects").val();

                  

                    var link ='';
                   
                    link += SITE_URL+'/search?';
                    

                    if(brands)
                   {
                      link += 'brands='+brands+"&";
                   }
                     if(sellers)
                   {
                     link += 'sellers='+sellers+"&";
                   }
                    if(category)
                   {
                     link += 'category_id='+category+"&";
                   }
                     if(mg)
                   {
                     link += 'mg='+mg+"&";
                   }
                   if(price)
                   {
                     link += 'price='+price+"&";
                   }     
                     if(age_restrictions)
                   {
                     link += 'age_restrictions='+age_restrictions+"&";
                   }    
                   if(filterby_price_drop)
                   {
                     link += 'filterby_price_drop='+filterby_price_drop+"&";
                   } 
                   if(product_search)
                   {
                     link += 'product_search='+product_search+"&";
                   }

                    if(state)
                   {
                     link += 'state='+state+"&";
                   }

                    if(city)
                   {
                     link += 'city='+city+"&";
                   }
                   if(chows_choice)
                   {
                     link += 'chows_choice='+chows_choice+"&";
                   }
                  
                    if(best_seller)
                   {
                     link += 'best_seller='+best_seller+"&";
                   }
                   if(rating)
                   {
                     link += 'rating='+rating+"&";
                   }
                    if(statelaw)
                   {
                     link += 'statelaw='+statelaw+"&";
                   }
                    if(spectrum)
                    {
                      link += 'spectrum='+spectrum+"&" ;
                    }

                    if(featured_option)
                    {
                       link += 'featured='+featured_option+"&" ;
                    }
                     if(reported_effects)
                   {
                     link += 'reported_effects='+reported_effects+"&";
                   } 

                    link = link.substring(0, link.length -1);
                    window.location.href = link; 

               }//else

        
        });

  } //end function canabodies
</script>