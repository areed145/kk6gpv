<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- GETS -><?php
if (isset($_GET["callsign"])){$callsign = $_GET["callsign"];}
?>
<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_wx -><?php include('includes/nav_wx.php');?>

<?php $utc_now = gmdate("Ymd");?>

<html>
    <body>
        <h4 align=center>findu - <?php echo $callsign;?></h4>
        <table>
            <tr bgcolor="#F0FFFF">
                <td>NEXRAD Radar</td>
                <td>Windstar</td>
            </tr>
            <tr>
                <td width="50%"><p align=center><img width="100%" src="http://www2.findu.com/cgi-bin/radar-find.cgi?call=<?php echo $callsign;?>"></p></td>
                <td width="50%"><p align=center><img width="100%" src="http://www.findu.com/cgi-bin/windstar.cgi?call=<?php echo $callsign;?>&last=120&xsize=200&ysize=200&units=english"></p></td>
            </tr>
            <tr bgcolor="#F0FFFF">
                <td>Barometric Pressure</td>
                <td>Rain</td>
            </tr>
            <tr>
                <td width="50%"><p align=center><img width="100%" src="http://www.findu.com/cgi-bin/baro.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=200&units=english"></p></td>
                <td width="50%"><p align=center><img width="100%" src="http://www.findu.com/cgi-bin/rain.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=200&units=english"></p></td>
            </tr>
            <tr bgcolor="#F0FFFF">
                <td>Wind</td>
                <td>Temperature</td>
            </tr>
            <tr>
                <td width="50%"><p align=center><img width="100%" src="http://www.findu.com/cgi-bin/wind.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=200&units=english"></p></td>
                <td width="50%"><p align=center><img width="100%" src="http://www.findu.com/cgi-bin/temp.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=200&units=english"></p></td>
            </tr>
        </table>
    </body>
</html>
<!- footer -><?php include('includes/footer.php');?>
