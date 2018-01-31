<script>
var date = <?php echo '["'; echo implode('", "', $date); echo '"]'; ?>;
var wells = <?php echo '['; echo implode(', ', $wells); echo ']'; ?>;
var oil = <?php echo '['; echo implode(', ', $oil); echo ']'; ?>;
var water = <?php echo '['; echo implode(', ', $water); echo ']'; ?>;
var gas = <?php echo '['; echo implode(', ', $gas); echo ']'; ?>;
var steamflood = <?php echo '['; echo implode(', ', $steamflood); echo ']'; ?>;
var cyclic = <?php echo '['; echo implode(', ', $cyclic); echo ']'; ?>;
var latall = <?php echo '['; echo implode(', ', $latall); echo ']'; ?>;
var lonall = <?php echo '['; echo implode(', ', $lonall); echo ']'; ?>;
var latoil = <?php echo '['; echo implode(', ', $latoil); echo ']'; ?>;
var lonoil = <?php echo '['; echo implode(', ', $lonoil); echo ']'; ?>;
var oilsum = <?php echo '['; echo implode(', ', $oilsum); echo ']'; ?>;
var latwater = <?php echo '['; echo implode(', ', $latwater); echo ']'; ?>;
var lonwater = <?php echo '['; echo implode(', ', $lonwater); echo ']'; ?>;
var watersum = <?php echo '['; echo implode(', ', $watersum); echo ']'; ?>;
var latgas = <?php echo '['; echo implode(', ', $latgas); echo ']'; ?>;
var longas = <?php echo '['; echo implode(', ', $longas); echo ']'; ?>;
var gassum = <?php echo '['; echo implode(', ', $gassum); echo ']'; ?>;
var latcyclic = <?php echo '['; echo implode(', ', $latcyclic); echo ']'; ?>;
var loncyclic = <?php echo '['; echo implode(', ', $loncyclic); echo ']'; ?>;
var cyclicsum = <?php echo '['; echo implode(', ', $cyclicsum); echo ']'; ?>;
var latsteamflood = <?php echo '['; echo implode(', ', $latsteamflood); echo ']'; ?>;
var lonsteamflood = <?php echo '['; echo implode(', ', $lonsteamflood); echo ']'; ?>;
var steamfloodsum = <?php echo '['; echo implode(', ', $steamfloodsum); echo ']'; ?>;
    
var traces_plot = [{
    x: date, y: wells,
    line: {color: 'black', width: 1.5},
    name: 'wellcount',
},{
    x: date, y: oil,
    line: {color: '#6eba23', width: 1.5},
    name: 'oil',
},{
	x: date, y: water,
    line: {color: '#2798dd', width: 1.5},
    name: 'water',
},{
	x: date, y: gas,
    line: {color: '#dd5427', width: 1.5},
    name: 'gas',
},{
	x: date, y: steamflood,
    line: {color: '#dd27c4', width: 1.5},
    name: 'steamflood',
},{
	x: date, y: cyclic,
    line: {color: '#f4d442', width: 1.5},
    name: 'cyclic',
}];

var layout_plot = {
    showlegend: true,
    yaxis: {title: '(bbls or mcf)', type: 'log',},
    xaxis: {type: 'date' , title: 'Date / Time'},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 10, t: 30, b: 30, l: 60, pad: 0},
};

