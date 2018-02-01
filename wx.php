<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- GETS -><?php
if (isset($_GET["period"])){$period = $_GET["period"];}
if (isset($_GET["sid"])){$sid = $_GET["sid"];}
?>
<!– style –><?php include('includes/style.php');?>
<!– mysql_cred –><?php include('includes/mysql_cred.php');?>
<!– fetch_wx –><?php include('includes/fetch_wx.php');?>
<!– header –><?php include('includes/header.php');?>
<!– colormaps –><?php include('includes/colormaps.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_wx -><?php include('includes/nav_wx.php');?>

<html>
    <head>
        <!-- Plotly.js --><script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    </head>
    <body>
        <h4 align=center>Weather Station - <?php echo $sid;?> - <?php echo $period;?></h4>
        <h5 align=center>(<?php echo $start;?> to <?php echo $end;?>) - updated: <?php echo gmdate("Y-m-d H:i:s");?> UTC</h5>
        <table bgcolor="#F0FFFF">
            <tr>
                <td><div align=center id="wx_combo" width="100%">Combo Plot</div></td>
            </tr>
            <tr>
                <td><div align=center id="wx_wr" width="100%">Wind Rose</div></td>
            </tr>
        </table>    
        <table bgcolor="#F0FFFF">
            <tr>
                <td width="50%"><div align=center id="wx_Tdh" width="100%">Temp vs. Dewpoint by Humidity</div></td>
                <td width="50%"><div align=center id="wx_dTdtd" width="100%">Temp vs. Time by &#916T/&#916t</div></td>
            </tr>
            <tr>
                <td width="50%"><div align=center id="wx_dTdts" width="100%">&#916T/&#916t vs. Solar Radiation by Temp</div></td>
                <td width="50%"><div align=center id="wx_dPdts" width="100%">&#916P/&#916t vs. Windspeed by Temp</div></td>
            </tr>
        </table>
                <table bgcolor="#F0FFFF">
            <tr>
                <td><div align=center id="wx_hmtemp" width="100%">Temp Heatmap</div></td>
            </tr>
            <tr>
                <td><div align=center id="wx_hmpres" width="100%">Pressure Heatmap</div></td>
            </tr>
            <tr>
                <td><div align=center id="wx_hmsolar" width="100%">Solar Heatmap</div></td>
            </tr>
        </table>
    </body>

<!- plotly_wx -><?php include('includes/plotly_wx.php');?>
</html>
<!- footer -><?php include('includes/footer.php');?>
