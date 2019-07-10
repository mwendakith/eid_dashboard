

<div class="modal fade" tabindex="-1" role="dialog" id="poc_site_details">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> POC Site Details </h4>
      </div>
      <div class="modal-body">
        <table id="poc_site_table_details" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
        	<thead>
        		<tr>
        			<th>#</th>
              <th>Name</th>
              <th>MFL Code</th>
<<<<<<< HEAD
=======
              <th>County</th>
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
              <th>Received Samples at Hub</th>
              <th>Rejected Samples (on receipt at Hub)</th>
              <th> All Tests Done at Hub</th>
              <th>Initial PCR Tests</th>
              <th>Initial PCR Positives</th>
              <th>2nd/3rd PCR Tests</th>
              <th>2nd/3rd PCR Positives</th>
              <th>Confirmatory PCR Tests</th>
              <th>Confirmatory PCR Positives</th>
              <th>Tests with Valid Outcomes</th>
              <th>Tests with Valid Outcomes - Positives</th>
              <!-- <th>Tests</th>
              <th>Positives</th>
              <th>Initial PCR</th>
              <th>Initial PCR Positive</th>
              <th>&lt; 2m</th>
              <th>&lt; 2m Positive</th> -->
              
        		</tr>
        	</thead>
        	<tbody>
        		<?= @$data['table']; ?>
        	</tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$("#poc_site_table_details").DataTable({
      // dom: 'Bfrtip',
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
    
    $("#poc_site_details").modal('show');

		// $("table").tablecloth({
		// 	theme: "paper",
		// 	striped: true,
		// 	sortable: true,
		// 	condensed: true
		// });
	});

</script>