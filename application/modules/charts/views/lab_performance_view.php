
<?php
    echo "<div id=" . $div_name . " class='col-md-6'>

</div>";

?>


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
            verticalAlign: 'top',
            borderWidth: 0
        },
        series: <?php echo json_encode($trends);?>
            
    });
  

 
</script>