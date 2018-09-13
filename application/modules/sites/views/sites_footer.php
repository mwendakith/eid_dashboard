<script type="text/javascript">
	$().ready(function(){
		// var site = <?php //echo json_encode($this->session->userdata("site_filter")); ?>;
		

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

	        	$.get("<?php echo base_url();?>template/breadcrum/"+em+"/"+null+"/"+1, function(data){
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
					$("#eidOutcomes").html("<center><div class='loader'></div></center>");
					$("#heiOutcomes").html("<center><div class='loader'></div></center>");
					$("#heiFollowUp").html("<center><div class='loader'></div></center>");
					$("#agebreakdown").html("<center><div class='loader'></div></center>");

					$("#pat_stats").html("<center><div class='loader'></div></center>");
					$("#pat_out").html("<center><div class='loader'></div></center>");
					$("#pat_graph").html("<center><div class='loader'></div></center>");

					$("#tsttrends").load("<?php echo base_url('charts/sites/site_trends');?>/"+data);
					$("#stoutcomes").load("<?php echo base_url('charts/sites/site_positivity');?>/"+data);
					$("#eidOutcomes").load("<?php echo base_url('charts/sites/site_eid');?>/"+data);
					$("#heiOutcomes").load("<?php echo base_url('charts/sites/site_hei_validation');?>/"+data);
					$("#heiFollowUp").load("<?php echo base_url('charts/sites/site_hei');?>/"+data);
					$("#agebreakdown").load("<?= @base_url('charts/sites/agegroup');?>/"+data);

					$("#pat_stats").load("<?php echo base_url('charts/sites/get_patients');?>/"+null+"/"+null+"/"+data);
					$("#pat_out").load("<?php echo base_url('charts/sites/get_patients_outcomes');?>/"+null+"/"+null+"/"+data);
					$("#pat_graph").load("<?php echo base_url('charts/sites/get_patients_graph');?>/"+null+"/"+null+"/"+data);

				}
	        });
		});
	});

	$("button").click(function () {
		var first, second;
		first = $(".date-picker[name=startDate]").val();
		second = $(".date-picker[name=endDate]").val();

		var new_title = set_multiple_date(first, second);

		$(".display_date").html(new_title);

		from  = format_date(first);
		to    = format_date(second);
		var error_check = check_error_date_range(from, to);
	        
	    if (!error_check) {
		    $.get("<?php echo base_url();?>sites/check_site_select", function(data){
	    		site = $.parseJSON(data);
	    		console.log(site);
	    		//Checking if site was previously selected and calling the relevant views
				if (!site) {
					$("#siteOutcomes").html("<center><div class='loader'></div></center>");
					$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					$("#unsupportedSites").html("<center><div class='loader'></div></center>");
					$("#unsupportedSites").load("<?php echo base_url('charts/sites/unsupported_sites');?>");
				} else {
					$("#tsttrends").html("<center><div class='loader'></div></center>");
					$("#stoutcomes").html("<center><div class='loader'></div></center>");
					$("#eidOutcomes").html("<center><div class='loader'></div></center>");
					$("#heiOutcomes").html("<center><div class='loader'></div></center>");
					$("#heiFollowUp").html("<center><div class='loader'></div></center>");
					$("#agebreakdown").html("<center><div class='loader'></div></center>");


					$("#pat_stats").html("<center><div class='loader'></div></center>");
					$("#pat_out").html("<center><div class='loader'></div></center>");
					$("#pat_graph").html("<center><div class='loader'></div></center>");

					$("#tsttrends").load("<?php echo base_url('charts/sites/site_trends');?>/"+site+"/"+from[1]);
					$("#stoutcomes").load("<?php echo base_url('charts/sites/site_positivity');?>/"+site+"/"+from[1]);
					$("#eidOutcomes").load("<?php echo base_url('charts/sites/site_eid');?>/"+site+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					$("#heiOutcomes").load("<?php echo base_url('charts/sites/site_hei_validation');?>/"+site+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					$("#heiFollowUp").load("<?php echo base_url('charts/sites/site_hei');?>/"+site+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					$("#agebreakdown").load("<?= @base_url('charts/sites/agegroup');?>/"+site+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);

					$("#pat_stats").load("<?php echo base_url('charts/sites/get_patients');?>/"+from[1]+"/"+from[0]+"/"+site+"/"+to[1]+"/"+to[0]);
					$("#pat_out").load("<?php echo base_url('charts/sites/get_patients_outcomes');?>/"+from[1]+"/"+from[0]+"/"+site+"/"+to[1]+"/"+to[0]);
					$("#pat_graph").load("<?php echo base_url('charts/sites/get_patients_graph');?>/"+from[1]+"/"+from[0]+"/"+site+"/"+to[1]+"/"+to[0]);

				}
	    	});
	    }
	        
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
    		// console.log(site);
    		//Checking if site was previously selected and calling the relevant views
			if (!site) {
				$("#siteOutcomes").html("<center><div class='loader'></div></center>");
				$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>/"+year+"/"+month+"/"+null);
				$("#unsupportedSites").html("<center><div class='loader'></div></center>");
				$("#unsupportedSites").load("<?php echo base_url('charts/sites/unsupported_sites');?>");
			} else {
				$("#tsttrends").html("<center><div class='loader'></div></center>");
				$("#stoutcomes").html("<center><div class='loader'></div></center>");
				$("#eidOutcomes").html("<center><div class='loader'></div></center>");
				$("#heiOutcomes").html("<center><div class='loader'></div></center>");
				$("#heiFollowUp").html("<center><div class='loader'></div></center>");
				$("#agebreakdown").html("<center><div class='loader'></div></center>");

				$("#pat_stats").html("<center><div class='loader'></div></center>");
				$("#pat_out").html("<center><div class='loader'></div></center>");
				$("#pat_graph").html("<center><div class='loader'></div></center>");

				$("#tsttrends").load("<?php echo base_url('charts/sites/site_trends');?>/"+null+"/"+year);
				$("#stoutcomes").load("<?php echo base_url('charts/sites/site_positivity');?>/"+null+"/"+year);
				$("#eidOutcomes").load("<?php echo base_url('charts/sites/site_eid');?>/"+null+"/"+year+"/"+month);
				$("#heiOutcomes").load("<?php echo base_url('charts/sites/site_hei_validation');?>/"+null+"/"+year+"/"+month);
				$("#heiFollowUp").load("<?php echo base_url('charts/sites/site_hei');?>/"+null+"/"+year+"/"+month);
				$("#agebreakdown").load("<?= @base_url('charts/sites/agegroup');?>/"+null+"/"+year+"/"+month);
				
				$("#pat_stats").load("<?php echo base_url('charts/sites/get_patients');?>/"+year+"/"+month+"/"+site);
				$("#pat_out").load("<?php echo base_url('charts/sites/get_patients_outcomes');?>/"+year+"/"+month+"/"+site);
				$("#pat_graph").load("<?php echo base_url('charts/sites/get_patients_graph');?>/"+year+"/"+month+"/"+site);

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
