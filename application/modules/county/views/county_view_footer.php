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
		$("#second").hide();
		$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes');?>");
		$("#county_details").load("<?php echo base_url('charts/counties/counties_details');?>");

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
	        	if (data=="") {
	        		$("#second").hide();
	        		$("#first").show();
					$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes');?>");
					$("#county_details").load("<?php echo base_url('charts/counties/counties_details');?>");
	        	}else {
	        		$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#subcounty_outcomes").html("<center><div class='loader'></div></center>");
		        	$("#county_sites_details").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_outcomes").load("<?php echo base_url('charts/counties/subCounties_outcomes'); ?>/"+null+"/"+null+"/"+data);
					$("#county_sub_county_details").load("<?php echo base_url('charts/counties/county_subcounties_details'); ?>/"+null+"/"+null+"/"+data);
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
		    
		    from 	= format_date(first);
		    to 		= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    
		    if (!error_check) {
		    
			 	$.get("<?php echo base_url();?>county/check_county_select", function (data) {
					if (data==0) {
						$("#second").hide();
						$("#first").show();
					
						// fetching the partner outcomes
						$("#county_outcomes").html("<center><div class='loader'></div></center>");
						$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+"/"+null+"/"+"/"+null+"/"+to[0]);
						$("#county_details").html("<center><div class='loader'></div></center>");
						$("#county_details").load("<?php echo base_url('charts/counties/counties_details');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[0]);
					} else {
						data = "<?php echo json_decode("+data+")?>";
						$("#first").hide();
						$("#second").show();
						// Loader displaying
			        	$("#subcounty_outcomes").html("<center><div class='loader'></div></center>");
			        	$("#county_sites_details").html("<center><div class='loader'></div></center>");
			        	// Actual graphs being loaded
						$("#subcounty_outcomes").load("<?php echo base_url('charts/counties/subCounties_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+data+"/"+to[0]);
						$("#county_sites_details").load("<?php echo base_url('charts/counties/county_sites_details'); ?>/"+from[1]+"/"+from[0]+"/"+data+"/"+to[0]);
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

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");

			$.get("<?php echo base_url();?>county/check_county_select", function (data) {
				if (data==0) {
					$("#second").hide();
					$("#first").show();
				
					// fetching the partner outcomes
					$("#county_outcomes").html("<center><div class='loader'></div></center>");
					$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes');?>/"+year+"/"+month);
					$("#county_details").html("<center><div class='loader'></div></center>");
					$("#county_details").load("<?php echo base_url('charts/counties/counties_details');?>/"+year+"/"+month);
				} else {
					data = "<?php echo json_decode("+data+")?>";
					$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#subcounty_outcomes").html("<center><div class='loader'></div></center>");
		        	$("#county_sites_details").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_outcomes").load("<?php echo base_url('charts/counties/subCounties_outcomes'); ?>/"+year+"/"+month+"/"+data);
					$("#county_sites_details").load("<?php echo base_url('charts/counties/county_sites_details'); ?>/"+year+"/"+month+"/"+data);
				}
			});
			
		});
	}
</script>