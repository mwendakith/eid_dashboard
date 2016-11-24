<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<tr class="colhead">
			<th rowspan="2">#</th>
			<th rowspan="2">County</th>
			<th rowspan="2">Tests</th>
			<th rowspan="2">1st DNA PCR</th>
			<th rowspan="2">Confirmed PCR</th>
			<th rowspan="2">+</th>
			<th rowspan="2">-</th>
			<th rowspan="2">Redraws</th>
			<th colspan="2">Adults</th>
			<th rowspan="2">Median Age</th>
			<th rowspan="2">Rejected</th>
			<th rowspan="2">Infants &lt;2M</th>
			<th rowspan="2">Infants &lt;2M +</th>
		</tr>
		<tr>
			<th>Tests</th>
			<th>+</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
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