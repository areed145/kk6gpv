<?php
set_time_limit(240);
include('mysql_cred.php');

$type = $_GET["type"];
if ($type == 'short') {
    $inc = 50; 
    $timeback = 0.08; 
}
else {
    $inc = 10; 
    $timeback = 2; 
}
$overlap = 1;
$minLat_f = -90;
$maxLat_f = 90;
$minLon_f = -180;
$maxLon_f = 180;
$connect = new PDO("mysql:host=$databasehost;dbname=$databasename", $databaseusername, $databasepassword);
$minLon = $minLon_f;
$minLat = $minLat_f;
for ($minLon = $minLon_f; $minLon <= $maxLon_f; $minLon+=$inc) {
    $maxLon = $minLon+$inc;
    $minLon_u = $minLon-$overlap;
    $maxLon_u = $maxLon+$overlap;
    if($minLon_u <= -180) {$minLon_u = -180;}
    if($maxLon_u >= 180) {$maxLon_u = 180;}
    for ($minLat = $minLat_f; $minLat <= $maxLat_f; $minLat+=$inc) {
        $maxLat = $minLat+$inc;
        $minLat_u = $minLat-$overlap;
        $maxLat_u = $maxLat+$overlap;
        if($minLat_u <= -90) {$minLat_u = -90;}
        if($maxLat_u >= 90) {$maxLat_u = 90;}
        $url = "https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&minLon=$minLon_u&maxLon=$maxLon_u&minLat=$minLat_u&maxLat=$maxLat_u&hoursBeforeNow=$timeback&mostRecentForEachStation=true";
        $xml = simplexml_load_file($url);
        echo $url . " - " . $xml->data['num_results'] . " - " . $xml->warnings->warning;
        echo PHP_EOL;
        foreach ($xml->data->METAR as $metar) {
            $sid = $metar->station_id;
            echo $sid;
            echo PHP_EOL;
        }
        $query = "REPLACE INTO $awstableraw
               (raw_text, station_id, observation_time, latitude, longitude, temp_c, dewpoint_c, wind_dir_degrees, wind_speed_kt, wind_gust_kt, visibility_statute_mi, altim_in_hg, sea_level_pressure_mb, flight_category, metar_type, elevation_m, precip_in, vert_vis_ft) 
               VALUES(:raw_text, :station_id, :observation_time, :latitude, :longitude, :temp_c, :dewpoint_c, :wind_dir_degrees, :wind_speed_kt, :wind_gust_kt, :visibility_statute_mi, :altim_in_hg, :sea_level_pressure_mb, :flight_category, :metar_type, :elevation_m, :precip_in, :vert_vis_ft);";
        $statement = $connect->prepare($query);
        foreach ($xml->data->METAR as $metar) {
            $statement->execute(
                array(
                    ':raw_text' => $metar->raw_text,
                    ':station_id' => $metar->station_id,
                    ':observation_time' => $metar->observation_time,
                    ':latitude' => $metar->latitude,
                    ':longitude' => $metar->longitude,
                    ':temp_c' => $metar->temp_c,
                    ':dewpoint_c' => $metar->dewpoint_c,
                    ':wind_dir_degrees' => $metar->wind_dir_degrees,
                    ':wind_speed_kt' => $metar->wind_speed_kt,
                    ':wind_gust_kt' => $metar->wind_gust_kt,
                    ':visibility_statute_mi' => $metar->visibility_statute_mi,
                    ':altim_in_hg' => $metar->altim_in_hg,
                    ':sea_level_pressure_mb' => $metar->sea_level_pressure_mb,
                    ':flight_category' => $metar->flight_category,
                    ':metar_type' => $metar->metar_type,
                    ':elevation_m' => $metar->elevation_m,
                    ':precip_in' => $metar->precip_in,
                    ':vert_vis_ft' => $metar->vert_vis_ft
                )
            );
        }
    }
}

print '<pre>' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
print '<pre>' . htmlspecialchars(print_r($_SERVER, true)) . '</pre>';

?>