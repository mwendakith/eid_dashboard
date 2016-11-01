<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<tr class="colhead">
			<th>#</th>
			<th>MFL Code</th>
			<th>Name</th>
			<th>County</th>
			<th>Tests</th>
			<th>EQA Tests</th>
			<th>First DNA PCR</th>
			<th>Confirmed PCR</th>
			<th>Positive Outcomes</th>
			<th>Negative Outcomes</th>
			<th>Redraws</th>
			<th>Infants &lt;2M</th>
			<th>Infants &lt;2M Positive</th>
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