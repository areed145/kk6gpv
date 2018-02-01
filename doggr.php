<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!– GETS –><?php 
if (isset($_GET["inc"])) {$inc = $_GET["inc"];}
if (isset($_GET["api"])) {$api = $_GET["api"];}
if (isset($_GET["lease"])) {$lease = $_GET["lease"];}
if (isset($_GET["county"])) {$county = $_GET["county"];
if (isset($_GET["district"])) {$district = $_GET["district"];}
if (isset($_GET["opcode"])) {$opcode = $_GET["opcode"];}
if (isset($_GET["fieldcode"])) {$fieldcode = $_GET["fieldcode"];}
if (isset($_GET["section"])) {$section = $_GET["section"];}
if (isset($_GET["township"])) {$township = $_GET["township"];}
if (isset($_GET["rnge"])) {$rnge = $_GET["rnge"];}
if (isset($_GET["status"])) {$status = $_GET["status"];}
if (isset($_GET["datemin"])) {$datemin = $_GET["datemin"];}
if (isset($_GET["datemax"])) {$datemax = $_GET["datemax"];}
?>

<!– style –><?php include('includes/style.php');?>
<!– mysql_cred –><?php include('includes/mysql_cred.php');?>
<!– fetch_doggr –><?php include('includes/fetch_doggr.php');?>
<!– header –><?php include('includes/header.php');?>
<!– colormaps –><?php include('includes/colormaps.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_doggr -><?php include('includes/nav_doggr.php');?>

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
