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
                               
                                width: 910,
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
                 width: 910,
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