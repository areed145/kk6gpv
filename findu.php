<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- GETS -><?php $callsign = $_GET["callsign"]; ?>
<!– style –><?php include('includes/style.php');?>
<!– mysql_cred –><?php include('includes/mysql_cred.php');?>
<!– fetch_wx –><?php include('includes/fetch_wx.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_wx -><?php include('includes/nav_wx.php');?>

<?php $utc_now = gmdate("Ymd");?>

<html>
    <body>
        <h4 align=center>findu - <?php echo $callsign;?></h4>
        <table bgcolor="#F0FFFF">
            <tr>
                <td width="50%"><p align=center>NEXRAD Radar<img width="100%" src="http://www2.findu.com/cgi-bin/radar-find.cgi?call=<?php echo $callsign;?>"></p></td>
                <td width="50%"><p align=center>Windstar<img width="100%" src="http://www.findu.com/cgi-bin/windstar.cgi?call=<?php echo $callsign;?>&last=120&xsize=200&ysize=200&units=english"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Barometric Pressure<img width="100%" src="http://www.findu.com/cgi-bin/baro.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=200&units=english"></p></td>
                <td width="50%"><p align=center>Rain<img width="100%" src="http://www.findu.com/cgi-bin/rain.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=200&units=english"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Wind<img width="100%" src="http://www.findu.com/cgi-bin/wind.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=200&units=english"></p></td>
                <td width="50%"><p align=center>Temperature<img width="100%" src="http://www.findu.com/cgi-bin/temp.cgi?call=<?php echo $callsign;?>&tz=480&last=120&xsize=350&ysize=200&units=english"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Barometric Pressure QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/AV359?date=<?php echo $utc_now;?>&sensor=baro&addnl=AV359&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Barometric Pressure QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=AV359&sensor=baro"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Temperature QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/AV359?date=<?php echo $utc_now;?>&sensor=temp&addnl=AV359&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Temperature QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=AV359&sensor=temp"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Wind QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/AV359?date=<?php echo $utc_now;?>&sensor=wspd&addnl=AV359&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Wind QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=AV359&sensor=wspd"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Dewpoint QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/AV359?date=<?php echo $utc_now;?>&sensor=dewp&addnl=AV359&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Dewpoint QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=AV359&sensor=dewp"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Rel Humidity QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/AV359?date=<?php echo $utc_now;?>&sensor=rh&addnl=AV359&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Rel Humidity QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=AV359&sensor=rh"></p></td>
            </tr>
        </table>
    </body>
</html>
<!- footer -><?php include('includes/footer.php');?>
