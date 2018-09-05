
<?php
    isset($class) ? $cls = $class : $cls = '';
    echo "<div id=" . $div_name . " ".$cls.">

</div>";

?>


<script type="text/javascript">

  
    $("#<?php echo $div_name; ?>").highcharts({
        title: {
            text: "<?= @$title; ?>",
            x: -20 //center
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: "<?php echo $yAxis; ?>"
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: "<?php echo $suffix; ?>",

        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'bottom',
            floating: false,
            borderWidth: 0
        },
        series: <?php echo json_encode($trends);?>
            
    });
  

 
</script>