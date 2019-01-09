<script type="text/javascript">
	$(document).ready(function () {
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_year").html("( "+obj['year']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#trends").load("<?= base_url('charts/rht/get_trends');?>");
		$("#outcomes").load("<?= base_url('charts/rht/get_outcomes');?>");
		$("#gender").load("<?= base_url('charts/rht/get_gender');?>");
		$("#yearly_trends").load("<?= base_url('charts/rht/get_yearly_trends');?>");
		$("#positivity").load("<?= base_url('charts/rht/get_positivity');?>");
		$("#negativity").load("<?= base_url('charts/rht/get_negativity');?>");
		$("#facilities").load("<?= base_url('charts/rht/get_facilities');?>");

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
						$(".display_year").html("( "+obj['year']+" )");
						$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
		        	});
	        	$("#trends").html("<center><div class='loader'></div></center>");
				$("#outcomes").html("<center><div class='loader'></div></center>");
				$("#gender").html("<center><div class='loader'></div></center>");
				$("#yearly_trends").html("<center><div class='loader'></div></center>");
				$("#positivity").html("<center><div class='loader'></div></center>");
				$("#negativity").html("<center><div class='loader'></div></center>");
				$("#facilities").html("<center><div class='loader'></div></center>");

				$("#trends").load("<?= base_url('charts/rht/get_trends');?>/"+data);
				$("#outcomes").load("<?= base_url('charts/rht/get_outcomes');?>/"+data);
				$("#gender").load("<?= base_url('charts/rht/get_gender');?>/"+data);
				$("#yearly_trends").load("<?= base_url('charts/rht/get_yearly_trends');?>/"+data);
				$("#positivity").load("<?= base_url('charts/rht/get_positivity');?>/"+data);
				$("#negativity").load("<?= base_url('charts/rht/get_negativity');?>/"+data);
				$("#facilities").load("<?= base_url('charts/rht/get_facilities');?>/"+data);

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

		    var n = from[0] - 1;

		    $(".display_range").html("( "+n+" - "+from[0]+" )");
		    $(".display_year").html("( "+from[0]+" )");
		    var error_check = check_error_date_range(from, to);
		    // alert(error_check);
		    if (!error_check) {

				$("#trends").html("<center><div class='loader'></div></center>");
				$("#outcomes").html("<center><div class='loader'></div></center>");
				$("#gender").html("<center><div class='loader'></div></center>");
				$("#positivity").html("<center><div class='loader'></div></center>");
				$("#negativity").html("<center><div class='loader'></div></center>");
				$("#facilities").html("<center><div class='loader'></div></center>");

				$("#trends").load("<?= base_url('charts/rht/get_trends');?>/"+null+"/"+from[1]);
				$("#outcomes").load("<?= base_url('charts/rht/get_outcomes');?>/"+null+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#gender").load("<?= base_url('charts/rht/get_gender');?>/"+null+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#positivity").load("<?= base_url('charts/rht/get_positivity');?>/"+null+"/"+from[1]);
				$("#negativity").load("<?= base_url('charts/rht/get_negativity');?>/"+null+"/"+from[1]);
				$("#facilities").load("<?= base_url('charts/rht/get_facilities');?>/"+null+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
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
			$(".display_year").html("( "+obj['year']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
			$("#trends").html("<center><div class='loader'></div></center>");
			$("#outcomes").html("<center><div class='loader'></div></center>");
			$("#gender").html("<center><div class='loader'></div></center>");
			$("#positivity").html("<center><div class='loader'></div></center>");
			$("#negativity").html("<center><div class='loader'></div></center>");
			$("#facilities").html("<center><div class='loader'></div></center>");

			$("#trends").load("<?= base_url('charts/rht/get_trends');?>/"+null+"/"+year);
			$("#outcomes").load("<?= base_url('charts/rht/get_outcomes');?>/"+null+"/"+year+"/"+month);
			$("#gender").load("<?= base_url('charts/rht/get_gender');?>/"+null+"/"+year+"/"+month);
			$("#positivity").load("<?= base_url('charts/rht/get_positivity');?>/"+null+"/"+year);
			$("#negativity").load("<?= base_url('charts/rht/get_negativity');?>/"+null+"/"+year);
			$("#facilities").load("<?= base_url('charts/rht/get_facilities');?>/"+null+"/"+year+"/"+month);
		});
	}
</script>