<?php $this->load->view('header_admin'); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Survey Details 
        </div>
        <div class="panel-body">
        	<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered">
					<thead>
						<tr class="colhead">
							<th>Facility</th>
							<th>County</th>
							<th>POC</th>
							<th>Survey Date</th>
							<th>Clerk Name</th>
							<th>Date of Birth</th>
							<th>Gender</th>
							<th>Entry Point</th>
							<th>Date of Visit</th>
							<th>Date of Collection</th>
							<th>Date of Testing</th>
							<th>Date of Result Return</th>
							<th>Result</th>
							<th>Art Initiation</th>
							<th>Date of ART Initiation</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $surveys;?>
					</tbody>
				</table>
            </div>
        </div>
        
      </div>
    </div>	
</div>

<script type="text/javascript">
	$().ready(function(){
	    $('.dt-picker').datepicker( {
	        dateFormat: 'yy-mm-dd'
	    });

	    $(".survey-select").select2();

	    $('#example').DataTable({
	      responsive: true
	  	});
    
	});
</script>