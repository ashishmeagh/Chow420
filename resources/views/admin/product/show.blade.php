@extends('admin.layout.master')                
@section('main_content')

 <link href="{{url('/')}}/assets/front/css/lightgallery.css" rel="stylesheet" type="text/css" />

<style type="text/css">
  .myprofile-lefts {
    float: left;
    font-weight: 600;
    color: #333;
    max-width: 160px;
}
  .morecontent span {display: none;}
  .morelink {display: block;color: #887d7d;}
  .morelink:hover,.morelink:focus{color: #887d7d;}
  .morelink.less{color: #887d7d;}
  .show-h3{margin-top: 0px;}
  .comments-mains.sub-reply{border-radius: 5px;}
  .txt-commnts{color: #888888;}
  .comments-mains-right.move-top-mrg {margin-top: 11px;}
</style>
<!-- Page Content -->
<div id="page-wrapper"> 
<div class="container-fluid">
<div class="row bg-title">
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">{{$page_title or ''}}</h4>
   </div>
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">

        @php
          $user = Sentinel::check();
        @endphp
        
        @if(isset($user) && $user->inRole('admin'))
         <li><a href="{{ url(config('app.project.admin_panel_slug').'/dashboard') }}">Dashboard</a></li>
        @endif
         
        <li><a href="{{ url(config('app.project.admin_panel_slug').'/product') }}">Products</a></li>
        <li class="active">{{$page_title or ''}}</li>
      </ol>
   </div>
   <!-- /.col-lg-12 -->
</div>

<!-- .row -->
<div class="row">
   <div class="col-sm-12">
      <div class="white-box">



        <div class="statusbuttons">
          <div class="pul-lefts">
            <div class="verification-statustitle">Verification Status</div>
          <div class="stt-block">
             @if(isset($arr_data['is_approve']) && $arr_data['is_approve']=="0")
               <span class="status-dispatched">Pending Approval</span>
             @elseif($arr_data['is_approve']=="1")
                <span class="status-completed">Approved</span>
              @elseif($arr_data['is_approve']=="2")
                <span class="status-shipped">Disapproved</span>   
             @endif
          </div>
          </div>
          <div class="button-padding">

            @if(isset($arr_data['is_approve']) && $arr_data['is_approve']=="0")

            <a href="#" class="status-shipped approve_disapprove btnchw"  productid="{{ $arr_data['id'] }}" productstatus="1" dbstatus="{{ $arr_data['is_approve'] }}">Approve</a>
            <a href="#" class="status-shipped approve_disapprove btnchw-disapprove" productid="{{ $arr_data['id'] }}" productstatus="2" dbstatus="{{ $arr_data['is_approve'] }}">Disapprove</a>
            @elseif($arr_data['is_approve']=='1')
            <a href="#" class="status-shipped approve_disapprove btnchw-disapprove" productid="{{ $arr_data['id'] }}" productstatus="2" dbstatus="{{ $arr_data['is_approve'] }}">Disapprove</a>
            @elseif($arr_data['is_approve']=='2')
              <a href="#" class="status-shipped approve_disapprove btnchw" productid="{{ $arr_data['id'] }}" productstatus="1" dbstatus="{{ $arr_data['is_approve'] }}">Approve</a>
            @endif

          </div>
          <div class="clearfix"></div>
        </div>



         @include('admin.layout._operation_status')
          <div class="row">
            <div class="col-sm-12 col-xs-12">
                 <h3>
                    <span 
                       class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action" >
                    </span>
                 </h3>
            </div>
          </div>
          
          {{--  <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label myprofile-lefts" >Average Rating :</label>
              <div class="col-sm-3 col-lg-3 controls myprofile-right">                
                 @php $avg_rating = 0; $avg_rating = get_avg_rating($arr_data['id']); @endphp
                   @if(isset($avg_rating) && $avg_rating!="")
                     {{isset($avg_rating)?$avg_rating:0}}
                   @endif 
              </div>
           </div> --}}

            <div class="row">

                  <div class="col-sm-6">

                 {{--  <div class="myprofile-main">
                       <div class="myprofile-lefts">Verification Status</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['is_approve']) && $arr_data['is_approve']=="0")
                           <span >Pending Approval</span>

                           <a href="#" class="status-completed btn btn-sm approve_disapprove" productid="{{ $arr_data['id'] }}" productstatus="1" dbstatus="{{ $arr_data['is_approve'] }}">Approve</a>   
                           <a href="#" class="status-shipped approve_disapprove btnchw" productid="{{ $arr_data['id'] }}" productstatus="2" dbstatus="{{ $arr_data['is_approve'] }}">Disapprove</a> 



                          @elseif($arr_data['is_approve']=='1')
                            <span class="status-completed">Approved</span>

                             <a href="#" class="status-shipped approve_disapprove btnchw" productid="{{ $arr_data['id'] }}" productstatus="2" dbstatus="{{ $arr_data['is_approve'] }}">Disapprove</a>


                          @elseif($arr_data['is_approve']=='2')
                            <span >Disapproved</span>  

                             <a href="#" class="status-completed btn btn-sm approve_disapprove" productid="{{ $arr_data['id'] }}" productstatus="1" dbstatus="{{ $arr_data['is_approve'] }}">Approve</a>   


                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>   --}} 


                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Product Name</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['product_name']) && $arr_data['product_name']!="")
                          {{ $arr_data['product_name'] }}
                          @else
                           NA
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>

                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Is Trending</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['is_trending']) && $arr_data['is_trending']==1)
                           Yes
                          @else
                            No
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>

                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Average Rating</div>
                       <div class="myprofile-right">
                           @php 
                            $avg_rating = 0; $avg_rating = get_avg_rating($arr_data['id']); 
                           @endphp
                           @if(isset($avg_rating) && $avg_rating!="")
                             {{isset($avg_rating)?$avg_rating:0}}
                           @endif 
                       </div>
                       <div class="clearfix"></div>
                  </div>


                   <div class="myprofile-main">
                       <div class="myprofile-lefts">SKU</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['sku']) && $arr_data['sku']!="")
                          {{ $arr_data['sku'] }}
                          @else
                           NA
                          @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>


                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Product Image</div>
                       <div class="myprofile-right">
                          
                      @if(!empty($arr_data['product_images_details']) && count($arr_data['product_images_details'])>0)
                           
                          @foreach($arr_data['product_images_details'] as $images)

                            @if(file_exists(base_path().'/uploads/product_images/thumb/'.$images['image']))
                             
                            {{--   <img id="admin-profile-img" 
                              src="{{ $product_imageurl_path}}/{{ $images['image']}}" alt="product-img" width="100" class=""> --}}

                            {{--   <div class="disv-zooms" id="lightgallery2">
                               <a href="" data-responsive="{{ $product_imageurl_path}}/{{ $images['image']}}" data-src="{{ $product_imageurl_path}}/{{ $images['image']}}">
                                <img src="{{ $product_imageurl_path}}/{{ $images['image']}}" alt="Product Image" width="100"> 
                               </a>
                             </div> --}}



                              <div class="disv-zooms" id="lightgallery2">
                               <a href="" data-responsive="{{ $product_imageurl_path}}/thumb/{{ $images['image']}}" data-src="{{ $product_imageurl_path}}/thumb/{{ $images['image']}}">
                                <img src="{{ $product_imageurl_path}}/thumb/{{ $images['image']}}" alt="Product Image" width="100"> 
                               </a>
                             </div>



                              @else
                                NA
                              @endif


                          @endforeach
                        @endif

                       </div>
                       <div class="clearfix"></div>
                  </div>



                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Additional Product Image</div>
                       <div class="myprofile-right">
                         
                          @if(file_exists(base_path().'/uploads/additional_product_image/'.$arr_data['additional_product_image']))
                         
                          <div class="disv-zooms" id="lightgallery2">
                           <a href="" data-responsive="{{ $add_product_public_img_path}}{{ $arr_data['additional_product_image']}}" data-src="{{ $add_product_public_img_path}}{{ $arr_data['additional_product_image']}}">
                            <img src="{{ $add_product_public_img_path}}{{ $arr_data['additional_product_image']}}" alt="Additional Product Image" width="100"> 
                           </a>
                          </div>

                          @else
                            NA
                          @endif


                       </div>
                       <div class="clearfix"></div>
                  </div>


                    <div class="myprofile-main">
                        <div class="myprofile-lefts">Terpenes</div>
                    {{--     <div class="myprofile-right">
                       
                          @php
                            if(isset($arr_data['terpenes']) && !empty($arr_data['terpenes']))
                            {
                              $get_terpenes_val = $arr_data['terpenes'];
                            }
                          @endphp
                           {{ isset($get_terpenes_val)?$get_terpenes_val:'NA' }}

                        </div> --}}


                      <div class="myprofile-right content">
                         @if(isset($arr_data['terpenes']) && $arr_data['terpenes']!="")
                           <!--------------div--added---------------------->

                             <div id="hidecontent1">
                              @if(strlen($arr_data['terpenes'])>50)
                               @php echo substr($arr_data['terpenes'],0,50) @endphp
                              <span id="show-more1" style="color: #4a3b3b;cursor: pointer;">...Show more</span>
                              @else
                                 @php echo $arr_data['terpenes'] @endphp
                              @endif
                            </div>
                            <span id="show-more-content1">
                                @php echo $arr_data['terpenes'] @endphp
                                <span id="show-less1" style="color:#4a3b3b;cursor: pointer;">Show less</span>
                            </span>

                          <script>
                           $('#show-more-content1').hide();
                          $('#show-more1').click(function(){
                            $('#show-more-content1').show();
                            $('#show-less1').show();
                            $(this).hide();
                            $("#hidecontent1").hide();
                          });
                          $('#show-less1').click(function(){
                            $('#show-more-content1').hide();
                            $('#show-more1').show();
                            $(this).hide();
                             $('#hidecontent1').show();
                          });
                          </script>
                           <!------------end-desc-div-------------------------->
                          @else
                          NA
                          @endif
                        </div>



                        <div class="clearfix"></div>

                    </div>

                   @if(isset($arr_data['first_level_category_details']['product_type']) && $arr_data['first_level_category_details']['product_type']!="" && $arr_data['first_level_category_details']['product_type']=="Accessories" || $arr_data['first_level_category_details']['product_type']=="Essential Oils") 
                   @else
                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Certificate Of Analysis</div>
                       <div class="myprofile-right">
                            
                        @if(isset($arr_data['product_certificate']) && !empty($arr_data['product_certificate']) && (file_exists(base_path().'/uploads/product_images/'.$arr_data['product_certificate'])))
                            
                             {{--  <img id="admin-profile-img" 
                              src="{{ $product_imageurl_path}}/{{ $arr_data['product_certificate']}}" alt="user-img" width="100" class=""> --}}

                              @php

                              $prod_certificate = $arr_data['product_certificate'];
                              $ext = pathinfo($prod_certificate, PATHINFO_EXTENSION);
                              if($ext=="pdf"){
                              @endphp

                               <div class="disv-zooms">
                               <a href="{{ url('/') }}/uploads/product_images/{{$arr_data['product_certificate']}}" target="_blank">
                                View Certificate
                               </a>
                             </div>
                             @php
                                }else{ 
                             @endphp  
                              NA
                             {{--  <div class="disv-zooms" id="lightgallery">
                               <a href="" data-responsive="{{ url('/') }}/uploads/product_images/thumb/{{$arr_data['product_certificate']}}" data-src="{{ url('/') }}/uploads/product_images/thumb/{{$arr_data['product_certificate']}}">
                                <img src="{{ url('/') }}/uploads/product_images/{{$arr_data['product_certificate']}}" alt="COA" width="100"> 
                               </a>
                             </div> --}}
                             @php } @endphp
                         @else
                           NA
                         @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>
                  @endif


                  @if(isset($arr_data['first_level_category_details']['product_type']) && $arr_data['first_level_category_details']['product_type']!="" && $arr_data['first_level_category_details']['product_type']=="Accessories" || $arr_data['first_level_category_details']['product_type']=="Essential Oils") 
                   @else
                   <div class="myprofile-main">
                       <div class="myprofile-lefts">COA Link</div>
                       <div class="myprofile-right">
                            
                        @if(isset($arr_data['coa_link']) && !empty($arr_data['coa_link']))
                             <div class="disv-zooms">
                               <a href="{{$arr_data['coa_link']}}" target="_blank">
                                View COA Link
                               </a>
                             </div>
                         @else
                           NA
                         @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>
                  @endif




                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Spectrum Type</div>
                       <div class="myprofile-right">
                        {{-- @if($arr_data['spectrum']=='0')
                         Full Spectrum
                        @elseif($arr_data['spectrum']=='1')
                         Broad Spectrum
                        @elseif($arr_data['spectrum']=='2')
                         Isolate 
                         @elseif($arr_data['spectrum']=='')
                         NA  
                        @endif   --}}

                         @php
                            if(isset($arr_data['spectrum']) && !empty($arr_data['spectrum']))
                            {
                              $get_spectrum_val = get_spectrum_val($arr_data['spectrum']);
                            }
                         @endphp
                           {{ isset($get_spectrum_val['name'])?$get_spectrum_val['name']:'NA' }}

                       </div>
                       <div class="clearfix"></div>


                  </div>


                   <div class="myprofile-main">
                       <div class="myprofile-lefts"></div>
                       <div class="myprofile-right">
                            @php
                                  $arr_cannabinoids = get_product_cannabinoids($arr_data['id']);
                              @endphp

                              @if(isset($arr_cannabinoids) && count($arr_cannabinoids) > 0)
                                @foreach($arr_cannabinoids as $canName)
                                    <span class="oil-category-cannabinoids">{{$canName['name']}} {{floatval($canName['percent'])}} %</span>
                                @endforeach
                              @endif
                       </div>
                       <div class="clearfix"></div>

                       
                  </div>





                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Category</div>
                       <div class="myprofile-right">
                          @if(isset($arr_data['first_level_category_details']['product_type']) && $arr_data['first_level_category_details']['product_type']!="")
                          {{ $arr_data['first_level_category_details']['product_type'] }}
                          @else
                          NA
                          @endif
                        </div>
                       <div class="clearfix"></div>
                  </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Sub category</div>
                       <div class="myprofile-right">
                         @if(isset($arr_data['second_level_category_details']['name']) && $arr_data['second_level_category_details']['name']!="") 
                         {{ $arr_data['second_level_category_details']['name'] }}
                         @else
                         NA
                         @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>



                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Unit Price($)</div>
                       <div class="myprofile-right">
                        @if(isset($arr_data['unit_price']) && $arr_data['unit_price']!="")
                         ${{num_format($arr_data['unit_price']) }} 
                        @else
                         NA
                        @endif
                       </div>
                       <div class="clearfix"></div>
                  </div>

                   @php
                     if(isset($arr_data['percent_price_drop']) && $arr_data['percent_price_drop']=='0.000000') 
                     {
                       $percent_price_drop = calculate_percentage_price_drop($arr_data['id'],$arr_data['unit_price'],$arr_data['price_drop_to']); 
                       $percent_price_drop = floor($percent_price_drop);
                     }
                     else
                     { 
                       $percent_price_drop = floor($arr_data['percent_price_drop']);
                     }
                  @endphp


                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Price Drop($)</div>
                       <div class="myprofile-right">
                         @if(isset($arr_data['price_drop_to']) && $arr_data['price_drop_to']!="")
                         ${{num_format($arr_data['price_drop_to']) }} @if($arr_data['price_drop_to']>0) ({{$percent_price_drop}}% off) @endif
                         @else
                         NA
                         @endif 
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  


                  @if(isset($arr_data['first_level_category_details']['product_type']) && $arr_data['first_level_category_details']['product_type']!="" && $arr_data['first_level_category_details']['product_type']=="Accessories" || $arr_data['first_level_category_details']['product_type']=="Essential Oils") 
                  @else
                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Concentration (mg)</div>
                       <div class="myprofile-right">
                         @if(isset($arr_data['per_product_quantity']) && $arr_data['per_product_quantity']!="")
                          {{ $arr_data['per_product_quantity'] or ''}}
                         @else
                           NA 
                         @endif  
                        </div>
                       <div class="clearfix"></div>
                  </div>
                  @endif

                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Reason of chow choice removal &nbsp;</div>
                       <div class="myprofile-right"> 
                         @if(isset($arr_data['reason_for_removal_from_chows_choice']) && $arr_data['reason_for_removal_from_chows_choice']!="")
                         {{ $arr_data['reason_for_removal_from_chows_choice'] }}
                         @else
                         NA
                         @endif 
                       </div>
                       <div class="clearfix"></div>
                  </div>


            @php
             $arr_dropshipper_details = [];
            if(isset($arr_data['drop_shipper']) && $arr_data['drop_shipper']!="")
            {  
              $arr_dropshipper_details = get_product_dropshipper($arr_data['drop_shipper']);
            }  
            @endphp

            @if(isset($arr_dropshipper_details) && sizeof($arr_dropshipper_details)>0)
             <div class="myprofile-main">
                <div class="myprofile-lefts">Dropshipper Name:</div>
                     <div class="myprofile-right">
                     {{isset($arr_dropshipper_details['name'])?ucfirst($arr_dropshipper_details['name']):''}}
                      </div>
                <div class="clearfix"></div>
            </div>
            <div class="myprofile-main">
                <div class="myprofile-lefts">Dropshipper Email ID:</div>
                     <div class="myprofile-right">
                     {{isset($arr_dropshipper_details['email'])?ucfirst($arr_dropshipper_details['email']):''}}
                      </div>
                <div class="clearfix"></div>
            </div>
             <div class="myprofile-main">
                <div class="myprofile-lefts">Dropshipper Price:</div>
                     <div class="myprofile-right">
                     ${{isset($arr_dropshipper_details['product_price'])?num_format($arr_dropshipper_details['product_price']):'NA'}}
                      </div>
                <div class="clearfix"></div>
            </div>
            @endif

                </div>

                <div class="col-sm-6">
                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Description</div>
                       {{--  <div class="myprofile-right prod-desc">
                        @if(isset($arr_data['description']) && $arr_data['description']!="")
                          @php echo $arr_data['description'] @endphp
                          @else
                          NA
                          @endif
                        </div> --}}

                         <div class="myprofile-right content">
                         @if(isset($arr_data['description']) && $arr_data['description']!="")
                           <!--------------div--added---------------------->

                             <div id="hidecontent">
                              @if(strlen($arr_data['description'])>50)
                               @php echo substr($arr_data['description'],0,50) @endphp
                              <span id="show-more" style="color: #4a3b3b;cursor: pointer;">...Show more</span>
                              @else
                                 @php echo $arr_data['description'] @endphp
                              @endif
                            </div>
                            <span id="show-more-content">
                                @php echo $arr_data['description'] @endphp
                                <span id="show-less" style="color:#4a3b3b;cursor: pointer;">Show less</span>
                            </span>
