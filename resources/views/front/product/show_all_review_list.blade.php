@extends('front.layout.master')
@section('main_content')
<style type="text/css">
.username-review{
position: relative;
}
.username-review .editreviews{
position: absolute;
right: 0;
top: 0;
}
.star-processs div {
    position:relative;
    margin:10px;
    width:220px; height:220px;
}
.star-processs canvas {
    display: block;
    position:absolute;
    top:0;
    left:0;
}
.star-processs span {
    color:#555;
    display:block;
    line-height:220px;
    text-align:center;
    width:220px;
    font-family:sans-serif;
    font-size:40px;
    font-weight:100;
    margin-left:5px; display: none;
}

.star-processs input {
    width: 200px;
}
.star-processs div.review-count {
    width: 70px;
    height: 60px;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    margin: auto;
    z-index: 99;
    font-size: 50px;
}
@media (max-width: 650px){
  .headerchnagesmobile .logo-block.mobileviewlogo{
        width: 55vw;
  }
}
@media (max-width: 520px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 53vw;
}
}
@media (max-width: 450px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 45%;
}
}
@media (max-width: 414px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 35%;
}
}
@media (max-width: 350px){
  .headerchnagesmobile .logo-block.mobileviewlogo {
    width: 30%;
}
@media all and (max-width:550px){
 .main-logo {
    width: 60px;
}
}
</style>

@php
$login_user = Sentinel::check();
$product_id = $productid;
$total_reviews = get_total_reviews($product_id);
$avg_rating  = get_avg_rating($product_id);
$emoji=[];

 $percentage_avg_rating=0;
 $getavg_rating  = get_avg_rating($product_id);   

 if(isset($getavg_rating) && $getavg_rating > 0)
  {
    $img_avg_rating = ""; 
    $img_avg_rating = isset($getavg_rating)?get_avg_rating_image($getavg_rating):'';
    $percentage_avg_rating = ($getavg_rating*100)/5;
  }

  $get_top_reported_effects1 = isset($product_id)? get_top_reported_effects($product_id):'';

@endphp


<div class="container">
<div class="comment-view-details-page showallreview-page">

<!------------------------------------------------------------->


<div class="main-reviewstar">
        <div class="card-products">
        <div class="row justify-content-left d-flex">
           
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                <div class="title-customer-reviews">Reviews</div>

               @if(isset($getavg_rating) && $getavg_rating>0)
 
                <div class="rating-bar0 justify-content-center">
                 <div class="filter-reviews-show">
                     <div class="star-review-fa"> 

                        @if(isset($getavg_rating) && $getavg_rating>0)
                         <img src="{{url('/')}}/assets/front/images/star/{{isset($img_avg_rating)?$img_avg_rating.'.svg':''}}" alt="{{isset($img_avg_rating)?$img_avg_rating:''}}">  
                        @endif 

                          <span class="class-lft-ratings">{{ isset($total_reviews)?$total_reviews.' Ratings':'' }}</span>
                     </div> 
                     <div class="num-star-review">
                        @if(isset($getavg_rating) && $getavg_rating>0) 
                        {{ $getavg_rating }}  out of 5 Stars
                        @endif
                    </div>
                 </div>
                  <div class="filter-review-txt">Reported effects from customers</div>
                     <table class="text-left mx-auto">

                         <tbody>

                           @php

                             $show_reported_effects1=[]; $get_effect_count= $percentage_effects = 0;
                             foreach($get_top_reported_effects1 as $k44=>$v44){

                                $show_reported_effects1 = get_effect_name($k44);

                                 if(isset($show_reported_effects1) && !empty($show_reported_effects1))
                                 {
                                   $get_effect_count = get_reportedeffect_count($show_reported_effects1['id'],$product_id);



                                   if(isset($get_effect_count) && $get_effect_count>0 && isset($total_reviews) && $total_reviews>0)
                                   {
                                      $percentage_effects = number_format($get_effect_count/$total_reviews *100,2);
                                   }
                             @endphp
                              <tr>
                                  <td class="rating-label">{{ isset($show_reported_effects1['title'])?ucwords($show_reported_effects1['title']):'' }}</td>
                                  <td class="rating-bar">
                                      <div class="bar-container">
                                          <div class="bar-5" style="width: 100%; max-width: {{ $percentage_effects }}%;"></div>
                                      </div> 
                                  </td>
                                  <td class="text-right">{{ $percentage_effects }}%</td>
                              </tr>
                              @php 
                                }//if
                            }//foreach
                           @endphp 
                           
                    </tbody>
                  </table>
                </div>
              @endif  

             @if($login_user==true && $login_user->inRole('buyer') && $is_review_added==0 && $product_purchased_by_user==1)     
                 <div class="white-review-div-full">
                      <a href="{{ url('/') }}/search/add_review/{{ base64_encode($product_id) }}" class="write-a-review-btn">Write a Review</a>
                 </div>
             @endif

               @if($login_user==true && $login_user->inRole('buyer') && $product_purchased_by_user==1)
                     
                      @if(isset($request_status) && $request_status == 0)
                        <div class="button-list-dts"> 
                           <button type="button" class="butn-def btnsendreviw send-money-back"  id="btn_money_back_request" style="cursor: not-allowed;">Reported</button>

                        </div>
                      @elseif(isset($request_status) && $request_status == 2)

                          <div class="button-list-dts"> 
                             <div class="mney-rejected">Corrected</div>
                           <button type="button" product_id="{{isset($product_id)?$product_id:0}}" class="butn-def btnsendreviw send-money-back"  id="btn_money_back_request" onclick="showModel($(this));">Report Issue</button>

                          </div>
                      
                      @elseif(isset($request_status) && $request_status == 1)

                          <div class="button-list-dts"> 
                            <button type="button" class="butn-def btnsendreviw send-money-back"  id="btn_money_back_request" style="cursor: not-allowed;">Refunded to wallet</button>

                          </div>
                      @else
                          
                          <div class="button-list-dts"> 
                           <button type="button" product_id="{{isset($product_id)?$product_id:0}}" class="butn-def btnsendreviw send-money-back"  id="btn_money_back_request" onclick="showModel($(this));">Report Issue</button>

                          </div>

                      @endif             
                    @endif



            </div>

        </div>
    </div>
</div>

<!------------------------------------------------------------->


   @if(isset($arr_product['review_details']) && sizeof($arr_product['review_details']) )
    @foreach($arr_product['review_details'] as $review)  

    @php
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
    
     $img_rating = isset($review['rating'])?get_avg_rating_image($review['rating']):'';
    }
    @endphp

    <div class="comment-view-only-white prfileimgnone">
        @php
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
        
        $setname = $review['user_details']['first_name'];
        }
        else  if(isset($review['user_name']) && $review['user_name']!="")  {
        $setname = isset($review['user_name'])?$review['user_name']:'';
        }
        else {
        $setname ='User';
        }
        @endphp
        <div class="review-main-avatar">
            <div class="review-main-avatar-left">
                <div class="rvw-circle-cw"><img src="{{url('/')}}/assets/front/images/check-buyer-icon.svg"></div>
                  @php
                   $initate_latter =  strtoupper($setname[0]);
                  @endphp
                {{$initate_latter}}
            </div>
            <div class="review-main-avatar-right">
                <div class="namereviews">
                    <span>
                         {{ isset($setname)?ucwords(strtolower($setname)):'' }}
                        @if($login_user == true && $review['buyer_id']==$login_user->id)
                        @php
                        $star = isset($review['rating'])?get_avg_rating_image($review['rating']):'';
                        @endphp
                        <a title="Edit Review" class="fa fa-edit editreviews " id="editreviews_{{ $review['id'] }}" reviewuser="{{ $review['buyer_id'] }}" reviewproduct="{{ $review['product_id'] }}"  reviewid="{{ $review['id'] }}" reviewtitle="{{ $review['title'] }}" reviewdesc="{{ $review['review'] }}" reviewrating="{{ $review['rating'] }}" star="{{ $star }}" emoji="{{ isset($review['emoji'])?$review['emoji']:'' }}">
                        </a>
                        @endif    

                    </span>
                    
                </div>
                <div class="namereviews">
                  <span class="verified-buyerclass">Verified Buyer</span>
                </div>
                <div class="lisitng-detls-rate" title="{{$review['rating']}} Rating">
                    <img src="{{url('/')}}/assets/front/images/star/{{isset($img_rating)?
                        $img_rating:''}}.svg" alt="">
                </div>
                <div class="titleofsub">
                    @php
                    $reviwe_title = isset($review['title']) ? $review['title'] : '-';
                    @endphp
                    {{$reviwe_title}}
                </div>
                <div class="commentofsub" id="hidecontent_{{ $review['id'] }}">
                    @if(isset($review['review']) && strlen($review['review'])>100)
                    @php echo substr($review['review'],0,100) @endphp
                    <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore({{ isset($review['id'])?$review['id']:'' }})">See more</span>
                    @else
                    @php
                    if(isset($review['review']))
                    echo $review['review'];
                    else
                    echo '';
                    @endphp
                    @endif
                </div>
                 <span class="show-more-content" style="display: none" id="show-more-content_{{ isset($review['id'])?$review['id']:'' }}">
                    @php
                    if(isset($review['review']))
                    echo $review['review'];
                    else
                    echo '';
                    @endphp
                    <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless({{ isset($review['id'])?$review['id']:'' }})"  id="show-less_{{ isset($review['id'])?$review['id']:'' }}">See less</span>
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
                    @if(isset($review['emoji']) && !empty($review['emoji']))
                    <div class="top-rated-div">
                        This helped with my:
                        
                        
                        <ul class="list-inline">
                            @php
                            $get_reported_effects=[];
                            $emoji = explode(",",$review['emoji']);
                            $exploded = [];
                            foreach($emoji as $kk=>$vv)
                            {
                            $get_reported_effects = get_effect_name($vv);
                            if(isset($get_reported_effects) && !empty($get_reported_effects)){
                            @endphp
                            <li>
                                @if(file_exists(base_path().'/uploads/reported_effects/'.$get_reported_effects['image']) && isset($get_reported_effects['image']) && !empty($get_reported_effects['image']))
                                <img src="{{ url('/') }}/uploads/reported_effects/{{ $get_reported_effects['image'] }}" width="32px">
                                @endif
                                <label>{{ isset($get_reported_effects['title'])?$get_reported_effects['title']:'' }}</label>
                            </li>
                            @php
                            }//if
                            }//foreach
                            @endphp
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="comment-view-only-white-right">
            <div class="title-user-name username-review">
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @endforeach

      <div class="pagination-chow"> 
                  @if(!empty($arr_pagination))
                {{$arr_pagination->render()}}    
            @endif 
        </div>
    
   @endif
     
      
