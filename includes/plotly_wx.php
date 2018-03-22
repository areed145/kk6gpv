<script>
var period = '<?php echo $period; ?>';
var start = '<?php echo $start; ?>';
var end = '<?php echo $end; ?>';
var time = <?php echo '["'; echo implode('", "', $time); echo '"]'; ?>;
var hm_x = <?php echo '["'; echo implode('", "', $hm_x); echo '"]'; ?>;
var hm_y = <?php echo '["'; echo implode('", "', $hm_y); echo '"]'; ?>;
var tempavg = <?php echo '['; echo implode(', ', $tempavg); echo ']'; ?>;
var tempmin = <?php echo '['; echo implode(', ', $tempmin); echo ']'; ?>;
var tempmax = <?php echo '['; echo implode(', ', $tempmax); echo ']'; ?>;
var dewptavg = <?php echo '['; echo implode(', ', $dewptavg); echo ']'; ?>;
var dewptmin = <?php echo '['; echo implode(', ', $dewptmin); echo ']'; ?>;
var dewptmax = <?php echo '['; echo implode(', ', $dewptmax); echo ']'; ?>;
var presavg = <?php echo '['; echo implode(', ', $presavg); echo ']'; ?>;
var presmin = <?php echo '['; echo implode(', ', $presmin); echo ']'; ?>;
var presmax = <?php echo '['; echo implode(', ', $presmax); echo ']'; ?>;
var winddir = <?php echo '['; echo implode(', ', $winddir); echo ']'; ?>;
var windspeed = <?php echo '['; echo implode(', ', $windspeed); echo ']'; ?>;
var windgust = <?php echo '['; echo implode(', ', $windgust); echo ']'; ?>;
var humavg = <?php echo '['; echo implode(', ', $humavg); echo ']'; ?>;
var hummin = <?php echo '['; echo implode(', ', $hummin); echo ']'; ?>;
var hummax = <?php echo '['; echo implode(', ', $hummax); echo ']'; ?>;
var preciphravg = <?php echo '['; echo implode(', ', $preciphravg); echo ']'; ?>;
var preciphrmin = <?php echo '['; echo implode(', ', $preciphrmin); echo ']'; ?>;
var preciphrmax = <?php echo '['; echo implode(', ', $preciphrmax); echo ']'; ?>;
var precipday = <?php echo '['; echo implode(', ', $precipday); echo ']'; ?>;
var precipcum = <?php echo '['; echo implode(', ', $precipcum); echo ']'; ?>;
var solarradavg = <?php echo '['; echo implode(', ', $solarradavg); echo ']'; ?>;
var solarradmin = <?php echo '['; echo implode(', ', $solarradmin); echo ']'; ?>;
var solarradmax = <?php echo '['; echo implode(', ', $solarradmax); echo ']'; ?>;
var uvavg = <?php echo '['; echo implode(', ', $uvavg); echo ']'; ?>;
var uvmin = <?php echo '['; echo implode(', ', $uvmin); echo ']'; ?>;
var uvmax = <?php echo '['; echo implode(', ', $uvmax); echo ']'; ?>;
var dtdt = <?php echo '['; echo implode(', ', $dtdt); echo ']'; ?>;
var dpdt = <?php echo '['; echo implode(', ', $dpdt); echo ']'; ?>;
var cloudbaseavg = <?php echo '['; echo implode(', ', $cloudbaseavg); echo ']'; ?>;
var cloudbasemin = <?php echo '['; echo implode(', ', $cloudbasemin); echo ']'; ?>;
var cloudbasemax = <?php echo '['; echo implode(', ', $cloudbasemax); echo ']'; ?>;
var total = '<?php echo $total; ?>';
var calm = '<?php echo $calm; ?>';
var dirs = '<?php echo $dirs; ?>';
var max = '<?php echo $max; ?>';
var wdircat = <?php echo '["'; echo implode('", "', $wdircat); echo '"]'; ?>;
var wcalm = <?php echo '['; echo implode(', ', $wcalm); echo ']'; ?>;
var w1mph = <?php echo '['; echo implode(', ', $w1mph); echo ']'; ?>;
var w1to2mph = <?php echo '['; echo implode(', ', $w1to2mph); echo ']'; ?>;
var w2to5mph = <?php echo '['; echo implode(', ', $w2to5mph); echo ']'; ?>;
var w5to10mph = <?php echo '['; echo implode(', ', $w5to10mph); echo ']'; ?>;
var w10mph = <?php echo '['; echo implode(', ', $w10mph); echo ']'; ?>;

