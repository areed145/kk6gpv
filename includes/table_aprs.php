<?php
$f = fopen("http://www.kk6gpv.net/includes/aprs/aprs_all.csv", "r");

echo "<html><table>\n";
echo "<tr>";
echo "<td>Date / Time (UTC)</td>";
echo "<td>Latitude</td>";
echo "<td>Longitude</td>";
echo "<td>Course (deg)</td>";
echo "<td>Speed (mph)</td>";
echo "<td>Altitude (ft)</td>";
echo "</tr>";
$columns = array(1,2,3,4,5,6);
$flag = true;
while (($line = fgetcsv($f)) !== false) {
    if($flag) { $flag = false; continue; }
        echo "<tr>";
        foreach ($line as $index=>$cell) {
            if (in_array($index+1, $columns)) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
        }
        echo "</tr>\n";
}
fclose($f);
echo "\n</table></html>";
?>