<script type="text/javascript">
	$().ready(function(){
		$.get("<?php echo base_url();?>template/breadcrum/"+null+"/"+null+"/"+null+"/"+1, function(data){
	        	$("#breadcrum").html(data);
	       });
		$("#second").hide();
		$("#county_outcomes").load("<?php echo base_url('charts/subcounties/subcounties_outcomes');?>");


		$("select").change(function(){
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_sub_county_data", { subCounty: em } );
	     
	        // Put the results in a div
	        posting.done(function( data ) {
	        	console.log(data);
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+null+"/"+null+"/"+1, function(data){
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
	        	if (data=="") {
	        		$("#second").hide();
	        		$("#first").show();
					$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes');?>");
	        	}else {
	        		$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#subcounty_outcomes").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_outcomes").load("<?php echo base_url('charts/counties/subCounties_outcomes'); ?>/"+null+"/"+null+"/"+data);
	        	}
	        });
		});
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
					$("#county_outcomes").html("<center><div class='loader'></div></center>");
					$("#county_outcomes").load("<?php echo base_url('charts/subcounties/subcounties_outcomes'); ?>/"+year+"/"+month);
				} else {
					partner = "<?php echo json_decode("+partner+")?>";
					$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#testing_trends").html("<center><div class='loader'></div></center>");
		        	$("#eidOutcomes").html("<center><div class='loader'></div></center>");
			        $("#hei_follow_up").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");
					$("#entry_point").html("<center><div class='loader'></div></center>");
					$("#mprophilaxis").html("<center><div class='loader'></div></center>");
					$("#iprophilaxis").html("<center><div class='loader'></div></center>");
					$("#county_outcomes").html("<center><div class='loader'></div></center>");

					// Actual graphs being loaded
					$("#testing_trends").load("<?php echo base_url('charts/partner_summaries/testing_trends'); ?>/"+year+"/"+partner);
					$("#eidOutcomes").load("<?php echo base_url('charts/partner_summaries/eid_outcomes');?>/"+year+"/"+month+"/"+partner);
					$("#hei_follow_up").load("<?php echo base_url('charts/partner_summaries/hei_follow');?>/"+year+"/"+month+"/"+partner);
					$("#ageGroups").load("<?php echo base_url('charts/partner_summaries/agegroup');?>/"+year+"/"+month+"/"+partner);

					$("#entry_point").load("<?php echo base_url('charts/partner_summaries/entry_points');?>/"+year+"/"+month+"/"+partner);
					$("#mprophilaxis").load("<?php echo base_url('charts/partner_summaries/mprophyalxis');?>/"+year+"/"+month+"/"+partner);
					$("#iprophilaxis").load("<?php echo base_url('charts/partner_summaries/iprophyalxis');?>/"+year+"/"+month+"/"+partner);
					// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
					
					$("#county_outcomes").load("<?php echo base_url('charts/partner_summaries/partner_outcomes'); ?>/"+year+"/"+month+"/"+partner);
				}
			});
		});
	}
</script>