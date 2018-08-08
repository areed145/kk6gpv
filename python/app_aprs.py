#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Jul 16 17:47:48 2018

@author: areed145
"""

# -*- coding: utf-8 -*-
import dash
import dash_core_components as dcc
import dash_html_components as html
from dash.dependencies import Input, Output, State, Event
import pandas as pd
import numpy as np
import requests

app = dash.Dash('KK6GPVaprs')
server = app.server

colors = {
    'background': '#ffffff',
    'text': '#2a2d2d',
    'background_paper': '#F0FFFF',
    'scl_main': [
	    [0.0, '#424ded'],
	    [0.1,'#4283ed'],
	    [0.2,'#42d0ed'],
	    [0.3,'#42edae'],
	    [0.4,'#78ed42'],
	    [0.5,'#d6ed42'],
	    [0.6,'#edde42'],
	    [0.7,'#f4af41'],
	    [0.8,'#f48541'],
	    [0.9,'#f44741'],
	    [1.0,'#f44298']
    ]
}

url = 'http://www.findu.com/cgi-bin/posit.cgi?call=kk6gpv&comma=1&time=1&start=240'

r = requests.get(url)

lines = r.text.splitlines()[8:-2]

dat = []
lat = []
lon = []
crs = []
spd = []
alt = []

for line in lines:
    parts = line.split(',')
    dat.append(pd.to_datetime(parts[0], utc=True, infer_datetime_format=True))
    lat.append(pd.to_numeric(parts[1]))
    lon.append(pd.to_numeric(parts[2]))
    crs.append(pd.to_numeric(parts[3]))
    spd.append(pd.to_numeric(parts[4]))
    alt.append(pd.to_numeric(parts[5].replace('<br>','').replace('&nbsp;','')))
    
data = pd.DataFrame()
data['dat'] = np.array(dat)
data['lat'] = np.array(lat)
data['lon'] = np.array(lon)
data['crs'] = np.array(crs)
data['spd'] = np.array(spd)
data['alt'] = np.array(alt)
data['d_dat'] = data['dat'].diff() / np.timedelta64(1, 's')
data['d_alt'] = data['alt'].diff()
data['roc'] = data['d_alt'] / data['d_dat']
data.index = data['dat']
data = data.resample('20S').mean()
data['dat'] = data.index

app.layout = html.Div(
	style={'backgroundColor': colors['background']},
	children=[app.css.append_css({"external_url": "https://codepen.io/chriddyp/pen/bWLwgP.css"}),    
    
    html.H1(
    	children='KK6GPV',
    	style={
            'textAlign': 'center',
            'color': colors['text']
        }
    ),

#    html.Div(children='''
#        Dash: A web application framework for Python.
#    '''),

    dcc.Graph(
        id='example-graph',
        config={'displayModeBar': False},
        figure={
            'data': [
                {'x': data.dat, 'y': data.lat, 'type': 'line', 'name': 'Latitude'},
                {'x': data.dat, 'y': data.lon, 'type': 'line', 'name': 'Longitude'},
                {'x': data.dat, 'y': data.crs, 'line': {'color': '#ffdb5b', 'width': 1.5}, 'name': 'Course'},
                {'x': data.dat, 'y': data.spd, 'line': {'color': '#f4663f', 'width': 1.5}, 'name': 'Speed'},
                {'x': data.dat, 'y': data.alt, 'line': {'color': '#f442ee', 'width': 1.5}, 'name': 'Altitude'},
                {'x': data.dat, 'y': data.roc, 'type': 'line', 'name': 'Rate of Climb'},
            ],
            'layout': {
                'title': 'KK6GPV Telemetry',
                'plot_bgcolor': colors['background'],
                'paper_bgcolor': colors['background_paper'],
                'font': {
                    'color': colors['text']
                }
            }
        }
    ),

	dcc.Graph(
        id='example-graph2',
        config={'displayModeBar': False},
        figure={
        	'data':[{
        		'type': 'scattermapbox',
            	'lat': data.lat,
                'lon': data.lon,
                'text': data.dat,
                'name': 'Position',
            	'mode': 'lines',
            	'line': {'width': 2, 'color': 'black'},
                },{
        		'type': 'scattermapbox',
            	'lat': data.lat,
                'lon': data.lon,
                'text': data.dat,
                'name': 'Position',
            	'marker': {
            		'size': 8,
            		'color': data.alt,
            		'colorscale': colors['scl_main']
            	}
            }],
        	'layout': {
                'title': 'KK6GPV Telemetry',
                'plot_bgcolor': colors['background'],
                'paper_bgcolor': colors['background_paper'],
                'mapbox': {
				    'center': {'lat': 35, 'lon': -119},
				    'style': 'outdoors', 
				    'zoom': 8,
				    'accesstoken': 'pk.eyJ1IjoiYXJlZWQxNDUiLCJhIjoiY2phdzNsN2ZoMGh0bjMybzF3cTkycWYyciJ9.4aS7z-guI2VDlP3duMg2FA',
				},
            }
        }
    )
])

        	# 'data': [{
        		# 'type': 'scattermapbox',
          #   	'lat': data.lat,
          #       'lon': data.lon,
          #       'text': data.dat,
          #       'name': 'Position',
          #   	'mode': 'lines',
          #   	'line': {'width': 2, 'color': 'black'},
          #       },{
          #   	'type': 'scattermapbox',
          #   	'lat': data.lat,
          #       'lon': data.lon,
          #       'text': data.dat,
          #       'name': 'Position',
          #   	'mode': 'markers',
          #       'opacity': 0.7,
          #       'marker': {
	         #        'color': data.spd,
	         #        'colorscale': colors['scl_main'],
          #       	'size': 8,
        		# 	'symbol': 'x',
        		# 	'colorbar':{
				      #   'thickness': 20,
				      #   'titleside': 'right',
				      #   'outlinecolor': 'rgba(68,68,68,0)',
				      #   'ticks': 'outside',
				      #   'ticklen': 3,
				      #   'shoticksuffix': 'last',
				      #   'ticksuffix': 'ft',
				      #   'dtick': 1000,
				      #   'bgcolor': '#F0FFFF',
				      # }
          #       	},
          #       },

# external_css = ["https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css",
#                 "//fonts.googleapis.com/css?family=Raleway:400,300,600",
#                 "//fonts.googleapis.com/css?family=Dosis:Medium",
#                 "https://cdn.rawgit.com/plotly/dash-app-stylesheets/62f0eb4f1fadbefea64b2404493079bf848974e8/dash-uber-ride-demo.css",
#                 "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"]

# for css in external_css:
#     app.css.append_css({"external_url": css})

if __name__ == '__main__':
    app.run_server(debug=True)