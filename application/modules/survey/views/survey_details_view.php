<?php $this->load->view('header_clerk'); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Survey 
        </div>
        <div class="panel-body">
        	<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered">
					<thead>
						<tr class="colhead">
							<th>Facility</th>
							<th>County</th>
							<th>POC</th>
							<th>Survey Date</th>
							<th>Add Survey</th>
							<th>Delete</th>
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