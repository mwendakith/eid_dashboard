<style type="text/css">
	.display_date {
		width: 130px;
		display: inline;
	}
	.display_range {
		width: 130px;
		display: inline;
	}
</style>
<div class="row" id="first">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Funding Agencies Positivity (Initial PCR) <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="positivity">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>

	<!-- <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Partner Test Analysis <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="partner_test_analysis">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div> -->
</div>
<div class="row" id="second">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading" style="min-height: 5em;">
		  	<div class="col-sm-3">
			    Testing Trends <div id="samples_heading">(Initial PCR)</div>
			    <div class="display_range"></div>
		    </div> 
		    
		    <div class="col-sm-3">
		    	<input type="submit" class="btn btn-primary" id="switchButton" onclick="switch_source()" value="Click to Switch To 2nd/3rd PCR">
		    </div>
		  </div>
		  <div class="panel-body" id="testing_trends">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<div class="col-md-4 col-sm-3 col-xs-12">
		<div class="panel panel-default">
		 	<div class="panel-heading">
		  		EID Outcomes <div class="display_date" ></div>
			</div>
		  	<div class="panel-body" id="eidOutcomes">
		  		<center><div class="loader"></div></center>
		  	</div>
		  
		</div>
	</div>
	<div class="col-md-3 col-sm-3 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Actual Infants Tested Positive Validation at Site Outcomes  <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="hei_outcomes">
		  	<center><div class="loader"></div></center>
		  </div>
		  
		</div>
	</div>
	<div class="col-md-2 col-sm-4 col-xs-12">
		<div class="panel panel-default">
		  	<div class="panel-heading">
			 	Status of Actual Confirmed Positives at Site <div class="display_date"></div>
		  	</div>
		  	<div class="panel-body" id="hei_follow_up" style="/*height:500px;">
		    	<center><div class="loader"></div></center>
		  	</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
		  	<div class="panel-heading">
		    	EID Outcomes by Age  (Initial PCR) <div class="display_date"></div>
		  	</div>
		  	<div class="panel-body" id="ageGroups" style="height:560px;">
		    	<center><div class="loader"></div></center>
		  	</div>
		</div>
	</div>

	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Funding Agency Partner Positivity (Initial PCR) <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="partner_positivity">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>
		
<?php $this->load->view('partner_agencies_view_footer'); ?>