var wr_calm = {
  r: wcalm, t: wdircat,
  name: 'calm',
  marker: {color: '#3366ff',line: {color: '#3366ff'},},
  type: 'area',
};

var wr_1 = {
  r: w1mph, t: wdircat,
  name: '0-1 mph',
  marker: {color: '#009999',line: {color: '#009999'},},
  type: 'area',
};

var wr_2 = {
  r: w1to2mph, t: wdircat,
  name: '1-2 mph',
  marker: {color: '#00cc00',line: {color: '#00cc00'},},
  type: 'area',
};

var wr_3 = {
  r: w2to5mph, t: wdircat,
  name: '2-5 mph',
  marker: {color: '#bfff00',line: {color: '#bfff00'},},
  type: 'area',
};

var wr_4 = {
  r: w5to10mph, t: wdircat,
  name: '5-10 mph',
  marker: {color: '#ffcc00',line: {color: '#ffcc00'},},
  type: 'area',
};

var wr_5 = {
  r: w10mph, t: wdircat,
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
  radialaxis: {visible: false, range: [0,max],},
  //barmode: 'stack',
};
           
var traces_dPdts = [{
    x: windspeed, y: dpdt,
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: tempavg,
        colorscale: scl_main,
        size: 8,
        symbol: 'x',
        colorbar:{
            title: 'Temp (F)',
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            bgcolor: '#F0FFFF',
        }
    }
}];
    
var layout_dPdts = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'dP/dt (inHg/hr)', fixedrange: true, range: [-0.1, 0.1],},
    xaxis: {title: 'Windspeed (mph)', fixedrange: true,},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_dTdts = [{
    x: solarradavg, y: dtdt,
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: tempavg,
        colorscale: scl_main,
        size: 8,
        symbol: 'x',
        colorbar:{
            title: 'Temp (F)',
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            bgcolor: '#F0FFFF',
        }
    }
}];
    
var layout_dTdts = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'dT/dt (F/hr)', fixedrange: true,},
    xaxis: {title: 'Solar Radiation (W/m^2)', fixedrange: true,},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_Tdh = [{
    x: dewptavg, y: tempavg,
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: humavg,
        colorscale: scl_tdh,
        size: 8,
        symbol: 'x',
        colorbar:{
            title: 'Humidity (%)',
            outlinecolor: 'rgba(68,68,68,0)',
            thickness: 20,
            titleside: 'right',
            ticks: 'outside',
            ticklen: 3,
            shoticksuffix: 'last',
            ticksuffix: '%',
            bgcolor: '#F0FFFF',
        }
    },
    
}];
    
