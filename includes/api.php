<?php
include('mysql_cred.php');
$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}