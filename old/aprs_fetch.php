<?php

$call = 'KK6GPV';
$csv = 'aprs_fetch.csv';

$call = $_GET["call"];
$h = $_GET["hours"];

$c = trim($call);
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, "http://www.findu.com/cgi-bin/posit.cgi?call=$c&time=$h&start=$h&comma=1&time=1" );
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true);
$data = curl_exec($ch);

$patterns = array( '/<TITLE>.*<\/TITLE>/' , '/<[^>]*>/' , '/&nbsp;/' );
$data = preg_replace( $patterns , '' , $data );
$data = preg_replace( "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/" , "\n" , $data );
$lines = explode( "\n" , $data );

$fd = fopen($csv, 'w');
fwrite($fd, 'timestamp,lat,lon,course,speed,altitude' . PHP_EOL);
echo 'timestamp,lat,lon,course,speed,altitude';
foreach( $lines as $line )
{
    if ( trim($line) == '' ) continue;
    fwrite($fd, ' ');
    fwrite($fd, substr($line,0,4));
    fwrite($fd, '-');
    fwrite($fd, substr($line,4,2));
    fwrite($fd, '-');
    fwrite($fd, substr($line,6,2));
    fwrite($fd, ' ');
    fwrite($fd, substr($line,8,2));
    fwrite($fd, ':');
    fwrite($fd, substr($line,10,2));
    fwrite($fd, ':');
    fwrite($fd, substr($line,12,2));
    fwrite($fd, ',');
    fwrite($fd, substr($line,15,100));
    fwrite($fd, PHP_EOL);
}
echo $data;
fclose($fd);

?>