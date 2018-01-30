<!doctype html>
<?php $utc_now = gmdate("Y-m-d H:i:s");?>
<html>
<hr>
<p align=center>
<a href="index.php">Home</a> | 
<a href="wx.php?sid=KCABAKER64&period=today&<?php echo $utc_now;?>">Station Data</a> | 
<a href="aws.php?data=flight_category&min=29.5&max=30.5&<?php echo $utc_now;?>">Aviation Weather</a> | 
<a href="aircraft.php">Aircraft</a> | 
<a href="paragliding.php">Paragliding</a> | 
<a href="soaring.php">Soaring</a> | 
<a href="n5777v.php">N5777V</a> | 
<a href="aprs.php?period=today&<?php echo $utc_now;?>">APRS</a> |  
<a href="travel.php">Travel</a> | 
<a href="photos.php">Photos</a> | 
<a href="links.php">Links</a> | 
<a href="doggr.php?<?php echo $utc_now;?>">DOGGR</a>
</p>
<hr>
</html>