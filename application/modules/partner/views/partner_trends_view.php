<div class="row">
  <div id="graphs">
  
  </div>


  <div id="stacked_graph" class="col-md-12">

  </div>
</div>

  


<script type="text/javascript">

  $().ready(function() {
    $("#graphs").load("<?php echo base_url();?>charts/PartnerTrends/partner_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/PartnerTrends/summary");


    $("select").change(function(){
      var part = $(this).val();

      var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: part } );
      posting.done(function( data ) {
            $.get("<?php echo base_url();?>template/breadcrum/"+data, function(data){
              $("#breadcrum").html(data);
            });
            $("#graphs").load("<?php echo base_url();?>charts/PartnerTrends/partner_trends/"+data);
            $("#stacked_graph").load("<?php echo base_url();?>charts/PartnerTrends/summary/"+data);
      });



      
    });
  });
  
     
</script>