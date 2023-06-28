@extends('admin.layout.master')  

@section('main_content')


<!--Datepicker js-->
    {{-- <script src="{{url('/')}}/assets/admin/js/custom.js"></script> --}}

<style type="text/css">
    .r-icon-stats i {
    width: 66px;
    height: 66px;
    padding: 20px;
    text-align: center;
    color: #fff;
    font-size: 24px;
    display: inline-block;
    border-radius: 100%;
    vertical-align: top;
    background: #edf1f5;
}

.r-icon-stats .bodystate {
    padding-left: 20px;
    display: inline-block;
    vertical-align: middle;
}
</style>
<!-- Page Content -->
  <div class="div-heightsmallheight">
        <div id="page-wrapper" class="pgwrapper">
          
            <div class="container-fluid">

                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
  
                <div class="row">
                    <!-- <div class="col-md-4 col-sm-6">
                        <div class="white-box dashbrd">
                            <div class="r-icon-stats">
                                <i class="ti-wallet bg-info"></i>
                                <div class="bodystate">
                                    <h1 class="counter text-right m-t-15 text-megna">{{$counts_arr['total_trades'] or 0}}</h1>
                                    <span class="text-muted">
                                    All Trades</span>
                                </div>
                            </div>
                        </div>
                    </div> -->

                     <div class="col-md-4 col-sm-6">
                        <a href="{{ url(config('app.project.admin_panel_slug').'/buyers')}}">
                            <div class="white-box dashbrd">
                                <div class="r-icon-stats">
                                    <i class="ti-user bg-info"></i>
                                    <div class="bodystate">
                                        <h1 class="counter m-t-15 text-megna">{{$counts_arr['total_buyer'] or 0}}</h1>
                                        <span class="text-muted"><b>Total Buyer</b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <a href="{{ url(config('app.project.admin_panel_slug').'/sellers')}}">
                            <div class="white-box dashbrd">
                                <div class="r-icon-stats">
                                    <i class="ti-user bg-info"></i>
                                    <div class="bodystate">
                                        <h1 class="counter m-t-15 text-megna">{{$counts_arr['total_seller'] or 0}}</h1>
                                        <span class="text-muted"><b>Total Dispensary</b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                    <div class="col-md-4 col-sm-6">
                        <a href="{{ url(config('app.project.admin_panel_slug').'/first_level_categories')}}">
                            <div class="white-box dashbrd table-responsive">
                                <div class="r-icon-stats">
                                    <i class="ti-list bg-info"></i>
                                    <div class="bodystate">
                                        <h1 class="counter text-center m-t-15 text-megna">{{$counts_arr['all_categories'] or 0}}</h1>
                                        <span class="text-muted"><b>Categories</b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>    
                    <div class="clearfix"></div>      

                     <div class="col-md-4 col-sm-6">
                       {{--  <a href="{{ url(config('app.project.admin_panel_slug').'/first_level_categories')}}"> --}}
                            <div class="white-box dashbrd table-responsive">
                                <div class="r-icon-stats">
                                     <i class="ti-cloud-down"></i>
                                    <div class="bodystate">
                                        <h1 class="text-center m-t-15 text-megna">
                                         $ {{$total_soldprice or 0}}</h1>
                                        <span class="text-muted"><b>Total cost of goods sold</b></span>
                                    </div>
                                </div>
                            </div>
                        {{-- </a> --}}
                    </div>    
                    <div class="clearfix"></div>       

                      <div class="col-md-4 col-sm-6">
                        {{-- <a href="{{ url(config('app.project.admin_panel_slug').'/first_level_categories')}}"> --}}
                            <div class="white-box dashbrd table-responsive">
                                <div class="r-icon-stats">
                                    <i class="ti-check-box"></i>
                                    <div class="bodystate">
                                        <h1 class="text-center m-t-15 text-megna">$ {{$total_productsum or 0}}</h1>
                                        <span class="text-muted"><b>Total cost of goods available</b></span>
                                    </div>
                                </div>
                            </div>
                       {{--  </a> --}}
                    </div>    
                    <div class="clearfix"></div>       



                </div>    
                       
               {{--  <div class="white-box dashbrd">
                 <button id="change-chart" class="btn btn-default">Change to Classic</button>
                 <div id="chart_div"></div>         
                </div> --}}
            </div>
            <!-- /.container-fluid -->
            <div class="clearfix"></div>            
        </div>
        <!-- /#page-wrapper -->
    </div>    
 </div> 
{{-- <input type="hidden" id="graph_data" value="{{$graph_data or ''}}" > --}}
@stop     
@section('extra_js')       
{{-- <script src="{{url('/')}}/assets/js/chart/loader.js"></script> --}}
{{-- <script type="text/javascript">
  graphData = $('#graph_data').val();

  graphData = $('#graph_data').val();

  tradeData = $.parseJSON(graphData);

   google.charts.load('current', {'packages':['line', 'corechart']});

   google.charts.setOnLoadCallback(drawChart);
   
   function drawChart() {
       var button   = document.getElementById('change-chart');
       var chartDiv = document.getElementById('chart_div');
       var data     = new google.visualization.DataTable();
       
       data.addColumn('string', 'Month');
       data.addColumn('number', "Buy");
       data.addColumn('number', "Sell");

       // var data_string = '';
      var data_string = new Array();
       $.each(tradeData, function(index, value) {
           var tmpArr = new Array();

           tmpArr.push(value.date); 
           tmpArr.push(parseFloat(value.average_buy)); 
           tmpArr.push(parseFloat(value.average_sell)); 

           data_string.push(tmpArr);

        });
 

         data.addRows(data_string);
       // data.addRows([
                      // ["Jan 2019",0,0],["Feb 2019",0,0],["Mar 2019",2.67,80.27],
                    // ]);

       var materialOptions = {
                                 chart: { title: 'Total Sell and Buy Throughout the Year'},
                               
                                width: 1000,
                                 height: 270,
                                 series: {
                                   // Gives each series an axis name that matches the Y-axis below.
                                   1: {axis: 'Trade'},
                                   // 1: {axis: 'month'}
                                 },
                                 axes: {
                                    // Adds labels to each axis; they don't have to match the axis names.
                                     y: {
                                       // Quantity: {label: 'Quantity'},
                                       Trade: {label: 'Trade'}
                                     }
                                 }
                              };

       var classicOptions = 
            {
                 title: 'Total Sell and Buy Throughout the Year',
                 width: 1000,
                 height: 270,
                 // Gives each series an axis that matches the vAxes number below.
                 series: {
                   0: {targetAxisIndex: 0},
                   1: {targetAxisIndex: 1}
                 },
                 vAxes: {
                 // Adds titles to each axis.
                   0: {title: 'Trade'},
                   1: {title: 'Trade'}
                 },

                 hAxis: {
                   ticks: [
                    data_string
                   ]
                 },

                 vAxis: {
                   viewWindow: {
                   max: 30
                   }
                 }
            };

   function drawMaterialChart() {
     var materialChart = new google.charts.Line(chartDiv);
     materialChart.draw(data, materialOptions);
     button.innerText = 'Change to Classic';
     button.onclick = drawClassicChart;
   }

   function drawClassicChart() {
     var classicChart = new google.visualization.LineChart(chartDiv);
     classicChart.draw(data, classicOptions);
     button.innerText = 'Change to Material';
     button.onclick = drawMaterialChart;
   }

   drawMaterialChart();
   }
</script>
 --}} 
<script type="text/javascript">
        $.toast({
            heading: 'Welcome to '+ '{{config('app.project.name')}}'+ ' Admin',
            text: 'Manage your website from here.',
            position: 'top-right',
            loaderBg: '#8d62d5',
            icon: 'info',
            hideAfter: 3500,
            stack: 6
        })
    </script>

@endsection