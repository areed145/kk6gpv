<!doctype html>
<?php $utc_now = gmdate("Y-m-d H:i:s");?>
<html>
<p align=center>
<a href="aws.php?data=flight_category&<?php echo $utc_now;?>">Flight Category</a> | 
<a href="aws.php?data=temp_c&min=-10&max=30&<?php echo $utc_now;?>">Temp</a> | 
<a href="aws.php?data=dewpoint_c&min=-10&max=30&<?php echo $utc_now;?>">Dewpoint</a> | 
<a href="aws.php?data=altim_in_hg&min=29.5&max=31&<?php echo $utc_now;?>">Altimeter</a> | 
<a href="aws.php?data=wind_dir_degrees&min=0&max=360&<?php echo $utc_now;?>">Wind Direction</a> | 
<a href="aws.php?data=wind_speed_kt&min=0&max=30&<?php echo $utc_now;?>">Windspeed</a> | 
<a href="aws.php?data=wind_gust_kt&min=0&max=30&<?php echo $utc_now;?>">Wind Gust</a> | 
<a href="aws.php?data=visibility_statute_mi&min=0&max=10&<?php echo $utc_now;?>">Visibility</a> | 
<a href="aws.php?data=pred_cloudbase_agl&min=0&max=2000&<?php echo $utc_now;?>">Cloudbase AGL (pred)</a> | 
<a href="aws.php?data=pred_cloudbase_msl&min=0&max=8000&<?php echo $utc_now;?>">Cloudbase MSL (pred)</a> | 
<a href="aws.php?data=elevation_m&min=0&max=3000&<?php echo $utc_now;?>">Elevation</a> | 
<a href="aws.php?data=age&min=0&max=60&<?php echo $utc_now;?>">Age</a>
</p>
<hr>
</html>