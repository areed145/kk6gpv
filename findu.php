<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- GETS -><?php $callsign = $_GET["callsign"]; ?>
<!– style –><?php include('includes/style.php');?>
<!– mysql_cred –><?php include('includes/mysql_cred.php');?>
<!– fetch_wx –><?php include('includes/fetch_wx.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_wx -><?php include('includes/nav_wx.php');?>

<html>
    <body>
        <h4 align=center>findu - <?php echo $callsign;?></h4>
        <table bgcolor="#F0FFFF">
            <tr>
                <td width="50%"><p align=center>NEXRAD Radar<img width="100%" src="http://www2.findu.com/cgi-bin/radar-find.cgi?call=<?php echo $callsign;?>"></p></td>
                <td width="50%"><p align=center>Temperature<img width="100%" src="http://www.findu.com/cgi-bin/temp.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=350&units=english"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Barometric Pressure<img width="100%" src="http://www.findu.com/cgi-bin/baro.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=350&units=english"></p></td>
                <td width="50%"><p align=center>Rain<img width="100%" src="http://www.findu.com/cgi-bin/rain.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=350&units=english"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Wind<img width="100%" src="http://www.findu.com/cgi-bin/wind.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=350&units=english"></p></td>
                <td width="50%"><p align=center>Windstar<img width="100%" src="http://www.findu.com/cgi-bin/windstar.cgi?call=<?php echo $callsign;?>&last=120&xsize=350&ysize=350&units=english"></p></td>
            </tr>
        </table>
    </body>
</html>
<!- footer -><?php include('includes/footer.php');?>
