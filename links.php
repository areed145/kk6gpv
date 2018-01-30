<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- google analytics -><?php include('includes/google_analytics.php');?>
<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<?php $utc_now = gmdate("Y-m-d H:i:s");?>
<html>
<h4 align=center>Links</h4>
<table>
  <tr>
    <td>Weather Station</td>
    <td>Photography</td> 
    <td>APRS</td>
    <td>Aviation</td>
    <td>Programming</td>
  </tr>
  <tr>
    <td>
    <a href="wx.php?sid=KCABAKER64&period=today&<?php echo $utc_now;?>">Today</a><br>
    <a href="wx.php?sid=KCABAKER64&period=week&<?php echo $utc_now;?>">Week</a><br>
    <a href="wx.php?sid=KCABAKER64&period=month&<?php echo $utc_now;?>">Month</a><br>
    <a href="wx.php?sid=KCABAKER64&period=3month&<?php echo $utc_now;?>">3-Month</a><br>
    <a href="wx.php?sid=KCABAKER64&period=6month&<?php echo $utc_now;?>">6-Month</a><br>
    <a href="wx.php?sid=KCABAKER64&period=year&<?php echo $utc_now;?>">Year</a><br>
    <a href="wx.php?sid=KCABAKER64&period=all&<?php echo $utc_now;?>">All</a><br>
    <a href="admin.php">Admin</a>
    </td>
    <td>
    <a href="photos.php">Photos</a><br>
    <a href="https://www.flickr.com/">Flickr</a><br>
    <a href="https://www.flickr.com/photos/adamreeder/albums">Flickr Albums</a><br>
    <a href="https://www.flickr.com/photos/adamreeder/">Flickr Photostream</a><br>
    <a href="https://www.flickr.com/photos/adamreeder/favorites">Flickr Favorites</a><br>
    <a href="https://www.flickr.com/people/adamreeder/">Flickr About Me</a>
    </td>
    <td>
    <a href="aprs.php?period=today&<?php echo $utc_now;?>">Today</a><br>
    <a href="aprs.php?period=week&<?php echo $utc_now;?>">Week</a><br>
    <a href="aprs.php?period=month&<?php echo $utc_now;?>">Month</a><br>
    <a href="aprs.php?period=3month&<?php echo $utc_now;?>">3-Month</a><br>
    <a href="aprs.php?period=6month&<?php echo $utc_now;?>">6-Month</a><br>
    <a href="aprs.php?period=year&<?php echo $utc_now;?>">Year</a><br>
    <a href="aprs.php?period=all&<?php echo $utc_now;?>">All</a><br>
    <a href="http://aprs.fi/info/a/KK6GPV">aprs.fi KK6GPV Data</a><br>
    <a href="http://aprs.fi/info/a/KK6GPV-13">aprs.fi KK6GPV-13 Data</a><br>
    <a href="http://www.findu.com/cgi-bin/find.cgi?call=kk6gpv">findu KK6GPV Data</a><br>
    <a href="http://www.findu.com/cgi-bin/find.cgi?call=kk6gpv-13">findu KK6GPV-13 Data</a><br>
    <a href="http://www.qrz.com/db/kk6gpv">QRZ Lookup</a>
    </td>
    <td>
    <a href="aircraft.php">Aircraft</a><br>
    <a href="soaring.php">Soaring</a><br>
    <a href="paragliding.php">Paragliding</a><br>
    <a href="n5777v.php">N5777V</a><br>
    <a href="http://www.paraglidingforum.com/leonardo/stats/world/alltimes/brand:all,cat:0,class:all,xctype:all,club:all,pilot:0_53757,takeoff:all">LEONARDO Paragliding Flights</a><br>
    <a href="https://www.windfinder.com/forecast/bakersfield_ant_hill">Windfinder - Ant Hill</a><br>
    <a href="https://windria.net/edison-ca">Windria - Ant Hill</a><br>
    <a href="http://www.wrh.noaa.gov/sgx/data/aviation/soar.htm">SoCal Soaring Forecast</a><br>
    <a href="http://www.wrh.noaa.gov/total_forecast/getprod.php?afos=xxxsrgrev&wfo=rev&version=0&font=120&print=yes">Reno Soaring Forecast</a><br>
    <a href="aws.php?data=flight_category&<?php echo $utc_now;?>">Flight Category</a><br>
    <a href="aws.php?data=temp_c&min=-10&max=30&<?php echo $utc_now;?>">Temp</a><br>
    <a href="aws.php?data=altim_in_hg&min=29.5&max=30.5&<?php echo $utc_now;?>">Altimeter</a><br>
    <a href="aws.php?data=wind_dir_degrees&min=0&max=360&<?php echo $utc_now;?>">Wind Direction</a><br>
    <a href="aws.php?data=wind_speed_kt&min=0&max=30&<?php echo $utc_now;?>">Windspeed</a><br>
    <a href="aws.php?data=visibility_statute_mi&min=0&max=10&<?php echo $utc_now;?>">Visibility</a><br>
    <a href="aws.php?data=pred_cloudbase_agl&min=0&max=8000&<?php echo $utc_now;?>">Pred Cloudbase AGL</a><br>
    <a href="aws.php?data=pred_cloudbase_msl&min=0&max=8000&<?php echo $utc_now;?>">Pred Cloudbase MSL</a><br>
    <a href="aws.php?data=elevation_m&min=0&max=3000&<?php echo $utc_now;?>">Elevation</a><br>
    <a href="aws.php?data=age&min=0&max=60&<?php echo $utc_now;?>">Age</a>
    </td>
    <td>
    <a href="programming.php">Programming</a><br>
    <a href="https://github.com/areed145/">GitHub</a><br>
    </td>
  </tr>
</table>
</html>
<!- footer -><?php include('includes/footer.php');?>
