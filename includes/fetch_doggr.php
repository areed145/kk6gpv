<?php

$inc = 0.001;

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query_data = "SELECT date,
                count(api) as wells, 
                sum(oil) as oil, 
                sum(water) as water, 
                sum(gas) as gas, 
                sum(cyclic) as cyclic, 
                sum(steamflood) as steamflood 
                from t_doggr_prodinj 
                group by date
                WHERE 1";
if (!empty($api)) {$query_data = $query_data . " AND api = '$api'";}
if (!empty($lease)) {$query_data = $query_data . " AND lease = '$lease'";}
if (!empty($county)) {$query_data = $query_data . " AND county = '$county'";}
if (!empty($district)) {$query_data = $query_data . " AND district = $district";}
if (!empty($opcode)) {$query_data = $query_data . " AND operatorcode = '$opcode'";}
if (!empty($fieldcode)) {$query_data = $query_data . " AND fieldcode = '$fieldcode'";}
if (!empty($section)) {$query_data = $query_data . " AND section = '$section'";}
if (!empty($township)) {$query_data = $query_data . " AND township = '$township'";}
if (!empty($rnge)) {$query_data = $query_data . " AND rnge = '$rnge'";}
if (!empty($status)) {$query_data = $query_data . " AND status = '$status'";}
if (!empty($datemin)) {$query_data = $query_data . " AND date >= '$datemin'";}
if (!empty($datemax)) {$query_data = $query_data . " AND date <= '$datemax'";}

echo $query_data;

//$query_data = "SELECT * from $doggrtable_all";
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

$data = [ [
   "date" => $date,
   "wells" => $wells,
   "oil" => $oil,
   "water" => $water,
   "gas" => $gas,
   "steamflood" => $steamflood,
   "cylic" => $cyclic
] ];
$json = json_encode($data);
echo $json

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