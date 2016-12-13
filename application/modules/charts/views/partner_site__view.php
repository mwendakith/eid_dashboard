<style type="text/css">
	#excels {
		padding-top: 0.5em;
		padding-bottom: 2em;
	}
</style>
<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<tr class="colhead">
			<th rowspan="2">#</th>
			<th rowspan="2">MFL Code</th>
			<th rowspan="2">Name</th>
			<th rowspan="2">County</th>
			<th rowspan="2">Tests</th>
			<th rowspan="2">1st DNA PCR</th>
			<th rowspan="2">Repeat Confirmatory PCR</th>
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
<div class="row" id="excels">
	<div class="col-md-6">
		<center><button id="unsupported" class="btn btn-primary" style="background-color: #009688;color: white;"></button></center>
	</div>
	<div class="col-md-6">
		<center><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;"></button></center>
	</div>
</div>
<!-- <div id='download_link'></div> -->
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#unsupported').html("<?php echo $link2; ?>")
  	$('#download_link').html("<?php echo $link;?>");
  	$('#download_link > a').css("color","white");
  	$('#unsupported > a').css("color","white");
  	$('#example').DataTable();

    $("table").tablecloth({
      theme: "paper",
      striped: true,
      sortable: true,
      condensed: true
    });

    //$('#download_link').empty().append("<?php echo $link;?>");
    
  });
</script>