<div id="validation_pie">

</div>
<div>
    <table>
        <?= @$outcomes['ul']; ?>
    </table>
</div>
<script type="text/javascript">
	$().ready(function(){
        $("table").tablecloth({
          striped: true,
          sortable: false,
          condensed: true
        });
    });
    $(function(){
	    $('#validation_pie').highcharts({
	        chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
            },
            title: {
                text: "<?= @(isset($outcomes['title']) ? $outcomes['title'] : '');?>"
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [<?php echo json_encode($outcomes['hei']); ?>]
        });
    });

</script>