<script type="text/javascript">
	$(document).ready(function(){
		//When the page first loads
		$("#first").show();
		$("#second").hide();
		$.get("<?php echo base_url();?>template/breadcrum/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+1, function(data){
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

    	$("#regimen_outcomes").load("<?= base_url('charts/regimens/get_regimen_outcomes');?>");
    	// When the page first loads

    	//When the Regimen is selected
    	$("select").change(function(){
    		em = $(this).val();
    		if (em == 48 || em == '48') {
    			$("#first").show();
				$("#second").hide();
    			$("#regimen_outcomes").html("<center><div class='loader'></div></center>");
    			$("#regimen_outcomes").load("<?= base_url('charts/regimens/get_regimen_outcomes');?>");
    		} else {
    			$("#first").hide();
				$("#second").show();
				var posting = $.post( "<?php echo base_url();?>template/filter_regimen_data", { regimen: em } );
				posting.done(function(data){
					$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+null+"/"+null+"/"+null+"/"+null+"/"+1, function(data){
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

		        	$("#outcomesRegimen").html("<center><div class='loader'></div></center>");
					$("#outcomesBycounty").html("<center><div class='loader'></div></center>");
					$("#outcomesBysubcounty").html("<center><div class='loader'></div></center>");
					$("#outcomesBypartner").html("<center><div class='loader'></div></center>");
					$("#coutnyRegimenOutcomes").html("<center><div class='loader'></div></center>");

					$("#outcomesRegimen").load("<?= base_url('charts/regimens/get_regimen_testing_trends'); ?>/"+null+"/"+data);
					$("#outcomesBycounty").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data+"/"+1+"/"+null+"/"+null);
					$("#outcomesBysubcounty").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data+"/"+null+"/"+1+"/"+null);
					$("#outcomesBypartner").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data+"/"+null+"/"+null+"/"+1);
					$("#coutnyRegimenOutcomes").load("<?= base_url('charts/regimens/get_counties_regimen'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
				});
    		}
    	});
    	//WHen the Regimen is selected

    	//When the date range filter is selected
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
		    	$.get("<?= @base_url('regimen/check_Regimen')?>", function(data) {
		 			obj = JSON.parse(data);
		 			if (obj == 0) {// No age group selected
		 				$("#regimen_outcomes").html("<center><div class='loader'></div></center>");
						$("#regimen_outcomes").load("<?= base_url('charts/regimens/get_regimen_outcomes');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
		 			} else {// Age group selected
		 				$("#outcomesRegimen").html("<center><div class='loader'></div></center>");
						$("#outcomesBycounty").html("<center><div class='loader'></div></center>");
						$("#outcomesBysubcounty").html("<center><div class='loader'></div></center>");
						$("#outcomesBypartner").html("<center><div class='loader'></div></center>");
						$("#coutnyRegimenOutcomes").html("<center><div class='loader'></div></center>");

						$("#outcomesRegimen").load("<?= base_url('charts/regimens/get_regimen_testing_trends'); ?>/"+to[1]+"/"+data);
						$("#outcomesBycounty").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+1);
						$("#outcomesBysubcounty").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+1);
						$("#outcomesBypartner").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+1);
						$("#coutnyRegimenOutcomes").load("<?= base_url('charts/regimens/get_counties_regimen'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
		 			}
		 		});
			}
		    
		});
    	//When the date range filter is selected
	});
	
	//When single year or month is clicked
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
			
	 		$.get("<?= @base_url('regimen/check_Regimen')?>", function(data) {
	 			obj = JSON.parse(data);
	 			console.log(obj);
	 			if (obj == 0) {// No age group selected
	 				$("#regimen_outcomes").html("<center><div class='loader'></div></center>");
					$("#regimen_outcomes").load("<?= base_url('charts/regimens/get_regimen_outcomes');?>/"+year+"/"+month);
	 			} else {// Age group selected
	 				$("#outcomesRegimen").html("<center><div class='loader'></div></center>");
					$("#outcomesBycounty").html("<center><div class='loader'></div></center>");
					$("#outcomesBysubcounty").html("<center><div class='loader'></div></center>");
					$("#outcomesBypartner").html("<center><div class='loader'></div></center>");
					$("#coutnyRegimenOutcomes").html("<center><div class='loader'></div></center>");

					$("#outcomesRegimen").load("<?= base_url('charts/regimens/get_regimen_testing_trends'); ?>/"+year);
					$("#outcomesBycounty").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+"/"+null+"/"+1);
					$("#outcomesBysubcounty").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+"/"+null+"/"+null+"/"+1);
					$("#outcomesBypartner").load("<?= base_url('charts/regimens/get_regimen_breakdown');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+"/"+null+"/"+null+"/"+null+"/"+1);
					$("#coutnyRegimenOutcomes").load("<?= base_url('charts/regimens/get_counties_regimen'); ?>/"+year+"/"+month);
	 			}
	 		});
		});
 		
	}
	//When single year or month is clicked
</script>