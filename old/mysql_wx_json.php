<html>
<head>
  <!-- Plotly.js -->
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<?php

$databasehost = "localhost";
$databasename = "kksixgpv_repo";
$databaseusername="kksixgpv_repo";
$databasepassword = "+U0bzMWSxHla";

$period = $_GET["period"];
$sid = 'KCABAKER27';

if ($period == 'today') {
    $start = gmdate("Y-m-d",strtotime('-10 hours')); 
    $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); 
    $gb = 'date(delta.time), hour(delta.time), round(minute(delta.time)/10,0)*10';
}
elseif ($period == 'week') {
    $start = gmdate("Y-m-d",strtotime('-1 week -10 hours')); 
    $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); 
    $gb = 'date(delta.time), hour(delta.time), round(minute(delta.time)/10,0)*10';
}
elseif ($period == 'month') {
    $start = gmdate("Y-m-d",strtotime('-1 month -10 hours')); 
    $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); 
    $gb = 'date(delta.time), hour(delta.time), round(minute(delta.time)/30,0)*30';
}
elseif ($period == 'year') {
    $start = gmdate("Y-m-d",strtotime('-1 year -16 hours')); 
    $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); 
    $gb = 'date(delta.time), round(hour(delta.time)/6,0)*6';
}
else {
    $start = gmdate("Y-m-d",strtotime('-8 years -16 hours'));
    $end = gmdate("Y-m-d",strtotime('+1 days -8 hours'));
    $gb = 'date(delta.time), round(hour(delta.time)/6,0)*6';
};

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query_data = "SELECT min(delta.time) AS time,
                ROUND(avg(delta.temp),1) AS temp,
                ROUND(avg(delta.dewpt),1) AS dewpt,
                ROUND(avg(delta.pres),2) AS pres,
                ROUND(avg(delta.winddir),0) AS winddir,
                ROUND(avg(delta.windspeed),1) AS windspeed,
                ROUND(avg(delta.windgust),1) AS windgust,
                ROUND(avg(delta.hum),1) AS hum,
                ROUND(avg(delta.preciphr),2) AS preciphr,
                ROUND(max(delta.precipday),2) AS precipday, 
                ROUND(avg(delta.solarrad),0) AS solarrad,
                ROUND(avg(delta.uv),0) AS uv,
                ROUND(avg(delta.dtemp / delta.dtime),3) AS dtdt,
                ROUND(avg(delta.dpres / delta.dtime),3) AS dpdt,
                ROUND(avg(((delta.temp - delta.dewpt) / 4.4) * 1000 + 400),0) AS cloudbase
                FROM (SELECT filter.*,
                      timediff(filter.time,@lastTime)/6000 AS dtime,
                      filter.temp - @lastTemp AS dtemp,
                      filter.pres - @lastPres AS dpres,
                      @lastTime := filter.time,
                      @lastTemp := filter.temp,
                      @lastPres := filter.pres 
                     FROM v_wx_filter filter, ( select @lastTime := 0, @lastTemp := 0, @lastPres := 0 ) SQLVars
                      WHERE filter.sid = '$sid'
                      ORDER BY filter.time) delta
                WHERE (date(delta.time) between '$start' and '$end')
                GROUP BY $gb
                ORDER BY delta.time ASC";
$result = mysqli_query($con, $query_data);
$time = array();
$temp = array();
$dewpt = array();
$pres = array();
$winddir = array();
$windspeed = array();
$windgust = array();
$hum = array();
$preciphr = array();
$precipday = array();
$solarrad = array();
$uv = array();
$dtdt = array();
$dpdt = array();
$cloudbase = array();
while($row = mysqli_fetch_assoc($result)){
    $time[] = $row['time'];
    $temp[] = $row['temp'];
    $dewpt[] = $row['dewpt'];
    $pres[] = $row['pres'];
    $winddir[] = $row['winddir'];
    $windspeed[] = $row['windspeed'];
    $windgust[] = $row['windgust'];
    $hum[] = $row['hum'];
    $preciphr[] = $row['preciphr'];
    $precipday[] = $row['precipday'];
    $solarrad[] = $row['solarrad'];
    $uv[] = $row['uv'];
    $dtdt[] = $row['dtdt'];
    $dpdt[] = $row['dpdt'];
    $cloudbase[] = $row['cloudbase'];
}

