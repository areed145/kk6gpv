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
import xml.etree.ElementTree as ET

class XML2DataFrame:

    def __init__(self, xml_data):
        self.root = ET.XML(xml_data)

    def parse_root(self, root):
        return [self.parse_element(child) for child in iter(root)]

    def parse_element(self, element, parsed=None):
        if parsed is None:
            parsed = dict()
        for key in element.keys():
            parsed[key] = element.attrib.get(key)
        if element.text:
            parsed[element.tag] = element.text
        for child in list(element):
            self.parse_element(child, parsed)
        return parsed

    def process_data(self):
        structure_data = self.parse_root(self.root)
        return pd.DataFrame(structure_data)

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
    ],
    'scl_tdh' : [
    [0.00,'#a9f441'],
    [0.25,'#41f455'],
    [0.50,'#41f1f4'],
    [0.75,'#41b8f4'],
    [1.00,'#4286f4']
    ],
}

def get_wx(sid, Y, m, d):
    url = 'https://www.wunderground.com/weatherstation/WXDailyHistory.asp?'
    url += 'ID='+sid
    url += '&day='+d
    url += '&month='+m
    url += '&year='+Y
    url += '&graphspan=day&format=XML'

    print(url)

    r = requests.get(url).content

    xml2df = XML2DataFrame(r)
    df = xml2df.process_data()

    df.index = pd.to_datetime(df.observation_time_rfc822)

    for col in df.columns:
        try:
            df[col] = pd.to_numeric(df[col])
        except:
            pass
    return df

sid = 'KTXHOUST151'
d = '24'
m = '6'
Y = '2018'

#sid = 'KCABAKER38'
#d = '24'
#m = '6'
#Y = '2017'

data = pd.DataFrame()
for i in range(15):
    df = get_wx(sid, Y, m, str(i))
    data = data.append(df)

data = data.resample('10T').mean()
data['dat'] = data.index
data['temp_delta'] = data.temp_f.diff()
data['dat_delta'] = data.dat.diff().dt.seconds / 360
data['dTdt'] = data['temp_delta'] / data['dat_delta']

#print(data.columns)

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
                {'x': data.dat, 'y': data.temp_f, 'line': {'color': '#f92500', 'width': 1.5}, 'name': 'temp_f'},
                {'x': data.dat, 'y': data.dewpoint_f, 'line': {'color': '#00b2ff', 'width': 1.5}, 'name': 'dewpoint_f'},
                {'x': data.dat, 'y': data.pressure_in, 'line': {'color': '#157248', 'width': 1.5}, 'name': 'pressure'},
                {'x': data.dat, 'y': data.relative_humidity, 'line': {'color': '#ffea2d', 'width': 1.5}, 'name': 'humidity'},
                #{'x': data.dat, 'y': data.wind_degrees, 'line': {'color': '#ff0000', 'width': 1.5}, 'name': 'wind_dir'},
                {'x': data.dat, 'y': data.wind_mph, 'line': {'color': '#a7e54b', 'width': 1.5}, 'name': 'wind_mph'},
                {'x': data.dat, 'y': data.wind_gust_mph, 'line': {'color': '#15b259', 'width': 1.5}, 'name': 'wind_gust_mph'},
                {'x': data.dat, 'y': data.solar_radiation/10, 'line': {'color': '#ff9900', 'width': 1.5}, 'name': 'solar'},
                {'x': data.dat, 'y': data.UV*10, 'line': {'color': '#ff9990', 'width': 1.5}, 'name': 'UV'},
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
            'data': [{
                'x': data.temp_f,
                'y': data.dewpoint_f,
                'name': 'Temp (F)',
                'type': 'scatter',
                'mode': 'markers',
                'marker': {
                    'color': data.dewpoint_f,
                    'colorscale': colors['scl_tdh'],
                    'size': 8,
                    'symbol': 'x',
                    'colorbar':{
                        'title': 'Humidity (%)',
                        'outlinecolor': 'rgba(68,68,68,0)',
                        'thickness': 20,
                        'titleside': 'right',
                        'ticks': 'outside',
                        'ticklen': 3,
                        'shoticksuffix': 'last',
                        'ticksuffix': '%',
                        'bgcolor': '#F0FFFF',
                    }
                },
            }],
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
        id='example-graph3',
        config={'displayModeBar': False},
        figure={
            'data': [{
                'x': data.dat,
                'y': data.temp_f,
                'name': 'Temp (F)',
                'type': 'scatter',
                'mode': 'markers',
                'marker': {
                    'color': data.dTdt,
                    'colorscale': colors['scl_main'],
                    'size': 8,
                    'symbol': 'x',
                    'colorbar':{
                        'title': 'dT/dt (F/hr)',
                        'outlinecolor': 'rgba(68,68,68,0)',
                        'thickness': 20,
                        'titleside': 'right',
                        'ticks': 'outside',
                        'ticklen': 3,
                        'shoticksuffix': 'last',
                        'bgcolor': '#F0FFFF',
                    }
                },
            }],
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

	# dcc.Graph(
 #        id='example-graph2',
 #        config={'displayModeBar': False},
 #        figure={
 #        	'data':[{
 #        		'type': 'scattermapbox',
 #            	'lat': data.lat,
 #                'lon': data.lon,
 #                'text': data.dat,
 #                'name': 'Position',
 #            	'mode': 'lines',
 #            	'line': {'width': 2, 'color': 'black'},
 #                },{
 #        		'type': 'scattermapbox',
 #            	'lat': data.lat,
 #                'lon': data.lon,
 #                'text': data.dat,
 #                'name': 'Position',
 #            	'marker': {
 #            		'size': 8,
 #            		'color': data.alt,
 #            		'colorscale': colors['scl_main']
 #            	}
 #            }],
 #        	'layout': {
 #                'title': 'KK6GPV Telemetry',
 #                'plot_bgcolor': colors['background'],
 #                'paper_bgcolor': colors['background_paper'],
 #                'mapbox': {
	# 			    'center': {'lat': 35, 'lon': -119},
	# 			    'style': 'outdoors', 
	# 			    'zoom': 8,
	# 			    'accesstoken': 'pk.eyJ1IjoiYXJlZWQxNDUiLCJhIjoiY2phdzNsN2ZoMGh0bjMybzF3cTkycWYyciJ9.4aS7z-guI2VDlP3duMg2FA',
	# 			},
 #            }
 #        }
 #    )
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