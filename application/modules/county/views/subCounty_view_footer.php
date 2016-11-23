<script type="text/javascript">
	$().ready(function(){
		$.get("<?php echo base_url();?>template/breadcrum/"+null+"/"+null+"/"+null+"/"+1, function(data){
	        	$("#breadcrum").html(data);
	       });

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
	        	
	        });
	    });
	});
</script>