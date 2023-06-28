@extends('front.layout.master')
@section('main_content')
  @php
     $login_user = Sentinel::check();
      $user_type='';
     if(isset($login_user) && !empty($login_user))
     {
       $user_type = $login_user->user_type;

     }

     $product_id = $productid;

      $total_reviews = get_total_reviews($product_id);
      $avg_rating  = get_avg_rating($product_id);

      $emoji=[];

 @endphp
                 

<style>
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
                    $total_reviews = get_total_reviews($product_id);
                    $avg_rating  = get_avg_rating($product_id);
                    if(isset($avg_rating) && $avg_rating > 0)
                    {
                      $img_avg_rating = "";

                      $img_avg_rating = isset($avg_rating)?get_avg_rating_image($avg_rating):'';
                    }
                    @endphp 
                    <div class="container">
                      <div class="add-review-page">
                   <!---------------start--------------------------------->
                    <div class="comment-view-only" id="showreviewdiv">
                    </div>
                    <!-------------------end----------------------------->

                    <div id="reviewform">
                    @if($login_user==true && $login_user->inRole('buyer') && $is_review_added==0 && $product_purchased_by_user==1)

               
                     <form id="frm-add-review" method="post">
                      {{ csrf_field() }}
                      <div class="whitebox-list paddingtop-o">
                          <div class="titledetailslist">Rate This Product</div>

                          <input type="hidden" name="product_id" id="product_id" value="{{isset($product_id)?$product_id:''}}">

                          <div class="ratings-frms view-rating-comments viewcommits">                            
                            <div class="starrr text-left">
                                  <input class="star required" type="radio" name="rating" id="rating_star" value="1"/>
                              </div>
                              <div id="err_rating"></div>
                          </div>
                             <!-- <input type="hidden" id="rating" name="rating"> -->
                            <div class="titledetailslist">Comments</div>
                              <div class="form-group">
                                  <label for="">Title</label>
                                  <input type="text" name="title" id="title" class="input-text  reviewtitle" placeholder="Title" >
                                  <span id="titleerr"></span>
                              </div>
                              <div class="form-group">
                                  <label for="">Write Comment</label>
                                  <textarea class="input-text reviewdesc" placeholder="Write Comment" name="review" id="review"></textarea>
                                  <span id="reviewerr"></span>
                              </div>

                              <div class="checkbox-dropdown">
                                      Helped with 
                                      <ul class="checkbox-dropdown-list">
                                           @if(isset($show_reported_effects) && !empty($show_reported_effects))
                                             @foreach($show_reported_effects as  $k=>$v)
                                              <li>
                                               <div class="checkbox clearfix">
                                                  <div class="form-check checkbox-theme">
                                                      <input class="form-check-input" type="checkbox" value="{{ $v['id'] }}" id="rememberMe1{{ $v['id'] }}"  name="emoji[]">
                                                      <label class="form-check-label" for="rememberMe1{{ $v['id'] }}">
                                                        {{ $v['title'] or '' }}
                                                         @if(file_exists(base_path().'/uploads/reported_effects/'.$v['image']) && isset($v['image']) && !empty($v['image']))
                                                         <img src='{{ url('/') }}/uploads/reported_effects/{{ $v['image'] }}' width="32px" title="{{ $v['title'] }}" />
                                                         @endif 
                                                      </label>
                                                  </div>
                                                </div>
                                               </li>
                                               @endforeach
                                             @endif  
                                         </ul>
                                     </div>
                                  
                                    <span id="helpedwitherr"></span>


                              <div class="button-review-add">
                                
                                  <button type="button" class="butn-def" id="btn_send_review">Send Review</button>      
                                  
                              </div>
                      </div> 
                     </form> 
                    @endif

                   {{--  @if($login_user==true && $login_user->inRole('buyer') && $product_purchased_by_user==1)                     
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
                    @endif --}}


                    
           </div> <!--------end of div of review form---------------------->
           </div>
        </div>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="{{url('/')}}/assets/buyer/js/jquery.rating.js"></script>
