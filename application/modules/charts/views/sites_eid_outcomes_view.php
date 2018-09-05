<div class="panel-body">
	<div id="eid_outcomes_pie" style="height: 250px;"></div>
</div>
<div>
		<center>
		    <table>
		    	<?php echo $outcomes['ul'];?>
		    </table>
		</center>
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
				$('#eid_outcomes_pie').highcharts({
			        chart: {
		                plotBackgroundColor: null,
		                plotBorderWidth: null,
		                plotShadow: false,
		                type: 'pie'
		            },
		            title: {
		                text: "<?php echo $outcomes['title'];?>"
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
		            series: [<?php echo json_encode($outcomes['eid_outcomes']); ?>]

		        });
		    });
</script>



