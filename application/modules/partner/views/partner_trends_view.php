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
    <div id="stacked_graph" class="col-md-12">

    </div>

    <div id="repeat_q" class="col-md-12">

    </div>

    <div id="alltests_q" class="col-md-12">

    </div>

    <div id="infants_q" class="col-md-12">

    </div>

    <div id="less2m_q" class="col-md-12">

    </div>

    <div id="graphs">
    
    </div>

  </div>

  <div id="second">
    
    <div id="q_outcomes" class="col-md-12">
    
    </div>

    <div id="q_graphs">
    
    </div>

  </div>


  
</div>
  


<script type="text/javascript">

  $().ready(function() {
    $("#graphs").load("<?php echo base_url();?>charts/PartnerTrends/partner_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/PartnerTrends/summary");

    $("#alltests_q").load("<?php echo base_url();?>charts/PartnerTrends/alltests_q");
    $("#repeat_q").load("<?php echo base_url();?>charts/PartnerTrends/repeat_q");
    $("#infants_q").load("<?php echo base_url();?>charts/PartnerTrends/infants_q");
    $("#less2m_q").load("<?php echo base_url();?>charts/PartnerTrends/less2m_q");

    localStorage.setItem("my_var", 0);


    $("select").change(function(){
      var part = $(this).val();

      var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: part } );
      posting.done(function( data ) {
        if (data=="") {data = 0;}
        $.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
          $("#breadcrum").html(data);
        });
      });


      var a = localStorage.getItem("my_var");

      if(a == 0){
        $("#first").show();
        $("#second").hide();

        $("#graphs").load("<?php echo base_url();?>charts/PartnerTrends/partner_trends/"+part);
        $("#stacked_graph").load("<?php echo base_url();?>charts/PartnerTrends/summary/"+part);
        $("#alltests_q").load("<?php echo base_url();?>charts/PartnerTrends/alltests_q/"+part);
        $("#repeat_q").load("<?php echo base_url();?>charts/PartnerTrends/repeat_q/"+part);
        $("#infants_q").load("<?php echo base_url();?>charts/PartnerTrends/infants_q/"+part);
        $("#less2m_q").load("<?php echo base_url();?>charts/PartnerTrends/less2m_q/"+part);
      }
      else{
        $("#first").hide();
        $("#second").show();
        $("#q_outcomes").load("<?php echo base_url();?>charts/PartnerTrends/quarterly_outcomes/"+part);
        $("#q_graphs").load("<?php echo base_url();?>charts/PartnerTrends/quarterly/"+part);
      }

        // $("#graphs").load("<?php //echo base_url();?>charts/PartnerTrends/partner_trends/"+data);
        // $("#stacked_graph").load("<?php //echo base_url();?>charts/PartnerTrends/summary/"+data);
      
    });
  });

  function switch_source(){
    var a = localStorage.getItem("my_var");

    if(a == 0){
      localStorage.setItem("my_var", 1);
      $("#first").hide();
      $("#second").show();
      $("#q_graphs").load("<?php echo base_url();?>charts/PartnerTrends/quarterly/");
      $("#q_outcomes").load("<?php echo base_url();?>charts/PartnerTrends/quarterly_outcomes/");
    }
    else{
      localStorage.setItem("my_var", 0);
      $("#first").show();
      $("#second").hide();

      $("#graphs").load("<?php echo base_url();?>charts/PartnerTrends/partner_trends/");
      $("#stacked_graph").load("<?php echo base_url();?>charts/PartnerTrends/summary/");
    
      $("#alltests_q").load("<?php echo base_url();?>charts/PartnerTrends/alltests_q");
      $("#repeat_q").load("<?php echo base_url();?>charts/PartnerTrends/repeat_q");
      $("#infants_q").load("<?php echo base_url();?>charts/PartnerTrends/infants_q");
      $("#less2m_q").load("<?php echo base_url();?>charts/PartnerTrends/less2m_q");
    }
  }
  
     
</script>