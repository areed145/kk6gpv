<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- GETS -><?php
if (isset($_GET["period"])){$period = $_GET["period"];}
?>
<!– style –><?php include('includes/style.php');?>
<!– mysql_cred –><?php include('includes/mysql_cred.php');?>
<!– fetch_aprs –><?php include('includes/fetch_aprs.php');?>
<!– header –><?php include('includes/header.php');?>
<!– colormaps –><?php include('includes/colormaps.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_aprs -><?php include('includes/nav_aprs.php');?>

<html>
    <head>
        <!-- Plotly.js --><script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    </head>
    <body>
        <h4 align=center>APRS - HAM Radio - <?php echo $period;?></h4>
        <h5 align=center>(<?php echo $start;?> to <?php echo $end;?>) - updated: <?php echo gmdate("Y-m-d H:i:s");?></h5>
        <table>
            <tr>
                <td>
                <p>My main interest in amateur radio has to do with APRS (Automatic Packet Reporting System), an <a href="https://en.wikipedia.org/wiki/Amateur_radio">amateur radio</a>-based system for real time tactical digital communications of information of immediate value in the local area.
                <p>Below are maps generated from data reported from APRS beaconing, typically while flying. aprs.fi maintains historical daily logs of points and tracks.</p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F0FFFF">
                <p align=center>
                KK6GPV Position Reports - Altitude
                <div id="aprs_map" width="100%"></div>
                </p>
            </tr>
                </tr>
                <td bgcolor="#F0FFFF">
                <p align=center>
                KK6GPV Telemetry
                <div id="aprs_plot" width="100%"></div>
                </p>
                </td>
            </tr>
        </table>
        <h4 align=center>Bakersfield Area HAM Frequencies</h4>
        <table>
        <thead>
        <tr>
            <td>Frequency</td>
            <td>Offset</td>
            <td>Tone</td>
            <td>Location</td>
            <td>Comment</td>
        </tr>
        </thead>
        <tr>
            <td>145.150</td>
            <td>-</td>
            <td>100.0</td>
            <td>Breckenridge Mt.</td>
            <td></td>
        </tr>
        <tr>
        	<td>146.910</td>
            <td>-</td>
            <td>100.0</td>
            <td>Grapevine Pk.</td>
            <td>Temporary Antenna - Storm Damage</td>
        </tr>
        <tr>
        	<td>224.060</td>
            <td>-</td>
            <td>100.0</td>
            <td>Breckenridge Mt.</td>
            <td></td>
        </tr>
        <tr>
        	<td>443.900</td>
            <td>+</td>
            <td>100.0</td>
            <td>Low level North of Town</td>
            <td></td>
        </tr>
        <tr>
        	<td class="column-1">52.780</td>
            <td class="column-2">-</td>
            <td class="column-3">82.5</td>
            <td class="column-4">Grapevine Pk.</td>
            <td class="column-5">Off the Air - Storm Damage</td>
        </tr>
        <tr>
        	<td class="column-1">147.210</td>
            <td class="column-2">+</td>
            <td class="column-3">100.0</td>
            <td class="column-4">Mt. Adelaide</td>
            <td class="column-5">KC6EOC</td>
        </tr>
        <tr>
        	<td class="column-1">145.050</td>
            <td class="column-2"></td>
            <td class="column-3"></td>
            <td class="column-4">Packet @ County EOC</td>
            <td class="column-5">PBBS: KC6EOC-1</td>
        </tr>
        <tr>
        	<td class="column-1">147.150</td>
            <td class="column-2">+</td>
            <td class="column-3">100.0</td>
            <td class="column-4"></td>
            <td class="column-5">ARRG Echo Link 56555</td>
        </tr>
        <tr>
        	<td class="column-1">224.520</td>
            <td class="column-2">-</td>
            <td class="column-3">100.0</td>
            <td class="column-4"></td>
            <td class="column-5">ARRG</td>
        </tr>
        <tr>
        	<td class="column-1">444.425</td>
            <td class="column-2">+</td>
            <td class="column-3">100.0</td>
            <td class="column-4">Tehachapi</td>
            <td class="column-5">ARRG</td>
        </tr>
        <tr>
        	<td class="column-1">51.880</td>
            <td class="column-2">-</td>
            <td class="column-3">114.8</td>
            <td class="column-4"></td>
            <td class="column-5">ARRG</td>
        </tr>
        <tr>
        	<td class="column-1">146.670</td>
            <td class="column-2">-</td>
            <td class="column-3">100.0</td>
            <td class="column-4">Mt. Adelaide</td>
            <td class="column-5">IRLP 3714, Echo Link 983970</td>
        </tr>
        <tr>
        	<td class="column-1">444.750</td>
            <td class="column-2">+</td>
            <td class="column-3">141.3</td>
            <td class="column-4">Mt. Adelaide</td>
            <td class="column-5">IRLP 3901</td>
        </tr>
        <tr>
        	<td class="column-1">447.040</td>
            <td class="column-2">-</td>
            <td class="column-3">136.5</td>
            <td class="column-4">Frazier Mt.</td>
            <td class="column-5">IRLP 7814</td>
        </tr>
        <tr>
        	<td class="column-1">52.525</td>
            <td class="column-2">simplex</td>
            <td class="column-3"></td>
            <td class="column-4">Mt. Adelaide</td>
            <td class="column-5">linked to 444.750</td>
        </tr>
        <tr>
        	<td class="column-1">29.600</td>
            <td class="column-2">simplex</td>
            <td class="column-3"></td>
            <td class="column-4">Mt. Adelaide</td>
            <td class="column-5">linked to 444.750</td>
        </tr>
        <tr>
        	<td class="column-1">144.390</td>
            <td class="column-2"></td>
            <td class="column-3"></td>
            <td class="column-4"></td>
            <td class="column-5">N American APRS reporting frequency</td>
        </tr>
        </table>
        <h4 align=center>HAM Equipment</h4>
        <table>
        <tr>
            <td width="30%">Item</td>
            <td width="30%">Description</td>
            <td width="40%">Image</td>
        </tr>
        <tr>
        	<td><a href="https://www.yaesu.com/indexVS.cfm?cmd=DisplayProducts&amp;ProdCatID=111&amp;encProdID=4A66D869E574453F343581B53E9FAB40" target="_blank">Yaesu FT-2DR</a></td>
            <td>Dual band, APRS, touchscreen</td>
            <td><img src="content/yaesu.jpg"/></td>
        </tr>
        <tr>
        	<td><a href="https://baofengradio.us/uv-5r-v2-2nd-gen/baofeng-uv5rv2-black-220.html" target="_blank">Baofeng UV-5R</a></td>
            <td>Cheap, easy to use</td>
            <td><img src="content/baofeng.jpg"/></td>
        </tr>
        <tr>
            <td><a href="content/qsl.png" target="_blank">QSL Card</a></td>
            <td>
                <p align=center><a href="http://aprs.fi/info/a/KK6GPV">aprs.fi Station Data</a></p>
                <p align=center><a href="http://www.findu.com/cgi-bin/find.cgi?call=kk6gpv">findu Station Data</a></p>
                <p align=center><a href="http://www.qrz.com/db/kk6gpv">QRZ Lookup</a></p>
            </td>
            <td><p align=center><a href="content/qsl.png"><img src="content/qsl.png" width="100%"></a></p></td>
        </tr>
        </table>
    </body>
<!- plotly_aprs -><?php include('includes/plotly_aprs.php');?>
</html>

<!- footer -><?php include('includes/footer.php');?>
