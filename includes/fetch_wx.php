<?php
error_reporting(0);

$now = gmdate("Y-m-d H:i:s");
$now_l = gmdate("Y-m-d",strtotime($now . "-$offset hours"));
$end = gmdate("Y-m-d",strtotime($now_l . '+1 days'));
if ($period == 'today') {
    $start = gmdate("Y-m-d",strtotime($now_l));
    $gb = 'date(timelocal), time(timelocal)';
    $hm_x = 'hour(timelocal)';
    $hm_y = 'minute(timelocal)';
}
elseif ($period == 'yesterday') {
    $end = gmdate("Y-m-d",strtotime($now_l));
    $start = gmdate("Y-m-d",strtotime($now_l . '-1 days'));
    $gb = 'date(timelocal), time(timelocal)';
    $hm_x = 'hour(timelocal)';
    $hm_y = 'minute(timelocal)';
}
elseif ($period == 'week') {
    $start = gmdate("Y-m-d",strtotime($end . '-1 week'));
    $gb = 'date(timelocal), hour(timelocal), floor(minute(timelocal)/10)*10';
    $hm_x = 'date(timelocal)';
    $hm_y = 'hour(timelocal)';
}
elseif ($period == 'month') {
    $start = gmdate("Y-m-d",strtotime($end . '-1 month'));
    $gb = 'date(timelocal), hour(timelocal)';
    $hm_x = 'date(timelocal)';
    $hm_y = 'hour(timelocal)';
}
elseif ($period == '3month') {
    $start = gmdate("Y-m-d",strtotime($end . '-3 months'));
    $gb = 'date(timelocal), floor(hour(timelocal)/3)*3';
    $hm_x = 'date(timelocal)';
    $hm_y = 'hour(timelocal)';
}
elseif ($period == '6month') {
    $start = gmdate("Y-m-d",strtotime($end . '-6 months'));
    $gb = 'date(timelocal), floor(hour(timelocal)/3)*3';
    $hm_x = 'date(timelocal)';
    $hm_y = 'hour(timelocal)';
}
elseif ($period == 'year') {
    $start = gmdate("Y-m-d",strtotime($end . '-1 year'));
    $gb = 'date(timelocal), floor(hour(timelocal)/3)*3';
    $hm_x = 'date(timelocal)';
    $hm_y = 'hour(timelocal)';
}
else {
    $start = gmdate("Y-m-d",strtotime($end . '-10 years'));
    $gb = 'date(timelocal), floor(hour(timelocal)/3)*3';
    $hm_x = 'date(timelocal)';
    $hm_y = 'hour(timelocal)';
};

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query_start = "SELECT min(date(filter.time)) AS start
                FROM $wxtable_filter filter
                WHERE filter.sid = '$sid'
                AND (date(filter.time) between '$start' and '$end')";
$result = mysqli_query($con, $query_start);
$row =  mysqli_fetch_assoc($result);
$start_u = $row['start'];
if (!empty($start_u)) {$start = $start_u;}