</div>
</div>



<!----------start review rating add modal--------------------------->

<div id="ReviewRatingsAddModal" class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="{{url('/')}}/assets/buyer/images/closbtns.png" alt="Chow420" /> </button>
            <div class="ordr-calltnal-title">Edit Review & Ratings</div>
            
            <form id="frm-add-review-modal" method="post" onsubmit="return false;">
              {{ csrf_field() }}

             <div class="ratings-frms">
              <input type="hidden" name="product_id_modal" id="product_id_modal" value="">
              <input type="hidden" name="review_id" id="review_id" value="">   
               <input type="hidden" name="rating_modal" id="rating_modal" value="">   


            </div>
             <div class="form-group">
               <label for="">Previous Ratings :  <span><img id="show_prev_rating" src="" alt="Previous Ratings" class="reviewsize" /></span></label>
             </div>

             <div class="ratings-frms">
              <div class="starrr text-left">
                   New Ratings : 
                   <input class="star required" type="radio" name="ratingnew" id="ratingnew" value=""/>
                </div>
            </div>



              <div class="form-group">
                  <label for="">Title <span>*</span></label>
                  <input type="text" name="title" id="title" class="input-text" placeholder="Enter title" data-parsley-required="true" data-parsley-required-message="Please enter title">
              </div>
              <div class="form-group">
                  <label for="">Comment <span>*</span></label>
                  <textarea class="input-text" placeholder="Write your comment" name="review" id="review" data-parsley-required="true" data-parsley-minlength='20' data-parsley-required-message="Please enter comment"></textarea>
              </div>


              <div class="checkbox-dropdown" >
                Helped with
                @php 

                 //dd($get_reported_effects)

                @endphp
                <ul class="checkbox-dropdown-list" id="modalchkboxes">
                  @if(isset($show_reported_effects) && !empty($show_reported_effects))
                   @foreach($show_reported_effects as  $k1=>$vs1)

                   
                    <li>
                     <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="{{ $vs1['id'] }}" id="rememberMe11{{ $vs1['id'] }}"  name="emoji[]">
                            <label class="form-check-label" for="rememberMe11{{ $vs1['id'] }}">
                              {{ $vs1['title'] or '' }}
                               @if(file_exists(base_path().'/uploads/reported_effects/'.$vs1['image']) && isset($vs1['image']) && !empty($vs1['image']))
                               <img src='{{ url('/') }}/uploads/reported_effects/{{ $vs1['image'] }}' width="32px" title="{{ $vs1['title'] }}" />
                               @endif 
                            </label>
                        </div>
                      </div>
                     </li>
                     @endforeach
                   @endif  
                  
                  
                </ul>
              </div>


            <div class="button-list-dts btn-order-cnls submits-button">
                <button class="butn-def btn_send_review_modal" id="btn_send_review_modal">Save</button>
            </div>
          </form>  
            <div class="clr"></div>
        </div>
    </div>
