<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!– GETS –><?php 
$api= $_GET["api"];
$lease= $_GET["lease"];
$county = $_GET["county"];
$district = $_GET["district"];
$opcode = $_GET["opcode"];
$fieldcode = $_GET["fieldcode"];
$section = $_GET["section"];
$township = $_GET["township"];
$rnge = $_GET["rnge"];
$status = $_GET["status"];
$datemin = $_GET["datemin"];
$datemax = $_GET["datemax"];
?>

<!– style –><?php include('includes/style.php');?>
<!– mysql_cred –><?php include('includes/mysql_cred.php');?>
<!– fetch_doggr –><?php include('includes/fetch_doggr.php');?>
<!– header –><?php include('includes/header.php');?>
<!– colormaps –><?php include('includes/colormaps.php');?>
<!- nav -><?php include('includes/nav.php');?>
<html>
    <head>
        <!-- Plotly.js --><script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    </head>
    <body>
        <h4 align=center>DOGGR Data Loaded</h4>
        <table bgcolor="#F0FFFF">
            <tr>
                <td><div id="doggr_plot" align=center></div></td>
            </tr>
            <tr>
                <td><div id="doggr_map" align=center></div></td>
            </tr>
        </table>
    </body>
    <!- plotly_aws -><?php include('includes/plotly_doggr.php');?>
</html>
<!- footer -><?php include('includes/footer.php');?>
