<?php

$c = "KCABAKER38";
$d = date("d");
$m = date("m");
$Y = date("Y");

$databasehost = "72.167.233.52";
$databasename = "coconutbarometer";
$databaseusername="coconutbarometer";
$databasepassword = "C0c0B@r0";

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
echo "Success!";

$query_update = 'call p_wx_update ()';

mysqli_query($con, $query_update); 

mysqli_close($con);

?>