</div>
<!-- Modal My-Review-Ratings-Add End -->






<!----------------------------model for reported issue note--------------------------------->

<div class="modal fade" id="reported_note_model" tabindex="-1" role="dialog" aria-labelledby="StateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <form id="reported_note_form">
    {{csrf_field()}}

    
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="StateModalLabel" align="center">Report Issue Note</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body admin-modal-new">
          <div class="title-imgd">
            <div class="form-textarea">
            <input type="hidden" name="reported_product_id" id="reported_product_id" value="">

            <label>Add Note</label>
             
            <textarea rows="5" name="reported_note" id="reported_note" class="form-control" placeholder="Enter note" data-parsley-required-message="Please enter note" data-parsley-required="true"></textarea>

            <span id="reported_note_error" style="color: red;"></span>
            </div>

          </div>  <!------row div end here------------->         
      <!------body div end here------------->
      <div class="clearfix"></div>
      <div class="button-review-add">
        <button type="button" class="butn-def" id="btn_text_add" onclick="sendMoneyBackRequest($(this));">Add</button>
        </div>
      </div>
  </div>
  </form>
</div>
</div>


<!-- ---------------------------------------------------------------------------------------->





 <link href="{{url('/')}}/assets/front/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" />

 <!--for Rating half star -->
<!--rating demo-->
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/buyer/js/jquery.rating.js"></script>
<script src="{{url('/')}}/assets/buyer/js/star-rating.js" type="text/javascript"></script>
<link href="{{url('/')}}/assets/buyer/css/star-rating.css" rel="stylesheet" />


