<div class="row">
  <div id="graphs">
  
  </div>


  <div id="stacked_graph">

  </div>
</div>

  


<script type="text/javascript">

  $().ready(function() {
    $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary");


    $("select").change(function(){
      var county_id = $(this).val();

      var posting = $.post( "<?php echo base_url();?>template/filter_county_data", { county: county_id } );

      $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends/"+county_id);
      $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary/"+county_id);
    });
  });
  
  $("select").change(function(){
    var county_id = $(this).val();

    $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends/"+county_id);
    $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary/"+county_id);
  });

  function get_graphs(year){
    $.ajax({
           url: "<?php echo base_url('charts/trends/positive_trends'); ?>/" + year,
           
           error: function(data) {
              $("#test").append(data);
           },
           dataType : "json",
           success: function(data) {
                
                
                $("#graphs").empty().append(data);
           },
           type: 'GET'
        });
  }

	
   
</script>