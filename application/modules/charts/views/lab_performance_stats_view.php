<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="/*background:#CCC;">
	<thead>
		<tr class="colhead">
			<th rowspan="2">No</th>
			<th rowspan="2">Testing Lab</th>
			<th rowspan="2">Facilities Serviced</th>
			<th rowspan="2">No of Batches</th>
			<th rowspan="2">Samples Tested</th>
			<th rowspan="2">EQA Samples Tested</th>
			<th rowspan="2">Rejected Samples</th>
			<th colspan="6"><center>Test Outcome</center></th>
		</tr>
		<tr>
			<th>Positives</th>
			<th>%</th>
			<th>Negatives</th>
			<th>%</th>
			<th>Redraws</th>
			<th>%</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $stats;?>
	</tbody>
</table>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#example').DataTable();

    $("table").tablecloth({
      theme: "paper",
      striped: true,
      sortable: true,
      condensed: true
    });
  });
</script>