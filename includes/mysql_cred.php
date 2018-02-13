<?php
error_reporting(0);

$sid = 'KCABAKER64';
$offset = 8;
$callsign = 'KK6GPV';
$callsign_wx = 'KK6GPV-13';
$passcode = 24248;

$databasehost = "localhost";
$databasename = "kk6gpv";
$databasename_doggr = "doggr";
$databaseusername="web";
$databasepassword = "web";

$wxtable = "t_wx_raw";
$wxtable_filter = "v_wx_filter";
$wxtable_wind = "v_wx_wr";
$wxtable_winddrange = "t_wx_wrdrange";
$wxtable_windsrange = "t_wx_wrsrange";
$aprstable = "t_aprs_raw";
$awstable = "v_aws";
$awstableraw = "t_aws_raw";
$doggrtable_prodinj = "t_doggr_prodinj";

$sq = 10;
$inc = 0.001;
$hours = 48;

?>