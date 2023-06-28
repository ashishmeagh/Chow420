@extends('seller.layout.master')
@section('main_content')

<div class="my-profile-pgnm">Sales Report</div>
<div class="new-wrapper">
  <div class="sales-report-search-by">
       <div class="report-by-main">
         <div class="searchby-txt">Search By</div>
      </div>
    <div class="report-by-main">
      <div class="check-nones">
        <div class="check-box">
           <input type="checkbox" checked="checked" class="css-checkbox" id="checkboxnew" name="radiog_dark">
           <label class="css-label radGroup2" for="checkboxnew">Report By</label>
             <div class="main-box-checkbox">
                <div class="row">
                  <div class="col-md-6">
                       <div class="form-group">
                          <label for="">From Date</label>
                          <input type="text" name="text" class="input-text datepicker" placeholder="Select From Date">
                      </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                          <label for="">To Date</label>
                          <input type="text" name="text" class="input-text datepicker" placeholder="Select To Date">
                      </div>
                   </div>
                </div>
                <a href="#" class="search-rpts-slr">
                  <img src="images/search-bar-mn.png" alt="" />
                </a>
             </div>
         </div>
       </div>
    </div>
 
    <div class="report-by-main">
      <div class="check-nones">
        <div class="check-box">
           <input type="checkbox" class="css-checkbox" id="checkboxnew1" name="radiog_dark">
           <label class="css-label radGroup2" for="checkboxnew1">Weekly</label>
         </div>
       </div>
    </div>

    <div class="report-by-main">
      <div class="check-nones">
        <div class="check-box">
           <input type="checkbox" class="css-checkbox" id="checkboxnew2" name="radiog_dark">
           <label class="css-label radGroup2" for="checkboxnew2">Monthly</label>
         </div>
       </div>
    </div>

    <div class="report-by-main">
      <div class="check-nones">
        <div class="check-box">
           <input type="checkbox" class="css-checkbox" id="checkboxnew3" name="radiog_dark">
           <label class="css-label radGroup2" for="checkboxnew3">Yearly</label>
         </div>
       </div>
    </div>
    <div class="report-by-main">
      <a href="#" class="exl-button-slr">
        <img src="images/pdf-report-seller-btn.png" alt="" />
        Export as pdf
      </a>
      <a href="#" class="exl-button-slr">
        <img src="images/excel-report-seller-btn.png" alt="" />
        Export as Excel
      </a>
    </div>


    <div class="clearfix"></div>
  </div>
<div class="order-main-dvs table-order">
   <div class="table-responsive">
                    <div class="rtable">
                    <div class="rtablerow none-boxshdow">
                    <div class="rtablehead"><strong>Order ID</strong></div>
                    <div class="rtablehead"><strong>Product Qty</strong></div>
                    <div class="rtablehead"><strong>Shipping Address</strong></div>
                    <div class="rtablehead"><strong>Price</strong></div>
                    <div class="rtablehead"><strong>Status</strong></div>
                    </div>
                    <div class="rtablerow">
                        <div class="rtablecell">O123654790</div>
                        <div class="rtablecell">5</div>
                        <div class="rtablecell">Maxell Heights, 102 Street, USA</div>
                        <div class="rtablecell">$ 10.50</div>
                        <div class="rtablecell">
                          <div class="status-completed">Completed</div>
                        </div>
                    </div>
                    <div class="rtablerow">
                        <div class="rtablecell">O123654790</div>
                        <div class="rtablecell">2</div>
                        <div class="rtablecell">Johnson Heights,110 Street, New York</div>
                        <div class="rtablecell">$ 20.10</div>
                        <div class="rtablecell">
                          <div class="status-shipped">Shipped</div>
                        </div>
                    </div>
                    <div class="rtablerow">
                        <div class="rtablecell">O3543554790</div>
                        <div class="rtablecell">7</div>
                        <div class="rtablecell">Wilson Era Heights, 107 Street,  India</div>
                        <div class="rtablecell">$ 10.10</div>
                        <div class="rtablecell">
                          <div class="status-dispatched">Dispatched</div>
                        </div>
                    </div>
                    <div class="rtablerow">
                        <div class="rtablecell">O123654790</div>
                        <div class="rtablecell">1</div>
                        <div class="rtablecell">Maxell Heights, 102 Street, USA</div>
                        <div class="rtablecell">$ 10.50</div>
                        <div class="rtablecell">
                          <div class="status-completed">Completed</div>
                        </div>
                    </div>
                    <div class="rtablerow">
                        <div class="rtablecell">O123654790</div>
                        <div class="rtablecell">3</div>
                        <div class="rtablecell">Johnson Heights,110 Street,  New York</div>
                        <div class="rtablecell">$ 20.10</div>
                        <div class="rtablecell">
                          <div class="status-shipped">Shipped</div>
                        </div>
                    </div>
                    <div class="rtablerow">
                        <div class="rtablecell">O3543554790</div>
                        <div class="rtablecell">1</div>
                        <div class="rtablecell">Wilson Era Heights, 107 Street,  India</div>
                        <div class="rtablecell">$ 10.10</div>
                        <div class="rtablecell">
                          <div class="status-dispatched">Dispatched</div>
                        </div>
                    </div>
                    
                    </div>
                </div>

                <div class="pagination-chow pagination-center">
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
@endsection