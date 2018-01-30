<html>
<head>
  <!-- Plotly.js -->
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<script>

var time = '<?php echo $time; ?>';
var start = '<?php echo $start; ?>';
var end = '<?php echo $end; ?>';

Plotly.d3.csv('includes/wx/wx_windrose_'+time+'.csv', function(err, rows){
    function unpack(rows, key) {
        return rows.map(function(row) { return row[key]; });
    }
        
var wr_calm = {
  r: unpack(rows, 'calm'),
  t: unpack(rows, 'winddir'),
  name: 'calm',
  marker: {color: '#3366ff',line: {color: '#3366ff'},},
  type: 'area',
};

var wr_1 = {
  r: unpack(rows, '1mph'),
  t: unpack(rows, 'winddir'),
  name: '0-1 mph',
  marker: {color: '#009999',line: {color: '#009999'},},
  type: 'area',
};

var wr_2 = {
  r: unpack(rows, '1to2mph'),
  t: unpack(rows, 'winddir'),
  name: '1-2 mph',
  marker: {color: '#00cc00',line: {color: '#00cc00'},},
  type: 'area',
};

var wr_3 = {
  r: unpack(rows, '2to5mph'),
  t: unpack(rows, 'winddir'),
  name: '2-5 mph',
  marker: {color: '#bfff00',line: {color: '#bfff00'},},
  type: 'area',
};

var wr_4 = {
  r: unpack(rows, '5to10mph'),
  t: unpack(rows, 'winddir'),
  name: '5-10 mph',
  marker: {color: '#ffcc00',line: {color: '#ffcc00'},},
  type: 'area',
};

var wr_5 = {
  r: unpack(rows, '10mph'),
  t: unpack(rows, 'winddir'),
  name: '>10 mph',
  marker: {color: '#ffff00',line: {color: '#ffff00'},},
  type: 'area',
};

var traces_wr = [wr_5, wr_4, wr_3, wr_2, wr_1, wr_calm];

var layout_wr = {
  height: 600,
  width: 600,
  orientation: 270,
  paper_bgcolor: '#F0FFFF',
  plot_bgcolor: '#FFFFFF',
  margin: {l: 20, r: 20, b: 20, t: 20, pad: 4},
  radialaxis: {visible: false, range: [0,15],},
  //barmode: 'stack',
};

Plotly.newPlot('wx_wr', traces_wr, layout_wr, {displayModeBar: false});
});

Plotly.d3.csv('includes/wx/wx_filter_'+time+'.csv', function(err, rows){
    function unpack(rows, key) {
        return rows.map(function(row) { return row[key]; });
    }

scl = [[0, 'rgb(0, 0, 200)'],[0.143,'rgb(0, 25, 255)'],[0.286,'rgb(0, 152, 255)'],[0.429,'rgb(44, 255, 150)'],
    [0.571,'rgb(151, 255, 0)'],[0.714,'rgb(255, 234, 0)'],[0.857,'rgb(255, 111, 0)'],[1,'rgb(255, 0, 0)']];
        
scl_Tdh = [[0, 'rgb(0, 0, 200)'],[0.333,'rgb(0, 25, 255)'],[0.666,'rgb(0, 152, 255)'],[1,'rgb(44, 255, 150)']];
           
var traces_dPdts = [{
    x: unpack(rows, 'windspeed'), 
    y: unpack(rows, 'dpdt'),
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: unpack(rows, 'temp'),
        cmin: 0,
        cmax: 120,
        colorscale: scl,
        size: 8,
        symbol: 'x',
        colorbar:{
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            dtick: 20,
            bgcolor: '#F0FFFF',
        }
    }
}];
    
var layout_dPdts = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'dPdt (inHg/hr)', fixedrange: true, range: [-0.1, 0.1],},
    xaxis: {title: 'Windspeed (mph)', fixedrange: true,},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {
    r: 50, 
    t: 30, 
    b: 30, 
    l: 60, 
    pad: 0
  },
};

var traces_dTdts = [{
    x: unpack(rows, 'solarrad'), 
    y: unpack(rows, 'dtdt'),
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: unpack(rows, 'temp'),
        cmin: 0,
        cmax: 120,
        colorscale: scl,
        size: 8,
        symbol: 'x',
        colorbar:{
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            dtick: 20,
            bgcolor: '#F0FFFF',
        }
    }
}];
    
var layout_dTdts = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'dTdt (F/hr)', fixedrange: true, range: [-10, 10],},
    xaxis: {title: 'Solar Radiation (W/m^2)', fixedrange: true, range: [0, 1000],},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_Tdh = [{
    x: unpack(rows, 'dewpt'), 
    y: unpack(rows, 'temp'),
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: unpack(rows, 'hum'),
        colorscale: scl_Tdh,
        size: 8,
        symbol: 'x',
        colorbar:{
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            ticksuffix: '%',
            dtick: 10,
            bgcolor: '#F0FFFF',
        }
    },
    
}];
    
