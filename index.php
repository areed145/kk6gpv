<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- updates -><?php include('includes/updates.php');?>
<!- current_wx -><?php include('includes/current_wx.php');?>
<html>
    <head>
        <!-- Plotly.js --><script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    </head>
<h4 align=center>Coconut Barometer</h4>
<table>
    <tr bgcolor="#F0FFFF">
        <td>Station ID</td>
        <td>Latitude</td>
        <td>Longitude</td>
        <td>Elevation</td>
        <td>City</td>
        <td>State</td>
        <td>Observation Date</td>
    </tr>
    <tr>
        <td><?php echo $sid;?></td>
        <td><?php echo $latitude;?></td>
        <td><?php echo $longitude;?></td>
        <td><?php echo $ele;?></td>
        <td><?php echo $city;?></td>
        <td><?php echo $state;?></td>
        <td><?php echo $date;?> GMT</td>
    </tr>
</table>
<table>
    <tr bgcolor="#F0FFFF">
        <td>Temp - <?php echo $temp_f; ?>F</td>
        <td>Dewpoint - <?php echo $dewpt_f; ?>F</td>
        <td>Humidity - <?php echo $hum; ?>%</td>
        <td>Pressure - <?php echo $pres_in; ?> inHg</td>
    </tr>
    <tr>
        <td><div align=center id="gauge_temp" width="100%"></td>
        <td><div align=center id="gauge_dewpt" width="100%"></td>
        <td><div align=center id="gauge_hum" width="100%"></td>
        <td><div align=center id="gauge_pres" width="100%"></td>
    </tr>
</table>
<table>
    <tr bgcolor="#F0FFFF">
        <td>Wind Degrees - <?php echo $wind_deg; ?> deg</td>
        <td>Wind/Gust - <?php echo $wind_mph; ?>/<?php echo $wind_gust; ?> mph</td>
        <td>Daily Rain - <?php echo $precipday_in; ?> in</td>
        <td>Solar - <?php echo $solar; ?> W/m^2</td>
        <td>UV - <?php echo $uv; ?></td>
    </tr>
    <tr>
        <td><div align=center id="gauge_winddeg" width="100%"></td>
        <td><div align=center id="gauge_windspd" width="100%"></td>
        <td><div align=center id="gauge_rain" width="100%"></td>
        <td><div align=center id="gauge_solar" width="100%"></td>
        <td><div align=center id="gauge_uv" width="100%"></td>
    </tr>
</table>
<table>
<col style="width:60%">
<col style="width:30%">
<col style="width:30%">
  <tr>
    <td rowspan=2><p align=center>NEXRAD Radar<img width="100%" src="http://www2.findu.com/cgi-bin/radar-find.cgi?call=<?php echo $callsign;?>"></p></td>
    <td><p align=center><img border=0 width="100%" src="content/wxstation.jpg"></p></td>
    <td><p align=center>The Coconut Barometer station is a Ambient Weather WS-1400-IP connected to the ObserverIP, which communicates observation data exclusively to Weather Underground as KCABAKER38.</p></td>
  </tr>
  <tr>
    <td><p align=center><img border=0 width="100%" src="content/rpi.jpg"></p></td> 
    <td><p align=center>Observation data is then retrieved from Weather Underground and the plots / graphs are created via a headless Raspberry Pi 3 running wx_scraper Python software I wrote for this purpose (see GitHub page)</p></td>
  </tr>
    <tr>
    <td><p align=center>
        <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=KCABAKER64">
        <img src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250&weatherstationcount=KCABAKER64" width="250" height="150" border="0" alt="Weather Underground PWS KCABAKER64" />
        </a></p></td> 
    <td><p align=center><a href="https://www.wunderground.com/personal-weather-station/dashboard?ID=KCABAKER64">Weather Underground PWS page</p></td>
  </tr>
</table>
</html>
<!- plotly_gauge -><?php include('includes/plotly_gauge.php');?>
<!- footer -><?php include('includes/footer.php');?>
