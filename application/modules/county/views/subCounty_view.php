<div id="first">
	<div class="row">
		<!-- Map of the country -->
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading" id="heading">
			  	Sub-County Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="county_outcomes">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>
</div>
<div id="second">
	<div class="row">
		<!-- Map of the country -->
		<div class="col-md-4 col-sm-3 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	EID Outcomes <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="eid_outcomes">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>

		<div class="col-md-3 col-sm-3 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	HEI Validation Outcomes <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="subcounty_hei_outcomes">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>

		<div class="col-md-2 col-sm-4 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				  HEI Follow up <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="subcounty_hei" style="/*height:500px;">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Age <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="subcounty_age" style="height:560px;">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading" id="heading">
			  	Facilities <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="subcounty_facilities">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('subCounty_view_footer'); ?>