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
			<th rowspan="2">County</th>
			<th rowspan="2">Facilities</th>
			<th rowspan="2">All Tests</th>
			<th rowspan="2">Actual Infants Tested</th>
			<th colspan="2">Initial PCR</th>
			<th colspan="2">2nd/3rd PCR</th>
			<th colspan="2">Confirmatory PCR</th>
			<th colspan="2">Infants &lt;2Weeks</th>
			<th colspan="2">Infants &lt;=2M</th>
			<th colspan="2">Infants &gt;=2M</th>
			<th rowspan="2">Median Age</th>
			<th rowspan="2">Rejected</th>
		</tr>
		<tr>
			<th>Tests</th>
			<th>Pos</th>
			<th>Tests</th>
			<th>Pos</th>
			<th>Tests</th>
			<th>Pos</th>
			<th>Tests</th>
			<th>Pos</th>
			<th>Tests</th>
			<th>Pos</th>
			<th>Tests</th>
			<th>Pos</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<div class="row" id="excels">
	<div class="col-md-6">
		<center id="unsupported"></center>
	</div>
	<div class="col-md-6">
		<center id="download_link"></center>
	</div>
</div>
<!-- <div id='download_link'></div> -->
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#unsupported').html("<?php echo $link2; ?>");
  	$('#download_link > a').css("color","white");
  	$('#unsupported > a').css("color","white");

    $("table").tablecloth({
      theme: "paper",
      striped: true,
      sortable: true,
      condensed: true
    });

    $('#example').DataTable({
      dom: '<"btn btn-primary"B>lTfgtip',
      responsive: true,
        buttons : [
            {
              text:  'Export to CSV',
              extend: 'csvHtml5',
              title: 'Download'
            },
            {
              text:  'Export to Excel',
              extend: 'excelHtml5',
              title: 'Download'
            }
          ]
  	});

    //$('#download_link').empty().append("<?php echo $link;?>");
    
  });
</script>