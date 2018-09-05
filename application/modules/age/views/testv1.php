<div id="outcomes">

</div>

<script type="text/javascript">
    $(function () {
        $('#outcomes').highcharts({
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Outcomes'
            },
            xAxis: [{
                categories: ["2008","2009","2010","2011","2012","2013","2014","2015","2016","2017"]            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'%';
                    },
                    style: {
                        color: '#89A54E'
                    }
                },
                title: {
                    text: 'Percentage',
                    style: {
                        color: '#89A54E'
                    }
                },
               opposite: true
    
            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: 'Tests',
                    style: {
                        color: '#4572A7'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +'';
                    },
                    style: {
                        color: '#4572A7'
                    }
                }
                // min: 0, 
                // max: 70000,
                // tickInterval: 1
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                x: -120,
                verticalAlign: 'top',
                y: 40,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: [
                    {
                        "name":"Redraws",
                        "color":"#52B3D9",
                        "type":"column",
                        "yAxis":1,
                        "data":[93,415,54,82,137,395,500,656,1497,126],
                        "tooltip":{
                            "valueSuffix":" "
                        }
                    },
                    {
                        "name":"Positive",
                        "color":"#E26A6A",
                        "type":"column",
                        "yAxis":1,
                        "data":[1852,2252,6199,5918,4505,4353,4120,3453,3674,1166],
                        "tooltip":{
                            "valueSuffix":" "
                        }
                    },
                    {
                        "name":"Negative",
                        "color":"#257766",
                        "type":"column",
                        "yAxis":1,
                        "data":[16449,16978,51572,52702,50003,49740,53797,51210,63803,27653],
                        "tooltip":{
                            "valueSuffix":" "
                        }
                    },
                    {
                        "name":"Positivity",
                        "color":"#913D88",
                        "type":"spline",
                        "data":[10.1,11.5,10.7,10.1,8.2,8,7.1,6.2,5.3,4],
                        "tooltip":{
                            "valueSuffix":" %"
                        }
                    }
                ]
            });
    });
    
</script>