<script type="text/javascript">
  $(".checkbox-dropdown").click(function () {
    $(this).toggleClass("is-active");
});

$(".checkbox-dropdown ul").click(function(e) {
    e.stopPropagation();
});

</script>
<script>

  /*show report issue model*/

function showModel(ref)
{
  var product_id = $(ref).attr('product_id');

  $("#reported_product_id").val(product_id);
  $("#reported_note_model").modal('show');
}//showmodel



/*send money back guarantee request to admin*/

function sendMoneyBackRequest(ref){

  var product_id = $("#reported_product_id").val();
  var note       = $("#reported_note").val();

  var csrf_token = "{{ csrf_token()}}";

  if($('#reported_note_form').parsley().validate()==false) return;

  $.ajax({
            url: SITE_URL+'/buyer/review-ratings/money_back_request',
            type:"POST",
            data: {product_id:product_id,_token:csrf_token,note:note},             
            dataType:'json',
            beforeSend: function(){ 
               showProcessingOverlay();
              $('.send-money-back').prop('disabled',true);
              $('.send-money-back').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
            },
            success:function(response)
            {
                hideProcessingOverlay();

                $('.send-money-back').prop('disabled',false);
                $('.send-money-back').html('Send');
              
                if(response.status == 'success')
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
                        }

                      });
                }
                else
                {                
                  swal('Error',response.description,'error');
                }  

            }  

    }); 

}//end  


  
  //function for update review modal

  $(document).on('click','.editreviews',function(){

      var reviewid = $(this).attr('reviewid');
      var reviewuser = $(this).attr('reviewuser');
      var reviewproduct = $(this).attr('reviewproduct');
      var reviewrating = $(this).attr('reviewrating');
       var prev_rating = $(this).attr('star');

      var reviewtitle = $(this).attr('reviewtitle');
      var reviewdesc = $(this).attr('reviewdesc');

      var emoji = $(this).attr('emoji');

      $("#ReviewRatingsAddModal #product_id_modal").val(reviewproduct);
      $("#ReviewRatingsAddModal #review_id").val(reviewid);

      $("#ReviewRatingsAddModal").modal('show');

      $("#title").val(reviewtitle);
      $("#review").val(reviewdesc);
      $("#rating_modal").val(reviewrating);

      // $("#show_prev_rating").attr('src',SITE_URL+'/assets/buyer/images/star-rate-'+prev_rating+'.svg');
      $("#show_prev_rating").attr('src',SITE_URL+'/assets/buyer/images/star/'+prev_rating+'.svg');

      $.each(emoji.split(","), function(i,e){
          $('input:checkbox[name="emoji[]"][value="' + e + '"]').prop('checked',true);
      });

      // $(document).click(function() {
      //    $(".checkbox-dropdown").removeClass('is-active');
      // }); 

      $("#modalchkboxes").click(function(event) {
        $("#modalchkboxes").toggleClass('checkbox-dropdown is-active');
          //event.stopPropagation();
      });

    
  }); 



