<?php
error_reporting(0);

$sid = 'KCABAKER64';
$url = "https://www.wunderground.com/weatherstation/WXCurrentObXML.asp?ID=$sid";
$obs = simplexml_load_file($url);

$sid = $obs->station_id;
$type = $obs->station_type;
$latitude = $obs->location->latitude;
$longitude = $obs->location->longitude;
$ele = $obs->location->elevation;
$city = $obs->location->city;
$state = $obs->location->state;
$date = date('Y-m-d H:i:s', strtotime($obs->observation_time_rfc822));
$wx = $obs->weather;
$temp_f = $obs->temp_f;
$temp_c = $obs->temp_c;
$hum = $obs->relative_humidity;
$wind_str = $obs->wind_string;
$wind_dir = $obs->wind_dir;
$wind_deg = $obs->wind_degrees;
$wind_mph = $obs->wind_mph;
$wind_gust = $obs->wind_gust_mph;
$pres_mb = $obs->pressure_mb;
$pres_in = $obs->pressure_in;
$dewpt_f = $obs->dewpoint_f;
$dewpt_c = $obs->dewpoint_c;
$hi_f = $obs->heat_index_f;
$hi_c = $obs->heat_index_c;
$wc_f = $obs->windchill_f;
$wc_c = $obs->windchill_c;
$solar = $obs->solar_radiation;
$uv = $obs->UV;
$preciphr_in = $obs->precip_1hr_in;
$preciphr_mm = $obs->precip_1hr_metric;
$precipday_in = $obs->precip_today_in;
$precipday_mm = $obs->precip_today_metric;

?>