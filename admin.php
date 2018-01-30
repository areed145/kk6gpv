<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>

<html>

<h4 align=center>Links</h4>

<table>
  <tr>
    <td>wx</td>
    <td>aprs</td> 
    <td>avwx</td> 
  </tr>
  <tr>
    <td>
    <a href="/includes/mysql_wx_loop.php?c=KCABAKER27&beg=2018-01-01&end=2018-01-02">loop update</a><br>
    <a href="/includes/mysql_wx.php?c=KCABAKER27&Y=2018&m=01&d=01">single day update</a><br>
    <a href="/includes/cron_wx.php">7 day loop (cron_wx)</a><br>
    </td>
    <td>
    <a href="/includes/mysql_aprs_var.php?hours=168">7 day update</a><br>
    <a href="/includes/mysql_aprs_var.php?hours=24">1 day update (cron_aprs)</a><br>
    </td>
    <td>
    <a href="/includes/mysql_aws.php?type=long">2 hour update (cron_aws)</a><br>
    <a href="/includes/mysql_aws.php?type=short">2 minute update (cron_aws)</a><br>
    </td>
  </tr>
</table>

</html>

<!- footer -><?php include('includes/footer.php');?>
