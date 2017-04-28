<script type="text/javascript">
	$(document).ready(function () {
		$("#summary").load("<?= base_url('charts/ages/get_age_summary');?>");
		$("#positivity").load("<?= base_url('charts/ages/get_age_positivity');?>");
		$("#age_outcomes").load("<?= base_url('charts/ages/get_age_outcomes');?>");
	});
</script>