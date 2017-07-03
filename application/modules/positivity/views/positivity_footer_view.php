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
		$("#notification").load("<?php echo base_url('charts/positivity/notification'); ?>");
		$("#ageCat").load("<?php echo base_url('charts/positivity/age'); ?>");
		$("#iprophylaxis").load("<?php echo base_url('charts/positivity/i_prophylaxis');?>");
		$("#mprophylaxis").load("<?php echo base_url('charts/positivity/m_prophylaxis');?>");
		$("#epoint").load("<?php echo base_url('charts/positivity/entry_point');?>");
		$("#countys").load("<?php echo base_url('charts/positivity/counties');?>");

		$("#subcounty").load("<?php echo base_url('charts/positivity/subCounties'); ?>");
		$("#facilities").load("<?php echo base_url('charts/positivity/facilites');?>");
		$("#partners").load("<?php echo base_url('charts/positivity/partners');?>");
		// $("#feeding").load("<?php //echo base_url('charts/summaries/agegroup');?>");
		
		$("#county_outcomes").load("<?php echo base_url('charts/positivity/county_outcomes'); ?>");

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
	        	$("#notification").html("<center><div class='loader'></div></center>");
	        	$("#ageCat").html("<center><div class='loader'></div></center>");
		        $("#iprophylaxis").html("<center><div class='loader'></div></center>");
		        $("#mprophylaxis").html("<center><div class='loader'></div></center>");
				$("#epoint").html("<center><div class='loader'></div></center>");
				$("#countys").html("<center><div class='loader'></div></center>");
				$("#subcounty").html("<center><div class='loader'></div></center>");
				$("#facilities").html("<center><div class='loader'></div></center>");
				$("#partners").html("<center><div class='loader'></div></center>");

				// Actual graphs being loaded
				$("#notification").load("<?php echo base_url('charts/positivity/notification'); ?>/"+null+"/"+null+"/"+data);
				$("#ageCat").load("<?php echo base_url('charts/positivity/age');?>/"+null+"/"+null+"/"+data);
				$("#iprophylaxis").load("<?php echo base_url('charts/positivity/i_prophylaxis');?>/"+null+"/"+null+"/"+data);
				$("#mprophylaxis").load("<?php echo base_url('charts/positivity/m_prophylaxis');?>/"+null+"/"+null+"/"+data);
				$("#epoint").load("<?php echo base_url('charts/positivity/entry_point');?>/"+null+"/"+null+"/"+data);

				$("#countys").load("<?php echo base_url('charts/positivity/counties');?>/"+null+"/"+null+"/"+data);
				$("#subcounty").load("<?php echo base_url('charts/positivity/subCounties');?>/"+null+"/"+null+"/"+data);
				$("#facilities").load("<?php echo base_url('charts/positivity/facilites');?>/"+null+"/"+null+"/"+data);
				$("#partners").load("<?php echo base_url('charts/positivity/partners');?>/"+null+"/"+null+"/"+data);
				
				$("#county_outcomes").load("<?php echo base_url('charts/positivity/county_outcomes'); ?>/"+null+"/"+null+"/"+data); 
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
		    
		    var new_title = set_multiple_date(first, second);

		    $(".display_date").html(new_title);
		    
		    from = format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 	= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    
		    if (!error_check) {
			    $("#notification").html("<div>Loading...</div>");
	        	$("#ageCat").html("<center><div class='loader'></div></center>");
		        $("#iprophylaxis").html("<center><div class='loader'></div></center>");
		        $("#mprophylaxis").html("<center><div class='loader'></div></center>");
				$("#epoint").html("<center><div class='loader'></div></center>");
				$("#countys").html("<center><div class='loader'></div></center>");
				$("#subcounty").html("<center><div class='loader'></div></center>");
				$("#facilities").html("<center><div class='loader'></div></center>");
				$("#partners").html("<center><div class='loader'></div></center>");

				$("#notification").load("<?php echo base_url('charts/positivity/notification'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
				$("#ageCat").load("<?php echo base_url('charts/positivity/age');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
				$("#iprophylaxis").load("<?php echo base_url('charts/positivity/i_prophylaxis');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
				$("#mprophylaxis").load("<?php echo base_url('charts/positivity/m_prophylaxis');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
				$("#epoint").load("<?php echo base_url('charts/positivity/entry_point');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);

				$("#countys").load("<?php echo base_url('charts/positivity/counties');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+"/"+to[1]+"/"+to[0]);
				$("#subcounty").load("<?php echo base_url('charts/positivity/subCounties');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
				$("#facilities").load("<?php echo base_url('charts/positivity/facilites');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
				$("#partners").load("<?php echo base_url('charts/positivity/partners');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
				
				$("#county_outcomes").load("<?php echo base_url('charts/positivity/county_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]);
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
			
		});
 		$("#notification").html("<div>Loading...</div>");
    	$("#ageCat").html("<center><div class='loader'></div></center>");
        $("#iprophylaxis").html("<center><div class='loader'></div></center>");
        $("#mprophylaxis").html("<center><div class='loader'></div></center>");
		$("#epoint").html("<center><div class='loader'></div></center>");
		$("#countys").html("<center><div class='loader'></div></center>");
		$("#subcounty").html("<center><div class='loader'></div></center>");
		$("#facilities").html("<center><div class='loader'></div></center>");
		$("#partners").html("<center><div class='loader'></div></center>");

		// Actual graphs being loaded
		$("#notification").load("<?php echo base_url('charts/positivity/turnaroundtime'); ?>/"+year+"/"+month);
		$("#ageCat").load("<?php echo base_url('charts/positivity/testing_trends'); ?>/"+year);
		$("#iprophylaxis").load("<?php echo base_url('charts/positivity/eid_outcomes');?>/"+year+"/"+month);
		$("#mprophylaxis").load("<?php echo base_url('charts/positivity/hei_validation');?>/"+year+"/"+month);
		$("#epoint").load("<?php echo base_url('charts/positivity/hei_follow');?>/"+year+"/"+month);

		$("#countys").load("<?php echo base_url('charts/positivity/entry_points');?>/"+year+"/"+month);
		$("#subcounty").load("<?php echo base_url('charts/positivity/mprophyalxis');?>/"+year+"/"+month);
		$("#facilities").load("<?php echo base_url('charts/positivity/iprophyalxis');?>/"+year+"/"+month);
		$("#partners").load("<?php echo base_url('charts/positivity/agegroup');?>/"+year+"/"+month);
		
		$("#county_outcomes").load("<?php echo base_url('charts/positivity/county_outcomes');?>/"+year+"/"+month); 
	}
</script>