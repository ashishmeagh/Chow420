@php
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
   $cat_id     =  $cat_id;
   else
   $cat_id     =  app('request')->input('category_id');   

   $price      =  app('request')->input('price');
   $sub_cat_id = app('request')->input('subcategory');
   $age_restrictions = app('request')->input('age_restrictions');
   $rating     = app('request')->input('rating');
   $seller     = app('request')->input('seller');
   $brand     = app('request')->input('brand');
   $brands     = app('request')->input('brands');
   $sellers     = app('request')->input('sellers');
   $mg      =  app('request')->input('mg');
   $filterby_price_drop      =  app('request')->input('filterby_price_drop');
   $product_search      =  app('request')->input('product_search');

 
     
@endphp 
<div class="col-3-list leftSidebar">
  <div class="closebtnslist">
  <span class="toggle-button">
    <span class="closelkds"></span>
    
  </span>
</div>
    {{-- <div class="cart-icon-top"></div> --}}
    {{-- <div class="cart-icon-bottom"></div> --}}
 <div class="theiaStickySidebar">
 <div id="sidebar">

  <div class="title-list-cart">Brand 
           @if(isset($brands))
            <a href="javascript:void(0)" class="clearfiltr" id="brandfilter" onclick="return clearfilter('brands');">  Clear Filter</a>
           @elseif(isset($brand)) 
               <a href="javascript:void(0)" class="clearfiltr" id="brandfilter" onclick="return clearfilter('brand');">  Clear Filter</a>
           @endif
  </div>
          
           
<div class="searchbrands">
  {{-- <input type="text" placeholder="Search by Brand" id="searchbybrand" value="@if(isset($brands)) {{ base64_decode($brands) }} @elseif(isset($brand)) {{ $brand_details[0]['name'] }}  @endif" /> --}}

  <input type="text" placeholder="Search by Brand" id="searchbybrand" value="@if(isset($brands) && isset($brand_details[0]['name'])) {{ $brand_details[0]['name'] }} @elseif(isset($brand)) {{ $brand_details[0]['name'] }}  @endif" />

  <div id="brandList"></div>
  <span id="branderr"></span>

  <!-------------------if brand is set or brands is set then dont show the search btn------------->
  @if(isset($brands)) @elseif(isset($brand)) @else
    {{--  <button class="searchbradss" id="searchbrandbtn"></button> --}}
  @endif

</div>


{{-- <div class="title-list-cart">Seller 
           @if(isset($sellers) && (isset($fname) || isset($lname)) ) 
               <a href="javascript:void(0)" class="clearfiltr" id="sellerfilter" onclick="return clearfilter('sellers');">  Clear Filter</a>
           @endif
  </div> --}}
<div class="title-list-cart">Business 
          {{--  @if(isset($sellers) && (isset($business_details['business_name'])) )  --}}
            @if(isset($sellers)) 
               <a href="javascript:void(0)" class="clearfiltr" id="sellerfilter" onclick="return clearfilter('sellers');">  Clear Filter</a>
            @endif
  </div>





<div class="searchbrands">
            @php
            /*if(isset($seller_details) && isset($sellers))
            {
              $fname =  $seller_details[0]['first_name']; 
              $lname =  $seller_details[0]['last_name']; 
            }*/
            if(isset($seller_details) && isset($sellers))
            {
              $fname =  $seller_details['first_name']; 
              $lname =  $seller_details['last_name']; 
            }

           @endphp


{{-- 
 <input type="text" placeholder="Search by Seller" id="searchbyseller" value="@if(isset($sellers) && (isset($fname) || (isset($lname)) )) {{ $fname }} {{ $lname }} @endif" />

  <div id="sellerList"></div>
  <span id="sellererr"></span>
   @if(isset($sellers)) @else <button class="searchbradss" id="searchsellerbtn"></button> @endif --}}

<!-- 
 <input type="text" placeholder="Search by Business" id="searchbyseller" value="@if(isset($sellers) && (isset($fname) || (isset($lname)) )) {{ $fname }} {{ $lname }} @endif" /> -->

  <input type="text" placeholder="Search by Business" id="searchbyseller" value="@if(isset($sellers) && (isset($business_details['business_name']) )) {{ $business_details['business_name'] }}  @endif"  />

  <div id="sellerList"></div>
  <span id="sellererr"></span>
   @if(isset($sellers)) @else 
   {{-- <button class="searchbradss" id="searchsellerbtn"></button> --}} 
   @endif