$query_data = "SELECT min(delta.timelocal) AS time,
                $hm_x AS hm_x,
                $hm_y AS hm_y,
                ROUND(avg(delta.temp),1) AS tempavg,
                ROUND(min(delta.temp),1) AS tempmin,
                ROUND(max(delta.temp),1) AS tempmax,
                ROUND(avg(delta.dewpt),1) AS dewptavg,
                ROUND(min(delta.dewpt),1) AS dewptmin,
                ROUND(max(delta.dewpt),1) AS dewptmax,
                ROUND(avg(delta.pres),2) AS presavg,
                ROUND(min(delta.pres),2) AS presmin,
                ROUND(max(delta.pres),2) AS presmax,
                ROUND(Vavg(sum(sin(radians(winddir))),sum(cos(radians(winddir)))),0) AS winddir,
                ROUND(avg(delta.windspeed),1) AS windspeed,
                ROUND(avg(delta.windgust),1) AS windgust,
                ROUND(avg(delta.hum),1) AS humavg,
                ROUND(min(delta.hum),1) AS hummin,
                ROUND(max(delta.hum),1) AS hummax,
                ROUND(avg(delta.preciphr),2) AS preciphravg,
                ROUND(min(delta.preciphr),2) AS preciphrmin,
                ROUND(max(delta.preciphr),2) AS preciphrmax,
                ROUND(max(delta.precipday),2) AS precipday,
                ROUND(max(delta.precipcum),2) AS precipcum,
                ROUND(avg(delta.solarrad),0) AS solarradavg,
                ROUND(min(delta.solarrad),0) AS solarradmin,
                ROUND(max(delta.solarrad),0) AS solarradmax,
                ROUND(avg(100*delta.uv),0) AS uvavg,
                ROUND(min(100*delta.uv),0) AS uvmin,
                ROUND(max(100*delta.uv),0) AS uvmax,
                ROUND(avg(delta.dtemp / delta.dtime),3) AS dtdt,
                ROUND(avg(delta.dpres / delta.dtime),3) AS dpdt,
                ROUND(avg(((delta.temp - delta.dewpt) / 4.4) * 1000 + delta.ele),0) AS cloudbaseavg,
                ROUND(min(((delta.temp - delta.dewpt) / 4.4) * 1000 + delta.ele),0) AS cloudbasemin,
                ROUND(max(((delta.temp - delta.dewpt) / 4.4) * 1000 + delta.ele),0) AS cloudbasemax 
                FROM (SELECT filter.*,
                      timediff(filter.time,@lastTime) / 6000 AS dtime,
                      filter.time - interval $offset hour AS timelocal,
                      filter.temp - @lastTemp AS dtemp,
                      filter.pres - @lastPres AS dpres,
                      @cumPrecip := @cumPrecip + GREATEST((filter.precipday - @lastPrecip),0),
                      @cumPrecip AS precipcum,
                      @lastTime := filter.time,
                      @lastTemp := filter.temp,
                      @lastPres := filter.pres,
                      @lastPrecip := filter.precipday 
                      FROM $wxtable_filter filter, ( select @lastTime := 0, @lastTemp := 0, @lastPres := 0, @lastPrecip := 0, @cumPrecip := 0 ) SQLVars
                      WHERE filter.sid = '$sid'
                      AND filter.time - interval $offset hour between '$start' and '$end'
                      ORDER BY filter.time) delta
                GROUP BY $gb
                ORDER BY delta.time ASC";
$result = mysqli_query($con, $query_data);
$time = array();
$hm_x = array();
$hm_y = array();
$tempavg = array();
$tempmin = array();
$tempmax = array();
$dewptavg = array();
$dewptmin = array();
$dewptmax = array();
$presavg = array();
$presmin = array();
$presmax = array();
$winddir = array();
$windspeed = array();
$windgust = array();
$humavg = array();
$hummin = array();
$hummax = array();
$preciphravg = array();
$preciphrmin = array();
$preciphrmax = array();
$precipday = array();
$precipcum = array();
$solarradavg = array();
$solarradmin = array();
$solarradmax = array();
$uvavg = array();
$uvmin = array();
$uvmax = array();
$dtdt = array();
$dpdt = array();
$cloudbaseavg = array();
$cloudbasemin = array();
$cloudbasemax = array();
while($row = mysqli_fetch_assoc($result)){
    $time[] = $row['time'];
    $hm_x[] = $row['hm_x'];
    $hm_y[] = $row['hm_y'];
    $tempavg[] = $row['tempavg'];
    $tempmin[] = $row['tempmin'];
    $tempmax[] = $row['tempmax'];
    $dewptavg[] = $row['dewptavg'];
    $dewptmin[] = $row['dewptmin'];
    $dewptmax[] = $row['dewptmax'];
    $presavg[] = $row['presavg'];
    $presmin[] = $row['presmin'];
    $presmax[] = $row['presmax'];
    $winddir[] = $row['winddir'];
    $windspeed[] = $row['windspeed'];
    $windgust[] = $row['windgust'];
    $humavg[] = $row['humavg'];
    $hummin[] = $row['hummin'];
    $hummax[] = $row['hummax'];
    $preciphravg[] = $row['preciphravg'];
    $preciphrmin[] = $row['preciphrmin'];
    $preciphrmax[] = $row['preciphrmax'];
    $precipday[] = $row['precipday'];
    $precipcum[] = $row['precipcum'];
    $solarradavg[] = $row['solarradavg'];
    $solarradmin[] = $row['solarradmin'];
    $solarradmax[] = $row['solarradmax'];
    $uvavg[] = $row['uvavg'];
    $uvmin[] = $row['uvmin'];
    $uvmax[] = $row['uvmax'];
    $dtdt[] = $row['dtdt'];
    $dpdt[] = $row['dpdt'];
    $cloudbaseavg[] = $row['cloudbaseavg'];
    $cloudbasemin[] = $row['cloudbasemin'];
    $cloudbasemax[] = $row['cloudbasemax'];
}

