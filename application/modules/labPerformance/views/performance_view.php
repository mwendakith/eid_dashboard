<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        LAB PERFORMANCE STATS ON EID <div class="display_range"></div>
      </div>
      <div class="panel-body" id="lab_perfomance_stats">
        <center><div class="loader"></div></center>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div id="graphs">
  	
  </div>

  <div id="stacked_graph" class="col-md-6">

  </div>
</div>

<div id="lineargauge">

</div>



<script type="text/javascript">

  $().ready(function() {
    $("#graphs").load("<?php echo base_url();?>charts/LabPerformance/testing_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes");
    $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround");
    $("#lab_perfomance_stats").load("<?php echo base_url();?>charts/LabPerformance/lab_performance_stats");
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

    var posting = $.post( '<?php echo base_url();?>summary/set_filter_date', { 'year': year, 'month': month } );

    // Put the results in a div
    posting.done(function( data ) {
      obj = $.parseJSON(data);
      
      if(obj['month'] == "null" || obj['month'] == null){
        obj['month'] = "";
      }
      $(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
      $(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
      
    });
    
    
    $("#stacked_graph").html("<div>Loading...</div>");
    $("#lineargauge").html("<div>Loading...</div>");

    if (criteria === "monthly") {
      
      $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes/"+year+"/"+month);
    $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround/"+year+"/"+month);
    }

    else{
      $("#graphs").html("<div>Loading...</div>");

      $("#graphs").load("<?php echo base_url();?>charts/LabPerformance/testing_trends/"+year);
      $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes/"+year+"/"+month);
      $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround/"+year+"/"+month);

    }


    
  }
   
</script>