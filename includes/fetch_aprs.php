<?php

if ($period == 'today') {
    $start = gmdate("Y-m-d"); 
    $end = gmdate("Y-m-d",strtotime('+1 days')); 
}
elseif ($period == 'week') {
    $start = gmdate("Y-m-d",strtotime('-1 week')); 
    $end = gmdate("Y-m-d",strtotime('+1 days')); 
}
elseif ($period == 'month') {
    $start = gmdate("Y-m-d",strtotime('-1 month')); 
    $end = gmdate("Y-m-d",strtotime('+1 days')); 
}
elseif ($period == '3month') {
    $start = gmdate("Y-m-d",strtotime('-3 month')); 
    $end = gmdate("Y-m-d",strtotime('+1 days')); 
}
elseif ($period == '6month') {
    $start = gmdate("Y-m-d",strtotime('-6 month')); 
    $end = gmdate("Y-m-d",strtotime('+1 days')); 
}
elseif ($period == 'year') {
    $start = gmdate("Y-m-d",strtotime('-1 year')); 
    $end = gmdate("Y-m-d",strtotime('+1 days')); 
}
else {
    $start = gmdate("Y-m-d",strtotime('-10 years'));
    $end = gmdate("Y-m-d",strtotime('+1 days'));
};

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query_start = "SELECT min(date(timestamp)) AS start
                FROM $aprstable
                WHERE (date(timestamp) between '$start' and '$end')";
$result = mysqli_query($con, $query_start);
$row =  mysqli_fetch_assoc($result);
$startu = $row['start'];
if (!empty($startu)) {$start = $startu;}

$query_data = "SELECT *
                FROM $aprstable
                WHERE (date(timestamp) between '$start' and '$end')
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