<script type="text/javascript">
	$().ready(function(){
		localStorage.setItem("my_var", 1);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#partner_tat_outcomes").load("<?= @base_url('charts/partner_summaries/partner_tat_outcomes'); ?>");

		//Function when the county is selected
		$("select").change(function(){
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );
	     
	        // Put the results in a div
	        posting.done(function( data ) {
	        	if (data=="") {data = 0;}
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
	        		
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
	        	
	        	if (data ==  ''  || data == 0) {
	        		// Loader displaying
		        	$("#partner_tat_outcomes").html("<center><div class='loader'></div></center>");

					$("#partner_tat_outcomes").load("<?php echo base_url('charts/partner_summaries/partner_tat_outcomes'); ?>");
	        	} else {
	        		// Loader displaying
		        	$("#partner_tat_outcomes").html("<center><div class='loader'></div></center>");

					$("#partner_tat_outcomes").load("<?php echo base_url('charts/partner_summaries/partner_tat_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
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
		    
		    from = format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 	= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    
		    if (!error_check) {
			    $("#partner_tat_outcomes").html("<center><div class='loader'></div></center>");
		        
				$("#partner_tat_outcomes").load("<?php echo base_url('charts/partner_summaries/partner_tat_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
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
 		
		var all = localStorage.getItem("my_var");

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
		});
 		$("#partner_tat_outcomes").html("<center><div class='loader'></div></center>");
    	
		$("#partner_tat_outcomes").load("<?php echo base_url('charts/partner_summaries/partner_tat_outcomes');?>/"+year+"/"+month); 
	}
</script>