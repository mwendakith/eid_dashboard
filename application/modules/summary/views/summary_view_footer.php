<script type="text/javascript">
	$().ready(function(){
		$("#testing_trends").load("<?php echo base_url('charts/summaries/testing_trends'); ?>");
		$("#eidOutcomes").load("<?php echo base_url('charts/summaries/eid_outcomes');?>");
		$("#hei_follow_up").load("<?php echo base_url('charts/summaries/hei_follow');?>");
		$("#ageGroups").load("<?php echo base_url('charts/summaries/agegroup');?>");

		$("#entry_point").load("<?php echo base_url('charts/summaries/testing_trends'); ?>");
		$("#mprophilaxis").load("<?php echo base_url('charts/summaries/eid_outcomes');?>");
		$("#iprophilaxis").load("<?php echo base_url('charts/summaries/hei_follow');?>");
		$("#feeding").load("<?php echo base_url('charts/summaries/agegroup');?>");

		$("#county").load("<?php echo base_url('charts/summaries/county_outcomes');?>");
	});
</script>