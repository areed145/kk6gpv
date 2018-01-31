<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- GETS -><?php $callsign = $_GET["callsign"]; ?>
<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_wx -><?php include('includes/nav_wx.php');?>

<?php $utc_now = gmdate("Ymd");?>

<html>
    <body>
        <h4 align=center>CWOP QC - <?php echo $callsign;?></h4>
        <table bgcolor="#F0FFFF">
            <tr>
                <td width="50%"><p align=center>Barometric Pressure QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/<?php echo $callsign;?>?date=<?php echo $utc_now;?>&sensor=baro&addnl=<?php echo $callsign;?>&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Barometric Pressure QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=<?php echo $callsign;?>&sensor=baro"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Temperature QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/<?php echo $callsign;?>?date=<?php echo $utc_now;?>&sensor=temp&addnl=<?php echo $callsign;?>&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Temperature QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=<?php echo $callsign;?>&sensor=temp"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Dewpoint QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/<?php echo $callsign;?>?date=<?php echo $utc_now;?>&sensor=dewp&addnl=<?php echo $callsign;?>&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Dewpoint QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=<?php echo $callsign;?>&sensor=dewp"></p></td>
            </tr>
            <tr>
                <td width="50%"><p align=center>Rel Humidity QC<img width="100%" src="http://weather.gladstonefamily.net/qchart/<?php echo $callsign;?>?date=<?php echo $utc_now;?>&sensor=rh&addnl=<?php echo $callsign;?>&addnl=CI005&addnl=AT285&addnl=C4038&addnl=UP671&addnl=CSBFL&addnl=UP644&addnl=KBFL&addnl=AN051&addnl=AU202&addnl=E9616"></p></td>
                <td width="50%"><p align=center>Wind QC<img width="100%" src="http://weather.gladstonefamily.net/cgi-bin/wxqual.pl?date=<?php echo $utc_now;?>&days=14&airnow=0&asos=0&percent=5&elevation=0&site=<?php echo $callsign;?>&sensor=wspd"></p></td>
            </tr>
        </table>
    </body>
</html>
<!- footer -><?php include('includes/footer.php');?>
