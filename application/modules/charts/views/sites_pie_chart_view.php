<div id="<?php echo $div;?>"></div>

<ul id="<?php echo $content;?>"></ul>

<script type="text/javascript">
$(function () {
    $("#<?php echo $div;?>").highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: "<?php echo $title;?>"
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },colors: [
            '#F2784B',
            '#1BA39C'
        ],
        series: [{
            name: 'Tests',
            colorByPoint: true,
            data: <?php echo json_encode($trend);?>
        }]
    });
    $("#<?php echo $content;?>").empty().append("<?php echo $stats;?>");

});
</script>