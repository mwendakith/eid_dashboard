<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="/*background:#CCC;">
	<thead>
		<tr class="colhead">
			<th>No</th>
			<th>Lab</th>
			<th>Facilities Sending Samples</th>
			<th>Received Samples at Lab</th>
			<th>Rejected Samples (on receipt at lab)</th>
			<th>All Tests (plus reruns) Done at Lab</th>
			<th>Redraws (after testing)</th>
			<th>EQA Tests</th>
			<th>Controls Run</th>
			<th>Initial PCR Tests</th>
			<th>Initial PCR Positives</th>
			<th>Repeat PCR Tests</th>
			<th>Repeat PCR Positives</th>
			<th>Confirmatory PCR Tests</th>
			<th>Confirmatory PCR Positives</th>
			<th>Confirmatory Without Previous Positive</th>
			<th>Tiebreaker PCR Tests</th>
			<th>Tiebreaker PCR Positives</th>
			<th>Tests with Valid Outcomes</th>
			<th>Tests with Valid Outcomes - Positives</th>
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