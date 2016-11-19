<script type="text/javascript">
	$().ready(function(){
		var site = <?php echo json_encode($this->session->userdata("site_filter")); ?>;
		

		$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
		$("#unsupportedSites").load("<?php echo base_url('charts/sites/unsupported_sites');?>");
		$("#first").show();
		$("#second").hide();



		$("select").change(function() {
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_site_data", { site: em } );

	        // Put the results in a div
	        posting.done(function( data ) {
	        	$.get("<?php echo base_url();?>template/dates", function(data){
	        		obj = $.parseJSON(data);

					if(obj['month'] == "null" || obj['month'] == null){
						obj['month'] = "";
					}
					$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
					$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
	        	});

	        	$.get("<?php echo base_url();?>template/breadcrum", function(data){
	        		$("#breadcrum").html(data);
	        	});

	        	
	        	if (em=="NA") {
	        		$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
					$("#first").show();
					$("#second").hide();
				} else {
					$("#first").hide();
					$("#second").show();

					$("#tsttrends").html("<center><div class='loader'></div></center>");
					$("#stoutcomes").html("<center><div class='loader'></div></center>");
					$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");

					$("#tsttrends").load("<?php echo base_url('charts/sites/site_trends');?>/"+data);
					$("#stoutcomes").load("<?php echo base_url('charts/sites/site_positivity');?>/"+data);
					$("#vlOutcomes").load("<?php echo base_url('charts/sites/site_eid');?>/"+data);
					$("#ageGroups").load("<?php echo base_url('charts/sites/site_hei');?>/"+data);

				}
	        });
		});
	});

	function date_filter(criteria, id)
 	{
 		// alert('hellp');
 		if (criteria === "monthly") {
 			year = null;
 			month = id;
 		}else {
 			year = id;
 			month = null;
 		}

 		var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );
 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");

		});
		
		$.get("<?php echo base_url();?>sites/check_site_select", function(data){
    		site = $.parseJSON(data);
    		console.log(site);
    		//Checking if site was previously selected and calling the relevant views
			if (!site) {
				$("#siteOutcomes").html("<center><div class='loader'></div></center>");
				$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>/"+year+"/"+month+"/"+null);
				$("#unsupportedSites").html("<center><div class='loader'></div></center>");
				$("#unsupportedSites").load("<?php echo base_url('charts/sites/unsupported_sites');?>");
			} else {
				$("#tsttrends").html("<center><div class='loader'></div></center>");
				$("#stoutcomes").html("<center><div class='loader'></div></center>");
				$("#vlOutcomes").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				$("#tsttrends").load("<?php echo base_url('charts/sites/site_trends');?>/"+null+"/"+year);
				$("#stoutcomes").load("<?php echo base_url('charts/sites/site_positivity');?>/"+null+"/"+year);
				$("#vlOutcomes").load("<?php echo base_url('charts/sites/site_eid');?>/"+null+"/"+year+"/"+month);
				$("#ageGroups").load("<?php echo base_url('charts/sites/site_hei');?>/"+null+"/"+year+"/"+month);

			}
    	});

		/*if(!$("#second").is(":hidden")){
			alert('found');
		}*/
		///console.log(county);


 	}

	function ageModal()
	{
		$('#agemodal').modal('show');
		// $('#CatAge').load('<?php echo base_url();?>charts/summaries/agebreakdown');
	}
</script>
