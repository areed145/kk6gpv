<?php
error_reporting(0);

$c = "KK6GPV";
$h = $_GET["hours"];

include('mysql_cred.php');

$fieldseparator = ",";
$lineseparator = "\n";
$csv = "aprs/aprs_fetch.csv";
$csv_all = "aprs/aprs_all.csv";

$c = trim($c);
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
fclose($fd);

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
    LOAD DATA LOCAL INFILE ".$pdo->quote($csv)." INTO TABLE `$aprstable`
      FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
      LINES TERMINATED BY ".$pdo->quote($lineseparator)."
      IGNORE 2 LINES");
echo "Loaded a total of $affectedRows records from this csv file.\n";

$con = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
echo "Success!";

mysqli_close($con);

?>