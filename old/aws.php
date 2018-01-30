<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- google analytics -><?php include('includes/google_analytics.php');?>
<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- plotly_aws -><?php $cdata='temp_c'; $cmin=0; $cmax=30; include('includes/plotly_aws.php');?>
<!- plotly_aws -><?php $cdata='altim_in_hg'; $cmin=29.5; $cmax=30.5; include('includes/plotly_aws.php');?>
<!- plotly_aws -><?php $cdata='wind_dir_degrees'; $cmin=0; $cmax=359; include('includes/plotly_aws.php');?>
<!- plotly_aws -><?php $cdata='wind_speed_kt'; $cmin=0; $cmax=30; include('includes/plotly_aws.php');?>
<!- plotly_aws -><?php $cdata='visibility_statute_mi'; $cmin=0; $cmax=10; include('includes/plotly_aws.php');?>
<!- plotly_aws -><?php $cdata='elevation_m'; $cmin=0; $cmax=3500; include('includes/plotly_aws.php');?>

<html>

<h4 align=center>Aviation Weather - AWS METARS</h4>

<table>
    <tr>
        <td bgcolor="#F0FFFF" width="50%"><p align=center>AWS METARS - Temp (C)<div id="aws_temp_c"></div></p></td>
        <td bgcolor="#F0FFFF" width="50%"><p align=center>AWS METARS - Altimeter (inHg)<div id="aws_altim_in_hg"></div></p></td>
    </tr>
    <tr>
        <td bgcolor="#F0FFFF" width="50%"><p align=center>AWS METARS - Wind Direction (def)<div id="aws_wind_dir_degrees"></div></p></td>
        <td bgcolor="#F0FFFF" width="50%"><p align=center>AWS METARS - Wind Speed (kts)<div id="aws_wind_speed_kt"></div></p></td>
    </tr>
    <tr>
        <td bgcolor="#F0FFFF" width="50%"><p align=center>AWS METARS - Visibility (mi)<div id="aws_visibility_statute_mi"></div></p></td>
        <td bgcolor="#F0FFFF" width="50%"><p align=center>AWS METARS - Elevation (m)<div id="aws_elevation_m"></div></p></td>
    </tr>
</table>

<!- footer -><?php include('includes/footer.php');?>
