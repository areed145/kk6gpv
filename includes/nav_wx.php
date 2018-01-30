<!doctype html>
<?php $utc_now = gmdate("Y-m-d H:i:s");?>
<html>
<p align=center>
<a href="wx.php?sid=KCABAKER64&period=today&<?php echo $utc_now;?>">Today</a> | 
<a href="wx.php?sid=KCABAKER64&period=week&<?php echo $utc_now;?>">Week</a> | 
<a href="wx.php?sid=KCABAKER64&period=month&<?php echo $utc_now;?>">Month</a> | 
<a href="wx.php?sid=KCABAKER64&period=3month&<?php echo $utc_now;?>">3-Month</a> | 
<a href="wx.php?sid=KCABAKER64&period=6month&<?php echo $utc_now;?>">6-Month</a> | 
<a href="wx.php?sid=KCABAKER64&period=year&<?php echo $utc_now;?>">Year</a> | 
<a href="wx.php?sid=KCABAKER64&period=all&<?php echo $utc_now;?>">All</a> | 
<a href="findu.php?callsign=KK6GPV-13&<?php echo $utc_now;?>">findu</a> | 
</p>
<hr>
</html>