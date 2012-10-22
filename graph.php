
<!DOCTYPE html>
<html>
<head>
<?php
        $time = microtime();
        $time = explode(" ", $time);
        $time = $time[1] + $time[0];
        $start = $time;
?>
<meta http-equiv="refresh" content="300"> 

<script language="javascript" type="text/javascript" src="jqplot/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.logAxisRenderer.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.enhancedLegendRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.cursor.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.highlighter.min.js"></script>
<link rel="stylesheet" type="text/css" href="jqplot/jquery.jqplot.css" />

<?php
  $dbh = new PDO('sqlite:/home/mrjackson/data/temperature.sqlite');
?>

<script type="text/javascript">
<?php
 
$dbh = new PDO('sqlite:/home/mrjackson/data/temperature.sqlite');
//Line1 Temperature
$query = "SELECT datetime, temperature FROM data WHERE sensorid = 10 order by rowid desc limit 288";
foreach ($dbh->query($query) as $row)
{
        $temp[] = "['" . $row["datetime"] . "'," . $row["temperature"] . "]";
}
print("var line1=[" . implode(",",$temp) . "]\n");
unset($query);
unset($temp);
//line2 Setpoint
$query = "SELECT datetime, temperature FROM data WHERE sensorid = 11 order by rowid desc limit 288";
foreach ($dbh->query($query) as $row)
{
        $temp[] = "['" . $row["datetime"] . "'," . $row["temperature"] . "]";
}
print("var line2=[" . implode(",",$temp) . "]\n");
unset($query);
unset($temp);
//line3 Boiler In
$query = "SELECT datetime, temperature FROM data WHERE sensorid = 100 order by rowid desc limit 288";
foreach ($dbh->query($query) as $row)
{
        $temp[] = "['" . $row["datetime"] . "'," . $row["temperature"] . "]";
}
print("var line3=[" . implode(",",$temp) . "]\n");
unset($query);
unset($temp);
//line4 Boiler Out
$query = "SELECT datetime, temperature FROM data WHERE sensorid = 101 order by rowid desc limit 288";
foreach ($dbh->query($query) as $row)
{
        $temp[] = "['" . $row["datetime"] . "'," . $row["temperature"] . "]";
}
print("var line4=[" . implode(",",$temp) . "]\n");
unset($query);
unset($temp);
//line5 Outside temp
$query = "SELECT datetime, temperature FROM data WHERE sensorid = 15 order by rowid desc limit 288";
foreach ($dbh->query($query) as $row)
{
        $temp[] = "['" . $row["datetime"] . "'," . $row["temperature"] . "]";                 
}
print("var line5=[" . implode(",",$temp) . "]\n");
unset($query);
unset($temp);
//line6 Boiler Run Percentage
$query = "SELECT datetime, temperature FROM data WHERE sensorid = 12 order by rowid desc limit 14";
foreach ($dbh->query($query) as $row)
{
        $temp[] = "['" . $row["datetime"] . "'," . $row["temperature"] * 100 . "]"; 
}
print("var line6=[" . implode(",",$temp) . "]\n");               
unset($query);     
unset($temp);

unset($dbh);
 
?>
</script>