var layout_Tdh = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'Temp (F)', fixedrange: true, range: [0, 120],},
    xaxis: {title: 'Dewpoint (F)', fixedrange: true, range: [0, 120],},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_dTdtd = [{
    x: unpack(rows, 'time'), 
    y: unpack(rows, 'temp'),
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: unpack(rows, 'dtdt'),
        cmin: -7.0,
        cmax: 7.0,
        colorscale: scl,
        size: 8,
        symbol: 'x',
        colorbar:{
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            dtick: 1,
            bgcolor: '#F0FFFF',
        }
    }
}];

var layout_dTdtd = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'Temp (F)', fixedrange: true, range: [0, 120]},
    xaxis: {type: 'date',title: 'Date / Time',},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_combo = [{
    x: unpack(rows, 'time'), 
    y: unpack(rows, 'windgust'),
    name: 'Wind Gust (mph)',
    xaxis: 'x',
    yaxis: 'y',
    line: {color: '#15b259', width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'windspeed'),
    name: 'Wind Speed (mph)',
    xaxis: 'x',
    yaxis: 'y',
    line: {color: '#a7e54b',width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'winddir'),
    name: 'Wind Direction (deg)',
    xaxis: 'x',
    yaxis: 'y10',
    type: 'scatter',
    mode: 'markers',
    marker: {color: '#ff0000',size: 8,symbol: 'x',}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'cloudbase'),
    name: 'Min Cloudbase (ft)',
    xaxis: 'x2',
    yaxis: 'y2',
    line: {color: '#ff00d4',width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'solarrad'),
    name: 'Solar Rad (W/m^2)',
    xaxis: 'x2',
    yaxis: 'y9',
    line: {color: '#ff9900',width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'hum'),
    name: 'Humidty (%)',
    xaxis: 'x3',
    yaxis: 'y3',
    line: {color: '#ffea2d',width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'pres'),
    name: 'Pressure (inHg)',
    xaxis: 'x3',
    yaxis: 'y8',
    line: {color: '#157248',width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'preciphr'),
    name: 'Precip Hourly (in/hr)',
    xaxis: 'x4',
    yaxis: 'y4',
    line: {color: '#00ddff',width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'precipday'),
    name: 'Precip Daily (in)',
    xaxis: 'x4',
    yaxis: 'y7',
    line: {color: '#0090ff',width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'temp'),
    name: 'Temp (F)',
    xaxis: 'x5',
    yaxis: 'y5',
    line: {color: '#f92500',width: 1.5,}
},{
	x: unpack(rows, 'time'),
	y: unpack(rows, 'dewpt'),
    name: 'Dewpoint (F)',
    xaxis: 'x5',
    yaxis: 'y6',
    line: {color: '#00b2ff',width: 1.5,}
}];

var layout_combo = {
    showlegend: false,
    height: 1200,
    yaxis: {domain: [0.02, 0.18], title: 'Windspeed / Gust (mph)', fixedrange: true,},
    yaxis10: {title: 'Wind Direction (deg)', overlaying: 'y', side: 'right', range: [0, 360], fixedrange: true,},
    xaxis5: {anchor: 'y5', type: 'date', fixedrange: true, range: [start, end]},
    xaxis4: {anchor: 'y4', type: 'date', fixedrange: true, range: [start, end]},
    xaxis3: {anchor: 'y3', type: 'date', fixedrange: true, range: [start, end]},
    xaxis2: {anchor: 'y2', type: 'date', fixedrange: true, range: [start, end]},
    yaxis2: {domain: [0.22, 0.38], title: 'Min Cloudbase (ft)', fixedrange: true,},
    yaxis9: {title: 'Solar Radiation (W/m^2)', overlaying: 'y2', side: 'right', fixedrange: true,},
    yaxis3: {domain: [0.42, 0.58], title: 'Humidity (%)', range: [0, 100], fixedrange: true,},
    yaxis8: {title: 'Pressure (inHg)', overlaying: 'y3', side: 'right', fixedrange: true,},
    yaxis4: {domain: [0.62, 0.78], title: 'Precip Hourly (in/hr)', fixedrange: true,},
    yaxis7: {title: 'Precip Daily (in)', overlaying: 'y4', side: 'right', fixedrange: true,},
    yaxis5: {domain: [0.82, 0.98], title: 'Temp (F)', fixedrange: true, range: [0, 120],},
    yaxis6: {title: 'Dewpoint (F)', overlaying: 'y5', side: 'right', fixedrange: true, range: [0, 120],},
    xaxis: {type: 'date', title: 'Date / Time', fixedrange: true, range: [start, end]},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

Plotly.newPlot('wx_combo', traces_combo, layout_combo, {displayModeBar: false});
Plotly.newPlot('wx_dTdtd', traces_dTdtd, layout_dTdtd, {displayModeBar: false});
Plotly.newPlot('wx_Tdh', traces_Tdh, layout_Tdh, {displayModeBar: false});
Plotly.newPlot('wx_dTdts', traces_dTdts, layout_dTdts, {displayModeBar: false});
Plotly.newPlot('wx_dPdts', traces_dPdts, layout_dPdts, {displayModeBar: false});
    
});
</script>

</html>