<script>
 $('#show-more-content').hide();
$('#show-more').click(function(){
  $('#show-more-content').show();
  $('#show-less').show();
  $(this).hide();
  $("#hidecontent").hide();
});
$('#show-less').click(function(){
  $('#show-more-content').hide();
  $('#show-more').show();
  $(this).hide();
   $('#hidecontent').show();
});
</script>
                           <!------------end-desc-div-------------------------->
                          @else
                          NA
                          @endif
                        </div>





                       <div class="clearfix"></div>
                  </div>


                  <!-- Added 3 new fields -->

                  <div class="myprofile-main">
                        <div class="myprofile-lefts">Ingredients</div>

                        <div class="myprofile-right content">
                              @if(isset($arr_data['ingredients']) && $arr_data['ingredients']!="")
                              <!--------------div--added---------------------->
                              <div id="hidecontent-ingredients">
                                  @if(strlen($arr_data['ingredients'])>50)
                                  @php echo substr($arr_data['ingredients'],0,50) @endphp
                                    <span id="show-more-ingredients" style="color: #4a3b3b;cursor: pointer;">...Show more</span>
                                  @else
                                   @php echo $arr_data['ingredients'] @endphp
                                  @endif
                              </div>
                              <span id="show-more-content-ingredients">
                                  @php echo $arr_data['ingredients'] @endphp
                                  <span id="show-less_ingredients" style="color:#4a3b3b;cursor: pointer;">Show less</span>
                              </span>
                              <script>
                                $('#show-more-content-ingredients').hide();
                                $('#show-more-ingredients').click(function(){
                                $('#show-more-content-ingredients').show();
                                $('#show-less_ingredients').show();
                                $(this).hide();
                                $("#hidecontent-ingredients").hide();
                              });
                                $('#show-less_ingredients').click(function(){
                                $('#show-more-content-ingredients').hide();
                                $('#show-more-ingredients').show();
                                $(this).hide();
                                $('#hidecontent-ingredients').show();
                              });
                              </script>
                              <!------------end-desc-div-------------------------->
                              @else
                              NA
                              @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>



                    <div class="myprofile-main">
                        <div class="myprofile-lefts">Suggested Use</div>

                        <div class="myprofile-right content">
                              @if(isset($arr_data['suggested_use']) && $arr_data['suggested_use']!="")
                              <!--------------div--added---------------------->
                              <div id="hidecontent-suggested_use">
                                  @if(strlen($arr_data['suggested_use'])>50)
                                  @php echo substr($arr_data['suggested_use'],0,50) @endphp
                                    <span id="show-more-suggested_use" style="color: #4a3b3b;cursor: pointer;">...Show more</span>
                                  @else
                                   @php echo $arr_data['suggested_use'] @endphp
                                  @endif
                              </div>
                              <span id="show-more-content-suggested_use">
                                  @php echo $arr_data['suggested_use'] @endphp
                                  <span id="show-less_suggested_use" style="color:#4a3b3b;cursor: pointer;">Show less</span>
                              </span>
                              <script>
                                $('#show-more-content-suggested_use').hide();
                                $('#show-more-suggested_use').click(function(){
                                $('#show-more-content-suggested_use').show();
                                $('#show-less_suggested_use').show();
                                $(this).hide();
                                $("#hidecontent-suggested_use").hide();
                              });
                                $('#show-less_suggested_use').click(function(){
                                $('#show-more-content-suggested_use').hide();
                                $('#show-more-suggested_use').show();
                                $(this).hide();
                                $('#hidecontent-suggested_use').show();
                              });
                              </script>
                              <!------------end-desc-div-------------------------->
                              @else
                              NA
                              @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="myprofile-main">
                        <div class="myprofile-lefts">Amount per serving</div>

                        <div class="myprofile-right content">
                              @if(isset($arr_data['amount_per_serving']) && $arr_data['amount_per_serving']!="")
                              <!--------------div--added---------------------->
                              <div id="hidecontent-amount_per_serving">
                                  @if(strlen($arr_data['amount_per_serving'])>50)
                                  @php echo substr($arr_data['amount_per_serving'],0,50) @endphp
                                    <span id="show-more-amount_per_serving" style="color: #4a3b3b;cursor: pointer;">...Show more</span>
                                  @else
                                   @php echo $arr_data['amount_per_serving'] @endphp
                                  @endif
                              </div>
                              <span id="show-more-content-amount_per_serving">
                                  @php echo $arr_data['amount_per_serving'] @endphp
                                  <span id="show-less_amount_per_serving" style="color:#4a3b3b;cursor: pointer;">Show less</span>
                              </span>
                              <script>
                                $('#show-more-content-amount_per_serving').hide();
                                $('#show-more-amount_per_serving').click(function(){
                                $('#show-more-content-amount_per_serving').show();
                                $('#show-less_amount_per_serving').show();
                                $(this).hide();
                                $("#hidecontent-amount_per_serving").hide();
                              });
                                $('#show-less_amount_per_serving').click(function(){
                                $('#show-more-content-amount_per_serving').hide();
                                $('#show-more-amount_per_serving').show();
                                $(this).hide();
                                $('#hidecontent-amount_per_serving').show();
                              });
                              </script>
                              <!------------end-desc-div-------------------------->
                              @else
                              NA
                              @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>




                  {{-- <div class="myprofile-main">
                       <div class="myprofile-lefts">Age Restriction</div>
                       <div class="myprofile-right">
                         @if(isset($arr_data['age_restriction_detail']['age']) && $arr_data['age_restriction_detail']['age'] != '')
                                {{ $arr_data['age_restriction_detail']['age']}}
                              @else
                               -
                               @endif
                       </div>
                       <div class="clearfix"></div>
                  </div> --}}
                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Dispensary</div>
                       <div class="myprofile-right">
                        {{--  {{ $arr_data['user_details']['first_name'].' '.$arr_data['user_details']['last_name'] }}  --}}
                         @if(isset($arr_data['user_details']['seller_detail']['business_name']) && !empty($arr_data['user_details']['seller_detail']['business_name']))
                          {{ $arr_data['user_details']['seller_detail']['business_name'] }}
                         @else
                          -
                         @endif  

                       </div>
                       <div class="clearfix"></div>
                  </div>


                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Shipping Type</div>
                       <div class="myprofile-right">
                        @if($arr_data['shipping_type']=='0')
                         Free Shipping
                        @elseif($arr_data['shipping_type']=='1')
                         Flat Shipping
                        @endif  
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Shipping Charges</div>
                       <div class="myprofile-right">
                        @if($arr_data['shipping_type']=='1' && ($arr_data['shipping_charges']!=''))
                         {{ num_format($arr_data['shipping_charges'],2) }}
                        @elseif($arr_data['shipping_type']=='0')
                        NA
                        @endif  
                       </div>
                       <div class="clearfix"></div>
                  </div>
                 <?php
                      $full_day = $str_shipping_duration = ""; 
                      if(isset($arr_data['shipping_duration']) && $arr_data['shipping_duration']!="" && filter_var($arr_data['shipping_duration'], FILTER_VALIDATE_FLOAT)==true && $arr_data['shipping_duration']!=0.500000) 
                      {
                         $full_day = floor($arr_data['shipping_duration']); 
                         $fraction = $arr_data['shipping_duration'] - $full_day;
                         if(isset($full_day) && $full_day!="")
                         { 
                            if(isset($fraction) && $fraction!=0)
                            {  
                             $str_shipping_duration = $full_day." & Half Day";  
                            }
                            else if(isset($fraction) && $fraction==0 && $full_day==1) 
                            {
                             $str_shipping_duration = $full_day." Day"; 
                            }
                            else if(isset($fraction) && $fraction==0 && $full_day!=1) 
                            {
                             $str_shipping_duration = $full_day." Days"; 
                            }
                         }
                      }
                      else if(isset($arr_data['shipping_duration']) && $arr_data['shipping_duration']!="" && filter_var($arr_data['shipping_duration'], FILTER_VALIDATE_FLOAT)==true && $arr_data['shipping_duration']== 0.500000)
                      {
                          $str_shipping_duration = "Half Day";  
                      }
                  ?> 

                 <div class="myprofile-main">
                       <div class="myprofile-lefts">Shipping Duration</div>
                       <div class="myprofile-right">
                        @if(isset($str_shipping_duration) && $str_shipping_duration!="")
                        {{$str_shipping_duration}}
                        @else
                        NA
                        @endif  
                       </div>
                       <div class="clearfix"></div>
                </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Remaining Stock</div>
                       <div class="myprofile-right">
                        @if(isset($arr_data['inventory_details']['remaining_stock']))
                         {{ $arr_data['inventory_details']['remaining_stock'] }}
                       @else                        
                        NA
                        @endif  
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  <!---------start-product-dimension-------------------------->
                 {{--  @php
                  $arr_product_dimensions = [];
                  if(isset($arr_data['id']) && $arr_data['id']!="")
                  {
                    $arr_product_dimensions  = get_product_dimensions($arr_data['id']);
                  }
                  @endphp

                   @if(isset($arr_product_dimensions) && !empty($arr_product_dimensions))
                   <div class="myprofile-main">
                      <div class="myprofile-lefts">Dimensions:</div>
                          @if(isset($arr_product_dimensions) && !empty($arr_product_dimensions))
                           @foreach($arr_product_dimensions as $product_dimension)   
                           <div class="myprofile-right" style="margin-bottom:2%">{{isset($product_dimension['option'])?ucfirst($product_dimension['option_type']):''}}: <span>{{isset($product_dimension['option'])?ucfirst($product_dimension['option']):''}}</div>
                           @endforeach  
                          @endif
                      <div class="clearfix"></div>
                  </div>
                  @endif --}}
                  <!---------end-product-dimension--------------------------->




                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Disapproved Reason</div>
                       <div class="myprofile-right reason-desc" style="color:red"> 
                        @if($arr_data['is_approve']=='2' && ($arr_data['reason']!=''))
                         {{ $arr_data['reason'] }}
                        @elseif($arr_data['is_approve']=='1')
                        NA
                        @elseif($arr_data['is_approve']=='0')
                        NA
                        @endif  
                       </div>
                       <div class="clearfix"></div>
                  </div>


                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Product Video Source</div>
                       <div class="myprofile-right"> 
                        @if(isset($arr_data['product_video_source']) && ($arr_data['product_video_source']!=''))
                         {{ ucfirst($arr_data['product_video_source']) }}                 
                        @else
                        NA
                        @endif  
                       </div>
                       <div class="clearfix"></div>
                  </div>

                   <div class="myprofile-main">
                       <div class="myprofile-lefts">Rating</div>
                       <div class="myprofile-right"> 
                        @if(isset($arr_data['avg_rating']) && ($arr_data['avg_rating']!=''))
                         {{ ucfirst($arr_data['avg_rating']) }}                 
                        @else
                        NA
                        @endif  
                       </div>
                       <div class="clearfix"></div>
                  </div>

                  <div class="myprofile-main">
                       <div class="myprofile-lefts">Review</div>
                       <div class="myprofile-right"> 
                        @if(isset($arr_data['avg_review']) && ($arr_data['avg_review']!=''))
                         {{ ucfirst($arr_data['avg_review']) }}                 
                        @else
                        NA
                        @endif  
                       </div>
                       <div class="clearfix"></div>
                  </div>


                  @if(isset($arr_data['product_video_source']) && !empty($arr_data['product_video_source']))
                     <div class="myprofile-main">
                       <div class="myprofile-lefts">Product Video </div>
                       <div class="myprofile-right"> 
                         <a href="javascript:void(0)"  class="btn btn-info" style="background-color: #873dc8;border-color: #873dc8;" id="product_video_popup" data-video-source="{{$arr_data['product_video_source']}}" data-video-id="{{$arr_data['product_video_url']}}" data-video-title="{{isset($arr_data['product_name'])? $arr_data['product_name']: ''}}" onclick="openProductVideoModal(this);">
                            View Video 
                          </a>
                       </div>
                      <div class="clearfix"></div>
                    </div>
                  @endif

                </div><!--end of col-md-6--->
               </div><!--end of row--->
             
