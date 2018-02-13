<?php
error_reporting(0);

include('mysql_cred.php');

$aprs_php_ver = "0.1";
$aprsis_url = "http://srvr.aprs-is.net:8080";
date_default_timezone_set('UTC');
$path = "APRS,WIDE2-2,TCPIP*";

$url = "https://www.wunderground.com/weatherstation/WXCurrentObXML.asp?ID=$sid";
$obs = simplexml_load_file($url);

$sid = $obs->station_id;
$type = $obs->station_type;
$latitude = $obs->location->latitude;
$longitude = $obs->location->longitude;
$ele = $obs->location->elevation;
$city = $obs->location->city;
$state = $obs->location->state;
$date = date('dHi', strtotime($obs->observation_time_rfc822));
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

$latRaw = floatval($latitude);
$lngRaw = floatval($longitude);
$latMin = fmod($latRaw,1);
$lngMin = fmod($lngRaw,-1);
$lat = str_pad(abs($latRaw - $latMin),2,"0");
$lng = str_pad(abs($lngRaw - $lngMin),3,"0",STR_PAD_LEFT);
number_format((float)$latMin, 2, '.', '');
$latMin = abs($latMin*60);
$lngMin = abs($lngMin*60);
$latMin = number_format((float)$latMin, 2, '.', '');
$lngMin = number_format((float)$lngMin, 2, '.', '');
if(strpos($latMin,'.') <= 1){$latMin = "0" . $latMin;}
if(strpos($lngMin,'.') <=1){$lngMin = "0" . $lngMin;}
$lat .= $latMin;
$lng .= $lngMin;
$lat .= $latRaw >= 0 ? "N" : "S";
$lng .= $lngRaw >= 0 ? "E" : "W";

$humc = $hum;
if ($humc > 99){$humc = 99;}

if ($solarc > 1000) {
    $wx = sprintf('_'."%03d/%03dg%03dt%03dr%03dl%03dP%03dh%02db%05d",
        $wind_deg,
        $wind_mph,
        $wind_gust,
        $temp_f,
        floatval($preciphr_in)*100,
        $solar-1000,
        floatval($precipday_in)*100, 
        $humc,
        floatval($pres_mb)*10);
} else {
    $wx = sprintf('_'."%03d/%03dg%03dt%03dr%03dL%03dP%03dh%02db%05d",
        $wind_deg,
        $wind_mph,
        $wind_gust,
        $temp_f,
        floatval($preciphr_in)*100,
        $solar,
        floatval($precipday_in)*100, 
        $humc,
        floatval($pres_mb)*10);
}

$message = $date."z";
$message .= $lat."/".$lng;
$message .= $wx.$sid;

$login_line = "user ".$callsign_wx." pass ". $passcode." vers aprs.php $aprs_php_ver\n";
$message_line = $callsign_wx .">" . $path . ":@" . $message . "\n";

$ch = curl_init();
$curl_opts = array(
	CURLOPT_URL => $aprsis_url,
	CURLOPT_POST => true,
	CURLOPT_HTTPHEADER => array(
		'Accept-Type: text/plain',
		'Content-type: application/octet-stream',
	),
	CURLOPT_POSTFIELDS => $login_line . $message_line,
	CURLOPT_RETURNTRANSFER => 1
);
curl_setopt_array($ch, $curl_opts); 
$output = curl_exec($ch);
$return = curl_getinfo($ch);
if($return['http_code'] == 204){$responseMessage = $message_line;}
else{$responseMessage = "Error from APRS-IS: " . $return['http_code'];}
curl_close($ch);
echo $responseMessage;

print '<pre>' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
print '<pre>' . htmlspecialchars(print_r($_SERVER, true)) . '</pre>';

?>