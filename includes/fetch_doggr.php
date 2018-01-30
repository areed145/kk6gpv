<?php

$inc = 0.001;
if ($period == '6month') {
    $start = gmdate("Y-m-d",strtotime('-6 month'));
}
elseif ($period == '1year') {
    $start = gmdate("Y-m-d",strtotime('-1 year'));
}
elseif ($period == '5year') {
    $start = gmdate("Y-m-d",strtotime('-5 year')); 
}
elseif ($period == '10year') {
    $start = gmdate("Y-m-d",strtotime('-10 year')); 
}
elseif ($period == '20year') {
    $start = gmdate("Y-m-d",strtotime('-20 year')); 
}
else {
    $start = gmdate("Y-m-d",strtotime('-40 years'));
};

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query_data = "SELECT * from $doggrtable_all";
$result = mysqli_query($con, $query_data);
$date = array();
$wells = array();
$oil = array();
$water = array();
$gas = array();
$steamflood = array();
$cyclic = array();
while($row = mysqli_fetch_assoc($result)){
    $date[] = $row['date'];
    $wells[] = $row['wells'];
    $oil[] = $row['oil'];
    $water[] = $row['water'];
    $gas[] = $row['gas'];
    $steamflood[] = $row['steamflood'];
    $cyclic[] = $row['cyclic'];
}

$query = "SELECT latitude, longitude, oilsum from $doggrtable_map where oilsum > 0";
$result = mysqli_query($con, $query);
$latoil = array();
$lonoil = array();
$oilsum = array();
while($row = mysqli_fetch_assoc($result)){
    $latoil[] = $row['latitude'];
    $lonoil[] = $row['longitude'];
    $oilsum[] = $row['oilsum'];
}

$query = "SELECT latitude, longitude, watersum from $doggrtable_map where watersum > 0";
$result = mysqli_query($con, $query);
$latwater = array();
$lonwater = array();
$watersum = array();
while($row = mysqli_fetch_assoc($result)){
    $latwater[] = $row['latitude'];
    $lonwater[] = $row['longitude'];
    $watersum[] = $row['watersum'];
}

$query = "SELECT latitude, longitude, gassum from $doggrtable_map where gassum > 0";
$result = mysqli_query($con, $query);
$latgas = array();
$longas = array();
$gassum = array();
while($row = mysqli_fetch_assoc($result)){
    $latgas[] = $row['latitude'];
    $longas[] = $row['longitude'];
    $gassum[] = $row['gassum'];
}

$query = "SELECT latitude, longitude, cyclicsum from $doggrtable_map where cyclicsum > 0";
$result = mysqli_query($con, $query);
$latcyclic = array();
$loncyclic = array();
$cyclicsum = array();
while($row = mysqli_fetch_assoc($result)){
    $latcyclic[] = $row['latitude'];
    $loncyclic[] = $row['longitude'];
    $cyclicsum[] = $row['cyclicsum'];
}

$query = "SELECT latitude, longitude, steamfloodsum from $doggrtable_map where steamfloodsum > 0";
$result = mysqli_query($con, $query);
$latsteamflood = array();
$lonsteamflood = array();
$steamfloodsum = array();
while($row = mysqli_fetch_assoc($result)){
    $latsteamflood[] = $row['latitude'];
    $lonsteamflood[] = $row['longitude'];
    $steamfloodsum[] = $row['steamfloodsum'];
}

//$data = [ [
//    "period" => $period,
//    "start" => $start,
//    "end" => $end,
//    "time" => $time,
//    "tempavg" => $tempavg,
//    "tempmin" => $tempmin,
//] ];
//$json = json_encode($data);

//print '<pre>' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';

// create table t_all as 
// SELECT date, 
// sum(oil) as oil, 
// sum(water) as water, 
// sum(gas) as gas, 
// sum(cyclic) as cyclic, 
// sum(steamflood) as steamflood 
// from t_prodinj 
// group by date

// create table t_map as SELECT api, 
// round(latitude/0.001,0)*0.001 as latitude, 
// round(longitude/0.001,0)*0.001 as longitude, 
// sum(oil) as oilsum, 
// sum(water) as watersum, 
// sum(gas) as gassum, 
// sum(cyclic) as cyclicsum, 
// sum(steamflood) as steamfloodsum 
// from t_prodinj 
// where latitude > 0 
// AND longitude < 0 
// group by round(latitude/0.001,0)*0.001, round(longitude/0.001,0)*0.001

mysqli_close($con);
?>