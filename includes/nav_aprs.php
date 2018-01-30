<!doctype html>
<?php $utc_now = gmdate("Y-m-d H:i:s");?>
<html>
<p align=center>
<a href="aprs.php?period=today&<?php echo $utc_now;?>">Today</a> | 
<a href="aprs.php?period=week&<?php echo $utc_now;?>">Week</a> | 
<a href="aprs.php?period=month&<?php echo $utc_now;?>">Month</a> | 
<a href="aprs.php?period=3month&<?php echo $utc_now;?>">3-Month</a> | 
<a href="aprs.php?period=6month&<?php echo $utc_now;?>">6-Month</a> | 
<a href="aprs.php?period=year&<?php echo $utc_now;?>">Year</a> | 
<a href="aprs.php?period=all&<?php echo $utc_now;?>">All</a> | 
</p>
<hr>
</html>