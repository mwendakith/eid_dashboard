<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div id="breadcrum" class="alert" style="background-color: #1BA39C;text-align: center;vertical-align: middle;" onclick="switch_source()">
          <span id="current_source">Click to toggle between quarterly and yearly</span>   
      </div>
         
  </div>
</div>

<div class="row">
  <div style="color:red;"><center>Click on Year(s)/Quarter(s) on legend to view only for the year(s)/quarter(s) selected</center></div>
  <div id="first">
    <div id="stacked_graph" class="col-md-12"></div>
    <div id="repeat_q" class="col-md-12"></div>
    <div id="alltests_q" class="col-md-12"></div>
    <div id="infants_q" class="col-md-12"></div>
    <div id="less2m_q" class="col-md-12"> </div>
    <div id="graphs"></div>

  </div>

  <div id="second">    
    <div id="q_outcomes" class="col-md-12"></div>
    <div id="q_graphs"></div>
  </div>
</div>

  

<script type="text/javascript">

  $().ready(function() {
    $("#year-month-filter").hide();
    $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary");
    
    $("#alltests_q").load("<?php echo base_url();?>charts/trends/alltests_q");
    $("#repeat_q").load("<?php echo base_url();?>charts/trends/repeat_q");
    $("#infants_q").load("<?php echo base_url();?>charts/trends/infants_q");
    $("#less2m_q").load("<?php echo base_url();?>charts/trends/less2m_q");

    localStorage.setItem("my_var", 0);


    $("select").change(function(){
      var county_id = $(this).val();

      var posting = $.post( "<?php echo base_url();?>template/filter_county_data", { county: county_id } );
      posting.done(function( data ) {
            $.get("<?php echo base_url();?>template/breadcrum/"+data, function(data){
              $("#breadcrum").html(data);
            });
      });

      var a = localStorage.getItem("my_var");

      if(a == 0){
        $("#first").show();
        $("#second").hide();

        $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends/"+county_id);
        $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary/"+county_id);
        $("#alltests_q").load("<?php echo base_url();?>charts/trends/alltests_q/"+county_id);
        $("#repeat_q").load("<?php echo base_url();?>charts/trends/repeat_q/"+county_id);
        $("#infants_q").load("<?php echo base_url();?>charts/trends/infants_q/"+county_id);
        $("#less2m_q").load("<?php echo base_url();?>charts/trends/less2m_q/"+county_id);
      }
      else{
        $("#first").hide();
        $("#second").show();
        $("#q_outcomes").load("<?php echo base_url();?>charts/trends/quarterly_outcomes/"+county_id);
        $("#q_graphs").load("<?php echo base_url();?>charts/trends/quarterly/"+county_id);
      }

    });
  });

  function switch_source(){
    var a = localStorage.getItem("my_var");

    if(a == 0){
      localStorage.setItem("my_var", 1);
      $("#first").hide();
      $("#second").show();
      $("#q_graphs").load("<?php echo base_url();?>charts/trends/quarterly/");
      $("#q_outcomes").load("<?php echo base_url();?>charts/trends/quarterly_outcomes/");
    }
    else{
      localStorage.setItem("my_var", 0);
      $("#first").show();
      $("#second").hide();

      $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends/");
      $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary/");
    
      $("#alltests_q").load("<?php echo base_url();?>charts/trends/alltests_q");
      $("#repeat_q").load("<?php echo base_url();?>charts/trends/repeat_q");
      $("#infants_q").load("<?php echo base_url();?>charts/trends/infants_q");
      $("#less2m_q").load("<?php echo base_url();?>charts/trends/less2m_q");
    }
  }
  
 

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