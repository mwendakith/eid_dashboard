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
					$("#county_outcomes").load("<?php echo base_url('charts/subcounties/subcounties_outcomes');?>");
	        	}else {
	        		$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#eid_outcomes").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#eid_outcomes").load("<?php echo base_url('charts/subcounties/subcounties_eid'); ?>/"+data+"/"+null+"/"+null);

					$("#subcounty_hei").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_hei").load("<?php echo base_url('charts/subcounties/subcounties_hei'); ?>/"+data+"/"+null+"/"+null);

					$("#subcounty_age").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_age").load("<?php echo base_url('charts/subcounties/subcounties_age'); ?>/"+data+"/"+null+"/"+null);

					$("#subcounty_facilities").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_facilities").load("<?php echo base_url('charts/subcounties/subcounties_sites'); ?>/"+data+"/"+null+"/"+null);
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

		    
			$.get("<?php echo base_url();?>county/check_subcounty_select", function (data) {
				subcounty = data;
				// console.log(subcounty);
				if (subcounty==0) {
					$("#second").hide();
					$("#first").show();
				
					// fetching the partner outcomes
					$("#county_outcomes").html("<center><div class='loader'></div></center>");
					$("#county_outcomes").load("<?php echo base_url('charts/subcounties/subcounties_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+to[0]);
				} else {
					// subcounty = "<?php echo json_decode("+subcounty+")?>";
					// console.log(subcounty);
					$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#eid_outcomes").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#eid_outcomes").load("<?php echo base_url('charts/subcounties/subcounties_eid'); ?>/"+subcounty+"/"+from[1]+"/"+from[0]+"/"+to[0]);

					$("#subcounty_hei").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_hei").load("<?php echo base_url('charts/subcounties/subcounties_hei'); ?>/"+subcounty+"/"+from[1]+"/"+from[0]+"/"+to[0]);

					$("#subcounty_age").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_age").load("<?php echo base_url('charts/subcounties/subcounties_age'); ?>/"+subcounty+"/"+from[1]+"/"+from[0]+"/"+to[0]);

					$("#subcounty_facilities").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_facilities").load("<?php echo base_url('charts/subcounties/subcounties_sites'); ?>/"+subcounty+"/"+from[1]+"/"+from[0]+"/"+to[0]);

					
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
			
			$.get("<?php echo base_url();?>county/check_subcounty_select", function (data) {
				subcounty = data;
				// console.log(subcounty);
				if (subcounty==0) {
					$("#second").hide();
					$("#first").show();
				
					// fetching the partner outcomes
					$("#county_outcomes").html("<center><div class='loader'></div></center>");
					$("#county_outcomes").load("<?php echo base_url('charts/subcounties/subcounties_outcomes'); ?>/"+year+"/"+month);
				} else {
					// subcounty = "<?php echo json_decode("+subcounty+")?>";
					// console.log(subcounty);
					$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#eid_outcomes").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#eid_outcomes").load("<?php echo base_url('charts/subcounties/subcounties_eid'); ?>/"+subcounty+"/"+year+"/"+month);

					$("#subcounty_hei").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_hei").load("<?php echo base_url('charts/subcounties/subcounties_hei'); ?>/"+subcounty+"/"+year+"/"+month);

					$("#subcounty_age").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_age").load("<?php echo base_url('charts/subcounties/subcounties_age'); ?>/"+subcounty+"/"+year+"/"+month);

					$("#subcounty_facilities").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_facilities").load("<?php echo base_url('charts/subcounties/subcounties_sites'); ?>/"+subcounty+"/"+year+"/"+month);

					
				}
			});
		});
	}
</script>