<?php
error_reporting(0);

$sid = 'KCABAKER64';
$end = date("Y-m-d",strtotime('+2 days'));
$beg = date("Y-m-d",strtotime('-3 days'));
$url = "http://159.89.157.46/includes/mysql_wx_loop.php?sid=$sid&beg=$beg&end=$end";
echo $url;
fopen($url, 'r');
?>