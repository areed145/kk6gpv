<?php
include 'api.php';
$end = $beg+125;

for ($api = $beg; $api <= $end; $api++) {
    $url = "http://159.89.157.46/includes/mysql_doggr.php?api=0$api";
    echo $api."<br>";
    fopen($url, "r");
    file_put_contents('api.php', '<?php $beg = '.var_export($api, true).'; ?>');
}

?>