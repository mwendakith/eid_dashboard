<style type="text/css">
	/*.display_date {
		width: 130px;
		display: inline;
	}
	.display_range {
		width: 130px;
		display: inline;
	}*/
	.title-name {
		color: blue;
	}
	#title {
		padding-top: 1.5em;
	}
	
</style>

<div class="row">
	<!-- Map of the country -->
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Summary <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="summary">
		  	<center><div class="loader"></div></center>
		  </div>
		  
		</div>
	</div>

	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
			  Positivity by Age Group <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="positivity" style="/*height:500px;">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>

</div>

<div class="row">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading" id="heading">
		  	Outcomes by Age Group <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="age_outcomes">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>

<?= $this->load->view('age/age_view_footer'); ?>