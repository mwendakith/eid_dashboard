<script type="text/javascript">
	$().ready(function(){
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>");
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

		

		// $('#startDate').on('input',function(e){
		//      alert('Changed!')
		//  });
		// $("#startDate").focusout(function() {
		// 	startDate = $(this).val();
		// 	console.log(startDate);
		// });
	});
	$("button").click(function () {
		    var first, second;
		    first = $(".date-picker[name=startDate]").val();
		    second = $(".date-picker[name=endDate]").val();
		    
		    from 	= format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 		= format_date(second);
		    
		    $("#nattat").html("<div>Loading...</div>");
        	$("#eidOutcomes").html("<center><div class='loader'></div></center>");
	        $("#hei_follow_up").html("<center><div class='loader'></div></center>");
			$("#ageGroups").html("<center><div class='loader'></div></center>");
			$("#entry_point").html("<center><div class='loader'></div></center>");
			$("#mprophilaxis").html("<center><div class='loader'></div></center>");
			$("#iprophilaxis").html("<center><div class='loader'></div></center>");
			$("#county_outcomes").html("<center><div class='loader'></div></center>");

			$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[0]);
			$("#eidOutcomes").load("<?php echo base_url('charts/summaries/eid_outcomes');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+"/"+null+"/"+to[0]);
			$("#hei_follow_up").load("<?php echo base_url('charts/summaries/hei_follow');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+"/"+null+"/"+to[0]);
			$("#ageGroups").load("<?php echo base_url('charts/summaries/agegroup');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+"/"+null+"/"+to[0]);

			$("#entry_point").load("<?php echo base_url('charts/summaries/entry_points');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+"/"+null+"/"+to[0]);
			$("#mprophilaxis").load("<?php echo base_url('charts/summaries/mprophyalxis');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+"/"+null+"/"+to[0]);
			$("#iprophilaxis").load("<?php echo base_url('charts/summaries/iprophyalxis');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+"/"+null+"/"+to[0]);
			// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
			
			$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+null+"/"+to[0]);
		    
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
			
		});
 		$("#nattat").html("<div>Loading...</div>");
		$("#testing_trends").html("<center><div class='loader'></div></center>");
    	$("#eidOutcomes").html("<center><div class='loader'></div></center>");
        $("#hei_follow_up").html("<center><div class='loader'></div></center>");
		$("#ageGroups").html("<center><div class='loader'></div></center>");
		$("#entry_point").html("<center><div class='loader'></div></center>");
		$("#mprophilaxis").html("<center><div class='loader'></div></center>");
		$("#iprophilaxis").html("<center><div class='loader'></div></center>");
		$("#county_outcomes").html("<center><div class='loader'></div></center>");

		// Actual graphs being loaded
		$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+year+"/"+month);
		$("#testing_trends").load("<?php echo base_url('charts/summaries/testing_trends'); ?>/"+year);
		$("#eidOutcomes").load("<?php echo base_url('charts/summaries/eid_outcomes');?>/"+year+"/"+month);
		$("#hei_follow_up").load("<?php echo base_url('charts/summaries/hei_follow');?>/"+year+"/"+month);
		$("#ageGroups").load("<?php echo base_url('charts/summaries/agegroup');?>/"+year+"/"+month);

		$("#entry_point").load("<?php echo base_url('charts/summaries/entry_points');?>/"+year+"/"+month);
		$("#mprophilaxis").load("<?php echo base_url('charts/summaries/mprophyalxis');?>/"+year+"/"+month);
		$("#iprophilaxis").load("<?php echo base_url('charts/summaries/iprophyalxis');?>/"+year+"/"+month);
		// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
		
		$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes');?>/"+year+"/"+month); 
	}
</script>