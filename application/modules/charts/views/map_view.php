<div id="counties_map" style="height: 700px">

</div>


<script type="text/javascript">
	$(function () {
        // Initiate the chart
        $('#counties_map').highcharts('Map', {
            title: {
                text: <?php echo json_encode($title);?>
            },
            legend: {
                enabled: true
            },
            
            series: [
                {
                    "name" : "data",
                    "type": "map",
                    "mapData": kenya_map,
                    "data" : <?php echo json_encode($outcomes);?>,
                    "joinBy": ['id', 'id'],
                    "dataLabels": {
                            enabled: true,
                            color: '#FFFFFF',
                            format: '{point.name}'
                        },
                    "point":{
                        "events":{
                            click: function(){
                                // set_table(this.id, this.name);
                            }
                        }
                    },
                    "tooltip": {
                        "valueSuffix": ""
                    }
                }
            ],

            colorAxis: {},

            mapNavigation: {
                enabled: true,
                enableButtons: true
            },
       
        
        });

    });
</script>