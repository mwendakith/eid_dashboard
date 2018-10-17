<script type="text/javascript">
	$(document).ready(function(){
		localStorage.setItem("my_var", 1);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#second").hide();
		$("#positivity").load("<?php echo base_url('charts/agencies/positivity');?>");

		//Function when the prtner is selected
		$("select").change(function(){
			em = $(this).val();
			var all = localStorage.getItem("my_var");
			
			// Send the data using post
			var posting = $.post( "<?php echo base_url();?>template/filter_funding_agency_data", { agency: em } );
			if (em=="NA") {
				$("#first").show();
				$("#second").hide();
				// location.reload();
				// $("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);

				$("#positivity").html("<center><div class='loader'></div></center>");
				$("#positivity").load("<?php echo base_url('charts/agencies/positivity');?>");
			} else {
				$("#first").hide();
				$("#second").show();

				$("#partner_positivity").html("<center><div class='loader'></div></center>");
				$("#eidOutcomes").html("<center><div class='loader'></div></center>");
				$("#hei_outcomes").html("<center><div class='loader'></div></center>");
				$("#hei_follow_up").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				
				$("#partner_positivity").load("<?= @base_url('charts/agencies/positivity');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+1+"/"+em);
				$("#eidOutcomes").load("<?= @base_url('charts/agencies/outcomes');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+1+"/"+em);
				$("#hei_outcomes").load("<?= @base_url('charts/agencies/hei_validation');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+1+"/"+em);
				$("#hei_follow_up").load("<?= @base_url('charts/agencies/hei_follow');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+1+"/"+em);
				$("#ageGroups").load("<?= @base_url('charts/agencies/agegroup');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+1+"/"+em);
			}
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
		    	$.get("<?php echo base_url();?>partner/check_agencies_select", function (data) {
		    		agency = $.parseJSON(data);
		    		if (agency==0) {
						$("#second").hide();
						$("#first").show();
					
						// fetching the partner outcomes
						$("#positivity").html("<center><div class='loader'></div></center>");
						$("#positivity").load("<?php echo base_url('charts/agencies/positivity'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					} else {
						$("#first").hide();
						$("#second").show();

						$("#partner_positivity").html("<center><div class='loader'></div></center>");
						$("#eidOutcomes").html("<center><div class='loader'></div></center>");
						$("#hei_outcomes").html("<center><div class='loader'></div></center>");
						$("#hei_follow_up").html("<center><div class='loader'></div></center>");
						$("#ageGroups").html("<center><div class='loader'></div></center>");
						
						$("#partner_positivity").load("<?= @base_url('charts/agencies/positivity');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+1+"/"+agency);
						$("#eidOutcomes").load("<?= @base_url('charts/agencies/outcomes');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+1+"/"+agency);
						$("#hei_outcomes").load("<?= @base_url('charts/agencies/hei_validation');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+1+"/"+agency);
						$("#hei_follow_up").load("<?= @base_url('charts/agencies/hei_follow');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+1+"/"+agency);
						$("#ageGroups").load("<?= @base_url('charts/agencies/agegroup');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+1+"/"+agency);
					}
		    	});
		    }
		});
    });

	function date_filter(criteria, id) {
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
			
			$.get("<?php echo base_url();?>partner/check_agencies_select", function (data) {
				agency = $.parseJSON(data);
		    	if (agency==0) {
					$("#second").hide();
					$("#first").show();
				
					$("#positivity").html("<center><div class='loader'></div></center>");
					$("#positivity").load("<?php echo base_url('charts/agencies/positivity'); ?>/"+year+"/"+month);
				} else {
					$("#first").hide();
					$("#second").show();

					$("#partner_positivity").html("<center><div class='loader'></div></center>");
					$("#eidOutcomes").html("<center><div class='loader'></div></center>");
					$("#hei_outcomes").html("<center><div class='loader'></div></center>");
					$("#hei_follow_up").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");
					
					$("#partner_positivity").load("<?php echo base_url('charts/agencies/positivity');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+1+"/"+agency);
					$("#eidOutcomes").load("<?= @base_url('charts/agencies/outcomes');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+1+"/"+agency);
					$("#hei_outcomes").load("<?= @base_url('charts/agencies/hei_validation');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+1+"/"+agency);
					$("#hei_follow_up").load("<?= @base_url('charts/agencies/hei_follow');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+1+"/"+agency);
					$("#ageGroups").load("<?= @base_url('charts/agencies/agegroup');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+1+"/"+agency);
				}
			});
		});
	}

	function switch_source(){
		var all = localStorage.getItem("my_var");

		if(all == 1){
			localStorage.setItem("my_var", 2);
			all=2;
			$("#samples_heading").html('(2nd/3rd PCR)');
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
			$("#switchButton").val('Click to Switch to 2nd/3rd PCR');
		}

		$("#testing_trends").load("<?php echo base_url('charts/partner_summaries/testing_trends'); ?>/"+null+"/"+all);

	}
</script>