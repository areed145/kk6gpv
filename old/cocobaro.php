<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- google analytics -><?php include('includes/google_analytics.php');?>
<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>

<html>

<h4 align=center>Coconut Barometer</h4>

<table>
<col style="width:30%">
<col style="width:70%">
  <tr>
    <td><p align=center><img border=0 width="100%" src="content/wxstation.jpg"></p></td>
    <td><p align=center>The Coconut Barometer station is a Ambient Weather WS-1400-IP connected to the ObserverIP, which communicates observation data exclusively to Weather Underground as KCABAKER38.</p></td>
  </tr>
  <tr>
    <td><p align=center><img border=0 width="100%" src="content/rpi.jpg"></p></td> 
    <td><p align=center>Observation data is then retrieved from Weather Underground and the plots / graphs are created via a headless Raspberry Pi 3 running wx_scraper Python software I wrote for this purpose (see GitHub page)</p></td>
  </tr>
    <tr>
    <td><p align=center>
        <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=KCABAKER38">
        <img src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250&weatherstationcount=KCABAKER38" width="250" height="150" border="0" alt="Weather Underground PWS KCABAKER38" />
        </a></p></td> 
    <td><p align=center><a href="https://www.wunderground.com/personal-weather-station/dashboard?ID=KCABAKER38">Weather Underground PWS page</p></td>
  </tr>
</table>

</html>

<!- footer -><?php include('includes/footer.php');?>