//echo $query_data;

$query_totclm = "SELECT count(windspeed_cat) / 100 AS total, 
                SUM(CASE WHEN windspeed_cat = 'calm' THEN 1 ELSE 0 END) AS calm 
                FROM $wxtable_wind wind
                WHERE wind.sid = '$sid'
                AND (wind.time - interval $offset hour between '$start' and '$end')";
$result = mysqli_query($con, $query_totclm);
$row =  mysqli_fetch_assoc($result);
$total = $row['total'];
$calm = $row['calm'];

//echo $query_totclm;

$query_dirs = "select count(cat)-1 AS dirs ".
            "from $wxtable_winddrange";
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
            FROM $wxtable_winddrange drange
            LEFT JOIN (select wind.winddir_cat AS cat,
                       SUM(case when wind.windspeed_cat = 'calm' then 1 else 0 end) AS `calm`,
                       SUM(case when wind.windspeed_cat = '1mph' then 1 else 0 end) AS `1mph`,
                       SUM(case when wind.windspeed_cat = '1to2mph' then 1 else 0 end) AS `1to2mph`,
                       SUM(case when wind.windspeed_cat = '2to5mph' then 1 else 0 end) AS `2to5mph`,
                       SUM(case when wind.windspeed_cat = '5to10mph' then 1 else 0 end) AS `5to10mph`,
                       SUM(case when wind.windspeed_cat = '10mph' then 1 else 0 end) AS `10mph`
                       FROM $wxtable_wind wind
                       WHERE wind.sid = '$sid'
                       AND wind.time - interval $offset hour between '$start' and '$end'
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
$max = max($w10mph);

$data = [[
    "period" => $period,
    "start" => $start,
    "end" => $end,
    "total" => $total,
    "calm" => $calm,
    "dirs" => $dirs,
    "max" => $max,
    "wdircat" => $wdircat,
    "wcalm" => $wcalm,
    "w1mph" => $w1mph,
    "w1to2mph" => $w1to2mph,
    "w2to5mph" => $w2to5mph,
    "w5to10mph" => $w5to10mph,
    "w10mph" => $w10mph,
    "time" => $time,
    "hm_x" => $hm_x,
    "hm_y" => $hm_y,
    "tempavg" => $tempavg,
    "tempmin" => $tempmin,
    "tempmax" => $tempmax,
    "dewptavg" => $dewptavg,
    "dewptmin" => $dewptmin,
    "dewptmax" => $dewptmax,
    "presavg" => $presavg,
    "presmin" => $presmin,
    "presmax" => $presmax,
    "winddir" => $winddir,
    "windspeed" => $windspeed,
    "windgust" => $windgust,
    "humavg" => $humavg,
    "hummin" => $hummin,
    "hummax" => $hummax,
    "preciphravg" => $preciphravg,
    "preciphrmin" => $preciphrmin,
    "preciphrmax" => $preciphrmax,
    "precipday" => $precipday,
    "precipcum" => $precipcum,
    "solarradavg" => $solarradavg,
    "solarradmin" => $solarradmin,
    "solarradmax" => $solarradmax,
    "uvavg" => $uvavg,
    "uvmin" => $uvmin,
    "uvmax" => $uvmax,
    "dtdt" => $dtdt,
    "dpdt" => $dpdt,
    "cloudbaseavg" => $cloudbaseavg,
    "cloudbasemin" => $cloudbasemin,
    "cloudbasemax" => $cloudbasemax
]];

//echo $query_wr;

$json = json_encode($data);

//echo $json;

mysqli_close($con);
?>