</div>








<div class="border-list-side"></div>
  <div class="title-list-cart">On Sale</div>
  {{-- <div class="subt-title-chebx">Health & Ingredients</div> --}}
    <div class="check-box">
      <input type="checkbox" class="css-checkbox" id="filterby_price_drop" name="filterby_price_drop" @if(isset($filterby_price_drop) && $filterby_price_drop==true) checked @endif onclick="return filter_by_price_drop()"  />
      <label class="css-label radGroup2" for="filterby_price_drop">Today's Deals</label>
    </div>

 <div class="border-list-side"></div>
        @if(isset($category_arr) && count($category_arr) > 0) 
            <div class="title-list-cart">Category 
              @if(isset($cat_id))<a href="javascript:void(0)" class="clearfiltr" id="categoryfilter" onclick="return clearfilter('category');">Clear Filter</a>@endif
            </div>
            <ul class="list-cart-abt"> 
            @foreach($category_arr as $category)

               <!-------------------------------------------------------------->
                @php
                  $link = '';
                  if(isset($category['id'])){
                    $link = url('search?category_id='.base64_encode($category['id']));
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

                  if(isset($filterby_price_drop)){
                     $link .= '&filterby_price_drop='.$filterby_price_drop;
                  }           

                  if(isset($product_search)){
                     $link .= '&product_search='.$product_search;
                  }   


                 @endphp
                 
                  <li>
                      <a  href="{{ $link }}" @if(isset($cat_id) && base64_decode($cat_id)==$category['id']) class="active"  style='color:#337ab7' @endif><i class="fa fa-angle-left"></i>{{$category['product_type']}} </a>
                  </li>

                <!-------------------------------------------------------------->

            @endforeach    
            </ul>
        @endif    
        
          {{-- <div class="check-box">
             <input type="checkbox"  class="css-checkbox" id="checkbox2" name="radiog_dark" />
             <label class="css-label radGroup2" for="checkbox2">Dairy-Free</label>
          </div>
          <div class="check-box">
             <input type="checkbox"  class="css-checkbox" id="checkbox3" name="radiog_dark" />
             <label class="css-label radGroup2" for="checkbox3">Preservative-Free</label>
          </div> --}}
        <div class="border-list-side"></div>
        <div class="title-list-cart">Price 
           @if(isset($price))
            <a href="javascript:void(0)" class="clearfiltr" id="pricefilter" onclick="return clearfilter('price');">Clear Filter</a>
            @endif
           
          </div>
          <div class="range-t input-bx" for="amount">
            <div id="slider-price-range" class="slider-rang"></div>
            <div class="amount-no" id="slider_price_range_txt"></div>
        </div>
 <div class="border-list-side"></div>

        <div class="title-list-cart">Concentration (mg) 
           @if(isset($mg))
          <a href="javascript:void(0)" class="clearfiltr" id="mgfilter" onclick="return clearfilter('mg');">Clear Filter</a>
          @endif
        </div>
        <div class="range-t input-bx" for="amount">
            <div id="slider-price-range2" class="slider-rang"></div>
            <div class="amount-no" id="slider_price_range_txt2"></div>
        </div>
        
        <!-- <div class="border-list-side"></div>
        <div class="check-box">
            <input type="checkbox" checked="checked" class="css-checkbox" id="checkbox4" name="radiog_dark" />
            <label class="css-label radGroup2" for="checkbox4">Same Day Delivery</label>
        </div> -->

		<div class="border-list-side"></div>

        <div class="title-list-cart">Age 
           @if(isset($age_restrictions))
          <a href="javascript:void(0)" class="clearfiltr" id="agefilter" onclick="return clearfilter('age_restrictions');">Clear Filter</a>
          @endif
        </div>
        <div class="radio-btns agerestricted">

            <div class="radio-btn">
                <input type="radio" id="agea-option" name="age_restriction" value="1"  @if(isset($age_restrictions) && base64_decode($age_restrictions)==1)  checked="checked" @endif  onclick="return filter_by_age($(this))">
                <label for="agea-option">18+</label>
                <div class="check"></div>
            </div>
          
            <div class="radio-btn">
                <input type="radio" id="ageb-option" name="age_restriction" value="2" @if(isset($age_restrictions) &&base64_decode($age_restrictions)==2) checked="checked" @endif onclick="return filter_by_age($(this))">
                <label for="ageb-option">21+</label>
                <div class="check"><div class="inside"></div></div>
            </div>

         {{--    <div class="radio-btn">
                <input type="radio" id="agec-option" name="selector">
                <label for="agec-option">Age All</label>
                <div class="check"><div class="inside"></div></div>
            </div> --}}
        </div>

        <div class="border-list-side"></div>

        <div class="title-list-cart">Customer Ratings 
          @if(isset($rating))
          <a href="javascript:void(0)" class="clearfiltr" id="ratingfilter" onclick="return clearfilter('rating');">Clear Filter</a>
          @endif
        </div>
        <div class="radio-btns">

            <div class="radio-btn" title="5 Ratings">
                <input type="radio" id="f-option" name="rating" value="5" @if(isset($rating) && base64_decode($rating)==5) checked="checked" @endif onclick="return filter_by_rating($(this))">
                <label for="f-option"><img src="{{url('/')}}/assets/front/images/star-rate-five.png" alt=""> 
                
                </label>
                <div class="check"></div>
            </div>
          
            <div class="radio-btn" title="4 Ratings">
                <input type="radio" id="s-option" name="rating" value="4" @if(isset($rating) && base64_decode($rating)==4) checked="checked" @endif onclick="return filter_by_rating($(this))">
                <label for="s-option"><img src="{{url('/')}}/assets/front/images/star-rate-four.png" alt=""> 
                 
                </label>
                <div class="check"><div class="inside"></div></div>
            </div>

            <div class="radio-btn" title="3 Ratings">
                <input type="radio" id="a-option" name="rating" value="3" @if(isset($rating) && base64_decode($rating)==3) checked="checked" @endif onclick="return filter_by_rating($(this))">
                <label for="a-option"><img src="{{url('/')}}/assets/front/images/star-rate-three.png" alt=""> 
                  
                </label>
                <div class="check"><div class="inside"></div></div>
            </div>

            <div class="radio-btn" title="2 Ratings">
                <input type="radio" id="b-option" name="rating" value="2" @if(isset($rating) && base64_decode($rating)==2) checked="checked" @endif onclick="return filter_by_rating($(this))">
                <label for="b-option"><img src="{{url('/')}}/assets/front/images/star-rate-two.png" alt=""> 
                 
                </label>
                <div class="check"><div class="inside"></div></div>
            </div>

            <div class="radio-btn" title="1 Rating">
                <input type="radio" id="c-option" name="rating" value="1" 
                  @if(isset($rating) && base64_decode($rating)==1) checked="checked" @endif onclick="return filter_by_rating($(this))">
                <label for="c-option"><img src="{{url('/')}}/assets/front/images/star-rate-one.png" alt="">
                  
                </label>
                <div class="check"><div class="inside"></div></div>
            </div>

        </div>
      </div>
    </div>
</div>


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


     /*****************************************************************/

       var link ='';
       link += SITE_URL+'/search?';


      if(filterby_price_drop)
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


       link = link.substring(0, link.length -1);
              
       window.location.href = link;





   /************************commented for price drop*********************************************/

      /* if(cat_id && price && rating && age_restrictions && brands && sellers && mg){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&price="+price+"&rating="+rating+"&brands="+brands+"&sellers="+sellers+"&mg="+mg;
       }
       else if(cat_id && price && rating && brands && sellers && mg){
          var link = SITE_URL + '/search?category_id='+cat_id+"&price="+price+"&rating="+rating+"&brands="+brands+"&sellers="+sellers+"&mg="+mg;
       }
      else if(cat_id && price && rating && age_restrictions && brands && sellers){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&price="+price+"&rating="+rating+"&brands="+brands+"&sellers="+sellers;
       }
       else if(cat_id && rating && age_restrictions && brands && sellers){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&rating="+rating+"&brands="+brands+"&sellers="+sellers;
       }
      else if(price && rating && cat_id && sellers && brands){
          var link = SITE_URL + '/search?category_id='+cat_id+"&price="+price+"&rating="+rating+"&sellers="+sellers+"&brands="+brands;
       } 
      else if(price && cat_id && age_restrictions && sellers && brands){ 
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+"&price="+price+"&category_id="+cat_id+"&sellers="+sellers+"&brands="+brands;
       }  
      else if(price && rating && age_restrictions && sellers && brands){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+"&price="+price+"&rating="+rating+"&sellers="+sellers+"&brands="+brands;
       } 
      else if(cat_id && price && rating && age_restrictions && brands){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&price="+price+"&rating="+rating+"&brands="+brands;
       }
      else if(cat_id && price && rating && age_restrictions && sellers){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&price="+price+"&rating="+rating+"&sellers="+sellers;
       }

        else if(cat_id && mg && age_restrictions && brands && sellers){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&mg="+mg+"&brands="+brands+"&sellers="+sellers;
       }


        else if(mg && brands && price && sellers){
          var link = SITE_URL + '/search?price='+price+"&mg="+mg+"&brands="+brands+"&sellers="+sellers;
       }
       else if(age_restrictions && brands && price && sellers){
          var link = SITE_URL + '/search?price='+price+"&age_restrictions="+age_restrictions+"&brands="+brands+"&sellers="+sellers;
       }
       else if(age_restrictions && brands && mg && sellers){
          var link = SITE_URL + '/search?mg='+mg+"&age_restrictions="+age_restrictions+"&brands="+brands+"&sellers="+sellers;
       }
        else if(age_restrictions && rating && mg && sellers){
          var link = SITE_URL + '/search?mg='+mg+"&age_restrictions="+age_restrictions+"&rating="+rating+"&sellers="+sellers;
       }

        else if(price && rating && mg && sellers){
          var link = SITE_URL + '/search?mg='+mg+"&price="+price+"&rating="+rating+"&sellers="+sellers;
       }
       else if(price && cat_id && mg && sellers){
          var link = SITE_URL + '/search?mg='+mg+"&category_id="+cat_id+"&price="+price+"&sellers="+sellers;
       }
      else if(price && rating && age_restrictions && sellers){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+"&price="+price+"&rating="+rating+"&sellers="+sellers;
       }
        else if(mg && age_restrictions && cat_id && brands){
          var link = SITE_URL + '/search?mg='+mg+'&age_restrictions='+age_restrictions+'&category_id='+cat_id+'&brands='+brands;
       }
       else if(cat_id && mg && age_restrictions && brands){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&mg="+mg+"&brands="+brands;
       }
      else if(cat_id && sellers && rating && age_restrictions){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&sellers="+sellers+"&rating="+rating;
       } 
      else if(cat_id && price && rating && age_restrictions){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&price="+price+"&rating="+rating;
       }
       else if(cat_id && price && rating && sellers){
          var link = SITE_URL + '/search?sellers='+sellers+'&category_id='+cat_id+"&price="+price+"&rating="+rating;
       }

       else if(cat_id && price && rating && brands){
          var link = SITE_URL + '/search?brands='+brands+'&category_id='+cat_id+"&price="+price+"&rating="+rating;
       }
         else if(mg && age_restrictions && rating){
          var link = SITE_URL + '/search?mg='+mg+'&age_restrictions='+age_restrictions+'&rating='+rating;
       }
        else if(price && age_restrictions && rating){
          var link = SITE_URL + '/search?price='+price+'&age_restrictions='+age_restrictions+'&rating='+rating;
       }
         else if(price && mg && age_restrictions){
          var link = SITE_URL + '/search?price='+price+'&mg='+mg+'&age_restrictions='+age_restrictions;
       }
       else if(price && mg && rating){
          var link = SITE_URL + '/search?price='+price+'&mg='+mg+'&rating='+rating;
       }
      else if(mg && age_restrictions && cat_id){
          var link = SITE_URL + '/search?mg='+mg+'&age_restrictions='+age_restrictions+'&category_id='+cat_id;
       }
      else if(cat_id && sellers && brands ){
          var link = SITE_URL + '/search?category_id='+cat_id+"&sellers="+sellers+"&brands="+brands;
      }
       else if(price && sellers && brands ){
          var link = SITE_URL + '/search?price='+price+"&sellers="+sellers+"&brands="+brands;
      }
      else if(cat_id && price && rating ){
          var link = SITE_URL + '/search?category_id='+cat_id+"&price="+price+"&rating="+rating;
       }
      else if(cat_id && price && brands ){
          var link = SITE_URL + '/search?category_id='+cat_id+"&price="+price+"&brands="+brands;
      }
      else if(cat_id && price && sellers ){
          var link = SITE_URL + '/search?category_id='+cat_id+"&price="+price+"&sellers="+sellers;
       }
       else if(cat_id && price && age_restrictions ){
          var link = SITE_URL + '/search?category_id='+cat_id+"&price="+price+"&age_restrictions="+age_restrictions;
       }
       else if(cat_id && rating && age_restrictions){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id+"&rating="+rating;
       }
       else if(sellers && brands && rating){
          var link = SITE_URL + '/search?sellers='+sellers+"&brands="+brands+"&rating="+rating;
        }
       else if(price && rating && age_restrictions){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+"&price="+price+"&rating="+rating;
       }
        else if(price && rating && brands){
          var link = SITE_URL + '/search?brands='+brands+"&price="+price+"&rating="+rating;
       }
       else if(price && rating && sellers){
          var link = SITE_URL + '/search?sellers='+sellers+"&price="+price+"&rating="+rating;
       }
       else if(sellers && brands ){
          var link = SITE_URL + '/search?sellers='+sellers+"&brands="+brands;
        }
       else if(rating && sellers ){
          var link = SITE_URL + '/search?sellers='+sellers+"&rating="+rating;
       }
       else if(rating && brands ){
          var link = SITE_URL + '/search?brands='+brands+"&rating="+rating;
       }

       else if(sellers && price_drop){ //new added for sellers and price drop
      
          var link = SITE_URL + '/search?sellers='+sellers+'&filterby_price_drop='+price_drop;
       }

       else if(brands && price_drop){ //new added for brands and price drop
      
          var link = SITE_URL + '/search?brands='+brands+'&filterby_price_drop='+price_drop;
       }


       else if(rating && price_drop){ //new added for rating and price drop
      
          var link = SITE_URL + '/search?rating='+rating+'&filterby_price_drop='+price_drop;
       }



       else if(age_restrictions && sellers){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+"&sellers="+sellers;
       }
       else if(age_restrictions && brands){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+"&brands="+brands;
       }
       else if(age_restrictions && rating){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+"&rating="+rating;
       }

      else if(age_restrictions && price_drop){ //new added
      
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&filterby_price_drop='+price_drop;
       }


       else if(cat_id && price){
          var link = SITE_URL + '/search?category_id='+cat_id+"&price="+price;
       }
       else if(cat_id && rating ){
          var link = SITE_URL + '/search?category_id='+cat_id+"&rating="+rating;
       }
       else if(cat_id && age_restrictions){

          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+'&category_id='+cat_id;
       }
       else if(cat_id && brands){
          var link = SITE_URL + '/search?category_id='+cat_id+'&brands='+brands;
       }
        else if(cat_id && brand){
          var link = SITE_URL + '/search?category_id='+cat_id+'&brand='+brand;
       }
       else if(cat_id && sellers){
          var link = SITE_URL + '/search?category_id='+cat_id+'&sellers='+sellers;
       }

       else if(cat_id && price_drop){ //new added
      
          var link = SITE_URL + '/search?category_id='+cat_id+'&filterby_price_drop='+price_drop;
       }



       else if(price && rating){
          var link = SITE_URL + '/search?price='+price+"&rating="+rating;
       }
       else if( price && age_restrictions){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions+"&price="+price;
       }
        else if(price && brands){
          var link = SITE_URL + '/search?price='+price+"&brands="+brands;
       }
      else if(price && sellers){
          var link = SITE_URL + '/search?price='+price+"&sellers="+sellers;
       }


      else if(price && price_drop){ //new added
      
          var link = SITE_URL + '/search?price='+price+'&filterby_price_drop='+price_drop;
       }


       else if(mg && cat_id){
          var link = SITE_URL + '/search?mg='+mg+'&category_id='+cat_id;
       }
       else if(mg && brands){
          var link = SITE_URL + '/search?mg='+mg+'&brands='+brands;
       }
      else if(mg && rating){
          var link = SITE_URL + '/search?mg='+mg+'&rating='+rating;
       }
        else if(mg && age_restrictions){
          var link = SITE_URL + '/search?mg='+mg+'&age_restrictions='+age_restrictions;
       }
       else if(mg && sellers){
          var link = SITE_URL + '/search?mg='+mg+'&sellers='+sellers;
       }
       else if(mg && price){
          var link = SITE_URL + '/search?mg='+mg+'&price='+price;
       }

       else if(mg && price_drop){ // new added
      
          var link = SITE_URL + '/search?mg='+mg+'&filterby_price_drop='+price_drop;
       }



       else if(price){
          var link = SITE_URL + '/search?price='+price;
       }
       else if(age_restrictions){
          var link = SITE_URL + '/search?age_restrictions='+age_restrictions;
       }
       else if(rating){
          var link = SITE_URL + '/search?rating='+rating;
       }
      else if(cat_id){

          var link = SITE_URL + '/search?category_id='+cat_id;
       }
       else if(brands){
          var link = SITE_URL + '/search?brands='+brands;
       }
       else if(sellers){
          var link = SITE_URL + '/search?sellers='+sellers;
       }
       else if(brand){
          var link = SITE_URL + '/search?brand='+brand;
       }
       else if(mg){
          var link = SITE_URL + '/search?mg='+mg;
       }
       else if(price_drop){    // new added
          var link = SITE_URL + '/search?filterby_price_drop='+price_drop;
       }
       else
       {
         var link = SITE_URL + '/search';
       }
      window.location.href= link;*/

   
     
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

       link = link.substring(0, link.length -1);
       
        
       window.location.href = link;


    

  }
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
      
       window.location.href = link;


  }

