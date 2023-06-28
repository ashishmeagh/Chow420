
@extends('front.layout.master')
@section('main_content')

<div class="listing-page-main">
    <div class="container-fluid">

        <div id="wrapper">
            <div class="row">
                @include('front.product.front_sidebar')
                <div class="col-md-9">
                    <div class="main-selectslist">
                        <div class="title-listingpages">Our Products</div>
                        <div class="listingpages-selects">
                           <div class="laber-selcts"> Sort By</div>
                           <select class="frm-select">
                              <option>Select</option>
                              <option>Quit Claim Deed</option>
                            </select>
                        </div> 
                        <div class="clearfix"></div>
                    </div>
                    <div id="grid">
                        <div class="row">
                        @php
                        	$login_user = Sentinel::check();
                          if(count($fav_product_arr)>0)
                          {
                           foreach($fav_product_arr as $key=>$value)
                           {
                             $fav_arr[] = $value['product_id'];
                           }

                          }
                        @endphp

                        @if(count($product_arr) > 0)
                            @foreach($product_arr as $product)

                            	<div class="col-md-4">
                                	<div class="product">
                                        @if($login_user == true)
                                        @if($login_user->inRole('buyer'))
                                             @if(isset($fav_arr) && in_array($product['id'],$fav_arr))
                                             
                                            	<a href="javascript:void(0)" class="heart-icn active" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" onclick="removeFromFavorite($(this));">
                                                 <i class="fa fa-heart"></i>Remove
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="heart-icn" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="buyer" onclick="addToFavorite($(this));">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            @endif    
                                        @endif
                                        @else
                                          <a href="javascript:void(0)" class="heart-icn" data-id="{{isset($product['id'])?base64_encode($product['id']):0}}" data-type="product" onclick="addToFavorite($(this));">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        @endif
                            			@if(isset($product['is_age_limit']) && $product['is_age_limit'] == 1 && isset($product['age_restriction']))
                            			
	                                		<div class="label-list">{{$product['age_restriction']}}+ Age</div>

	                                	@endif
	                                    <div class="make3D">
	                                        <div class="product-front">
	                                            <div class="img-cntr">
	                                            	@php
	                                            		if(isset($product['product_image']) && $product['product_image'] != '' && file_exists(base_path().'/uploads/product_images/'.$product['product_image']))
		                                            	{
		                                          			$product_img = url('/uploads/product_images/'.$product['product_image']);
		                                    			}
		                                    			else
			                                    		{                  
			                                      			$product_img = url('/assets/images/no-product-img-found.jpg');
			                                    		}
		                                    		@endphp
	                                                <img src="product_img" class="portrait" alt="" />
	                                                
	                                            </div>
	                                            <div class="border-list"></div>
	                                            <div class="content-pro-img">
	                                                <div class="stats">
	                                                    <div class="stats-container">
	                                                        <div class="title-sub-list">Men Fashion</div>
	                                                        <span class="product_name">{{isset($product['product_name']) ? $product['product_name'] : ''}}</span>
	                                                    </div>
	                                                </div>
	                                                
	                                            </div>
	                                            

	                                            @if($login_user == true)
		                                            @if($login_user->inRole('buyer') == false)
			                                            <a href="javascript::void(0)"><div class="add_to_cart" onclick="swal('Warning','Please login as a Buyer','warning')"> 
			                                            	<img src="{{url('/')}}/assets/front/images/cart-icon-list.png" alt="" /> Add to cart
			                                            </div></a>
			                                        @elseif($login_user->inRole('buyer') == true)
			                                        	<a href="javascript::void(0)"><div class="add_to_cart"> 
			                                            	<img src="{{url('/')}}/assets/front/images/cart-icon-list.png" alt="" /> Add to cart
			                                            </div></a>			                                       
		                                            @endif
		                                            @else
			                                        	<a href="javascript::void(0)"><div class="add_to_cart guest_url_btn"> 
		                                            	<img src="{{url('/')}}/assets/front/images/cart-icon-list.png" alt="" /> Add to cart
		                                            </div></a>
	                                            @endif

	                                            <div class="clearfix"></div>
	                                        </div>
	                                    </div>
		                               
                                	</div>
                                  <div class="price-listing"><span>{{isset($product['unit_price']) ? num_format($product['unit_price']).' USD' : ''}} </span> </div>
                            	</div>
		                    @endforeach
		                @endif

                            

                            <div class="col-md-12">
                                <div class="pagination-chow">
                                    <ul> 
                                        <li><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#" class="active">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>

<script type="text/javascript">
    
    function addToFavorite(ref)
{   

    var guest_url = "{{url('/listing')}}";
    var guest_redirect_url = window.location.href;

    var id   = $(ref).attr('data-id');
    var type = $(ref).attr('data-type');
    var csrf_token = "{{ csrf_token()}}";

    var logged_in_user  = "{{Sentinel::check()}}";


    if(logged_in_user == '')
    {
        
         $.ajax({
                url:guest_url+'/set_guest_url',
                method:'GET',
                data:{guest_link:guest_redirect_url},
                dataType:'json',
           
                
                success:function(response)
                {
                  if(response.status=="success")
                  {
                    $(location).attr('href', guest_url+'/signup')

                  }

                }
            });



    }
    else
    {
       
        $.ajax({
            url: SITE_URL+'/listing/add_to_favorite',
            type:"POST",
            data: {id:id,type:type,_token:csrf_token},             
            dataType:'json',
            beforeSend: function(){            
            },
            success:function(response)
            {
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
                        //window.location.reload();
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
  } 

}


function removeFromFavorite(ref)
{
    var id         = $(ref).attr('data-id');
    var type       = $(ref).attr('data-type');
    var csrf_token = "{{ csrf_token()}}";

    $.ajax({
              url: SITE_URL+'/listing/remove_from_favorite',
              type:"POST",
              data: {id:id,type:type,_token:csrf_token},             
              dataType:'json',
              beforeSend: function(){            
              },
              success:function(response)
              {
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
                            $(this).removeClass('active');
                        }

                      });
                }
                else
                {                
                  swal('Error',response.description,'error');
                }  
              }  


      }); 

}

</script>

@endsection