//function for update review modal
$('.btn_send_review_modal').click(function()
      { 
        //var rating = $("#rating_modal").val();

         var rating_new = $("#ratingnew").val();
         
         if(rating_new>0){

          var rating = rating_new;
         }
         else{
           var rating = $("#rating_modal").val();
         }
         

        var productid = $("#product_id_modal").val();

        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          return false; 
        }

        if($('#frm-add-review-modal').parsley().validate()==false) return;

        var form_data   = $('#frm-add-review-modal').serializeArray(); 
        form_data.push({name: 'rating_modal', value: rating});

        
         var csrf_token = "{{ csrf_token()}}";
         
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
              $('.btn_send_review_modal').html('Save');
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
                         //$(this).addClass('active');
                         //showreviews(productid);
                        $("#ReviewRatingsAddModal").modal('hide');

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





@php
//dd($arr_product['review_details']);
/*
@endphp
<div class="comment-view-only" id="showreviewdiv" >
    @if(isset($arr_product['review_details']) && sizeof($arr_product['review_details']) )
    @foreach($arr_product['review_details'] as $review)
    @php
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
    
    $img_rating = isset($review['rating'])?get_avg_rating_image($review['rating']):'';
    }
    @endphp
    <div class="comment-view-only-white prfileimgnone">
        @php
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
        
        $setname = $review['user_details']['first_name'];
        }
        else  if(isset($review['user_name']) && $review['user_name']!="")  {
        $setname = isset($review['user_name'])?$review['user_name']:'';
        }
        else {
        $setname ='User';
        }
        @endphp
        {{-- **************************************************** --}}
        <div class="review-main-avatar">
            <div class="review-main-avatar-left">
                <div class="rvw-circle-cw"><img src="{{url('/')}}/assets/front/images/check-buyer-icon.svg" /></div>
                @php
                $initate_latter =  strtoupper($setname[0]);
                @endphp
                {{$initate_latter}}
            </div>
            <div class="review-main-avatar-right">
                <div class="namereviews">
                    <span>
                        
                        
                        {{ isset($setname)?ucwords(strtolower($setname)):'' }}
                        @if($login_user == true && $review['buyer_id']==$login_user->id)
                        @php
                        $star = isset($review['rating'])?get_avg_rating_image($review['rating']):'';
                        @endphp
                        <a title="Edit Review" class="fa fa-edit editreviews " id="editreviews_{{ $review['id'] }}" reviewuser="{{ $review['buyer_id'] }}" reviewproduct="{{ $review['product_id'] }}"  reviewid="{{ $review['id'] }}" reviewtitle="{{ $review['title'] }}" reviewdesc="{{ $review['review'] }}" reviewrating="{{ $review['rating'] }}" star="{{ $star }}" emoji="{{ isset($review['emoji'])?$review['emoji']:'' }}">
                        </a>
                        @endif
                    </span>
                    <span class="verified-buyerclass">Verified Buyer</span>
                </div>
                <div class="lisitng-detls-rate" title="{{$review['rating']}} Rating">
                    
                    <img src="{{url('/')}}/assets/front/images/star/{{isset($img_rating)?$img_rating.'.svg':''}}" alt="">
                </div>
                <div class="titleofsub">
                    @php
                    $reviwe_title = isset($review['title']) ? $review['title'] : '-';
                    @endphp
                    {{$reviwe_title}}
                </div>
                <div class="commentofsub" id="hidecontent_{{ $review['id'] }}">
                    @if(isset($review['review']) && strlen($review['review'])>100)
                    @php echo substr($review['review'],0,100) @endphp
                    <span class="show-more" style="color: #873dc8;cursor: pointer;" onclick="return showmore({{ isset($review['id'])?$review['id']:'' }})">See more</span>
                    @else
                    @php
                    if(isset($review['review']))
                    echo $review['review'];
                    else
                    echo '';
                    @endphp
                    @endif
                </div>
                <span class="show-more-content" style="display: none" id="show-more-content_{{ isset($review['id'])?$review['id']:'' }}">
                    @php
                    if(isset($review['review']))
                    echo $review['review'];
                    else
                    echo '';
                    @endphp
                    <span class="show-less" style="color:#873dc8;cursor: pointer;" onclick="return showless({{ isset($review['id'])?$review['id']:'' }})"  id="show-less_{{ isset($review['id'])?$review['id']:'' }}">See less</span>
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
                    @if(isset($review['emoji']) && !empty($review['emoji']))
                    <div class="top-rated-div">
                        This helped with my:
                        
                        
                        <ul class="list-inline">
                            @php
                            $get_reported_effects=[];
                            $emoji = explode(",",$review['emoji']);
                            $exploded = [];
                            foreach($emoji as $kk=>$vv)
                            {
                            $get_reported_effects = get_effect_name($vv);
                            if(isset($get_reported_effects) && !empty($get_reported_effects)){
                            @endphp
                            <li>
                                @if(file_exists(base_path().'/uploads/reported_effects/'.$get_reported_effects['image']) && isset($get_reported_effects['image']) && !empty($get_reported_effects['image']))
                                <img src="{{ url('/') }}/uploads/reported_effects/{{ $get_reported_effects['image'] }}" width="32px">
                                @endif
                                <label>{{ isset($get_reported_effects['title'])?$get_reported_effects['title']:'' }}</label>
                            </li>
                            @php
                            }//if
                            }//foreach
                            @endphp
                        </ul>
                    </div>
                    @endif
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
    @endforeach
    @else
    <div class="whitebox-list space-o-padding">
        <div class="titledetailslist pull-left">No Reviews (0)</div>
    </div>
    @endif
    <div class="clearfix"></div>
    
</div>
@php */ @endphp
@endsection