<?php
$sid = $_GET["sid"];
$beg = $_GET["beg"];
$end = $_GET["end"];
for ($date = strtotime("$beg"); $date < strtotime("$end"); $date = strtotime("+1 day", $date)) {
    $Y = date("Y", $date);
    $m = date("m", $date);
    $d = date("d", $date);
    $url = "http://159.89.157.46/includes/mysql_wx.php?sid=$sid&d=$d&m=$m&Y=$Y";
    fopen($url, "r");
}
?>