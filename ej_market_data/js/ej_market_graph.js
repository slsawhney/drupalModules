/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal, drupalSettings) {

    'use strict';

    Drupal.behaviors.ej_market_graph = {
        attach: function (context, settings) {
            $(document).ready(function () {
                $("#ptabs").tabs();
            });
            
            var dijaData = JSON.parse(drupalSettings.dijaData);
            var spx = JSON.parse(drupalSettings.spx);
            var compq = JSON.parse(drupalSettings.compq);
            
            /*var data = [
                [1167609600000,0.7537],
                [1200960000000,0.69],
                [1250035200000,0.7058],
                [1300060800000,0.717],
                [1338508800000,0.8117],
                [1379030400000,0.7537],
                [1401926400000,0.7332],
                [1424131200000,0.8761],
                [1514505600000,0.8339]  
            ];
            alert(data);
            alert(spx);*/

            generateGraph('containerDjia', dijaData);
            generateGraph('containerSandP', spx);
            generateGraph('containerNasdaq', compq);

            /*if($( "#ptabs" ).tabs({ selected: 2 })){
             alert('call service');
             }*/

            $('#ptabs li a[href="#nyse-most-active"]').click(function (event) {
                $('#ajaxLink').click();
            });
        }
    };
    
    
    // Chart Common settings
    var zoomType = 'none';
    var height = 170;
    var backgroundColor = "#eeeeee";
    var plotBackgroundColor = "#eeeeee";
    var threshold = null;
    var enableMouseTracking = false;
    var lineWidth = 2;
    var color = '#cae5f6';
    var lineColor = '#999999';
    var fillOpacity = 0.6;
    var period = 1;

    var formatSettings = {
        0: '%m %e', // 1 month
        1: '%b %e', // 3 month
        2: '%b %e', // 6 month
        3: '%m/%y', // 1 year
        4: '%m/%y', // 3 year
        5: '%b %y', // 5 year
        6: '%b %y'  // 10 year
    };
    
    function generateGraph(containerId, data){
        Highcharts.chart(containerId, {
            chart: {
                zoomType: zoomType,
                height: height,
                backgroundColor: backgroundColor,
                plotBackgroundColor: plotBackgroundColor
            },
            //exporting: { enabled: false },
            title: {
                text: ''
            },
            /*subtitle: {
                text: document.ontouchstart === undefined ?
                        '' : ''
            },*/
            xAxis: {
                type: 'datetime',
                gridLineWidth: 1,
                tickPixelInterval: 30,
                labels: {
                    step: 2,
                    formatter: function () {
                        var res = Highcharts.dateFormat(formatSettings[period], this.value);
                        return Highcharts.dateFormat(formatSettings[period], this.value);
                    },
                    style: {
                        fontSize: 8
                    }
                }
            },
            yAxis: {
                tickPixelInterval: 35,
                title: "",
                labels: {
                    formatter: function () {
                        var numDecimals = 0;
                        return Highcharts.numberFormat(this.value, numDecimals, '.', ',');
                    },
                    style: {
                        fontSize: 8
                    }
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    /*fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },*/
                    marker: {
                         enabled: false
                        //radius: 2
                    },
                    /*lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth:1
                        }
                    },*/
                    threshold: threshold,
                    enableMouseTracking: enableMouseTracking,
                    lineWidth: lineWidth,
                    color: color,
                    lineColor: lineColor,
                    fillOpacity: fillOpacity
                }
            },

            series: [{
                type: 'area',
                name: '',
                data: data
            }]
        });
    }
})(jQuery, Drupal, drupalSettings);