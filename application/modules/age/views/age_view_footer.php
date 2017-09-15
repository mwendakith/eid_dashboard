<script type="text/javascript">
	$(document).ready(function () {
		$("#first").show();
		$("#second").hide();
		$.get("<?php echo base_url();?>template/breadcrum/"+null+"/"+null+"/"+null+"/"+null+"/"+1, function(data){
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
		// $("#summary").load("<?php //base_url('charts/ages/get_age_summary');?>");
		// $("#positivity").load("<?php //base_url('charts/ages/get_age_positivity');?>");
		$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>");

		//Function when the Age category is selected
		$("select").change(function(){
			em = $(this).val();
			if (em == 8 || em == '8') {
				$.get("<?php echo base_url();?>template/breadcrum/"+null+"/"+null+"/"+null+"/"+null+"/"+1, function(data){
	        		$("#breadcrum").html(data);
	        	});
				$("#first").show();
				$("#second").hide();
				$("#age_outcomes").html("<center><div class='loader'></div></center>");
				$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>");
			} else {
				$("#first").hide();
				$("#second").show();
				var posting = $.post( "<?php echo base_url();?>template/filter_age_data", { age: em } );

				posting.done(function(data){
					$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+null+"/"+null+"/"+null+"/"+1, function(data){
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

		        	$("#outcomesAgeGroup").html("<center><div class='loader'></div></center>");
					$("#outcomesBycounty").html("<center><div class='loader'></div></center>");
					$("#outcomesBysubcounty").html("<center><div class='loader'></div></center>");
					$("#outcomesBypartner").html("<center><div class='loader'></div></center>");
					$("#coutnyAgeOutcomes").html("<center><div class='loader'></div></center>");

					$("#outcomesAgeGroup").load("<?= base_url('charts/ages/testing_trends'); ?>/"+null+"/"+data);
					$("#outcomesBycounty").load("<?= base_url('charts/ages/age_breakdowns');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data+"/"+1+"/"+null+"/"+null);
					$("#outcomesBysubcounty").load("<?= base_url('charts/ages/age_breakdowns');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data+"/"+null+"/"+1+"/"+null);
					$("#outcomesBypartner").load("<?= base_url('charts/ages/age_breakdowns');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data+"/"+null+"/"+null+"/"+1);
					$("#coutnyAgeOutcomes").load("<?= base_url('charts/ages/counties_age_group_breakdown'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
				});
			}
			// Send the data using post
	   //      var posting = $.post( "<?php //echo base_url();?>template/filter_county_data", { county: em } );
	     
	   //      // Put the results in a div
	   //      posting.done(function( data ) {
	   //      	$("#summary").html("<center><div class='loader'></div></center>");
				// $("#positivity").html("<center><div class='loader'></div></center>");
				// $("#age_outcomes").html("<center><div class='loader'></div></center>");

				// $("#summary").load("<?php //base_url('charts/ages/get_age_summary');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
				// $("#positivity").load("<?php //base_url('charts/ages/get_age_positivity');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
				// $("#age_outcomes").load("<?php //base_url('charts/ages/get_age_outcomes');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
	   //      });
		});

		$("button").click(function () {
		    var first, second;
		    first = $(".date-picker[name=startDate]").val();
		    second = $(".date-picker[name=endDate]").val();
		    
		    var new_title = set_multiple_date(first, second);

		    $(".display_date").html(new_title);
		    
		    from = format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 	= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    // alert(error_check);
		    if (!error_check) {
		    	$.get("<?= @base_url('age/check_ageGroup')?>", function(data) {
		 			obj = JSON.parse(data);
		 			if (obj == 0) {// No age group selected
		 				$("#age_outcomes").html("<center><div class='loader'></div></center>");
						$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
		 			} else {// Age group selected
		 				$("#outcomesAgeGroup").html("<center><div class='loader'></div></center>");
						$("#outcomesBycounty").html("<center><div class='loader'></div></center>");
						$("#outcomesBysubcounty").html("<center><div class='loader'></div></center>");
						$("#outcomesBypartner").html("<center><div class='loader'></div></center>");
						$("#coutnyAgeOutcomes").html("<center><div class='loader'></div></center>");

						$("#outcomesAgeGroup").load("<?= base_url('charts/ages/testing_trends'); ?>/"+to[1]);
						$("#outcomesBycounty").load("<?= base_url('charts/ages/age_breakdowns');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+1);
						$("#outcomesBysubcounty").load("<?= base_url('charts/ages/age_breakdowns');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+1);
						$("#outcomesBypartner").load("<?= base_url('charts/ages/age_breakdowns');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+1);
						$("#coutnyAgeOutcomes").load("<?= base_url('charts/ages/counties_age_group_breakdown'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
		 			}
		 		});
			}
		    
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
			
		});
 		
 		$.get("<?= @base_url('age/check_ageGroup')?>", function(data) {
 			obj = JSON.parse(data);
 			if (obj == 0) {// No age group selected
 				$("#age_outcomes").html("<center><div class='loader'></div></center>");
				$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>/"+year+"/"+month);
 			} else {// Age group selected
 				$("#outcomesAgeGroup").html("<center><div class='loader'></div></center>");
				$("#outcomesBycounty").html("<center><div class='loader'></div></center>");
				$("#outcomesBysubcounty").html("<center><div class='loader'></div></center>");
				$("#outcomesBypartner").html("<center><div class='loader'></div></center>");
				$("#coutnyAgeOutcomes").html("<center><div class='loader'></div></center>");

				$("#outcomesAgeGroup").load("<?= base_url('charts/ages/testing_trends'); ?>/"+year);
				$("#outcomesBycounty").load("<?= base_url('charts/ages/age_breakdowns');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+"/"+null+"/"+1);
				$("#outcomesBysubcounty").load("<?= base_url('charts/ages/age_breakdowns');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+"/"+null+"/"+null+"/"+1);
				$("#outcomesBypartner").load("<?= base_url('charts/ages/age_breakdowns');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+"/"+null+"/"+null+"/"+null+"/"+1);
				$("#coutnyAgeOutcomes").load("<?= base_url('charts/ages/counties_age_group_breakdown'); ?>/"+year+"/"+month);
 			}
 		});
	}
</script>