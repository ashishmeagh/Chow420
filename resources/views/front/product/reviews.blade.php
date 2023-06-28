  
{{-- <link href="{{url('/')}}/assets/buyer/css/star-rating.css" rel="stylesheet" />
 --}}
{{-- <script src="{{url('/')}}/assets/buyer/js/star-rating.js" type="text/javascript"></script>
 --}} 
{{--  <script type="text/javascript" language="javascript" src="{{url('/')}}/assets/buyer/js/jquery.rating.js"> </script>
 --}}

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


   @php
     $login_user = Sentinel::check();
     $product_id = $productid;

      $total_reviews = get_total_reviews($product_id);
      $avg_rating  = get_avg_rating($product_id);

      $emoji=[];



   @endphp
                 {{--  <div class="whitebox-list reviewboxs">
                        <div class="review-txts-sub-left">                           
                            <div class="review-txts-stars">                              
                                @if($total_reviews > 0)
                                  <div class="titledetailslist pull-left">Reviews ({{isset($total_reviews)?$total_reviews:0}})</div>
                                  
                                @else
                                  <div class="titledetailslist pull-left">Reviews Yet</div>
                                @endif
                            </div>
                        </div>
                     
                        <div class="clearfix"></div>
                    </div> --}}





                    


                 {{--  <div class="comment-view-only" id="showreviewdiv" style="max-height: 300px;overflow-y: auto;">
                        @if(isset($arr_product['review_details']) && sizeof($arr_product['review_details']) )
                        @foreach($arr_product['review_details'] as $review)
                          @php 

                                $review_at = "";
                                $review_at = date('h:i - M d, Y', strtotime($review['updated_at']));

                                 if(isset($review['user_details']['profile_image']) && $review['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$review['user_details']['profile_image']))
                                 {
                                   $user_profile_img = url('/uploads/profile_image/'.$review['user_details']['profile_image']);
                                 }
                                 else
                                {                  
                                  $user_profile_img = url('/assets/images/no_image_available.jpg');
                                }  


                                if(isset($review['rating']) && $review['rating'] > 0)
                                {
                                  $img_rating = "";
                                  if($review['rating']=='1') $img_rating = "star-rate-one.png";
                                  else if($review['rating']=='2')  $img_rating = "star-rate-two.png";
                                  else if($review['rating']=='3')  $img_rating = "star-rate-three.png";
                                  else if($review['rating']=='4')  $img_rating = "star-rate-four.png";                                  
                                  else if($review['rating']=='5')  $img_rating = "star-rate-five.png";
                                  else if($review['rating']=='0.5')  $img_rating = "star-rate-zeropointfive.png";
                                  else if($review['rating']=='1.5')  $img_rating = "star-rate-onepointfive.png";
                                  else if($review['rating']=='2.5')  $img_rating = "star-rate-twopointfive.png";
                                  else if($review['rating']=='3.5')  $img_rating = "star-rate-threepointfive.png";
                                  else if($review['rating']=='4.5')  $img_rating = "star-rate-fourpointfive.png";
                                } 
                          @endphp
                        <div class="comment-view-only-white prfileimgnone">
                        
                            <div class="comment-view-only-white-right">
                                <div class="title-user-name username-review"> 

                                

                                  @php 
                                     $setname = '';
                                     if(isset($review['user_details']) && ($review['user_details']['first_name']=="" || $review['user_details']['last_name']=="")) 
                                     {
                                         if($review['user_details']['user_type']=="seller")
                                         {
                                            $setname = "Seller";
                                         }
                                         else
                                         {
                                           $setname = "Buyer";
                                         }


                                     }
                                    else if(isset($review['user_details']) && ($review['user_details']['first_name']!="" || $review['user_details']['last_name']!="")) 
                                    {
                                       $setname = $review['user_details']['first_name']." ".$review['user_details']['last_name'];
                                    }
                                    else  if(isset($review['user_name']) && $review['user_name']!="") 
                                    {
                                      $setname = isset($review['user_name'])?$review['user_name']:'';
                                    }
                                    else
                                    {
                                      $setname ='User';
                                    }
                                  @endphp

                                  {{ isset($setname)?$setname:'' }}


                             @if($login_user == true && $review['buyer_id']==$login_user->id)

                             @php 

                              if($review['rating']==1)
                                  {$star = "one";}
                                  else if($review['rating']==2)
                                  {$star = "two";}
                                  else if($review['rating']==3)
                                  {$star = "three";}
                                  else if($review['rating']==4)    
                                  {$star = "four";}
                                  else if($review['rating']==5)    
                                  {$star = "five";}
                                  else if($review['rating']==0.5)    
                                  {$star = "zeropointfive";}
                                  else if($review['rating']==1.5)    
                                  {$star = "onepointfive";}
                                  else if($review['rating']==2.5)    
                                  {$star = "twopointfive";}
                                  else if($review['rating']==3.5)    
                                  {$star = "threepointfive";}
                                  else if($review['rating']==4.5)    
                                  {$star = "fourpointfive";} 

                             @endphp

                             <a title="Edit Review" class="fa fa-edit editreviews " id="editreviews_{{ $review['id'] }}" reviewuser="{{ $review['buyer_id'] }}" reviewproduct="{{ $review['product_id'] }}"  reviewid="{{ $review['id'] }}" reviewtitle="{{ $review['title'] }}" reviewdesc="{{ $review['review'] }}" reviewrating="{{ $review['rating'] }}" star="{{ $star }}" emoji="{{ isset($review['emoji'])?$review['emoji']:'' }}">
                              </a>

                             @endif 



                                </div>
                                <div class="lisitng-detls-rate" title="{{$review['rating']}} Rating">
                                <img src="{{url('/')}}/assets/front/images/{{isset($img_rating)?$img_rating:'star-rate-ziro.png'}}" alt="">                                
                                </div>
                            

                                  

                                  <div class="hidecontent" id="hidecontent_{{ $review['id'] }}">
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






                            </div>
                            <div class="clearfix"></div>

                            <div class="showemoji">
                             


                               @if(isset($review['emoji']) && !empty($review['emoji']))
                                <div class="top-rated-div">
                                
                                This helped with my:
                                
                                <span class="colorbk" data-toggle="tooltip" data-html="true" title="Disclaimer: Effects and flavors are reported by users on our site. This is for informational purposes only and not intended as medical advice. Please consult with your physician before changing medical treatments.  These statements have not been evaluated by the Food and Drug Administration. These products are not intended to diagnose, treat, cure or prevent any disease.">
                                  <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </span>
                                <ul class="list-inline">

                                 @php 
                                  $emoji = explode(",",$review['emoji']);
                                  $exploded = [];
                                  foreach($emoji as $kk=>$vv)
                                  {
                                    $exploded = explode(".",$vv);
                                 @endphp
                                  <li>
                                   <img src="{{ url('/') }}/assets/images/{{ $vv }}" width="32px"> 
                                   <label>{{ isset($exploded[0])?$exploded[0]:'' }}</label>
                                  </li>
                                 @php 
                                  }
                                 @endphp
                                 </ul>
                               </div>
                               @endif


                            </div>

                            <div class="clearfix"></div>
                        </div>
                        @endforeach
                        @else
                        <div class="whitebox-list space-o-padding">
                            <div class="titledetailslist pull-left">No Reviews (0)</div>
                        </div>
                        @endif
                        <div class="clearfix"></div>
                                       
                    </div>  --}}




{{-- 
<div id="ReviewRatingsAddModal" class="modal fade login-popup" data-replace="true" style="display: none;">
    <div class="modal-dialog ordercancellationmodal">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><img src="{{url('/')}}/assets/buyer/images/closbtns.png" alt="" /> </button>
            <div class="ordr-calltnal-title">Edit Review & Ratings</div>
            
            <form id="frm-add-review" onsubmit="return false;">
              {{ csrf_field() }}

             <div class="ratings-frms">
              <input type="text" name="product_id" id="product_id" value="">
              <input type="text" name="review_id" id="review_id" value="">   



              <div class="starrr text-left">
                   <input class="star required" type="radio" name="rating" id="rating" value="1"/>
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

            <div class="button-list-dts btn-order-cnls">
                <button class="butn-def btn_send_review" id="btn_send_review">Save</button>
            </div>
          </form>  
            <div class="clr"></div>
        </div>
    </div>
</div>
<!-- Modal My-Review-Ratings-Add End -->
 --}}


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


@php  @endphp

<div class="comment-view-only" id="showreviewdiv" style="max-height: 300px;overflow-y: auto;">
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

                   // $setname = $review['user_details']['first_name']." ".$review['user_details']['last_name'];
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
                    {{-- <img src="{{url('/')}}/assets/front/images/menu-user-icon.png" /> --}}
                    @php
                       $initate_latter =  strtoupper($setname[0]);
                    @endphp
                    {{$initate_latter}}
                </div>
                <div class="review-main-avatar-right">
                    <div class="namereviews">
                        <span>
                            {{--  {{isset($review['user_details']['first_name'])?$review['user_details']['first_name'] :''}}
                            {{isset($review['user_details']['last_name'])?$review['user_details']['last_name']:''}} --}}
                            
                            {{ isset($setname)?ucwords(strtolower($setname)):'' }}

                            @if($login_user == true && $review['buyer_id']==$login_user->id)
                                @php 

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

                                @endphp
                                <a title="Edit Review" class="fa fa-edit editreviews " id="editreviews_{{ $review['id'] }}" reviewuser="{{ $review['buyer_id'] }}" reviewproduct="{{ $review['product_id'] }}"  reviewid="{{ $review['id'] }}" reviewtitle="{{ $review['title'] }}" reviewdesc="{{ $review['review'] }}" reviewrating="{{ $review['rating'] }}" star="{{ $star }}" emoji="{{ isset($review['emoji'])?$review['emoji']:'' }}">
                                </a>
                            @endif 
                        </span>
                        <span class="verified-buyerclass">Verified Buyer</span>
                    </div>
                    <div class="lisitng-detls-rate" title="{{$review['rating']}} Rating">
                        {{-- <img src="{{url('/')}}/assets/front/images/{{isset($img_rating)?$img_rating:'star-rate-ziro.svg'}}" alt="">   --}}              

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
                               

                       {{--  <ul class="list-inline">
                               @php 
                                $emoji = explode(",",$review['emoji']);
                                // dump($review);
                                $exploded = [];
                                foreach($emoji as $kk=>$vv)
                                {
                                  $exploded = explode(".",$vv);
                               @endphp
                                <li>
                                    <img src="{{ url('/') }}/assets/images/{{ $vv }}" width="32px"> 
                                    <label>{{ isset($exploded[0])?ucwords(str_replace("_"," ",$exploded[0])):'' }}</label>
                                </li>
                                @php 
                            }
                                @endphp
                        </ul> --}}
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
            {{-- **************************************************** --}}

            {{--   
            <div class="comment-view-only-white-left">
                <img src="{{$user_profile_img}}" alt="" />
            </div>
            --}}
            <div class="comment-view-only-white-right">

                <div class="title-user-name username-review"> 
                </div>
                {{--    
                <div class="datetimes">{{isset($review_at)?$review_at:''}}</div>
                --}}   
                {{--  
                <p>{{isset($review['review'])?$review['review']:''}} </p>
                --}}

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
    {{--  @if($total_reviews > 6)
    <div class="load-more">
        <a href="#" class="loadmores">Load More...</a>
    </div>
    @endif      --}}                 
</div>

@php  @endphp
