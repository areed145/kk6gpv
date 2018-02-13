<?php
error_reporting(0);

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query_c = "select round(latitude/$sq,0)*$sq as latitude, round(longitude/$sq,0)*$sq as longitude, avg($data) as $data from $awstable group by round(latitude/$sq,0)*$sq, round(longitude/$sq,0)*$sq";
$result_c = mysqli_query($con, $query_c);
$lat_c = array();
$lon_c = array();
$data_c = array();
while($row = mysqli_fetch_assoc($result_c)){
    $lat_c[] = $row['latitude'];
    $lon_c[] = $row['longitude'];
    $data_c[] = $row[$data];}

$query_all = "select raw_text, latitude, longitude, $data from $awstable";
$result_all = mysqli_query($con, $query_all);
$lat_all = array();
$lon_all = array();
$data_all = array();
$raw_all = array();
while($row = mysqli_fetch_assoc($result_all)){
    $lat_all[] = $row['latitude'];
    $lon_all[] = $row['longitude'];
    $raw_all[] = $row['raw_text'];
    $data_all[] = $row[$data];}

$query_vfr = "select raw_text, latitude, longitude, $data from $awstable where $data = 'VFR'";
$result_vfr = mysqli_query($con, $query_vfr);
$lat_vfr = array();
$lon_vfr = array();
$raw_vfr = array();
while($row = mysqli_fetch_assoc($result_vfr)){
    $lat_vfr[] = $row['latitude'];
    $lon_vfr[] = $row['longitude'];
    $raw_vfr[] = $row['raw_text'];}

$query_mvfr = "select raw_text, latitude, longitude, $data from $awstable where $data = 'MVFR'";
$result_mvfr = mysqli_query($con, $query_mvfr);
$lat_mvfr = array();
$lon_mvfr = array();
$raw_mvfr = array();
while($row = mysqli_fetch_assoc($result_mvfr)){
    $lat_mvfr[] = $row['latitude'];
    $lon_mvfr[] = $row['longitude'];
    $raw_mvfr[] = $row['raw_text'];}

$query_ifr = "select raw_text, latitude, longitude, $data from $awstable where $data = 'IFR'";
$result_ifr = mysqli_query($con, $query_ifr);
$lat_ifr = array();
$lon_ifr = array();
$raw_ifr = array();
while($row = mysqli_fetch_assoc($result_ifr)){
    $lat_ifr[] = $row['latitude']; 
    $lon_ifr[] = $row['longitude'];
    $raw_ifr[] = $row['raw_text'];}

$query_lifr = "select raw_text, latitude, longitude, $data from $awstable where $data = 'LIFR'";
$result_lifr = mysqli_query($con, $query_lifr);
$lat_lifr = array();
$lon_lifr = array();
$raw_lifr = array();
while($row = mysqli_fetch_assoc($result_lifr)){
    $lat_lifr[] = $row['latitude'];
    $lon_lifr[] = $row['longitude'];
    $raw_lifr[] = $row['raw_text'];}

$dataj = [[
    "data" => $data,
    "lat_c" => $lat_c,
    "lon_c" => $lon_c,
    "data_c" => $data_c,
    "lat_all" => $lat_all,
    "lon_all" => $lon_all,
    "raw_all" => $raw_all,
    "data_all" => $data_all,
    "lat_vfr" => $lat_vfr,
    "lon_vfr" => $lon_vfr,
    "raw_vfr" => $raw_vfr,
    "lat_mvfr" => $lat_mvfr,
    "lon_mvfr" => $lon_mvfr,
    "raw_mvfr" => $raw_mvfr,
    "lat_ifr" => $lat_ifr,
    "lon_ifr" => $lon_ifr,
    "raw_ifr" => $raw_ifr,
    "lat_lifr" => $lat_lifr,
    "lon_lifr" => $lon_lifr,
    "raw_lifr" => $raw_lifr
]];

//$json = json_encode($dataj);

//echo $json;

mysqli_close($con);
?>