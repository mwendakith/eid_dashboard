<script type="text/javascript">
	$().ready(function(){
		$("#second").hide();
		
		$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);

		//Function when the prtner is selected
		$("select").change(function(){
			em = $(this).val();
			$("#first").hide();
			$("#second").show();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );
	     
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
		        $("#hei_follow_up").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				$("#entry_point").html("<center><div class='loader'></div></center>");
				$("#mprophilaxis").html("<center><div class='loader'></div></center>");
				$("#iprophilaxis").html("<center><div class='loader'></div></center>");
				$("#county_outcomes").html("<center><div class='loader'></div></center>");

				// Actual graphs being loaded
				$("#testing_trends").load("<?php echo base_url('charts/summaries/testing_trends'); ?>/"+null+"/"+data);
				$("#eidOutcomes").load("<?php echo base_url('charts/summaries/eid_outcomes');?>/"+null+"/"+null+"/"+"/"+null+"/"+data);
				$("#hei_follow_up").load("<?php echo base_url('charts/summaries/hei_follow');?>/"+null+"/"+null+"/"+"/"+null+"/"+data);
				$("#ageGroups").load("<?php echo base_url('charts/summaries/agegroup');?>/"+null+"/"+null+"/"+"/"+null+"/"+data);

				$("#entry_point").load("<?php echo base_url('charts/summaries/entry_points');?>/"+null+"/"+null+"/"+"/"+null+"/"+data);
				$("#mprophilaxis").load("<?php echo base_url('charts/summaries/mprophyalxis');?>/"+null+"/"+null+"/"+"/"+null+"/"+data);
				$("#iprophilaxis").load("<?php echo base_url('charts/summaries/iprophyalxis');?>/"+null+"/"+null+"/"+"/"+null+"/"+data);
				// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
				
				$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+true+data); 
	        });
		});

	});

	
</script>