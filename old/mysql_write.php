<?php
$time = $_GET["time"];
if ($time == 'today') {$start = gmdate("Y-m-d",strtotime('-10 hours')); $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); $gb = 'date(delta.time), hour(delta.time), round(minute(delta.time)/10,0)*10';}
elseif ($time == 'week') {$start = gmdate("Y-m-d",strtotime('-1 week -10 hours')); $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); $gb = 'date(delta.time), hour(delta.time), round(minute(delta.time)/10,0)*10';}
elseif ($time == 'month') {$start = gmdate("Y-m-d",strtotime('-1 month -10 hours')); $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); $gb = 'date(delta.time), hour(delta.time), round(minute(delta.time)/30,0)*30';}
elseif ($time == 'year') {$start = gmdate("Y-m-d",strtotime('-1 year -16 hours')); $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); $gb = 'date(delta.time), round(hour(delta.time)/6,0)*6';}
else {$start = gmdate("Y-m-d",strtotime('-8 years -16 hours')); $end = gmdate("Y-m-d",strtotime('+1 days -8 hours')); $gb = 'date(delta.time), round(hour(delta.time)/6,0)*6';};

$databasehost = "localhost";
$databasename = "kksixgpv_repo";
$databaseusername="kksixgpv_repo";
$databasepassword = "+U0bzMWSxHla";
$csv = "wx/wx_filter_$time.csv";
$csv_wr = "wx/wx_windrose_$time.csv";

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
echo "Success!";
echo "<br>";

