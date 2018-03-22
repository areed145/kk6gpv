<?php
error_reporting(0);

include('mysql_cred.php');
$callsign = trim($callsign);
$url = "http://www.findu.com/cgi-bin/posit.cgi?call=$callsign&start=$hours&comma=1&time=1";
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url);
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true);
$data = curl_exec($ch);
$patterns = array( '/<TITLE>.*<\/TITLE>/' , '/<[^>]*>/' , '/&nbsp;/' );
$data = preg_replace( $patterns , '' , $data );
$data = preg_replace( "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/" , "\n" , $data );
$lines = explode( "\n" , $data );
$connect = new PDO("mysql:host=$databasehost;dbname=$databasename", $databaseusername, $databasepassword);
foreach( $lines as $line) {
    if ( trim($line) == '' ) continue;
    $arr = explode(",", $line);
    $dt = $arr[0];
    $Y = substr($dt,0,4);
    $m = substr($dt,4,2);
    $d = substr($dt,6,2);
    $H = substr($dt,8,2);
    $M = substr($dt,10,2);
    $S = substr($dt,12,2);
    $dt = $Y."-".$m."-".$d." ".$H.":".$M.":".$S;
    $lat = $arr[1];
    $lon = $arr[2];
    $crs = $arr[3];
    $spd = $arr[4];
    $alt = $arr[5];
    $query = "INSERT INTO $aprstable
           (timestamp, latitude, longitude, course, speed, altitude) 
           VALUES('$dt', $lat, $lon, $crs, $spd, $alt);";
    $connect->exec($query);
    //echo $query;
}

$url = "http://www.findu.com/cgi-bin/raw.cgi?call=$callsign&start=$hours&time=1";
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url);
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true);
$data = curl_exec($ch);
$patterns = array( '/<TITLE>.*<\/TITLE>/' , '/<[^>]*>/' , '/&nbsp;/' );
$data = preg_replace( $patterns , '' , $data );
$data = preg_replace( "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/" , "\n" , $data );
$lines = explode( "\n" , $data );
foreach( $lines as $line) {
    if ( trim($line) == '' ) continue;
    $arr = explode(",", $line);
    $dt = $arr[0];
    $Y = substr($dt,0,4);
    $m = substr($dt,4,2);
    $d = substr($dt,6,2);
    $H = substr($dt,8,2);
    $M = substr($dt,10,2);
    $S = substr($dt,12,2);
    $dt = $Y."-".$m."-".$d." ".$H.":".$M.":".$S;
    $arr = explode("=", $line);
    $pth = "'".substr($arr[0],15,100)."'";
    $com = "'".substr($arr[2],6,100)."'";
    $query = "INSERT INTO $aprstable (timestamp, comment, path) VALUES('$dt', $com, $pth) ON DUPLICATE KEY UPDATE comment = $com, path = $pth;";
    $connect->exec($query);
    //echo $query;

$query = "DELETE FROM $aprstable WHERE latitude = 0 AND longitude = 0;";
$connect->exec($query);
}

?>