<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!– style –><?php include('includes/style.php');?>
<!– mysql_cred –><?php include('includes/mysql_cred.php');?>
<!– fetch_aws –><?php include('includes/fetch_aws.php');?>
<!– header –><?php include('includes/header.php');?>
<!– colormaps –><?php include('includes/colormaps.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_aws -><?php include('includes/nav_aws.php');?>
<html>
    <head>
        <link rel="stylesheet" href="https://openlayers.org/en/v4.6.4/css/ol.css" type="text/css">
        <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
        <!-- Plotly.js --><script src="https://openlayers.org/en/v4.6.4/build/ol.js"></script>
    </head>
    <style>
        #map {
          width: 100%;
          height: 800;
        }
    </style>
    <body>
        <h4 align=center>OpenLayers - Test</h4>
        <table>
            <tr>
                <td>
                <p>Below are maps generated to test OpenLayers</p>
                </td>
            </tr>
            <tr bgcolor="#F0FFFF">
                <td id="map"></td>
            </tr>
        </table>
    </body>
<script>
      var blur = 0;
      var radius = 5;

      var vector = new ol.layer.Heatmap({
        source: new ol.source.Vector({
          url: 'https://openlayers.org/en/v4.6.4/examples/data/kml/2012_Earthquakes_Mag5.kml',
          format: new ol.format.KML({
            extractStyles: false
          })
        }),
        blur: blur,
        radius: radius,
        opacity: 1.0,
        gradient: ['#424ded','#4283ed','#42d0ed','#42edae','#78ed42','#d6ed42','#edde42','#f4af41','#f48541','#f44741','#f44298'],
      });

      vector.getSource().on('addfeature', function(event) {
        // 2012_Earthquakes_Mag5.kml stores the magnitude of each earthquake in a
        // standards-violating <magnitude> tag in each Placemark.  We extract it from
        // the Placemark's name instead.
        var name = event.feature.get('name');
        var magnitude = parseFloat(name.substr(2));
        event.feature.set('weight', Math.sqrt(magnitude - 5));
      });

      var raster = new ol.layer.Tile({
        source: new ol.source.OSM()
      });

      var map = new ol.Map({
        layers: [raster, vector],
        target: 'map',
        view: new ol.View({
          center: [0, 0],
          zoom: 2
        })
      });
    </script>
</html>
<!- footer -><?php include('includes/footer.php');?>
