<table id="example2" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="/*background:#CCC;">
	<thead>
		<tr class="colhead">
			<th >No</th>
			<th >MFL code</th>
			<th >Name</th>
			<th >County</th>
			<th >Subcounty</th>
		</tr>
		
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#example2').DataTable();

    $("table").tablecloth({
      theme: "paper",
      striped: true,
      sortable: true,
      condensed: true
    });
  });
</script>