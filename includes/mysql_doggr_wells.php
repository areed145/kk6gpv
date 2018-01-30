<?php

$databasehost = "localhost";
$databasename = "kksixgpv_doggr";
$databaseusername="kksixgpv_repo";
$databasepassword = "+U0bzMWSxHla";
$databasetable = "t_wells";
$csv = "AllWells.csv";

try {
    $pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", 
        $databaseusername, $databasepassword,
        array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
} catch (PDOException $e) {
    die("database connection failed: ".$e->getMessage());
}

$affectedRows = $pdo->exec("
    LOAD DATA LOCAL INFILE ".$pdo->quote($csv)." 
    INTO TABLE `$databasetable` 
    FIELDS TERMINATED BY ',' 
    LINES TERMINATED BY '\n' 
    IGNORE 1 LINES");
echo "Loaded a total of $affectedRows records from this csv file.\n";

?>