<?php $this->load->view('header_clerk'); ?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
			    <strong>Fill in the Survey Form Below.</strong>
			</div>
			<div class="panel-body" id="contact_us">
				<center><div id="error_div"></div></center>
			    <form class="form-horizontal" role="form" method="post" action="<?php echo base_url('survey/update_survey/' . $survey['id']);?>">

			    	<input type="hidden"  name="survey_id" value="<?= $survey['survey_id'] ?>" >

					<div class="form-group">
						<label for="dob" class="col-sm-2 control-label" style="color: black;">DOB:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control dt-picker" name="dob" placeholder="Date of Birth" required value="<?= $survey['date-of-birth'] ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="gender" class="col-sm-2 control-label" style="color: black;">Gender:</label>
						<div class="col-sm-10">
							<input type="radio" name="gender" value="M"
								<?php
									if($survey['gender'] == "M"){
										echo "checked";
									}
								?>
							>Male
							<input type="radio" name="gender" value="F"
								<?php
									if($survey['gender'] == "F"){
										echo "checked";
									}
								?>
							>Female
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="entry" class="col-sm-2 control-label" style="color: black;">Entry Point:</label>
						<div class="col-sm-10">
							<select class="form-control survey-select" name="entry" placeholder="Entry Point" required>
								<option disabled="true" selected="true"> Please Select an Entry Point </option>
								<option value=3 > MCH/PMTCT </option>
								<option value=5 > Maternity </option>
								<option value=2 > Paediatric Ward </option>
								<option value=1 > OPD </option>
								<option value=4 > CCC/PSC </option>
								<option value=6 > Other </option>
								<option value=7 > No Data </option>
							</select>
						</div>
					</div> -->


					<div class="form-group">
						<label for="entry" class="col-sm-2 control-label" style="color: black;">Entry Point:</label>
						<div class="col-sm-10">
							<select class="form-control survey-select" name="entry" placeholder="Entry Point" required>
								<option disabled="true" selected="true"> Please Select an Entry Point </option>
								<?php 
									foreach ($entrypoints as $entrypoint) {
										echo "<option value='" . $entrypoint['ID'] . "' ";
										if($entrypoint['ID'] == $survey['entrypoint']){
											echo "selected ";
										}
										echo "> " . $entrypoint['name'] . '</option>';
									}
								?>
							</select>
						</div>
					</div>



					<div class="form-group">
						<label for="dov" class="col-sm-2 control-label" style="color: black;">Patient visit for EID:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control dt-picker" name="dov" placeholder="Date of Visit" required value="<?= $survey['date-of-visit'] ?>">
						</div>
					</div>



					<div class="form-group">
						<label for="doc" class="col-sm-2 control-label" style="color: black;">Sample Collected:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control dt-picker" name="doc" placeholder="Date of Collection" required value="<?= $survey['date-collected'] ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="dot" class="col-sm-2 control-label" style="color: black;">Eid test performed:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control dt-picker" name="dot" placeholder="Date of Testing" required value="<?= $survey['date-tested'] ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="dor" class="col-sm-2 control-label" style="color: black;">Result Returned to Patient:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control dt-picker" name="dor" placeholder="Date of Return of Result" required value="<?= $survey['date-dispatch'] ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="result" class="col-sm-2 control-label" style="color: black;">Result:</label>
						<div class="col-sm-10">
							<input type="radio" name="result" value="2" required
								<?php
									if($survey['result'] == "2" || $survey['result'] == 2){
										echo "checked";
									}
								?>
							>Positive
							<input type="radio" name="result" value="1"
								<?php
									if($survey['result'] == "1" || $survey['result'] == 1){
										echo "checked";
									}
								?>
							>Negative
						</div>
					</div>

					<div class="form-group">
						<label for="art" class="col-sm-2 control-label" style="color: black;">Art Initiated:</label>
						<div class="col-sm-10">
							<input type="radio" name="art" value="1" required
								<?php
									if($survey['art-initiated'] == "1" || $survey['art-initiated'] == 1){
										echo "checked";
									}
								?>
							>Yes
							<input type="radio" name="art" value="0"
								<?php
									if($survey['art-initiated'] == "0" || $survey['art-initiated'] == 0){
										echo "checked";
									}
								?>
							>No
						</div>
					</div>

					<div class="form-group">
						<label for="do-art" class="col-sm-2 control-label" style="color: black;">Date Initiated:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control dt-picker" name="do-art" placeholder="Date of ART Initiation" value="<?= $survey['date-art'] ?>">
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