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
<div id="second">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Testing Trends <div class="display_range"></div>
			  </div>
			  <div class="panel-body" id="testing_trends">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>
	<div class="row">
		<!-- Map of the country -->
		<div class="col-md-3 col-sm-3 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	EID Outcomes <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="eidOutcomes">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>

		<!-- Map of the country -->
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				  HEI Follow up <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="hei_follow_up" style="/*height:500px;">
			    <center><div class="loader"></div></center>
			  </div>
			  <!-- <div>
			  	<button class="btn btn-default" onclick="justificationModal();">Click here for breakdown</button>
			  </div> -->
			</div>
		</div>

		<div class="col-md-5">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Age <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="ageGroups">
			    <center><div class="loader"></div></center>
			  </div>
			  <!-- <div>
			  	<button class="btn btn-default" onclick="ageModal();">Click here for breakdown</button>
			  </div> -->
			</div>
		</div>
	</div>

	<div class="row">
	<!-- Map of the country -->
		<div class="col-md-4 col-sm-3 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Entry Point <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="entry_point">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>

		<!-- Map of the country -->
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				  Mother Prophylaxis <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="mprophilaxis" style="/*height:500px;">
			    <center><div class="loader"></div></center>
			  </div>
			  <!-- <div>
			  	<button class="btn btn-default" onclick="justificationModal();">Click here for breakdown</button>
			  </div> -->
			</div>
		</div>
		<!-- Map of the country -->
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				  Infant Prophylaxis <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="iprophilaxis" style="/*height:500px;">
			    <center><div class="loader"></div></center>
			  </div>
			  <!-- <div>
			  	<button class="btn btn-default" onclick="justificationModal();">Click here for breakdown</button>
			  </div> -->
			</div>
		</div>

	</div>
	<div class="row">
		<!-- Map of the country -->
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading" id="heading">
			  	County Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="county_outcomes">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>
</div>

<div class="row" id="first">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Partner Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="partner">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>


<!-- <div class="modal fade" tabindex="-1" role="dialog" id="justificationmodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pregnant and Lactating Mothers</h4>
      </div>
      <div class="modal-body" id="CatJust">
        <center><div class="loader"></div></center>
      </div>
    </div>
  </div>
</div> -->
		
<?php $this->load->view('partner_summary_view_footer'); ?>