$query_totclm = "SELECT count(windspeed_cat) / 100 AS total, 
                SUM(CASE WHEN windspeed_cat = 'calm' THEN 1 ELSE 0 END) AS calm 
                FROM v_wx_wind 
                WHERE v_wx_wind.sid = '$sid'
                AND (date(v_wx_wind.time) between '$start' and '$end')";
$result = mysqli_query($con, $query_totclm);
$row =  mysqli_fetch_assoc($result);
$total = $row['total'];
$calm = $row['calm'];

$query_dirs = "select count(cat)-1 AS dirs ".
            "from t_wx_windrose_drange";
$result = mysqli_query($con, $query_dirs);
$row =  mysqli_fetch_assoc($result);
$dirs = $row['dirs'];

$query_wr = "SELECT drange.cat as `wdircat`,
            (round($calm / $dirs, 0)) / $total AS `calm`,
            (round($calm / $dirs, 0) + w.`1mph`) / $total AS `1mph`,
            (round($calm / $dirs, 0) + w.`1mph` + w.`1to2mph`) / $total AS `1to2mph`,
            (round($calm / $dirs, 0) + w.`1mph` + w.`1to2mph` + w.`2to5mph`) / $total AS `2to5mph`,
            (round($calm / $dirs, 0) + w.`1mph` + w.`1to2mph` + w.`2to5mph` + w.`5to10mph`) / $total AS `5to10mph`,
            (round($calm / $dirs, 0) + w.`1mph` + w.`1to2mph` + w.`2to5mph` + w.`5to10mph` + w.`10mph`) / $total AS `10mph`
            FROM t_wx_windrose_drange drange
            LEFT JOIN (select wind.winddir_cat AS cat,
                       SUM(case when wind.windspeed_cat = 'calm' then 1 else 0 end) AS `calm`,
                       SUM(case when wind.windspeed_cat = '1mph' then 1 else 0 end) AS `1mph`,
                       SUM(case when wind.windspeed_cat = '1to2mph' then 1 else 0 end) AS `1to2mph`,
                       SUM(case when wind.windspeed_cat = '2to5mph' then 1 else 0 end) AS `2to5mph`,
                       SUM(case when wind.windspeed_cat = '5to10mph' then 1 else 0 end) AS `5to10mph`,
                       SUM(case when wind.windspeed_cat = '10mph' then 1 else 0 end) AS `10mph`
                       FROM v_wx_wind wind
                       WHERE wind.sid = '$sid'
                       AND (date(wind.time) between '$start' and '$end')
                       GROUP BY wind.winddir_cat) w
            ON drange.cat = w.cat
            GROUP BY drange.cat
            ORDER BY field(drange.cat,'N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW')";
$result = mysqli_query($con, $query_wr);
$wdircat = array();
$wcalm = array();
$w1mph = array();
$w1to2mph = array();
$w2to5mph = array();
$w5to10mph = array();
$w10mph = array();
while($row = mysqli_fetch_assoc($result)){
    $wdircat[] = $row['wdircat'];
    $wcalm[] = $row['calm'];
    $w1mph[] = $row['1mph'];
    $w1to2mph[] = $row['1to2mph'];
    $w2to5mph[] = $row['2to5mph'];
    $w5to10mph[] = $row['5to10mph'];
    $w10mph[] = $row['10mph'];
}

//$data = [ [
//    "period" => $period,
//    "start" => $start,
//    "end" => $end,
//    "time" => $time,
//    "temp" => $temp,
//    "dewpt" => $dewpt,
//    "pres" => $pres,
//    "winddir" => $winddir,
//    "windspeed" => $windspeed,
//    "windgust" => $windgust,
//    "hum" => $hum,
//    "preciphr" => $preciphr,
//    "precipday" => $precipday,
//    "solarrad" => $solarrad,
//    "uv" => $uv,
//    "dtdt" => $dtdt,
//    "dpdt" => $dpdt,
//    "cloudbase" => $cloudbase,
//    "total" => $total,
//    "calm" => $calm,
//    "dirs" => $dirs,
//    "wdircat" => $wdircat,
//    "wcalm" => $wcalm,
//    "w1mph" => $w1mph,
//    "w1to2mph" => $w1to2mph,
//    "w2to5mph" => $w2to5mph,
//    "w5to10mph" => $w5to10mph,
//    "w10mph" => $w10mph,
//] ];
//$json = json_encode($data);