$query = "select min(delta.time) as time, round(avg(delta.temp),1) as temp, round(avg(delta.dewpt),1) as dewpt, round(avg(delta.pres),2) as pres, round(avg(delta.winddir),0) as winddir, round(avg(delta.windspeed),1) as windspeed, round(avg(delta.windgust),1) as windgust, round(avg(delta.hum),1) as hum, round(avg(delta.preciphr),2) as preciphr, round(max(delta.precipday),2) as precipday, round(avg(delta.solarrad),0) as solarrad, round(avg(delta.uv),0) as uv, round(avg(delta.dtemp / delta.dtime),3) as dtdt, round(avg(delta.dpres / delta.dtime),3) as dpdt, round(avg(((delta.temp - delta.dewpt) / 4.4) * 1000 + 400),0) as cloudbase FROM (select filter.*, timediff(filter.time,@lastTime)/6000 as dtime, filter.temp - @lastTemp as dtemp, filter.pres - @lastPres as dpres, @lastTime := filter.time, @lastTemp := filter.temp, @lastPres := filter.pres from v_wx_filter filter, ( select @lastTime := 0, @lastTemp := 0, @lastPres := 0 ) SQLVars order by filter.time) delta WHERE (date(delta.time) between '$start' and '$end') GROUP BY $gb ORDER BY delta.time ASC;";
$query_totclm = "select count(windspeed_cat)/100 as total, SUM(case when windspeed_cat = 'calm' then 1 else 0 end) as calm from v_wx_wind WHERE (date(v_wx_wind.time) between '$start' and '$end')";
//$query_totclm = "select count(windspeed_cat)/100 as total, SUM(case when windspeed_cat = 'calm' then 1 else 0 end) as calm from v_wx_wind WHERE (date(v_wx_wind.time) between (now() - interval 1 month) and now())";
$query_dirs = "select count(cat)-1 as dirs from t_wx_windrose_drange";
$result = mysqli_query($con, $query_totclm);
$row =  mysqli_fetch_array($result);
$total = $row['total'];
$calm = $row['calm'];
$result = mysqli_query($con, $query_dirs);
$row =  mysqli_fetch_array($result);
$dirs = $row['dirs'];
$query_wr = "select drange.cat, (round($calm / $dirs, 0)) / $total as calm, (round($calm / $dirs, 0) + w.1mph) / $total as 1mph, (round($calm / $dirs, 0) + w.1mph + w.1to2mph) / $total as 1to2mph, (round($calm / $dirs, 0) + w.1mph + w.1to2mph + w.2to5mph) / $total as 2to5mph, (round($calm / $dirs, 0) + w.1mph + w.1to2mph + w.2to5mph + w.5to10mph) / $total as 5to10mph, (round($calm / $dirs, 0) + w.1mph + w.1to2mph + w.2to5mph + w.5to10mph + w.10mph) / $total as 10mph from t_wx_windrose_drange drange LEFT JOIN (select wind.winddir_cat AS cat, SUM(case when wind.windspeed_cat = 'calm' then 1 else 0 end)  as calm, SUM(case when wind.windspeed_cat = '1mph' then 1 else 0 end) as 1mph, SUM(case when wind.windspeed_cat = '1to2mph' then 1 else 0 end) as 1to2mph, SUM(case when wind.windspeed_cat = '2to5mph' then 1 else 0 end) as 2to5mph, SUM(case when wind.windspeed_cat = '5to10mph' then 1 else 0 end) as 5to10mph, SUM(case when wind.windspeed_cat = '10mph' then 1 else 0 end) as 10mph FROM v_wx_wind wind WHERE (date(wind.time) between '$start' and '$end') GROUP BY wind.winddir_cat) w ON drange.cat = w.cat GROUP BY drange.cat ORDER BY field(drange.cat,'N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW')";
//$query_wr = "select drange.cat, (round($calm / $dirs, 0)) / $total as calm, (round($calm / $dirs, 0) + w.1mph) / $total as 1mph, (round($calm / $dirs, 0) + w.1mph + w.1to2mph) / $total as 1to2mph, (round($calm / $dirs, 0) + w.1mph + w.1to2mph + w.2to5mph) / $total as 2to5mph, (round($calm / $dirs, 0) + w.1mph + w.1to2mph + w.2to5mph + w.5to10mph) / $total as 5to10mph, (round($calm / $dirs, 0) + w.1mph + w.1to2mph + w.2to5mph + w.5to10mph + w.10mph) / $total as 10mph from t_wx_windrose_drange drange LEFT JOIN (select wind.winddir_cat AS cat, SUM(case when wind.windspeed_cat = 'calm' then 1 else 0 end)  as calm, SUM(case when wind.windspeed_cat = '1mph' then 1 else 0 end) as 1mph, SUM(case when wind.windspeed_cat = '1to2mph' then 1 else 0 end) as 1to2mph, SUM(case when wind.windspeed_cat = '2to5mph' then 1 else 0 end) as 2to5mph, SUM(case when wind.windspeed_cat = '5to10mph' then 1 else 0 end) as 5to10mph, SUM(case when wind.windspeed_cat = '10mph' then 1 else 0 end) as 10mph FROM v_wx_wind wind WHERE (date(wind.time) between (now() - interval 1 month) and now()) GROUP BY wind.winddir_cat) w ON drange.cat = w.cat GROUP BY drange.cat ORDER BY field(drange.cat,'N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW')";
echo $query_wr;
echo "<br>";

$f = fopen($csv, 'w');
fputcsv($f, array('time','temp','dewpt','pres','winddir','windspeed','windgust','hum','preciphr','precipday','solarrad','uv','dtdt','dpdt','cloudbase'));  
$result = mysqli_query($con, $query); 
while($row = mysqli_fetch_assoc($result))  
{  
    fputcsv($f, $row);
}  
fclose($f);

$f_wr = fopen($csv_wr, 'w');
fputcsv($f_wr, array('winddir','calm','1mph','1to2mph','2to5mph','5to10mph','10mph'));  
$result_wr = mysqli_query($con, $query_wr); 
while($row = mysqli_fetch_assoc($result_wr))  
{  
    fputcsv($f_wr, $row);
}  
fclose($f_wr);

mysqli_close($con);

?>