<div id="positivity"></div>

<script type="text/javascript">
$(function () {
    $('#positivity').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Positivity'
        },
        xAxis: [{
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'Positive Tests',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Positivity (%)',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value} (%)',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 100,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Positive Tests',
            type: 'column',
            yAxis: 1,
            data: <?php echo json_encode($trends[0]);?>,
            tooltip: {
                valueSuffix: ' '
            }

        }, {
            name: 'Positivity (%)',
            type: 'spline',
            data: <?php echo json_encode($trends[1]);?>,
            tooltip: {
                valueSuffix: '%'
            }
        }]
    });
});

</script>