<script src="{{url('/')}}/assets/buyer/js/star-rating.js" type="text/javascript"></script>
<link href="{{url('/')}}/assets/buyer/css/star-rating.css" rel="stylesheet" />
  <script>
        jQuery(document).ready(function () {
            $("#input-21f").rating({
                starCaptions: function (val) {
                    if (val < 3) {
                        return val;
                    } else {
                        return 'high';
                    }
                },
                starCaptionClasses: function (val) {
                    if (val < 3) {
                        return 'label label-danger';
                    } else {
                        return 'label label-success';
                    }
                },
                hoverOnClear: false
            });
            var $inp = $('#rating-input');

            $inp.rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'lg',
                showClear: false
            });

            $('#btn-rating-input').on('click', function () {
                $inp.rating('refresh', {
                    showClear: true,
                    disabled: !$inp.attr('disabled')
                });
            });


            $('.btn-danger').on('click', function () {
                $("#kartik").rating('destroy');
            });

            $('.btn-success').on('click', function () {
                $("#kartik").rating('create');
            });

            $inp.on('rating.change', function () {
                alert($('#rating-input').val());
            });


            $('.rb-rating').rating({
                'showCaption': true,
                'stars': '3',
                'min': '0',
                'max': '3',
                'step': '1',
                'size': 'xs',
                'starCaptions': {0: 'status:nix', 1: 'status:wackelt', 2: 'status:geht', 3: 'status:laeuft'}
            });
            $("#input-21c").rating({
                min: 0, max: 8, step: 0.5, size: "xl", stars: "8"
            });
        });
    </script>

<script type="text/javascript">
  $(".checkbox-dropdown").click(function () {
    $(this).toggleClass("is-active");
});

$(".checkbox-dropdown ul").click(function(e) {
    e.stopPropagation();
});

</script>



<script>
   
     
      // This is working function
      $('#btn_send_review').click(function()
      { 

         var flag1= 0; var flag2= 0;var flag3=0;
       // var rating = $("#rating").val();
        var rating = $("#rating_star").val();
        var title = $("#title").val();
        var review = $("#review").val();
        
        if(rating == '')
        {
          $("#err_rating").html('this value is required'); 
          $("#err_rating").addClass('err_rating');
          //return false; 
          flag1 =1;
        }else{
          $("#err_rating").html('');
          flag1 =0;
        }
        if(title=='')
        {
         $("#titleerr").html('Please enter title');
         $("#titleerr").css('color','red');
         flag2 =1;
         // return false; 
        }else{
          $("#titleerr").html('');
          flag2 =0;
        }     
        if(review=='')
        {
         $("#reviewerr").html('Please enter review');
         $("#reviewerr").css('color','red');
         flag3 = 1;
          //return false; 
        }else{
          $("#reviewerr").html('');
          flag3 =0;
        }
         
       // if($('#frm-add-review').parsley().validate()==false) return;
     if(flag1==0 && flag2==0 && flag3==0){

        // var form_data   = $('#frm-add-review').serialize(); 
        var form_data   = $('#frm-add-review').serializeArray(); 
        form_data.push({name: 'rating', value: rating});

        var csrf_token = "{{ csrf_token()}}";

        var login_id = "{{ $login_user->id or '' }}";
        var user_type = "{{ $user_type or '' }}";
        var product_id = "{{ $product_id or '' }}";

        if(login_id.trim()=='')
        {
          window.location.href="{{ url('/') }}/login";
        }
        else if(login_id.trim()!='' && user_type!='' && user_type=="seller")
        {

          swal({
            title: 'Warning',
            text: "You can not add reviews!",
            type: 'warning',
            showConfirmButton:false,
            confirmButtonText: 'Yes, delete it!'
          })
          
            setTimeout(function(){
                        window.location.reload();

            },4000);
        
        }
        else
        {
     
        $.ajax({
            url: SITE_URL+'/buyer/review-ratings/store',
            type:"POST",
            data: form_data,     
           // data:{ title:title,review:review,rating:rating,product_id:product_id },        
            dataType:'json',
            beforeSend: function(){ 
             //showProcessingOverlay();
             $('#btn_send_review').prop('disabled',true);
             $('#btn_send_review').html('Please Wait <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');

            },
            success:function(response)
            {
              // hideProcessingOverlay();
              $('#btn_send_review').prop('disabled',false);
              $('#btn_send_review').html('Send Review');
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
                        window.location.href="{{ url('/') }}/search/show_all_review_list/"+btoa(product_id);
                       $("#reviewform").hide();
                       // showreviews(productid);
                      // $(this).addClass('active');
                        $( "#review_div" ).load(window.location.href + " #review_div" );

                      }

                    });
              }
              else
              {                
                swal('Error',response.description,'error');
              }  
            }  

           }); //ajax
          }//else of login conditions

          }else{
           return false;
          }
       
     }); 
		

</script>

 @endsection