<script type="text/javascript">
$(document).ready(function() {
//$.jqplot('chart1',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]]);

//var line1=[['10-25-2011 19:30:02',73.0], ['10-25-2011 19:25:01',73.0], ['10-25-2011 19:20:02',73.0], ['10-25-2011 19:15:01',73.0], ['10-25-2011 19:10:02',73.0], ['10-25-2011 19:05:02',73.0], ['10-25-2011 19:00:01',73.0], ['10-25-2011 18:55:01',73.0]];
var line = $.jqplot('chart1', [line2, line1], {
    title: 'Thermostat',
    cursor: {
        show: true,
        showTooltip: false,
        zoom: true
    },
    highlighter: {
        show: true,
        useAxesFormatters: true
    },
    seriesDefaults: {
        pointLabels: { show: false },
        markerOptions:{ style:'diamond' },
        showMarker: false,
        breakOnNull: true
   },
    axesDefaults: {
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
        labelOptions: {
            fontSize: '13pt'
        }
    },
       legend:{
           renderer: $.jqplot.EnhancedLegendRenderer,
           show:true,
           labels:['Setpoint', 'Temperature'],
           rendererOptions:{
               numberRows: 1
           },
           placement: 'outsideGrid',
           location: 's'
		},
    axes: {
        xaxis: {
            label: 'Date',
            renderer: $.jqplot.DateAxisRenderer,
            tickInterval: '240 minutes',
            tickOptions: {
                formatString: '%b %#d %I:%M %p',
                angle: -30
            }

        },
        yaxis: {
            label: 'Temperature', 
            tickOptions: {
                formatString: '%.1f'
            }
        }
    }
});
var line = $.jqplot('chart2', [line3, line4], {
    title: 'Boiler',
    cursor: {
        show: true,
        showTooltip: false,
        zoom: true
    }, 

    highlighter: {
        show: true,
        useAxesFormatters: true
    }, 
    seriesDefaults: {
        pointLabels: { show: false },
        markerOptions:{ style:'diamond' },
        showMarker: false
   },
    axesDefaults: {
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
        labelOptions: {
            fontSize: '13pt'
        }
    },
       legend:{
           renderer: $.jqplot.EnhancedLegendRenderer,
           show:true,
           labels:['Boiler-In', 'Boiler-Out'],
           rendererOptions:{
               numberRows: 1
           },
           placement: 'outsideGrid',
           location: 's'
                },
    axes: {
        xaxis: {
            label: 'Date',    
            renderer: $.jqplot.DateAxisRenderer,
            tickInterval: '240 minutes',
            tickOptions: {
                formatString: '%b %#d %I:%M %p',
                angle: -30
            }

        },         
        yaxis: {          
            label: 'Temperature',
            tickOptions: {
                formatString: '%.1f',
                angle: -30    
            }
        }
    }
});
var line = $.jqplot('chart3', [line2, line1, line5], {
    title: 'Thermostat',
    cursor: {
        show: true,     
        showTooltip: false,
        zoom: true
    },          
    highlighter: {        
        show: true,
        useAxesFormatters: true         
    },
    seriesDefaults: {
        pointLabels: { show: false },
        markerOptions:{ style:'diamond' },
        showMarker: false,
        breakOnNull: true
   },           
    axesDefaults: {              
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
        labelOptions: {             
            fontSize: '13pt'
        }
    },
       legend:{
           renderer: $.jqplot.EnhancedLegendRenderer,
           show:true,
           labels:['Setpoint', 'Temperature', 'Outside'],
           rendererOptions:{
               numberRows: 1
           },     
           placement: 'outsideGrid',
           location: 's'
                },
    axes: {        
        xaxis: {                        
            label: 'Date',
            renderer: $.jqplot.DateAxisRenderer,
            tickInterval: '240 minutes',
            tickOptions: {                
                formatString: '%b %#d %I:%M %p',
                angle: -30
            }                    

        },                          
        yaxis: {            
            label: 'Temperature',
            tickOptions: {
                formatString: '%.1f'
            }
        }            
    }
});
chart6 = $.jqplot('chart6', [line6], {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
		pointLabels: {
			show: true,
			formatString: '%d\%',
		}
	},
        axesDefaults: {        
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                labelOptions: {
                        fontSize: '13pt'
                }
        },
        axes: {           
                xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                }
        },         
        highlighter: { show: false }
        });

})
</script>
</head>

<body>
<?php
        print strftime('%c');
        echo "<BR>";
?>
<div id="chart1" style="height:400px;width:1200px; "></div>
<div id="chart3" style="height:400px;width:1200px; "></div>
<div id="chart2" style="height:600px;width:1200px; "></div>
<div id="chart6" style="height:600px;width:1200px; "></div>

<?php
        $time = microtime();
        $time = explode(" ", $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $totaltime = ($finish - $start);
        echo "Server Compile Time: $totaltime Seconds.";
?>
</body>
</html>
