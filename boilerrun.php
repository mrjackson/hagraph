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
//line6 Boiler Run Percentage
$query = "SELECT * FROM (SELECT datetime, temperature FROM data WHERE sensorid = 12 ORDER BY rowid DESC LIMIT 7) ORDER BY datetime";
//$query = "SELECT datetime, temperature FROM data WHERE sensorid = 12 order by rowid desc limit 14";
//$query = array_reverse($query, true);
foreach ($dbh->query($query) as $row)
{
        $temp[] = "['" . $row["datetime"] . "'," . $row["temperature"] * 100 . "]"; 
}
print("var line6=[" . implode(",",$temp) . "]\n");
unset($query);
unset($temp); 
//line7 Daily temperature average
$query = "SELECT * FROM (SELECT substr(datetime,0,11) as datetime,avg(temperature) as temperature FROM data WHERE sensorid = 15 group by substr(datetime,0,11) order by rowid desc limit 7) ORDER BY datetime";
foreach ($dbh->query($query) as $row)
{    
        $temp[] = "['" . $row["datetime"] . "'," . $row["temperature"] . "]"; 
}
print("var line7=[" . implode(",",$temp) . "]\n");
unset($query);     
unset($temp);


unset($dbh);
 
?>
</script>


<script type="text/javascript">
$(document).ready(function() {
//$.jqplot('chart1',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]]);

//var line1=[['10-25-2011 19:30:02',73.0], ['10-25-2011 19:25:01',73.0], ['10-25-2011 19:20:02',73.0], ['10-25-2011 19:15:01',73.0], ['10-25-2011 19:10:02',73.0], ['10-25-2011 19:05:02',73.0], ['10-25-2011 19:00:01',73.0], ['10-25-2011 18:55:01',73.0]];
var line = $.jqplot('chart1', [line6], {
    title: 'Calling for Heat',
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
	renderer:$.jqplot.BarRenderer,
        pointLabels: { show: true },
        markerOptions:{ style:'diamond' },
        showMarker: false,
	fill: true,
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
           labels:['Percent Heat'],
           rendererOptions:{
               numberRows: 1
           },
           placement: 'outsideGrid',
           location: 's'
		},
    axes: {
        xaxis: {
            label: 'Date',
			renderer: $.jqplot.CategoryAxisRenderer,
            //renderer: $.jqplot.DateAxisRenderer,
            tickInterval: '1 day',
            tickOptions: {
                formatString: '%b %#d',
                angle: -30
            }

        },
        yaxis: {
            label: 'Percent', 
            tickOptions: {
                formatString: '%.1f'
            }
        }
    }
});

<?php
if ((include 'include/boiler-runtime.js') !== 1)
{
    die('Include failed.');
}
?>
<?php
if ((include 'include/temp-avg-outside.js') !== 1)
{
    die('Include failed.');
}
?>


})
</script>


</head>

<body>
<?php
        print strftime('%c');
        echo "<BR>";
?>
<div id="chart1" style="height:400px;width:1200px; "></div>
<div id="chart6" style="height:400px;width:1200px; "></div>
<div id="chart7" style="height:400px;width:1200px; "></div>
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
