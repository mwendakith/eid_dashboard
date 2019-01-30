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
                text: 'Outcomes by Age Groups'
            },
            xAxis: [{
                categories: ["<2 weeks","2-6 weeks","6-8 weeks","6 months","9 months","12 months"]            }],
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
                        "name":"Positive",
                        "color":"#E26A6A",
                        "type":"column",
                        "yAxis":1,
                        "data":[26,165,114,297,189,127],
                        "tooltip":{
                            "valueSuffix":" "
                        }
                    },
                    {
                        "name":"Negative",
                        "color":"#257766",
                        "type":"column",
                        "yAxis":1,
                        "data":[833,7156,2730,7467,3034,3572],
                        "tooltip":{
                            "valueSuffix":" "
                        }
                    },
                    {
                        "name":"Positivity",
                        "color":"#913D88",
                        "type":"spline",
                        "data":[3,2.3,4,3.8,5.9,3.4],
                        "tooltip":{
                            "valueSuffix":" %"
                        }
                    }
                ]
            });
    });
    
</script>