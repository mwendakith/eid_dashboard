<div id="positivity"></div>

<script type="text/javascript">
$(function () {
    $('#positivity').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: "<?php echo $title; ?>",
        },
        xAxis: [{
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            title: {
                text: 'Positive Tests',
                style: {
                    color: '#1BA39C'
                }
            },
            labels: {
                format: '{value}',
                style: {
                    color: '#1BA39C'
                }
            }
        },
        { // Secondary yAxis
            labels: {
                format: '{value} (%)',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'Positivity (%)',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            opposite: true
        }, ],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Positives ',
            type: 'column',
            data: <?php echo json_encode($trends[0]);?>,
            tooltip: {
                valueSuffix: ' '
            },
            color : '#1BA39C',

        },
        {
            name: 'Positivity (%) ',
            type: 'spline',
            yAxis: 1,
            data: <?php echo json_encode($trends[1]);?>,
            tooltip: {
                valueSuffix: '%'
            },
            color : Highcharts.getOptions().colors[1],
        },
        ]
    });
});

</script>