</div><!--end of class=white-box--->



  @if(isset($arr_comment) && sizeof($arr_comment)>0)

<div class="white-box">
       

<div cass="main-show-list-dtls">
  <h3 class="show-h3"><b>Comments</b></h3>

  @if(isset($arr_comment) && sizeof($arr_comment)>0)
  @foreach($arr_comment as $comment)
   @php
    if(isset($comment['user_details']['profile_image']) && $comment['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$comment['user_details']['profile_image']))
      {
          $user_profile_img = url('/uploads/profile_image/'.$comment['user_details']['profile_image']);
      }
      else
      {                  
        $user_profile_img = url('/assets/images/avatar.png');
       }
    @endphp 

      <div class="comments-mains">
          <div class="comments-mains-left">
              <img src="{{$user_profile_img}}" alt="" />
          </div>
          <div class="comments-mains-right move-top-mrg">
              <div class="txt-commnts"><span>{{isset($comment['user_details']['first_name'])?$comment['user_details']['first_name']:''}} {{isset($comment['user_details']['last_name'])?$comment['user_details']['last_name']:''}}</span>   {{isset($comment['comment'])?$comment['comment']:''}}</div>
              {{-- <div class="times">{{isset($reply['created_at'])?date('h:i - M d, Y', strtotime($reply['created_at'])):''}} <a href="#">Reply</a>
              </div> --}}
          </div>
          <div class="clearfix"></div>

              @if(isset($comment['reply_details']) && sizeof($comment['reply_details'])>0)
                @foreach($comment['reply_details'] as $reply)

                  @php

                    if(isset($reply['user_details']['profile_image']) && $reply['user_details']['profile_image'] != '' && file_exists(base_path().'/uploads/profile_image/'.$reply['user_details']['profile_image']))
                        {
                          $reply_user_profile_img = url('/uploads/profile_image/'.$reply['user_details']['profile_image']);
                        }
                    else
                        {                  
                          $reply_user_profile_img = url('/assets/images/avatar.png');
                        }

                  @endphp
          <div class="comments-mains sub-reply">
              <div class="comments-mains-left">
                  <img src="{{$reply_user_profile_img}}" alt="" />
              </div>
              <div class="comments-mains-right">

                  <div class="txt-commnts"><span>{{isset($reply['user_details']['first_name'])?$reply['user_details']['first_name']:''}} {{isset($reply['user_details']['last_name'])?$reply['user_details']['last_name']:''}}</span> {{isset($reply['reply'])?$reply['reply']:''}}
                  </div>

                 {{--  <div class="times"> 
                    {{isset($reply['created_at'])?date('h:i - M d, Y', strtotime($reply['created_at'])):''}}
                    <a href="#">Reply</a>
                  </div> --}}
              </div>
              <div class="clearfix"></div>
          </div>
           @endforeach
           @endif
      </div>

   @endforeach  
   @endif 
</div>

</div>
  @endif


  <div class="form-group row">
    <div class="col-10">
       <a class="btn btn-inverse waves-effect waves-light" href="{{$module_url_path}}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  </div>

</div>
</div>      
</div>
</div>



<div class="modal fade" id="reject_product_sectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <input type="hidden" name="hidden_product_id" id="hidden_product_id" value="">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Reject Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="age_body">
       <div class="row" id="viewagedetails">
          <div class="title-imgd">Reason &nbsp;</div>
          <textarea id="reason" name="reason" class="form-control" rows="5" maxlength="500"></textarea>
          <span id="reason_err"></span>
      </div><!------row div end here------------->         
      </div><!------body div end here------------->
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger rejectprodbtn" id="rejectprodbtn">Reject</button>
      </div>
    </div>
  </div> 
</div>




<!----------------videomodal-------------------------->

<div  class="modal fade" id="productVideoModal" tabindex="-1" role="dialog" aria-labelledby="productVideoModalTitle1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header borderbottom">
        <div class="video-modal-title" id="productVideoModalTitle"></div>
        {{-- <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5> --}}
        <button type="button" id="close_product_video" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="yt-player" style="height: 400px;">
        <iframe class="youtube-video" id="youtube-video" width="100%" height="100%" frameborder="0" allowfullscreen
            src="">
        </iframe>

      </div>
    </div>
  </div>
</div>
<!---------------end videomodal------------>


  <script>
    function openProductVideoModal(ref){

      let videoID = $(ref).attr('data-video-id');
      
      let video_source = $(ref).attr('data-video-source');

      let title = $(ref).attr('data-video-title');
      let videoUrl ='';
      if(video_source=="youtube")
      {
        videoUrl = 'https://www.youtube.com/embed/'+videoID/*+'?autoplay=1'*/;
      }
      if(video_source=="vimeo")
      {
        videoUrl = 'https://player.vimeo.com/video/'+videoID/*+'?autoplay=1'*/;
      }

      $("#yt-player iframe.youtube-video").attr("src",videoUrl);

      $(".modal-footer").html('');  
      $("#productVideoModalTitle").html(title);     

      $("#productVideoModal").modal();
    }

  </script>





<script type="text/javascript">
  $(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 100;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";
    

    $('.prod-desc').each(function() {
        var content = $(this).html().trim();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });


     $('.reason-desc').each(function() {
        var content = $(this).html().trim();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });


 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
</script>

<script> 
  
  var module_url_path = "{{$module_url_path}}";

     $('.approve_disapprove').click(function(){

         var product_id = $(this).attr('productid');  
         var status = $(this).attr('productstatus'); 
         var dbstatus = $(this).attr('dbstatus'); 
         
         if(status=='0' || status=='2')
         {
          // var status  = 1;
           var status_app_disapp = 'Do you really want to disapprove status of this product?';
         }
         else if(status=='1')
         {
           //var status  = 2;
           var status_app_disapp = 'Do you really want to approve status of this product?';
         }

                           

           swal({
              title: status_app_disapp,
              type: "warning",
              showCancelButton: true,
              // confirmButtonColor: "#DD6B55",
              confirmButtonColor: "#8d62d5",
              confirmButtonText: "Yes, do it!",
              closeOnConfirm: true
            },
            function(isConfirm,tmp)
            {
              if(isConfirm==true)
              {

                    if(status=='2')
                    {

                        $("#reject_product_sectionmodal").modal('show');
                        $("#hidden_product_id").val(product_id);

                    }else{ 

                         $.ajax({
                             method   : 'GET',
                             dataType : 'JSON',
                             data     : {status:status,product_id:product_id},
                             url      : module_url_path+'/approvedisapprove',
                             beforeSend : function()
                             { 
                                showProcessingOverlay();        
                             },
                             success  : function(response)
                             {                         
                               hideProcessingOverlay(); 

                              if(typeof response == 'object' && response.status == 'SUCCESS')
                              {
                                swal('Done', response.message, 'success');
                                    setTimeout(function(){
                                      window.location.reload();
                                     },5000); 
                              }
                              else
                              {
                                swal('Oops...', response.message, 'error');
                              }               
                             }
                          });
                       
                 }//else

               }
             });


      });    


  $(document).on("click",".rejectprodbtn",function() {
      
    var product_id = $("#hidden_product_id").val();
    
    var reason = $("#reason").val();
    if(reason=="")
    {
      $("#reason_err").html('Please enter the reason for rejection');
      $("#reason_err").css('color','red');
    }else{
       $("#reason_err").html('');
        if(product_id && reason)
        { 
      
 
            $.ajax({
                url: module_url_path+'/rejectproduct',
                type:"GET",
                data: {product_id:product_id,reason:reason},             
                dataType:'json',
                beforeSend: function(){    
                 showProcessingOverlay();           
                },
                success:function(response)
                {
                  hideProcessingOverlay(); 
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
                         $("#reject_product_sectionmodal").hide();
                          setTimeout(function(){
                             window.location.reload();
                          },1000); 
                      }

                    });
                  }
                  else
                  {                
                    swal('Error',response.description,'error');
                  }  
                }  
             }); // end of ajax
      
        } //if user id and note
      } //else    
  });






</script>

<!-- END Main Content -->
@stop