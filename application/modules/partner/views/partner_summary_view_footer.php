<script type="text/javascript">
	$().ready(function(){
		$("#second").hide();
		
		$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);

		$('select').change(function(){
			partner = $(this).val();
			alert(partner);

			$("#first").hide();
			$("#second").show();
		});

	});

	
</script>