var layout_Tdh = {
    showlegend: false,
    height: 400,
    yaxis: {title: 'Temp (F)', fixedrange: true,},
    xaxis: {title: 'Dewpoint (F)', fixedrange: true,},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_dTdtd = [{
    x: time, y: tempavg,
    name: 'Temp (F)',
    type: 'scatter',
    mode: 'markers',
    marker: {
        color: dtdt,
        cmin: -7.0,
        cmax: 7.0,
        colorscale: scl_main,
        size: 8,
        symbol: 'x',
        colorbar:{
            title: 'dT/dt (F/hr)',
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
    yaxis: {title: 'Temp (F)', fixedrange: true,},
    xaxis: {type: 'date', title: 'Date / Time', fixedrange: true, range: [start, end]},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var traces_combo = [{
    x: time, y: windgust,
    name: 'Wind Gust (mph)',
    xaxis: 'x',
    yaxis: 'y',
    connectgaps: true,
    line: {color: '#15b259', width: 1.5,}
},{
	x: time, y: windspeed,
    name: 'Wind Speed (mph)',
    xaxis: 'x',
    yaxis: 'y',
    connectgaps: true,
    line: {color: '#a7e54b',width: 1.5,}
},{
	x: time, y: winddir,
    name: 'Wind Direction (deg)',
    xaxis: 'x',
    yaxis: 'y10',
    type: 'scatter',
    mode: 'markers',
    connectgaps: true,
    marker: {color: '#ff0000',size: 8,symbol: 'x',}
},{
	x: time, y: cloudbaseavg,
    name: 'Min Cloudbase Avg (ft)',
    xaxis: 'x2',
    yaxis: 'y2',
    connectgaps: true,
    line: {color: '#ff00d4',width: 1.5,}
},{
	x: time, y: cloudbasemin,
    name: 'Min Cloudbase Min (ft)',
    xaxis: 'x2',
    yaxis: 'y2',
    connectgaps: true,
    line: {color: '#ff00d4',width: 0,}
},{
	x: time, y: cloudbasemax,
    name: 'Min Cloudbase Max (ft)',
    xaxis: 'x2',
    yaxis: 'y2',
    connectgaps: true,
    fill: 'tonexty',
    line: {color: '#ff00d4',width: 0,}
},{
	x: time, y: solarradmax,
    name: 'Solar Rad Max (W/m^2)',
    xaxis: 'x2',
    yaxis: 'y9',
    connectgaps: true,
    line: {color: '#ff9900',width: 1.5,}
},{
	x: time, y: uvmax,
    name: 'UV*100 Max',
    xaxis: 'x2',
    yaxis: 'y9',
    connectgaps: true,
    line: {color: '#ff9990',width: 1.5,}
},{
	x: time, y: humavg,
    name: 'Humidty Avg (%)',
    xaxis: 'x3',
    yaxis: 'y3',
    connectgaps: true,
    line: {color: '#ffea2d',width: 1.5,}
},{
	x: time, y: hummin,
    name: 'Humidty Min (%)',
    xaxis: 'x3',
    yaxis: 'y3',
    connectgaps: true,
    line: {color: '#ffea2d',width: 0,}
},{
	x: time, y: hummax,
    name: 'Humidty Max (%)',
    xaxis: 'x3',
    yaxis: 'y3',
    connectgaps: true,
    fill: 'tonexty',
    line: {color: '#ffea2d',width: 0,}
},{
	x: time, y: presavg,
    name: 'Pressure Avg (inHg)',
    xaxis: 'x3',
    yaxis: 'y8',
    connectgaps: true,
    line: {color: '#157248',width: 1.5,}
},{
	x: time, y: presmin,
    name: 'Pressure Min (inHg)',
    xaxis: 'x3',
    yaxis: 'y8',
    connectgaps: true,
    line: {color: '#157248',width: 0,}
},{
	x: time, y: presmax,
    name: 'Pressure Max (inHg)',
    xaxis: 'x3',
    yaxis: 'y8',
    connectgaps: true,
    fill: 'tonexty',
    line: {color: '#157248',width: 0,}
},{
	x: time, y: preciphravg,
    name: 'Precip Hourly (in/hr)',
    xaxis: 'x4',
    yaxis: 'y4',
    connectgaps: true,
    line: {color: '#00ddff',width: 1.5,}
},{
	x: time, y: preciphrmin,
    name: 'Precip Hourly (in/hr)',
    xaxis: 'x4',
    yaxis: 'y4',
    connectgaps: true,
    line: {color: '#00ddff',width: 0,}
},{
	x: time, y: preciphrmax,
    name: 'Precip Hourly (in/hr)',
    xaxis: 'x4',
    yaxis: 'y4',
    connectgaps: true,
    fill: 'tonexty',
    line: {color: '#00ddff',width: 0,}
},{
	x: time, y: precipcum,
    name: 'Precip Cumulative (in)',
    xaxis: 'x4',
    yaxis: 'y7',
    connectgaps: true,
    line: {color: '#0090ff',width: 1.5,}
},{
	x: time, y: tempavg,
    name: 'Temp Avg (F)',
    xaxis: 'x5',
    yaxis: 'y5',
    connectgaps: true,
    line: {color: '#f92500',width: 1.5,}
},{
	x: time, y: tempmin,
    name: 'Temp Min (F)',
    xaxis: 'x5',
    yaxis: 'y5',
    connectgaps: true,
    line: {color: '#f92500',width: 0,}
},{
	x: time, y: tempmax,
    name: 'Temp Max (F)',
    xaxis: 'x5',
    yaxis: 'y5',
    connectgaps: true,
    fill: 'tonexty',
    line: {color: '#f92500',width: 0,}
},{
	x: time, y: dewptavg,
    name: 'Dewpoint Avg (F)',
    xaxis: 'x5',
    yaxis: 'y6',
    connectgaps: true,
    line: {color: '#00b2ff',width: 1.5,}
},{
	x: time, y: dewptmin,
    name: 'Dewpoint Min (F)',
    xaxis: 'x5',
    yaxis: 'y6',
    connectgaps: true,
    line: {color: '#00b2ff',width: 0,}
},{
	x: time, y: dewptmax,
    name: 'Dewpoint Max (F)',
    xaxis: 'x5',
    yaxis: 'y6',
    connectgaps: true,
    fill: 'tonexty',
    line: {color: '#00b2ff',width: 0,}
}];

var layout_combo = {
    showlegend: false,
    height: 1200,
    yaxis: {domain: [0.02, 0.18], title: 'Windspeed / Gust (mph)', fixedrange: true, titlefont: {color: '#a7e54b'}},
    yaxis10: {title: 'Wind Direction (deg)', overlaying: 'y', side: 'right', range: [0, 360], fixedrange: true, titlefont: {color: '#ff0000'}},
    xaxis5: {anchor: 'y5', type: 'date', fixedrange: true, range: [start, end]},
    xaxis4: {anchor: 'y4', type: 'date', fixedrange: true, range: [start, end]},
    xaxis3: {anchor: 'y3', type: 'date', fixedrange: true, range: [start, end]},
    xaxis2: {anchor: 'y2', type: 'date', fixedrange: true, range: [start, end]},
    yaxis2: {domain: [0.22, 0.38], title: 'Min Cloudbase (ft)', fixedrange: true, titlefont: {color: '#ff00d4'}},
    yaxis9: {title: 'Solar Radiation (W/m^2)', overlaying: 'y2', side: 'right', fixedrange: true, titlefont: {color: '#ff9900'}},
    yaxis3: {domain: [0.42, 0.58], title: 'Humidity (%)', range: [0, 100], fixedrange: true, titlefont: {color: '#ffea2d'}},
    yaxis8: {title: 'Pressure (inHg)', overlaying: 'y3', side: 'right', fixedrange: true, titlefont: {color: '#157248'}},
    yaxis4: {domain: [0.62, 0.78], title: 'Precip Hourly (in/hr)', fixedrange: true, titlefont: {color: '#00ddff'}},
    yaxis7: {title: 'Precip Cumulative (in)', overlaying: 'y4', side: 'right', fixedrange: true, titlefont: {color: '#0090ff'}},
    yaxis5: {domain: [0.82, 0.98], title: 'Temp (F)', fixedrange: true, range: [0, 120], titlefont: {color: '#f92500'}},
    yaxis6: {title: 'Dewpoint (F)', overlaying: 'y5', side: 'right', fixedrange: true, range: [0, 120], titlefont: {color: '#00b2ff'}},
    xaxis: {type: 'date', title: 'Date / Time', fixedrange: true, range: [start, end]},
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 30, b: 30, l: 60, pad: 0},
};

var _x ='Date';
var _y = 'Hour';
var _ymin = 0;
var _ymax = 23;
if (period == 'today') {_x = 'Hour'; _y = 'Minute'; _ymin = 0; _ymax = 59}

var traces_hmtemp = [
  {
    z: tempavg,
    x: hm_x,
    y: hm_y,
    type: 'heatmap',
    colorscale: scl_main,
    connectgaps: true,
    zsmooth: 'best',
    colorbar:{
        title: 'Temp (F)',
        outlinecolor: 'rgba(68,68,68,0)',
        thickness: 20,
        titleside: 'right',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        bgcolor: '#F0FFFF',
        },
    xcalendar: 'gregorian',
  }
];

var layout_hmtemp = {
    showlegend: false,
    height: 200,
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 10, b: 50, l: 60, pad: 0},
    yaxis: {title: _y, fixedrange: true, range: [_ymin, _ymax],},
    xaxis: {title: _x, fixedrange: true, range: [start, end],},
};

var traces_hmpres = [
  {
    z: presavg,
    x: hm_x,
    y: hm_y,
    type: 'heatmap',
    colorscale: scl_blueyel,
    connectgaps: true,
    zsmooth: 'best',
    colorbar:{
        title: 'Pressure (inHg)',
        outlinecolor: 'rgba(68,68,68,0)',
        thickness: 20,
        titleside: 'right',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        bgcolor: '#F0FFFF',
        },
    xcalendar: 'gregorian',
  }
];

var layout_hmpres = {
    showlegend: false,
    height: 200,
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 10, b: 50, l: 60, pad: 0},
    yaxis: {title: _y, fixedrange: true, range: [_ymin, _ymax],},
    xaxis: {title: _x, fixedrange: true, range: [start, end],},
};

var traces_hmsolar = [
  {
    z: solarradmax,
    x: hm_x,
    y: hm_y,
    type: 'heatmap',
    colorscale: scl_sunset,
    connectgaps: true,
    zsmooth: 'best',
    colorbar:{
        title: 'Solar Radiation (W/m^2)',
        outlinecolor: 'rgba(68,68,68,0)',
        thickness: 20,
        titleside: 'right',
        ticks: 'outside',
        ticklen: 3,
        shoticksuffix: 'last',
        bgcolor: '#F0FFFF',
        },
    xcalendar: 'gregorian',
  }
];

var layout_hmsolar = {
    showlegend: false,
    height: 200,
    paper_bgcolor: '#F0FFFF',
    plot_bgcolor: '#FFFFFF',
    margin: {r: 50, t: 10, b: 50, l: 60, pad: 0},
    yaxis: {title: _y, fixedrange: true, range: [_ymin, _ymax],},
    xaxis: {title: _x, fixedrange: true, range: [start, end],},
};


Plotly.newPlot(wx_wr, traces_wr, layout_wr, {displayModeBar: false});
Plotly.newPlot(wx_combo, traces_combo, layout_combo, {displayModeBar: false});
Plotly.newPlot(wx_dTdtd, traces_dTdtd, layout_dTdtd, {displayModeBar: false});
Plotly.newPlot(wx_Tdh, traces_Tdh, layout_Tdh, {displayModeBar: false});
Plotly.newPlot(wx_dTdts, traces_dTdts, layout_dTdts, {displayModeBar: false});
Plotly.newPlot(wx_dPdts, traces_dPdts, layout_dPdts, {displayModeBar: false});
Plotly.newPlot(wx_hmtemp, traces_hmtemp, layout_hmtemp, {displayModeBar: false});
Plotly.newPlot(wx_hmpres, traces_hmpres, layout_hmpres, {displayModeBar: false});
Plotly.newPlot(wx_hmsolar, traces_hmsolar, layout_hmpres, {displayModeBar: false});
</script>