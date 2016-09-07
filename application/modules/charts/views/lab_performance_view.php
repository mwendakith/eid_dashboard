
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Testing Trends <div class="display_range"></div>
          </div>
          <div class="panel-body" id="tests">
            <center><div class="loader"></div></center>
          </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Reject Trends <div class="display_range"></div>
          </div>
          <div class="panel-body" id="rejects">
            <center><div class="loader"></div></center>
          </div>
        </div>
    </div>
    <!-- <div id="tests" class="col-md-6">
        
    </div> -->

    <!-- <div id="rejects" class="col-md-6">
        
    </div> -->
</div>


<div id="positivity" class="col-md-12">

</div>

<script type="text/javascript">

  
    $("<?php echo $div; ?>").highcharts({
        title: {
            text: "<?php echo $title; ?>",
            x: -20 //center
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: "Number of Tests"
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: <?php echo json_encode($trends);?>
            
    });
  

 
</script>