mysqli_close($con);
?>

<body>

<h4 align=center>Weather Station - KCABAKER38 - <?php echo $time;?></h4>

<table bgcolor="#F0FFFF">
    <tr>
    <td><div align=center id="wx_combo" width="100%"></div></td>
    </tr>
    <tr>
    <td><div align=center id="wx_wr" width="100%"></div></td>
    </tr>
</table>    
<table bgcolor="#F0FFFF">
    <tr>
    <td width="50%"><div align=center id="wx_Tdh" width="100%"></div></td>
    <td width="50%"><div align=center id="wx_dTdtd" width="100%"></div></td>
    </tr>
    <tr>
    <td width="50%"><div align=center id="wx_dTdts" width="100%"></div></td>
    <td width="50%"><div align=center id="wx_dPdts" width="100%"></div></td>
    </tr>
</table>

<script>
var period = '<?php echo $period; ?>';
var start = '<?php echo $start; ?>';
var end = '<?php echo $end; ?>';
var time = <?php echo '["'; echo implode('", "', $time); echo '"]'; ?>;
var temp = <?php echo '['; echo implode(', ', $temp); echo ']'; ?>;
var dewpt = <?php echo '['; echo implode(', ', $dewpt); echo ']'; ?>;
var pres = <?php echo '['; echo implode(', ', $pres); echo ']'; ?>;
var winddir = <?php echo '['; echo implode(', ', $winddir); echo ']'; ?>;
var windspeed = <?php echo '['; echo implode(', ', $windspeed); echo ']'; ?>;
var windgust = <?php echo '['; echo implode(', ', $windgust); echo ']'; ?>;
var hum = <?php echo '['; echo implode(', ', $hum); echo ']'; ?>;
var preciphr = <?php echo '['; echo implode(', ', $preciphr); echo ']'; ?>;
var precipday = <?php echo '['; echo implode(', ', $precipday); echo ']'; ?>;
var solarrad = <?php echo '['; echo implode(', ', $solarrad); echo ']'; ?>;
var uv = <?php echo '['; echo implode(', ', $uv); echo ']'; ?>;
var dtdt = <?php echo '['; echo implode(', ', $dtdt); echo ']'; ?>;
var dpdt = <?php echo '['; echo implode(', ', $dpdt); echo ']'; ?>;
var cloudbase = <?php echo '['; echo implode(', ', $cloudbase); echo ']'; ?>;
var total = '<?php echo $total; ?>';
var calm = '<?php echo $calm; ?>';
var dirs = '<?php echo $dirs; ?>';
var wdircat = <?php echo '["'; echo implode('", "', $wdircat); echo '"]'; ?>;
var wcalm = <?php echo '['; echo implode(', ', $wcalm); echo ']'; ?>;
var w1mph = <?php echo '['; echo implode(', ', $w1mph); echo ']'; ?>;
var w1to2mph = <?php echo '['; echo implode(', ', $w1to2mph); echo ']'; ?>;
var w2to5mph = <?php echo '['; echo implode(', ', $w2to5mph); echo ']'; ?>;
var w5to10mph = <?php echo '['; echo implode(', ', $w5to10mph); echo ']'; ?>;
var w10mph = <?php echo '['; echo implode(', ', $w10mph); echo ']'; ?>;

scl = [[0, 'rgb(0, 0, 200)'],
    [0.143,'rgb(0, 25, 255)'],
    [0.286,'rgb(0, 152, 255)'],
    [0.429,'rgb(44, 255, 150)'],
    [0.571,'rgb(151, 255, 0)'],
    [0.714,'rgb(255, 234, 0)'],
    [0.857,'rgb(255, 111, 0)'],
    [1,'rgb(255, 0, 0)']];
        
scl_Tdh = [[0, 'rgb(0, 0, 200)'],
    [0.333,'rgb(0, 25, 255)'],
    [0.666,'rgb(0, 152, 255)'],
    [1,'rgb(44, 255, 150)']];

