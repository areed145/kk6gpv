<?php
//include 'aprs.php';
$c = 'KCABAKER38';
$csv = 'cocobaro_fetch_daily.csv';

$call = $_GET["call"];
$d = date('d');
$m = date("m");
$Y = date("Y");

$c = trim($c);
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, "https://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=$c&day=$d&month=$m&year=$Y&graphspan=day&format=1" );
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true);
$data = curl_exec($ch);

$patterns = array( '/<TITLE>.*<\/TITLE>/' , '/<[^>]*>/' , '/&nbsp;/' );
$data = preg_replace( $patterns , '' , $data );
$data = preg_replace( "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/" , "\n" , $data );

$fd = fopen($csv, 'w');
fwrite($fd, $data);
echo $data;
fclose($fd);

?>