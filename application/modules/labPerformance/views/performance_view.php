<div class="row">
  <div id="graphs">
  	
  </div>

  <div id="stacked_graph">

  </div>
</div>

<div id="lineargauge">

</div>



<script type="text/javascript">

  $().ready(function() {
    $("#graphs").load("<?php echo base_url();?>charts/LabPerformance/testing_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/LabPerformance/lab_outcomes");
    $("#lineargauge").load("<?php echo base_url();?>charts/LabPerformance/lab_turnaround");
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