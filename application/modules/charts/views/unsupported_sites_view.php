<table id="example2" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="/*background:#CCC;">
	<thead>
		<tr class="colhead">
			<th >No</th>
			<th >MFL code</th>
			<th >DHIS code</th>
			<th >Name</th>
			<th >County</th>
			<th >Subcounty</th>
		</tr>
		
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<div class="row">
	<div class="col-md-12">
		<center><a href="<?php  echo base_url('charts/sites/download_unsupported_sites'); ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('table').DataTable();

    // $("table").tablecloth({
    //   theme: "paper",
    //   striped: true,
    //   sortable: true,
    //   condensed: true
    // });
  });
</script>