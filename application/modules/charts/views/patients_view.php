<p style="height: 200px;">
	Total Patients : <?php echo number_format($patients); ?>  <br />
	Total Tests Done : <?php echo number_format($tests); ?>  <br />

</p>

<div style="height: 340px;">
<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
	<thead>
		<tr class="colhead">
			<th>Total Tests Tests</th>
			<th>1 Test</th>
			<th>2 Tests</th>
			<th>3 Tests</th>
			<th>> 3 Tests</th>
		</tr>
		
	</thead>
	<tbody>
		<?php echo $stats;?>
	</tbody>
</table>
</div>