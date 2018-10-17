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