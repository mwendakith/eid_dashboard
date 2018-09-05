<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<?php if(isset($th)) { 
			echo $th; 
		} else {?>
		<tr class="colhead">
			<th rowspan="2">#</th>
			<th rowspan="2">County</th>
			<th rowspan="2"># Sites</th>
			<th rowspan="2">All Tests</th>
			<th rowspan="2">PMTCT Need</th>
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
		<?php } ?>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<!-- <div class="row" id="excels" style="display: none;">
	
	<div class="col-md-12">
		<center><a href="<?php  //echo $link; ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
	</div>
</div> -->
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	
  	// $('#example').DataTable();

  	$('#example').DataTable({
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