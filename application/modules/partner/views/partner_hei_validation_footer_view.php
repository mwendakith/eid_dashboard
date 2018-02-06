<script type="text/javascript">
	$().ready(function(){
		$("#second").hide();
		localStorage.setItem("my_var", 1);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#hei_validation_table").load("<?php echo base_url('charts/hei/validation'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+1);

		//Function when the prtner is selected
		$("select").change(function(){
			em = $(this).val();
			var all = localStorage.getItem("my_var");
			
			// Send the data using post
			var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );

			posting.done(function( data ) {
				if (data == "") data = null;
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+true, function(data){
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
	        	$("#hei_validation_table").html("<center><div class='loader'></div></center>");
	        	$("#hei_validation_table").load("<?php echo base_url('charts/hei/validation');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+1+"/"+data);
	        });
		});

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
				$.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
					partner = data;
					// console.log(partner);
					$("#hei_validation_table").html("<center><div class='loader'></div></center>");

					$("#hei_validation_table").load("<?php echo base_url('charts/hei/validation');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+1+"/"+partner);
					
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
	    var all = localStorage.getItem("my_var");

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
			$.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
				partner = data;
				
				$("#hei_validation_table").html("<center><div class='loader'></div></center>");
		        
		        $("#hei_validation_table").load("<?php echo base_url('charts/hei/validation');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+1+"/"+partner);
			});
		});
	}
</script>