<script type="text/javascript">
	$().ready(function(){
		$("#second").hide();
		$("#county_outcomes").load("<?php echo base_url('charts/summaries/county_outcomes');?>");

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
	        	}else {
	        		$("#first").hide();
					$("#second").show();
					// Loader displaying
		        	$("#subcounty_outcomes").html("<center><div class='loader'></div></center>");
		        	$("#county_sites_details").html("<center><div class='loader'></div></center>");
		        	// Actual graphs being loaded
					$("#subcounty_outcomes").load("<?php echo base_url('charts/counties/subCounties_outcomes'); ?>/"+null+"/"+null+"/"+data);
					$("#county_sites_details").load("<?php echo base_url('charts/counties/county_sites_details'); ?>/"+null+"/"+null+"/"+data);
	        	}
	        });
		});
	});
</script>