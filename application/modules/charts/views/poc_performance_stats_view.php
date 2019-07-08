<div class="table-responsive">
  <table id="poc_table" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="/*background:#CCC;">
  	<thead>
  		<tr class="colhead">
  			<th>No</th>
  			<th>Facility</th>
  			<th>MFL</th>
<<<<<<< HEAD
=======
        <th>County</th>
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
  			<th>Facilities Sending Samples</th>
  			<th>Received Samples at Hub</th>
  			<th>Rejected Samples (on receipt at Hub)</th>
  			<th>Tests with Valid Outcomes  + Redraws (after testing)</th>
  			<th>Initial PCR Tests</th>
  			<th>Initial PCR Positives</th>
  			<th>2nd/3rd PCR Tests</th>
  			<th>2nd/3rd PCR Positives</th>
  			<th>Confirmatory PCR Tests</th>
  			<th>Confirmatory PCR Positives</th>
  			<th>Tests with Valid Outcomes</th>
        <th>Tests with Valid Outcomes - Positives</th>
  			<th>View Spokes</th>
  		</tr>
  	</thead>
  	<tbody>
  		<?php echo $stats;?>
  	</tbody>
  </table>
</div>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {

  	$('#poc_table').DataTable({
      dom: '<"btn btn-primary"B>lTfgtip',
      responsive: false,
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