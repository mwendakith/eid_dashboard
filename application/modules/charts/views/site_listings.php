<div class="list-group" style="height: 362px;">
	<?php echo $facilities['ul'];?>
</div>
<button class="btn btn-primary"  onclick="expandSiteListing();" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">View Full Listing</button>

<div class="modal fade" tabindex="-1" role="dialog" id="expSiteList">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Faciilities Listing</h4>
      </div>
      <div class="modal-body">
        <table id="SiteList" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
        	<thead>
        		<tr>
        			<th>#</th>
        			<th>Name</th>
        			<?php
                if(isset($countys['requests'])){
                  echo "<th># of Requests</th>";
                }else{
                  echo "<th>% Positivity</th>";
                  echo "<th>Positives</th>";
                  echo "<th>Negatives</th>";
                }
              ?>
        		</tr>
        	</thead>
        	<tbody>
        		<?= @$facilities['table']; ?>
        	</tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#SiteList').DataTable({
      dom: '<"btn btn-primary"B>lTfgtip',
      responsive: true,
        buttons : [
            {
              text:  'Export to CSV',
              extend: 'csvHtml5',
              title: 'Download'
            },
            {
              text:  'Export to Excel',
              extend: 'excelHtml5',
              title: 'Download'
            }
          ]
		});

		// $("table").tablecloth({
		// 	theme: "paper",
		// 	striped: true,
		// 	sortable: true,
		// 	condensed: true
		// });
	});
	function expandSiteListing()
	{
		$('#expSiteList').modal('show');
	}
</script>