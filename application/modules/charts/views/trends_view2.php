<div id="<?php echo $div_name ?>"></div>
<?php
    if(isset($export)){
?>
        <div class="row" id="excels">
            <div class="col-md-6 col-md-offset-3">
                <center><a href="<?php  echo $link; ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
            </div>
        </div>
<?php
    }
?>

<script type="text/javascript">
    $(function () {
        $('#<?php echo $div_name ?>').highcharts({
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: '<?php echo $trends['title'];?>'
            },
            xAxis: [{
                categories: <?php echo json_encode($trends['categories']);?>
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'<?= (isset($tat) ? @"": @"%"); ?>';
                    },
                    style: {
                        
                    }
                },
                title: {
                    text: '<?= (isset($tat) ? @"Days": @"Percentage"); ?>',
                    style: {
                        color: '#89A54E'
                    }
                },
                opposite: true
    
            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: '<?= (isset($tat) ? @"Days": @"Tests"); ?>',
                    style: {
                        color: '#4572A7'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +'';
                    },
                    style: {
                        color: '#4572A7'
                    }
                }
                // min: 0, 
                // max: 70000,
                // tickInterval: 1
            }],
            tooltip: {
                borderRadius: 2,
                borderWidth: 1,
                borderColor: '#999',
                shadow: false,
                shared: true,
                useHTML: true,
                yDecimals: 0,
                valueDecimale: 0,
                headerFormat: '<table class="tip"><caption>{point.key}</caption>'+'<tbody>',
                pointFormat: '<tr><th style="color:{series.color}">{series.name}:</th>'+'<td style="text-align:right">{point.y}</td></tr>',
                footerFormat: '<tr><th>Total:</th>'+'<td style="text-align:right"><b>{point.total}</b></td></tr>'+'</tbody></table>'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 15,
                floating: false,
                backgroundColor: '#FFFFFF'
            },navigation: {
                        buttonOptions: {
                            verticalAlign: 'bottom',
                            y: -20
                        }
                    },
            series: <?php echo json_encode($trends['outcomes']);?>
        });
    });
    
</script>