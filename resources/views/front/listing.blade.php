@extends('front.layout.master')
@section('main_content')

<div class="listing-page-main">
    <div class="container-fluid">

        <div id="wrapper">
            <div class="row">
                <div class="col-md-3">
                    <div class="cart-icon-top"></div>
                    <div class="cart-icon-bottom"></div>
                    <div id="sidebar">
                        <h3>CART</h3>
                        <div id="cart">
                            <span class="empty">No items in cart.</span>
                        </div>
                        <div class="title-list-cart">SHOP BY CATEGORY</div>
                        <ul class="list-cart-abt">
                            <li><a href="#">Food ( 970)</a></li>
                            <li><a href="#">Other (267)</a></li>
                            <li><a href="#" class="active">Vitamins & Supplements (129)</a></li>
                            <li><a href="#">New (62)</a></li>
                            <li><a href="#">Meat & Seafood (29)</a></li>
                            <li><a href="#">Bath & Body (15)</a></li>
                            <li><a href="#">Babies & Kids (11)</a></li>
                            <li><a href="#">Beauty (7)</a></li>
                            <li><a href="#">Pet (1)</a></li>
                        </ul>
                        <div class="border-list-side"></div>
                        <div class="title-list-cart">REFINE BY</div>
                        <div class="subt-title-chebx">Health & Ingredients</div>
                         <div class="check-box">
                             <input type="checkbox" checked="checked" class="css-checkbox" id="checkbox1" name="radiog_dark" />
                             <label class="css-label radGroup2" for="checkbox1">Non-GMO</label>
                          </div>
                          <div class="check-box">
                             <input type="checkbox"  class="css-checkbox" id="checkbox2" name="radiog_dark" />
                             <label class="css-label radGroup2" for="checkbox2">Dairy-Free</label>
                          </div>
                          <div class="check-box">
                             <input type="checkbox"  class="css-checkbox" id="checkbox3" name="radiog_dark" />
                             <label class="css-label radGroup2" for="checkbox3">Preservative-Free</label>
                          </div>
                          <div class="border-list-side"></div>
                          <div class="title-list-cart">PRICE</div>
                         <div class="range-t input-bx" for="amount">
                             <div id="slider-price-range" class="slider-rang"></div>
                             <div class="amount-no" id="slider_price_range_txt">
                             </div>
                          </div>
                             <div class="border-list-side"></div>
                          <div class="check-box">
                             <input type="checkbox" checked="checked" class="css-checkbox" id="checkbox4" name="radiog_dark" />
                             <label class="css-label radGroup2" for="checkbox4">Same Day Delivery</label>
                          </div>
                           <div class="border-list-side"></div>

                             <div class="title-list-cart">AVERAGE RATING</div>
                           <div class="radio-btns">

                            <div class="radio-btn">
                            <input type="radio" id="f-option" name="selector">
                            <label for="f-option"><img src="{{url('/')}}/assets/front/images/star-rate-five.png" alt=""></label>
                            <div class="check"></div>
                            </div>
                          
                            <div class="radio-btn">
                            <input type="radio" id="s-option" name="selector">
                            <label for="s-option"><img src="{{url('/')}}/assets/front/images/star-rate-four.png" alt=""></label>
                            <div class="check"><div class="inside"></div></div>
                            </div>

                            <div class="radio-btn">
                            <input type="radio" id="a-option" name="selector">
                            <label for="a-option"><img src="{{url('/')}}/assets/front/images/star-rate-three.png" alt=""></label>
                            <div class="check"><div class="inside"></div></div>
                            </div>

                            <div class="radio-btn">
                            <input type="radio" id="b-option" name="selector">
                            <label for="b-option"><img src="{{url('/')}}/assets/front/images/star-rate-two.png" alt=""></label>
                            <div class="check"><div class="inside"></div></div>
                            </div>

                            <div class="radio-btn">
                            <input type="radio" id="c-option" name="selector">
                            <label for="c-option"><img src="{{url('/')}}/assets/front/images/star-rate-one.png" alt=""></label>
                            <div class="check"><div class="inside"></div></div>
                            </div>

                        </div>
                    </div>
                </div>
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
                            <div class="col-md-4">
                                <div class="product">
                                    
                                    <div class="make3D">
                                        <div class="product-front">
                                            <div class="img-cntr">
                                                <img src="{{url('/')}}/assets/front/images/product-list-img.png" class="portrait" alt="" />
                                            </div>
                                            <div class="border-list"></div>
                                            <div class="content-pro-img">
                                                <div class="stats">
                                                    <div class="stats-container">
                                                        <div class="title-sub-list">Men Fashion</div>
                                                        <span class="product_name">CBD is Tillery</span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="price-listing"><span>$999</span> $899</div>
                                            
                                            <div class="add_to_cart"> <img src="{{url('/')}}/assets/front/images/cart-icon-list.png" alt="" /> Add to cart</div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="product">
                                    <div class="label-list">18+ Age</div>
                                    <div class="make3D">
                                        <div class="product-front">
                                            <div class="img-cntr">
                                                <img src="{{url('/')}}/assets/front/images/product-list-img2.png" class="portrait" alt="" />
                                            </div>
                                            <div class="border-list"></div>
                                            <div class="content-pro-img">
                                                <div class="stats">
                                                    <div class="stats-container">
                                                        <div class="title-sub-list">Women Fashion</div>
                                                        <span class="product_name">CBD Drops</span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="price-listing"><span>$399</span> $299</div>
                                            
                                            <div class="add_to_cart"> <img src="{{url('/')}}/assets/front/images/cart-icon-list.png" alt="" /> Add to cart</div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="product">
                                    <div class="make3D">
                                        <div class="product-front">
                                            <div class="img-cntr">
                                                <img src="images/product-list-img3.png" class="portrait" alt="" />
                                            </div>
                                            <div class="border-list"></div>
                                            <div class="content-pro-img">
                                                <div class="stats">
                                                    <div class="stats-container">
                                                        <div class="title-sub-list">Men Fashion</div>
                                                        <span class="product_name">Dixie Dew Drops Peppermin</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-listing"><span>$699</span> $599</div>
                                            <div class="add_to_cart"> <img src="images/cart-icon-list.png" alt="" /> Add to cart</div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product">
                                    <div class="make3D">
                                        <div class="product-front">
                                            <div class="img-cntr">
                                                <img src="images/product-list-img4.png" class="portrait" alt="" />
                                            </div>
                                            <div class="border-list"></div>
                                            <div class="content-pro-img">
                                                <div class="stats">
                                                    <div class="stats-container">
                                                        <div class="title-sub-list">Men Fashion</div>
                                                        <span class="product_name">CBD-Hemp</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-listing"><span>$699</span> $599</div>
                                            <div class="add_to_cart"> <img src="images/cart-icon-list.png" alt="" /> Add to cart</div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              <div class="col-md-4">
                                <div class="product">
                                    <div class="make3D">
                                        <div class="product-front">
                                            <div class="img-cntr">
                                                <img src="images/product-list-img.png" class="portrait" alt="" />
                                            </div>
                                            <div class="border-list"></div>
                                            <div class="content-pro-img">
                                                <div class="stats">
                                                    <div class="stats-container">
                                                        <div class="title-sub-list">Men Fashion</div>
                                                        <span class="product_name">CBD is Tillery</span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="price-listing"><span>$999</span> $899</div>
                                            
                                            <div class="add_to_cart"> <img src="images/cart-icon-list.png" alt="" /> Add to cart</div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="product">
                                    <div class="make3D">
                                        <div class="product-front">
                                            <div class="img-cntr">
                                                <img src="images/product-list-img2.png" class="portrait" alt="" />
                                            </div>
                                            <div class="border-list"></div>
                                            <div class="content-pro-img">
                                                <div class="stats">
                                                    <div class="stats-container">
                                                        <div class="title-sub-list">Women Fashion</div>
                                                        <span class="product_name">CBD Drops</span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="price-listing"><span>$399</span> $299</div>
                                            
                                            <div class="add_to_cart"> <img src="images/cart-icon-list.png" alt="" /> Add to cart</div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="product">
                                    <div class="make3D">
                                        <div class="product-front">
                                            <div class="img-cntr">
                                                <img src="images/product-list-img3.png" class="portrait" alt="" />
                                            </div>
                                            <div class="border-list"></div>
                                            <div class="content-pro-img">
                                                <div class="stats">
                                                    <div class="stats-container">
                                                        <div class="title-sub-list">Men Fashion</div>
                                                        <span class="product_name">Dixie Dew Drops Peppermin</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-listing"><span>$699</span> $599</div>
                                            <div class="add_to_cart"> <img src="images/cart-icon-list.png" alt="" /> Add to cart</div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product">
                                    <div class="make3D">
                                        <div class="product-front">
                                            <div class="img-cntr">
                                                <img src="images/product-list-img4.png" class="portrait" alt="" />
                                            </div>
                                            <div class="border-list"></div>
                                            <div class="content-pro-img">
                                                <div class="stats">
                                                    <div class="stats-container">
                                                        <div class="title-sub-list">Men Fashion</div>
                                                        <span class="product_name">CBD-Hemp</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-listing"><span>$699</span> $599</div>
                                            <div class="add_to_cart"> <img src="images/cart-icon-list.png" alt="" /> Add to cart</div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

@endsection