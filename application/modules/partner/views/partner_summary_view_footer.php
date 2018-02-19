<script type="text/javascript">
	$().ready(function(){
		$("#second").hide();
		localStorage.setItem("my_var", 1);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#partner").load("<?php echo base_url('charts/partner_summaries/partner_outcomes'); ?>");
		$("#partner_test_analysis").load("<?= @base_url('charts/partner_summaries/tests_analysis'); ?>");

		//Function when the prtner is selected
		$("select").change(function(){
			em = $(this).val();
			var all = localStorage.getItem("my_var");
			
			// Send the data using post
			var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );

			if (em=="NA") {
				// $("#first").show();
				// $("#second").hide();
				location.reload();
				// $("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
			} else {
				$("#first").hide();
				$("#second").show();

				// Put the results in a div
		        posting.done(function( data ) {
		        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+true, function(data){
		        		$("#breadcrum").html(data);
		        	});
		        	$.get("<?php echo base_url();?>template/dates", function(data){
		        		obj = $.parseJSON(data);
				
						if(obj['month'] == "null" || obj['month'] == null){
							obj['month'] = "";
						}
						$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
						$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
		        	});
		        	// Loader displaying
		        	$("#testing_trends").html("<center><div class='loader'></div></center>");
		        	$("#eidOutcomes").html("<center><div class='loader'></div></center>");
		        	$("#hei_outcomes").html("<center><div class='loader'></div></center>");
			        $("#hei_follow_up").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");
					$("#entry_point").html("<center><div class='loader'></div></center>");
					$("#mprophilaxis").html("<center><div class='loader'></div></center>");
					$("#iprophilaxis").html("<center><div class='loader'></div></center>");
					$("#county_outcomes").html("<center><div class='loader'></div></center>");

					$("#pat_stats").html("<center><div class='loader'></div></center>");
					$("#pat_out").html("<center><div class='loader'></div></center>");
					$("#pat_graph").html("<center><div class='loader'></div></center>");
					

					// Actual graphs being loaded
					$("#testing_trends").load("<?php echo base_url('charts/partner_summaries/testing_trends'); ?>/"+null+"/"+all+"/"+data);
					$("#eidOutcomes").load("<?php echo base_url('charts/partner_summaries/eid_outcomes');?>/"+null+"/"+null+"/"+data);
					$("#hei_outcomes").load("<?php echo base_url('charts/partner_summaries/hei_validation');?>/"+null+"/"+null+"/"+data);
					$("#hei_follow_up").load("<?php echo base_url('charts/partner_summaries/hei_follow');?>/"+null+"/"+null+"/"+data);
					$("#ageGroups").load("<?php echo base_url('charts/partner_summaries/agegroup');?>/"+null+"/"+null+"/"+data);

					$("#entry_point").load("<?php echo base_url('charts/partner_summaries/entry_points');?>/"+null+"/"+null+"/"+data);
					$("#mprophilaxis").load("<?php echo base_url('charts/partner_summaries/mprophyalxis');?>/"+null+"/"+null+"/"+data);
					$("#iprophilaxis").load("<?php echo base_url('charts/partner_summaries/iprophyalxis');?>/"+null+"/"+null+"/"+data);
					
					$("#county_outcomes").load("<?php echo base_url('charts/partner_summaries/partner_outcomes'); ?>/"+null+"/"+null+"/"+data); 
					

					$("#pat_stats").load("<?php echo base_url('charts/partner_summaries/get_patients');?>/"+null+"/"+null+"/"+null+"/"+data);
					$("#pat_out").load("<?php echo base_url('charts/partner_summaries/get_patients_outcomes');?>/"+null+"/"+null+"/"+null+"/"+data);
					$("#pat_graph").load("<?php echo base_url('charts/partner_summaries/get_patients_graph');?>/"+null+"/"+null+"/"+null+"/"+data);
		        });
			}
	        
		});

	});
	$("button").click(function () {
		    var first, second;
		    first = $(".date-picker[name=startDate]").val();
		    second = $(".date-picker[name=endDate]").val();
		    
		    var new_title = set_multiple_date(first, second);
		    var all = localStorage.getItem("my_var");

		    $(".display_date").html(new_title);
		    
		    from = format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 	= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    
		    if (!error_check) {
				$.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
					partner = data;
					// console.log(partner);
					if (partner==0) {
						$("#second").hide();
						$("#first").show();
					
						// fetching the partner outcomes
						$("#partner").html("<center><div class='loader'></div></center>");
						$("#partner").load("<?php echo base_url('charts/partner_summaries/partner_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
						$("#partner_test_analysis").html("<center><div class='loader'></div></center>");
						$("#partner_test_analysis").load("<?= @base_url('charts/partner_summaries/tests_analysis'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					} else {
						partner = $.parseJSON(partner);
						$("#first").hide();
						$("#second").show();
						// Loader displaying
			        	$("#testing_trends").html("<center><div class='loader'></div></center>");
			        	$("#eidOutcomes").html("<center><div class='loader'></div></center>");
				        $("#hei_outcomes").html("<center><div class='loader'></div></center>");
				        $("#hei_follow_up").html("<center><div class='loader'></div></center>");
						$("#ageGroups").html("<center><div class='loader'></div></center>");
						$("#entry_point").html("<center><div class='loader'></div></center>");
						$("#mprophilaxis").html("<center><div class='loader'></div></center>");
						$("#iprophilaxis").html("<center><div class='loader'></div></center>");
						$("#county_outcomes").html("<center><div class='loader'></div></center>");

						$("#pat_stats").html("<center><div class='loader'></div></center>");
						$("#pat_out").html("<center><div class='loader'></div></center>");
						$("#pat_graph").html("<center><div class='loader'></div></center>");

						// Actual graphs being loaded
						$("#testing_trends").load("<?php echo base_url('charts/partner_summaries/testing_trends'); ?>/"+from[1]+"/"+all+"/"+partner);
						$("#eidOutcomes").load("<?php echo base_url('charts/partner_summaries/eid_outcomes');?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);
						$("#hei_outcomes").load("<?php echo base_url('charts/partner_summaries/hei_validation');?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);
						$("#hei_follow_up").load("<?php echo base_url('charts/partner_summaries/hei_follow');?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);
						$("#ageGroups").load("<?php echo base_url('charts/partner_summaries/agegroup');?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);

						$("#entry_point").load("<?php echo base_url('charts/partner_summaries/entry_points');?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);
						$("#mprophilaxis").load("<?php echo base_url('charts/partner_summaries/mprophyalxis');?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);
						$("#iprophilaxis").load("<?php echo base_url('charts/partner_summaries/iprophyalxis');?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);
						// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
						
						$("#county_outcomes").load("<?php echo base_url('charts/partner_summaries/partner_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);

						$("#pat_stats").load("<?php echo base_url('charts/partner_summaries/get_patients');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+partner+"/"+to[1]+"/"+to[0]);
						$("#pat_out").load("<?php echo base_url('charts/partner_summaries/get_patients_outcomes');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+partner+"/"+to[1]+"/"+to[0]);
						$("#pat_graph").load("<?php echo base_url('charts/partner_summaries/get_patients_graph');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+partner+"/"+to[1]+"/"+to[0]);
					}
				});
			}
		    
		});
	function date_filter(criteria, id)
	{
		if (criteria === "monthly") {
 			year = null;
 			month = id;
 		}else {
 			year = id;
 			month = null;
 		}

 		var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );
	    var all = localStorage.getItem("my_var");

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
			$.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
				partner = data;
				console.log(partner);
				if (partner==0) {
					$("#second").hide();
					$("#first").show();
				
					// fetching the partner outcomes
					$("#partner").html("<center><div class='loader'></div></center>");
					$("#partner").load("<?php echo base_url('charts/partner_summaries/partner_outcomes'); ?>/"+year+"/"+month);
					$("#partner_test_analysis").html("<center><div class='loader'></div></center>");
					$("#partner_test_analysis").load("<?= @base_url('charts/partner_summaries/tests_analysis'); ?>/"+year+"/"+month);
				} else {
					partner = $.parseJSON(partner);
					$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#testing_trends").html("<center><div class='loader'></div></center>");
		        	$("#eidOutcomes").html("<center><div class='loader'></div></center>");
		        	$("#hei_outcomes").html("<center><div class='loader'></div></center>");
			        $("#hei_follow_up").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");
					$("#entry_point").html("<center><div class='loader'></div></center>");
					$("#mprophilaxis").html("<center><div class='loader'></div></center>");
					$("#iprophilaxis").html("<center><div class='loader'></div></center>");
					$("#county_outcomes").html("<center><div class='loader'></div></center>");

					$("#pat_stats").html("<center><div class='loader'></div></center>");
					$("#pat_out").html("<center><div class='loader'></div></center>");
					$("#pat_graph").html("<center><div class='loader'></div></center>");

					// Actual graphs being loaded
					$("#testing_trends").load("<?php echo base_url('charts/partner_summaries/testing_trends'); ?>/"+year+"/"+all+"/"+partner);
					$("#eidOutcomes").load("<?php echo base_url('charts/partner_summaries/eid_outcomes');?>/"+year+"/"+month+"/"+partner);
					$("#hei_outcomes").load("<?php echo base_url('charts/partner_summaries/hei_validation');?>/"+year+"/"+month+"/"+partner);
					$("#hei_follow_up").load("<?php echo base_url('charts/partner_summaries/hei_follow');?>/"+year+"/"+month+"/"+partner);
					$("#ageGroups").load("<?php echo base_url('charts/partner_summaries/agegroup');?>/"+year+"/"+month+"/"+partner);

					$("#entry_point").load("<?php echo base_url('charts/partner_summaries/entry_points');?>/"+year+"/"+month+"/"+partner);
					$("#mprophilaxis").load("<?php echo base_url('charts/partner_summaries/mprophyalxis');?>/"+year+"/"+month+"/"+partner);
					$("#iprophilaxis").load("<?php echo base_url('charts/partner_summaries/iprophyalxis');?>/"+year+"/"+month+"/"+partner);
					// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
					
					$("#county_outcomes").load("<?php echo base_url('charts/partner_summaries/partner_outcomes'); ?>/"+year+"/"+month+"/"+partner);

					$("#pat_stats").load("<?php echo base_url('charts/partner_summaries/get_patients');?>/"+year+"/"+month+"/"+null+"/"+partner);
					$("#pat_out").load("<?php echo base_url('charts/partner_summaries/get_patients_outcomes');?>/"+year+"/"+month+"/"+null+"/"+partner);
					$("#pat_graph").load("<?php echo base_url('charts/partner_summaries/get_patients_graph');?>/"+year+"/"+month+"/"+null+"/"+partner);
				}
			});
		});
	}

	function switch_source(){
		var all = localStorage.getItem("my_var");

		if(all == 1){
			localStorage.setItem("my_var", 2);
			all=2;
			$("#samples_heading").html('(Repeat PCR)');
			$("#switchButton").val('Click to Switch to All Tests');
		}

		else if(all == 2){
			localStorage.setItem("my_var", 3);
			all=3;
			$("#samples_heading").html('(All Tests)');
			$("#switchButton").val('Click to Switch to Initial PCR');
		}

		else{
			localStorage.setItem("my_var", 1);
			all=1;
			$("#samples_heading").html('(Initial PCR)');
			$("#switchButton").val('Click to Switch to Repeat PCR');
		}

		$("#testing_trends").load("<?php echo base_url('charts/partner_summaries/testing_trends'); ?>/"+null+"/"+all);

	}

	
</script>