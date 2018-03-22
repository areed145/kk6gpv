<script>
var d3 = Plotly.d3;
var img_jpg= d3.select('#jpg-export');

var data = '<?php echo $data; ?>';
var min = '<?php echo $min; ?>';
var max = '<?php echo $max; ?>';
var lat_c = <?php echo '['; echo implode(', ', $lat_c); echo ']'; ?>;
var lon_c = <?php echo '['; echo implode(', ', $lon_c); echo ']'; ?>;
var data_c = <?php echo '["'; echo implode('", "', $data_c); echo '"]'; ?>;
var lat_all = <?php echo '['; echo implode(', ', $lat_all); echo ']'; ?>;
var lon_all = <?php echo '['; echo implode(', ', $lon_all); echo ']'; ?>;
var data_all = <?php echo '["'; echo implode('", "', $data_all); echo '"]'; ?>;
var raw_all = <?php echo '["'; echo implode('", "', $raw_all); echo '"]'; ?>;
var lat_vfr = <?php echo '['; echo implode(', ', $lat_vfr); echo ']'; ?>;
var lon_vfr = <?php echo '['; echo implode(', ', $lon_vfr); echo ']'; ?>;
var raw_vfr = <?php echo '["'; echo implode('", "', $raw_vfr); echo '"]'; ?>;
var lat_mvfr = <?php echo '['; echo implode(', ', $lat_mvfr); echo ']'; ?>;
var lon_mvfr = <?php echo '['; echo implode(', ', $lon_mvfr); echo ']'; ?>;
var raw_mvfr = <?php echo '["'; echo implode('", "', $raw_mvfr); echo '"]'; ?>;
var lat_ifr = <?php echo '['; echo implode(', ', $lat_ifr); echo ']'; ?>;
var lon_ifr = <?php echo '['; echo implode(', ', $lon_ifr); echo ']'; ?>;
var raw_ifr = <?php echo '["'; echo implode('", "', $raw_ifr); echo '"]'; ?>;
var lat_lifr = <?php echo '['; echo implode(', ', $lat_lifr); echo ']'; ?>;
var lon_lifr = <?php echo '['; echo implode(', ', $lon_lifr); echo ']'; ?>;
var raw_lifr = <?php echo '["'; echo implode('", "', $raw_lifr); echo '"]'; ?>;

if (data == 'visibility_statute_mi') {scl_main = scl_stop_r}
if (data == 'pred_cloudbase_agl') {scl_main = scl_stop_r}
if (data == 'pred_cloudbase_msl') {scl_main = scl_stop_r}
if (data == 'age') {scl_main = scl_stop}
if (data == 'wind_dir_degrees') {scl_main = scl_circle}

if (data == 'flight_category') {
    var data_map = [{
        type: 'scattermapbox',
        lat: lat_vfr,
        lon: lon_vfr,
        text: raw_vfr,
        mode: 'markers',
        marker: {color: 'rgb(0,255,0)', opacity: 1, size: 10,},
        name: 'VFR',
    },{
        type: 'scattermapbox',
        lat: lat_mvfr,
        lon: lon_mvfr,
        text: raw_mvfr,
        mode: 'markers',
        marker: {color: 'rgb(0,0,255)', opacity: 1, size: 10,},
        name: 'MVFR',
    },{
        type: 'scattermapbox',
        lat: lat_ifr,
        lon: lon_ifr,
        text: raw_ifr,
        mode: 'markers',
        marker: {color: 'rgb(255,0,0)', opacity: 1, size: 10,},
        name: 'IFR',
    },{
        type: 'scattermapbox',
        lat: lat_lifr,
        lon: lon_lifr,
        text: raw_lifr,
        mode: 'markers',
        marker: {color: 'rgb(255,127.5,255)', opacity: 1, size: 10,},
        name: 'LIFR',
    }];
} else {
    var data_map = [{
        type: 'scattermapbox',
        lat: lat_all,
        lon: lon_all,
        text: raw_all,
        mode: 'markers',
        marker: {
          color: data_all,
          colorscale: scl_main,
          cmin: min,
          cmax: max,
          reversescale: false,
          opacity: 1,
          size: 10,
          colorbar:{
            title: data,
            thickness: 20,
            titleside: 'right',
            outlinecolor: 'rgba(68,68,68,0)',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            bgcolor: '#F0FFFF',
          }
        },
    }];
}

if (data == 'flight_category') {leg = true} else {leg = false}

var layout_map = {
  paper_bgcolor: '#F0FFFF',
  plot_bgcolor: '#F0FFFF',
  dragmode: 'zoom',
  autosize: true,
  //width: 1000,
  height: 800,
  mapbox: {
    center: {lat: 40, lon: -96},
    domain: {x: [0, 1], y: [0, 1]}, 
    style: 'outdoors', 
    zoom: 3
  }, 
  margin: {r: 0, t: 0, b: 0, l: 0, pad: 0}, 
  showlegend: leg
};

Plotly.setPlotConfig({mapboxAccessToken: 'pk.eyJ1IjoiYXJlZWQxNDUiLCJhIjoiY2phdzNsN2ZoMGh0bjMybzF3cTkycWYyciJ9.4aS7z-guI2VDlP3duMg2FA'})

Plotly.newPlot(aws, data_map, layout_map, {displayModeBar: false})

var data_c = [{
    type: 'contour',
    ncontours: 50,
    line:{smoothing: 3},
    contours: {
        start: min,
        end: max,
        coloring: 'fill',
        showlines: false},
    colorscale: scl_main,
    x: lon_c,
    y: lat_c,
    z: data_c,
    colorbar:{
            title: data,
            thickness: 20,
            titleside: 'right',
            outlinecolor: 'rgba(68,68,68,0)',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            bgcolor: '#F0FFFF',
          }
}];
    
var layout_c = {
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#F0FFFF',
    autosize: true,
    //width: 1000,
    height: 500,
    margin: {r: 0, t: 0, b: 0, l: 0, pad: 0},
    showlegend: false,
};

Plotly.newPlot(aws_contour, data_c, layout_c, {displayModeBar: false})
</script>