var data_map = [{
    type: 'scattermapbox',
    lat: latsteamflood,
    lon: lonsteamflood,
    text: steamfloodsum,
    mode: 'markers',
    marker: {
      color: steamfloodsum,
      colorscale: scl_stm,
      cmin: 0,
      cmax: 500000,
      reversescale: false,
      opacity: 1,
      size: 15,
      colorbar:{
        lenmode: 'fraction',
        len: 0.15,
        x: 1.02,
        xanchor: 'left',
        //xpad: 10,
        y: 0.25,
        yanchor: 'top',
        //ypad: 10,
        thickness: 20,
        titleside: 'right',
        outlinecolor: 'rgba(68,68,68,0)',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        ticksuffix: 'bbls',
        bgcolor: '#F0FFFF',
        title: 'Sum Steamflood (bbls)'
      }
    },
    name: 'Sum Steamflood (bbls)',
},{
    type: 'scattermapbox',
    lat: latcyclic,
    lon: loncyclic,
    text: cyclicsum,
    mode: 'markers',
    marker: {
      color: cyclicsum,
      colorscale: scl_cyc,
      cmin: 0,
      cmax: 100000,
      reversescale: false,
      opacity: 1,
      size: 15,
      colorbar:{
        lenmode: 'fraction',
        len: 0.15,
        x: 1.02,
        xanchor: 'left',
        //xpad: 10,
        y: 0.4,
        yanchor: 'top',
        //ypad: 10,
        thickness: 20,
        titleside: 'right',
        outlinecolor: 'rgba(68,68,68,0)',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        ticksuffix: 'bbls',
        bgcolor: '#F0FFFF',
        title: 'Sum Cyclic (bbls)'
      }
    },
    name: 'Sum Cyclic (bbls)',
},{
    type: 'scattermapbox',
    lat: latwater,
    lon: lonwater,
    text: watersum,
    mode: 'markers',
    marker: {
      color: watersum,
      colorscale: scl_wtr,
      cmin: 0,
      cmax: 1000000,
      reversescale: false,
      opacity: 1,
      size: 15,
      colorbar:{
        lenmode: 'fraction',
        len: 0.15,
        x: 1.02,
        xanchor: 'left',
        //xpad: 10,
        y: 0.55,
        yanchor: 'top',
        //ypad: 10,
        thickness: 20,
        titleside: 'right',
        outlinecolor: 'rgba(68,68,68,0)',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        ticksuffix: 'bbls',
        bgcolor: '#F0FFFF',
        title: 'Sum Water (bbls)'
      }
    },
    name: 'Sum Water (bbls)',
},{
    type: 'scattermapbox',
    lat: latgas,
    lon: longas,
    text: gassum,
    mode: 'markers',
    marker: {
      color: gassum,
      colorscale: scl_gas,
      cmin: 0,
      cmax: 100000,
      reversescale: false,
      opacity: 1,
      size: 10,
      colorbar:{
        lenmode: 'fraction',
        len: 0.15,
        x: 1.02,
        xanchor: 'left',
        //xpad: 10,
        y: 0.7,
        yanchor: 'top',
        //ypad: 10,
        thickness: 20,
        titleside: 'right',
        outlinecolor: 'rgba(68,68,68,0)',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        ticksuffix: 'mcf',
        bgcolor: '#F0FFFF',
        title: 'Sum Gas (mcf)'
      }
    },
    name: 'Sum Gas (mcf)',
},{
    type: 'scattermapbox',
    lat: latoil,
    lon: lonoil,
    text: oilsum,
    mode: 'markers',
    marker: {
      color: oilsum,
      colorscale: scl_oil,
      cmin: 0,
      cmax: 100000,
      reversescale: false,
      opacity: 1,
      size: 10,
      colorbar:{
        lenmode: 'fraction',
        len: 0.15,
        x: 1.02,
        xanchor: 'left',
        //xpad: 10,
        y: 0.85,
        yanchor: 'top',
        //ypad: 10,
        thickness: 20,
        titleside: 'right',
        outlinecolor: 'rgba(68,68,68,0)',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        ticksuffix: 'bbls',
        bgcolor: '#F0FFFF',
        title: 'Sum Oil (bbls)'
      }
    },
    name: 'Sum Oil (bbls)',
},{
    type: 'scattermapbox',
    lat: latall,
    lon: lonall,
    mode: 'markers',
    marker: {
      color: '#000000',
      colorscale: scl_oil,
      cmin: 0,
      cmax: 100000,
      reversescale: false,
      opacity: 1,
      size: 5,
      }
    },
    name: 'Wells',
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
    style: 'satellite-streets', 
    zoom: 8
  }, 
  margin: {r: 10, t: 10, b: 10, l: 10, pad: 10}, 
  showlegend: true
};

Plotly.setPlotConfig({mapboxAccessToken: 'pk.eyJ1IjoiYXJlZWQxNDUiLCJhIjoiY2phdzNsN2ZoMGh0bjMybzF3cTkycWYyciJ9.4aS7z-guI2VDlP3duMg2FA'})

Plotly.newPlot('doggr_plot', traces_plot, layout_plot, {displayModeBar: false});
Plotly.newPlot('doggr_map', data_map, layout_map, {displayModeBar: false});
</script>
