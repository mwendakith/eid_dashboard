<div class="panel-body">
	<div id="eidAgePositivity_pie" style="height: 450px;"></div>
</div>

<script type="text/javascript">
	$().ready(function(){
		$("table").tablecloth({
	      striped: true,
	      sortable: false,
	      condensed: true
	    });
	});

	$(function () {
				$('#eidAgePositivity_pie').highcharts({
			        chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
		            },
		            title: {
		                text: ''
		            },
		            tooltip: {
		                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		            },
		            plotOptions: {
		                pie: {
		                    allowPointSelect: true,
		                    cursor: 'pointer',
		                    dataLabels: {
			                    enabled: true,
			                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
			                    style: {
			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			                    }
			                },
		                    showInLegend: true
		                }
		            },
		            series: [<?php echo json_encode($agesPositivity['eidAgesPositivity']); ?>]

		        });
		    });
</script>