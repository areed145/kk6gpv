<?php
$f = fopen("http://www.kk6gpv.net/includes/wx/wx_filter_$time.csv", "r");

echo "<html><table>\n";
echo "<tr>";
echo "<td>Time (local)</td>";
echo "<td>Temp (F)</td>";
echo "<td>Dewpoint (F)</td>";
echo "<td>Pressure (inHg)</td>";
echo "<td>Wind (deg)</td>";
echo "<td>Wind Speed (mph)</td>";
echo "<td>Wind Gust (mph)</td>";
echo "<td>Humidity (%)</td>";
echo "<td>Precip. Hourly (in/hr)</td>";
echo "<td>Precip. Daily (in)</td>";
echo "<td>Solar Rad. (W/m<sup>2</sup>)</td>";
echo "<td>Min. Cloudbase (ft)</td>";
echo "</tr>";
$columns = array(1,2,3,4,5,6,7,8,9,10,11,14);
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