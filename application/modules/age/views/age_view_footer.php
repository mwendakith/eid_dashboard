<script type="text/javascript">
	$(document).ready(function () {
		$("#summary").load("<?= base_url('charts/ages/get_age_summary');?>");
		$("#positivity").load("<?= base_url('charts/ages/get_age_positivity');?>");
		$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>");

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
	        	$("#summary").html("<center><div class='loader'></div></center>");
				$("#positivity").html("<center><div class='loader'></div></center>");
				$("#age_outcomes").html("<center><div class='loader'></div></center>");

				$("#summary").load("<?= base_url('charts/ages/get_age_summary');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
				$("#positivity").load("<?= base_url('charts/ages/get_age_positivity');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
				$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
	        });
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
			    $("#summary").html("<center><div class='loader'></div></center>");
				$("#positivity").html("<center><div class='loader'></div></center>");
				$("#age_outcomes").html("<center><div class='loader'></div></center>");

				$("#summary").load("<?= base_url('charts/ages/get_age_summary');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#positivity").load("<?= base_url('charts/ages/get_age_positivity');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
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
 		
		$("#summary").html("<div>Loading...</div>");
 		$("#positivity").html("<center><div class='loader'></div></center>");
 		$("#age_outcomes").html("<center><div class='loader'></div></center>"); 
		
		$("#summary").load("<?= base_url('charts/ages/get_age_summary');?>/"+year+"/"+month);
		$("#positivity").load("<?= base_url('charts/ages/get_age_positivity');?>/"+year+"/"+month);
		$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>/"+year+"/"+month);
	}
</script>