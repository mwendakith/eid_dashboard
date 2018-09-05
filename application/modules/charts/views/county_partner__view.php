<style type="text/css">
	#excels {
		padding-top: 0.5em;
		padding-bottom: 2em;
	}
</style>
<table id="<?= (isset($sub_county)) ? @'c_facilities' : @'c_partner';?>" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<tr class="colhead">
			<th rowspan="2">#</th>
			<?php 
				if(isset($sub_county)){
			?>
			<th rowspan="2">Facility Name</th>
			<th rowspan="2">Sub-County</th>
			<th rowspan="2">MFL Code</th>
			<?php 
				} else {
			?>
			<th rowspan="2">Partner</th>
			<?php
				}
			?>
			<th rowspan="2">All Tests</th>
			<th rowspan="2">Actual Infants Tested</th>
			<th rowspan="2">Initial PCR</th>
			<th rowspan="2">Initial PCR Pos</th>
			<th rowspan="2">2nd/3rd PCR</th>
			<th rowspan="2">2nd/3rd PCR Pos</th>
			<th rowspan="2">Confirmatory PCR</th>
			<th rowspan="2">Confirmatory PCR Pos</th>
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
		</tr>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<div class="row" id="exc" style="display: none;">
	
	<div class="col-md-12">
		<center><a href="<?php  echo $link; ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {

  	$('#<?= (isset($sub_county)) ? @'c_facilities' : @'c_partner';?>').DataTable({
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