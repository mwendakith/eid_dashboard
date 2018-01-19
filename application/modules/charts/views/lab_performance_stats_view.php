<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="/*background:#CCC;">
	<thead>
		<tr class="colhead">
			<th rowspan="2">No</th>
			<th rowspan="2">Lab</th>
			<th rowspan="2">Facilities Sending Samples</th>
			<th rowspan="2">Received Samples at Lab</th>
			<th rowspan="2">Rejected Samples (on receipt at lab)</th>
			<th rowspan="2">All Tests (plus reruns) Done at Lab</th>
			<th rowspan="2">Redraws (after testing)</th>
			<th rowspan="2">EQA QA/IQC Tests</th>
			<th colspan="2">Initial PCR</th>
			<th colspan="2">Repeat PCR</th>
			<th colspan="3">Confirmatory PCR</th>
			<th colspan="2">Tests with Valid Outcomes</th>
			<!-- <th rowspan="2">Valid Test Results</th>
			<th rowspan="2">Repeat +ve Confirmatory Tests</th>
			<th rowspan="2">Total Tests Performed</th>
			<th colspan="6"><center>Test Outcome</center></th> -->
		</tr>
		<tr>
			<!-- <th>Excludes QA and Repeats</th>
			<th>Positives</th>
			<th>%</th>
			<th>Negatives</th>
			<th>%</th>
			<th>Redraws</th>
			<th>%</th> -->
			<th>Tests</th>
			<th>Positives</th>
			<th>Tests</th>
			<th>Positives</th>
			<th>Tests</th>
			<th>Positives</th>
			<th>Confirmatory Without Previous Positive</th>
			<th>Tests</th>
			<th>Positives</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $stats;?>
	</tbody>
</table>
<div class="row" style="display: none;">
	<div class="col-md-12">
		<center><a href="<?php  echo $link; ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {

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

    // $("table").tablecloth({
    //   theme: "paper",
    //   striped: true,
    //   sortable: true,
    //   condensed: true
    // });


  });
</script>