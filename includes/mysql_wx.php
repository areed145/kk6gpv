<?php
include('mysql_cred.php');

$sid = $_GET["sid"];
$d = $_GET["d"];
$m = $_GET["m"];
$Y = $_GET["Y"];

$xml = simplexml_load_file("https://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=$sid&day=$d&month=$m&year=$Y&graphspan=day&format=XML");
$connect = new PDO("mysql:host=$databasehost;dbname=$databasename", $databaseusername, $databasepassword);
$query = "INSERT INTO $wxtable
           (sid, type, lat, lon, ele, city, state, datetimeUTC, wx, temp_f, temp_c, hum, wind_str, wind_dir, wind_deg, wind_mph, wind_gust, pres_mb, pres_in, dewpt_f, dewpt_c, hi_f, hi_c, wc_f, wc_c, solar, uv, preciphr_in, preciphr_mm, precipday_in, precipday_mm) 
           VALUES(:sid, :type, :lat, :lon, :ele, :city, :state, :datetimeUTC, :wx, :temp_f, :temp_c, :hum, :wind_str, :wind_dir, :wind_deg, :wind_mph, :wind_gust, :pres_mb, :pres_in, :dewpt_f, :dewpt_c, :hi_f, :hi_c, :wc_f, :wc_c, :solar, :uv, :preciphr_in, :preciphr_mm, :precipday_in, :precipday_mm);";
$statement = $connect->prepare($query);
foreach ($xml->current_observation as $obs) {
    $statement->execute(
        array(
            ':sid' => $obs->station_id,
            ':type' => $obs->station_type,
            ':lat' => $obs->location->latitude,
            ':lon' => $obs->location->longitude,
            ':ele' => $obs->location->elevation,
            ':city' => $obs->location->city,
            ':state' => $obs->location->state,
            ':datetimeUTC' => date('Y-m-d H:i:s', strtotime($obs->observation_time_rfc822)),
            ':wx' => $obs->weather,
            ':temp_f' => $obs->temp_f,
            ':temp_c' => $obs->temp_c,
            ':hum' => $obs->relative_humidity,
            ':wind_str' => $obs->wind_string,
            ':wind_dir' => $obs->wind_dir,
            ':wind_deg' => $obs->wind_degrees,
            ':wind_mph' => $obs->wind_mph,
            ':wind_gust' => $obs->wind_gust_mph,
            ':pres_mb' => $obs->pressure_mb,
            ':pres_in' => $obs->pressure_in,
            ':dewpt_f' => $obs->dewpoint_f,
            ':dewpt_c' => $obs->dewpoint_c,
            ':hi_f' => $obs->heat_index_f,
            ':hi_c' => $obs->heat_index_c,
            ':wc_f' => $obs->windchill_f,
            ':wc_c' => $obs->windchill_c,
            ':solar' => $obs->solar_radiation,
            ':uv' => $obs->UV,
            ':preciphr_in' => $obs->precip_1hr_in,
            ':preciphr_mm' => $obs->precip_1hr_metric,
            ':precipday_in' => $obs->precip_today_in,
            ':precipday_mm' => $obs->precip_today_metric
        )
    );
}

// print '<pre>' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
// print '<pre>' . htmlspecialchars(print_r($_SERVER, true)) . '</pre>';

?>