var wr_calm = {
  r: wcalm, t: wdircat,
  name: 'calm',
  marker: {color: '#3366ff',line: {color: '#3366ff'},},
  type: 'area',
};

var wr_1 = {
  r: w1mph, t: wdircat,
  name: '0-1 mph',
  marker: {color: '#009999',line: {color: '#009999'},},
  type: 'area',
};

var wr_2 = {
  r: w1to2mph, t: wdircat,
  name: '1-2 mph',
  marker: {color: '#00cc00',line: {color: '#00cc00'},},
  type: 'area',
};

var wr_3 = {
  r: w2to5mph, t: wdircat,
  name: '2-5 mph',
  marker: {color: '#bfff00',line: {color: '#bfff00'},},
  type: 'area',
};

var wr_4 = {
  r: w5to10mph, t: wdircat,
  name: '5-10 mph',
  marker: {color: '#ffcc00',line: {color: '#ffcc00'},},
  type: 'area',
};

var wr_5 = {
  r: w10mph, t: wdircat,
  name: '>10 mph',
  marker: {color: '#ffff00',line: {color: '#ffff00'},},
  type: 'area',
};

var traces_wr = [wr_5, wr_4, wr_3, wr_2, wr_1, wr_calm];

var layout_wr = {
  height: 600,
  width: 600,
  orientation: 270,
  paper_bgcolor: '#F0FFFF',
  plot_bgcolor: '#FFFFFF',
  margin: {l: 20, r: 20, b: 20, t: 20, pad: 4},
  radialaxis: {visible: false, range: [0,15],},
  //barmode: 'stack',
};
           
var traces_dPdts = [{
    x: windspeed, y: dpdt,
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: temp,
        cmin: 0,
        cmax: 120,
        colorscale: scl,
        size: 8,
        symbol: 'x',
        colorbar:{
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            dtick: 20,
            bgcolor: '#F0FFFF',
        }
    }
}];
    
var layout_dPdts = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'dPdt (inHg/hr)', fixedrange: true, range: [-0.1, 0.1],},
    xaxis: {title: 'Windspeed (mph)', fixedrange: true,},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_dTdts = [{
    x: solarrad, y: dtdt,
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: temp,
        cmin: 0,
        cmax: 120,
        colorscale: scl,
        size: 8,
        symbol: 'x',
        colorbar:{
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            dtick: 20,
            bgcolor: '#F0FFFF',
        }
    }
}];
    
var layout_dTdts = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'dTdt (F/hr)', fixedrange: true, range: [-10, 10],},
    xaxis: {title: 'Solar Radiation (W/m^2)', fixedrange: true, range: [0, 1000],},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_Tdh = [{
    x: dewpt, y: temp,
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: hum,
        colorscale: scl_Tdh,
        size: 8,
        symbol: 'x',
        colorbar:{
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            ticksuffix: '%',
            dtick: 10,
            bgcolor: '#F0FFFF',
        }
    },
    
}];
    
var layout_Tdh = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'Temp (F)', fixedrange: true, range: [0, 120],},
    xaxis: {title: 'Dewpoint (F)', fixedrange: true, range: [0, 120],},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_dTdtd = [{
    x: time, y: temp,
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: dtdt,
        cmin: -7.0,
        cmax: 7.0,
        colorscale: scl,
        size: 8,
        symbol: 'x',
        colorbar:{
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            dtick: 1,
            bgcolor: '#F0FFFF',
        }
    }
}];

