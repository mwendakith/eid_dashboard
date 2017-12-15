<?php $this->load->view('header_clerk'); ?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
			    <strong>Fill in the Survey Details Below.</strong>
			</div>
			<div class="panel-body" id="contact_us">
				<center><div id="error_div"></div></center>
			    <form class="form-horizontal" role="form" method="post" action="<?php echo base_url();?>survey/submit">

					<div class="form-group">
						<label for="facility" class="col-sm-2 control-label" style="color: black;">Facility Name:</label>
						<div class="col-sm-10">
							<select class="form-control survey-select" name="facility" required>
								<option disabled="true" selected="true"> Select a Facility:</option>
								<?php echo $sites; ?>
								
							</select>
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="county" class="col-sm-2 control-label" style="color: black;">County:</label>
						<div class="col-sm-10">
							<select class="form-control survey-select" name="county" required>
								<option disabled="true" selected="true"> Select a County:</option>
								<?php // echo $filter; ?>
							</select>
						</div>
					</div> -->

					<div class="form-group">
						<label for="poc" class="col-sm-2 control-label" style="color: black;">POC:</label>
						<div class="col-sm-10">
							<input type="radio" name="poc" value=1 required>POC
							<input type="radio" name="poc" value=0>Non POC
						</div>
					</div>


					<!-- <div class="form-group">
						<label for="name" class="col-sm-2 control-label" style="color: black;">Data Collector's Name:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" placeholder="Name" required>
						</div>
					</div> -->

					<div class="form-group">
						<label for="dos" class="col-sm-2 control-label" style="color: black;">Date:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control dt-picker" name="dos" placeholder="Date of Survey" required>
						</div>
					</div>


					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Submit" class="btn btn-primary" style="color:white; background-color:#1BA39C;">
						</div>
						<div class="col-sm-6" id="loading"></div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
						</div>
					</div>
				</form>
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
    
	});
</script>