<script type="text/javascript">
	$().ready(function(){
		$("#second").hide();
		$("#third").hide();

		$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);

	});

	
</script>