</script>  
<script>
  

  /**************************************************************************/
     var lowest_mg = $('#lowest_mg').val();
     var highest_mg = $('#highest_mg').val();
     var mg = $('#mg').val();
     var min_selected_mg = mg.split('-')[0] || lowest_mg;
     var max_selected_mg = mg.split('-')[1] || highest_mg; 

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
                   $("#slider_price_range_txt2").html("<span class='slider_price_min'> " + ui.values[0] + " mg</span>  <span class='slider_price_max'> " + ui.values[1] + " mg </span>");
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

                 window.location.href = link;

             
               
               }//stop function


           });
           $("#slider_price_range_txt2").html("<span class='slider_price_min'>  " + $("#slider-price-range2").slider("values", 0) + " mg</span>  <span class='slider_price_max'> " + $("#slider-price-range2").slider("values", 1) + " mg</span>");
         });  
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


        if(query != '')
        {
           var _token = "{{ csrf_token() }}";
           $.ajax({
            url:SITE_URL+'/autosuggest',
            method:"POST",
            data:{query:query, _token:_token,sellers:sellers,rating:rating,category_id:category,age_restrictions:age_restrictions,price:price,mg:mg,filterby_price_drop:filterby_price_drop,product_search:product_search},
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


        if(query != '')
        {
           var _token = "{{ csrf_token() }}";
           $.ajax({
            // url:SITE_URL+'/autosuggest_by_seller',
             url:SITE_URL+'/autosuggest_by_business',
            method:"POST",
            data:{query:query, _token:_token,category_id:category,rating:rating,age_restrictions:age_restrictions,price:price,brands:brands,brand:brand,mg:mg,filterby_price_drop:filterby_price_drop,product_search:product_search},
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
     
      var sellers_url = "{{ $sellers }}";     
      if(sellers_url=='undefined' || sellers_url.trim()==""){
        $('#searchbyseller').val('');
      }

      var brands_url = "{{ $brands }}";
     
       if(brands_url=='undefined' || brands_url.trim()==""){
        $('#searchbybrand').val('');
      }

      
    });
 
</script>

