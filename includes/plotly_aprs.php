<script>
var timestamp = <?php echo '["'; echo implode('", "', $timestamp); echo '"]'; ?>;
var latitude = <?php echo '['; echo implode(', ', $latitude); echo ']'; ?>;
var longitude = <?php echo '["'; echo implode('", "', $longitude); echo '"]'; ?>;
var course = <?php echo '['; echo implode(', ', $course); echo ']'; ?>;
var speed = <?php echo '['; echo implode(', ', $speed); echo ']'; ?>;
var altitude = <?php echo '["'; echo implode('", "', $altitude); echo '"]'; ?>;
    
var data_map = [{
    type: 'scattermapbox',
    lat: latitude,
    lon: longitude,
    mode: 'lines',
    line: {width: 2, color: 'black'},
    name: 'KK6GPV',
},{
    type: 'scattermapbox',
    lat: latitude,
    lon: longitude,
    mode: 'markers',
    marker: {
      color: altitude,
      colorscale: scl_main,
      cmin: 0,
      cmax: 5000,
      reversescale: false,
      opacity: 1,
      size: 8,
      colorbar:{
        thickness: 20,
        titleside: 'right',
        outlinecolor: 'rgba(68,68,68,0)',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        ticksuffix: 'ft',
        dtick: 1000,
        bgcolor: '#F0FFFF',
      }
    },
    name: 'KK6GPV',
}];

var layout_map = {
  paper_bgcolor: '#F0FFFF',
  plot_bgcolor: '#F0FFFF',
  dragmode: 'zoom',
  autosize: true,
  //width: 1000,
  height: 800,
  mapbox: {
    center: {lat: 35, lon: -119},
    domain: {x: [0, 1], y: [0, 1]}, 
    style: 'outdoors', 
    zoom: 8
  }, 
  margin: {r: 0, t: 0, b: 0, l: 0, pad: 0}, 
  showlegend: false
};

var traces_plot = [{
    x: timestamp, y: speed,
    line: {color: '#f4663f', width: 1.5}
},{
	x: timestamp, y: course,
    xaxis: 'x2',
    yaxis: 'y2',
    line: {color: '#ffdb5b', width: 1.5}
},{
	x: timestamp, y: altitude,
    xaxis: 'x3',
    yaxis: 'y3',
    line: {color: '#f442ee', width: 1.5}
}];

var layout_plot = {
    showlegend: false,
    yaxis: {domain: [0, 0.266], title: 'Speed (mph)'},
    xaxis3: {anchor: 'y3', type: 'date'},
    xaxis2: {anchor: 'y2', type: 'date'},
    yaxis2: {domain: [0.366, 0.633], title: 'Course (deg)'},
    yaxis3: {domain: [0.733, 1],title: 'Altitude (ft)'},
    xaxis: {type: 'date' , title: 'Date / Time'},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 10, t: 30, b: 30, l: 60, pad: 0},
};

Plotly.setPlotConfig({
mapboxAccessToken: 'pk.eyJ1IjoiYXJlZWQxNDUiLCJhIjoiY2phdzNsN2ZoMGh0bjMybzF3cTkycWYyciJ9.4aS7z-guI2VDlP3duMg2FA'
})

Plotly.newPlot('aprs_map', data_map, layout_map, {displayModeBar: false});
Plotly.newPlot('aprs_plot', traces_plot, layout_plot, {displayModeBar: false});
</script>