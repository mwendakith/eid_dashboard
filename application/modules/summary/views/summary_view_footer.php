<script type="text/javascript">
	$().ready(function(){
		$("#testing_trends").load("<?php echo base_url('charts/summaries/testing_trends'); ?>");
		$("#eidOutcomes").load("<?php echo base_url('charts/summaries/eid_outcomes');?>");
		$("#hei_follow_up").load("<?php echo base_url('charts/summaries/hei_follow');?>");
		$("#ageGroups").load("<?php echo base_url('charts/summaries/agegroup');?>");

		$("#entry_point").load("<?php echo base_url('charts/summaries/entry_points'); ?>");
		$("#mprophilaxis").load("<?php echo base_url('charts/summaries/mprophyalxis');?>");
		$("#iprophilaxis").load("<?php echo base_url('charts/summaries/iprophyalxis');?>");
		// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
		
		$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>");

		//Function when the county is selected
		$("select").change(function(){
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_county_data", { county: em } );
	     
	        // Put the results in a div
	        posting.done(function( data ) {
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data, function(data){
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
	        	$("#nattat").html("<div>Loading...</div>");
	        	$("#samples").html("<center><div class='loader'></div></center>");
		        $("#vlOutcomes").html("<center><div class='loader'></div></center>");
				$("#justification").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				$("#gender").html("<center><div class='loader'></div></center>");

				// Actual graphs being loaded
				$("#testing_trends").load("<?php echo base_url('charts/summaries/testing_trends'); ?>/"+null+"/"+data);
				$("#eidOutcomes").load("<?php echo base_url('charts/summaries/eid_outcomes');?>/"+null+"/"+null+"/"+data);
				$("#hei_follow_up").load("<?php echo base_url('charts/summaries/hei_follow');?>/"+null+"/"+null+"/"+data);
				$("#ageGroups").load("<?php echo base_url('charts/summaries/agegroup');?>/"+null+"/"+null+"/"+data);

				$("#entry_point").load("<?php echo base_url('charts/summaries/entry_points');?>/"+null+"/"+null+"/"+data);
				$("#mprophilaxis").load("<?php echo base_url('charts/summaries/mprophyalxis');?>/"+null+"/"+null+"/"+data);
				$("#iprophilaxis").load("<?php echo base_url('charts/summaries/iprophyalxis');?>/"+null+"/"+null+"/"+data);
				// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
				
				$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data); 
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

 		var posting = $.post( '<?php echo base_url();?>summary/set_filter_date', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
		});
 		
		$("#nattat").html("<div>Loading...</div>");
    	$("#samples").html("<center><div class='loader'></div></center>");
        $("#vlOutcomes").html("<center><div class='loader'></div></center>");
		$("#justification").html("<center><div class='loader'></div></center>");
		$("#ageGroups").html("<center><div class='loader'></div></center>");
		$("#gender").html("<center><div class='loader'></div></center>");

		$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+year+"/"+month);
		$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+year);
 		$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month); 
		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+year+"/"+month);
		$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+year+"/"+month); 
		$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+year+"/"+month); 
		$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+year+"/"+month);
	}
</script>