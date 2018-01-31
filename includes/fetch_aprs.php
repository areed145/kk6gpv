<?php
$offset = 8;
$now = gmdate("Y-m-d H:i:s");
$now_l = gmdate("Y-m-d",strtotime($now . "-$offset hours"));
$end = gmdate("Y-m-d",strtotime($now_l . '+1 days'));
if ($period == 'today') {
    $start = gmdate("Y-m-d",strtotime($now_l));
}
elseif ($period == 'week') {
    $start = gmdate("Y-m-d",strtotime($end . '-1 week'));
}
elseif ($period == 'month') {
    $start = gmdate("Y-m-d",strtotime($end . '-1 month'));
}
elseif ($period == '3month') {
    $start = gmdate("Y-m-d",strtotime($end . '-3 months'));
}
elseif ($period == '6month') {
    $start = gmdate("Y-m-d",strtotime($end . '-6 months'));
}
elseif ($period == 'year') {
    $start = gmdate("Y-m-d",strtotime($end . '-1 year'));
}
else {
    $start = gmdate("Y-m-d",strtotime($end . '-10 years'));
};

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query_start = "SELECT min(date(timestamp)) - interval $offset hour AS start
                FROM $aprstable
                WHERE (date(timestamp) - interval $offset hour between '$start' and '$end')";
$result = mysqli_query($con, $query_start);
$row =  mysqli_fetch_assoc($result);
$startu = $row['start'];
if (!empty($startu)) {$start = $startu;}

$query_data = "SELECT date(timestamp) - interval $offset hour as timestamp,
                latitude,
                longitude,
                course,
                speed,
                altitude
                FROM $aprstable
                WHERE (date(timestamp) - interval $offset hour between '$start' and '$end')
                ORDER BY timestamp ASC";
$result = mysqli_query($con, $query_data);
$timestamp = array();
$latitude = array();
$longitude = array();
$course = array();
$speed = array();
$altitude = array();
while($row = mysqli_fetch_assoc($result)){
    $timestamp[] = $row['timestamp'];
    $latitude[] = $row['latitude'];
    $longitude[] = $row['longitude'];
    $course[] = $row['course'];
    $speed[] = $row['speed'];
    $altitude[] = $row['altitude'];
}

$data = [ [
   "period" => $period,
   "start" => $start,
   "end" => $end,
   "timestamp" => $timestamp,
   "latitude" => $latitude,
   "longitude" => $longitude,
   "course" => $course,
   "speed" => $speed,
   "altitude" => $altitude,
] ];
$json = json_encode($data);

//echo $json;

mysqli_close($con);
?>