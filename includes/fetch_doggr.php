<?php
error_reporting(0);

if (empty($inc)) {$inc = 0.01;}

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query_data = "SELECT date,
                count(api) as wells, 
                sum(oil)/30.44 as oil, 
                sum(water)/30.44 as water, 
                sum(gas)/30.44 as gas, 
                sum(cyclic)/30.44 as cyclic, 
                sum(steamflood)/30.44 as steamflood 
                from t_doggr_prodinj 
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
$query_data = $query_data . " group by date";

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

$query_data = "SELECT round(latitude/$inc,0)*$inc as latitude, 
                round(longitude/$inc,0)*$inc as longitude, 
                sum(oil) as oilsum, 
                sum(water) as watersum, 
                sum(gas) as gassum, 
                sum(cyclic) as cyclicsum, 
                sum(steamflood) as steamfloodsum 
                from t_doggr_prodinj 
                where latitude > 0 
                AND longitude < 0";
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
$query_data = $query_data . " group by round(latitude/$inc,0)*$inc, round(longitude/$inc,0)*$inc";

//$query = "SELECT latitude, longitude, oilsum from $doggrtable_map";
$result = mysqli_query($con, $query_data);
$latall = array();
$lonall = array();
$latoil = array();
$lonoil = array();
$oilsum = array();
$latwater = array();
$lonwater = array();
$watersum = array();
$latgas = array();
$longas = array();
$gassum = array();
$latcyclic = array();
$loncyclic = array();
$cyclicsum = array();
$latsteamflood = array();
$lonsteamflood = array();
$steamfloodsum = array();
while($row = mysqli_fetch_assoc($result)){
    $latall[] = $row['latitude'];
    $lonall[] = $row['longitude'];
    if($row['oilsum']>0){
        $latoil[] = $row['latitude'];
        $lonoil[] = $row['longitude'];
        $oilsum[] = $row['oilsum'];
    }
    if($row['watersum']>0){
        $latwater[] = $row['latitude'];
        $lonwater[] = $row['longitude'];
        $watersum[] = $row['watersum'];
    }
    if($row['gassum']>0){
        $latgas[] = $row['latitude'];
        $longas[] = $row['longitude'];
        $gassum[] = $row['gassum'];
    }
    if($row['cyclicsum']>0){
        $latcyclic[] = $row['latitude'];
        $loncyclic[] = $row['longitude'];
        $cyclicsum[] = $row['cyclicsum'];
    }
    if($row['steamfloodsum']>0){
        $latsteamflood[] = $row['latitude'];
        $lonsteamflood[] = $row['longitude'];
        $steamfloodsum[] = $row['steamfloodsum'];
    }
}

// $data = [ [
//    "date" => $date,
//    "wells" => $wells,
//    "oil" => $oil,
//    "water" => $water,
//    "gas" => $gas,
//    "steamflood" => $steamflood,
//    "cylic" => $cyclic
// ] ];
// $json = json_encode($data);

//echo $json;

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
