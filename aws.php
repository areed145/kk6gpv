<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!- GETS -><?php $data = $_GET["data"]; $min = $_GET["min"]; $max = $_GET["max"];?>
<!– style –><?php include('includes/style.php');?>
<!– mysql_cred –><?php include('includes/mysql_cred.php');?>
<!– fetch_aws –><?php include('includes/fetch_aws.php');?>
<!– header –><?php include('includes/header.php');?>
<!– colormaps –><?php include('includes/colormaps.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_aws -><?php include('includes/nav_aws.php');?>
<html>
    <head>
        <!-- Plotly.js --><script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    </head>
    <body>
        <h4 align=center>AWS - <?php echo $data;?></h4>
        <table bgcolor="#F0FFFF">
            <tr>
                <td><div id="aws" align=center></div></td>
            </tr>
        </table>
    </body>
    <!- plotly_aws -><?php include('includes/plotly_aws.php');?>
</html>
<!- footer -><?php include('includes/footer.php');?>