var layout_dTdtd = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'Temp (F)', fixedrange: true, range: [0, 120]},
    xaxis: {type: 'date',title: 'Date / Time',},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_combo = [{
    x: time, y: windgust,
    name: 'Wind Gust (mph)',
    xaxis: 'x',
    yaxis: 'y',
    line: {color: '#15b259', width: 1.5,}
},{
	x: time, y: windspeed,
    name: 'Wind Speed (mph)',
    xaxis: 'x',
    yaxis: 'y',
    line: {color: '#a7e54b',width: 1.5,}
},{
	x: time, y: winddir,
    name: 'Wind Direction (deg)',
    xaxis: 'x',
    yaxis: 'y10',
    type: 'scatter',
    mode: 'markers',
    marker: {color: '#ff0000',size: 8,symbol: 'x',}
},{
	x: time, y: cloudbase,
    name: 'Min Cloudbase (ft)',
    xaxis: 'x2',
    yaxis: 'y2',
    line: {color: '#ff00d4',width: 1.5,}
},{
	x: time, y: solarrad,
    name: 'Solar Rad (W/m^2)',
    xaxis: 'x2',
    yaxis: 'y9',
    line: {color: '#ff9900',width: 1.5,}
},{
	x: time, y: hum,
    name: 'Humidty (%)',
    xaxis: 'x3',
    yaxis: 'y3',
    line: {color: '#ffea2d',width: 1.5,}
},{
	x: time, y: pres,
    name: 'Pressure (inHg)',
    xaxis: 'x3',
    yaxis: 'y8',
    line: {color: '#157248',width: 1.5,}
},{
	x: time, y: preciphr,
    name: 'Precip Hourly (in/hr)',
    xaxis: 'x4',
    yaxis: 'y4',
    line: {color: '#00ddff',width: 1.5,}
},{
	x: time, y: precipday,
    name: 'Precip Daily (in)',
    xaxis: 'x4',
    yaxis: 'y7',
    line: {color: '#0090ff',width: 1.5,}
},{
	x: time, y: temp,
    name: 'Temp (F)',
    xaxis: 'x5',
    yaxis: 'y5',
    line: {color: '#f92500',width: 1.5,}
},{
	x: time, y: dewpt,
    name: 'Dewpoint (F)',
    xaxis: 'x5',
    yaxis: 'y6',
    line: {color: '#00b2ff',width: 1.5,}
}];

var layout_combo = {
    showlegend: false,
    height: 1200,
    yaxis: {domain: [0.02, 0.18], title: 'Windspeed / Gust (mph)', fixedrange: true,},
    yaxis10: {title: 'Wind Direction (deg)', overlaying: 'y', side: 'right', range: [0, 360], fixedrange: true,},
    xaxis5: {anchor: 'y5', type: 'date', fixedrange: true, range: [start, end]},
    xaxis4: {anchor: 'y4', type: 'date', fixedrange: true, range: [start, end]},
    xaxis3: {anchor: 'y3', type: 'date', fixedrange: true, range: [start, end]},
    xaxis2: {anchor: 'y2', type: 'date', fixedrange: true, range: [start, end]},
    yaxis2: {domain: [0.22, 0.38], title: 'Min Cloudbase (ft)', fixedrange: true,},
    yaxis9: {title: 'Solar Radiation (W/m^2)', overlaying: 'y2', side: 'right', fixedrange: true,},
    yaxis3: {domain: [0.42, 0.58], title: 'Humidity (%)', range: [0, 100], fixedrange: true,},
    yaxis8: {title: 'Pressure (inHg)', overlaying: 'y3', side: 'right', fixedrange: true,},
    yaxis4: {domain: [0.62, 0.78], title: 'Precip Hourly (in/hr)', fixedrange: true,},
    yaxis7: {title: 'Precip Daily (in)', overlaying: 'y4', side: 'right', fixedrange: true,},
    yaxis5: {domain: [0.82, 0.98], title: 'Temp (F)', fixedrange: true, range: [0, 120],},
    yaxis6: {title: 'Dewpoint (F)', overlaying: 'y5', side: 'right', fixedrange: true, range: [0, 120],},
    xaxis: {type: 'date', title: 'Date / Time', fixedrange: true, range: [start, end]},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

Plotly.newPlot(wx_wr, traces_wr, layout_wr, {displayModeBar: false});
Plotly.newPlot(wx_combo, traces_combo, layout_combo, {displayModeBar: false});
Plotly.newPlot(wx_dTdtd, traces_dTdtd, layout_dTdtd, {displayModeBar: false});
Plotly.newPlot(wx_Tdh, traces_Tdh, layout_Tdh, {displayModeBar: false});
Plotly.newPlot(wx_dTdts, traces_dTdts, layout_dTdts, {displayModeBar: false});
Plotly.newPlot(wx_dPdts, traces_dPdts, layout_dPdts, {displayModeBar: false});
</script>
</body>
</html>