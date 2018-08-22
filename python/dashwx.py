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
#from dash.dependencies import Input, Output, State, Event
import pandas as pd
#import numpy as np
import requests
import xml.etree.ElementTree as ET
from datetime import datetime, timedelta

#sid = 'KCABAKER38'
sid = 'KTXHOUST151'
days = 5

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

def get_data(sid, days):
    today = datetime.utcnow()
    data = pd.DataFrame()
    for d in range(days):
        try:
            cur = today - timedelta(days=d)
            df = get_wx(sid, str(cur.year), str(cur.month), str(cur.day))
            data = data.append(df)
        except:
            pass
    
    data = data.tz_localize('utc').tz_convert('US/Central')
    data['cloudbase'] = ((data['temp_f'] - data['dewpoint_f']) / 4.4) * 1000 + 50
    data.loc[data['pressure_in'] < 0, 'pressure_in'] = pd.np.nan
    data2 = data.resample('5T').mean().interpolate()
    data2['dat'] = data2.index
    data2['temp_delta'] = data2.temp_f.diff()
    data2['pres_delta'] = data2.pressure_in.diff()
    data2['dat_delta'] = data2.dat.diff().dt.seconds / 360
    data2['dTdt'] = data2['temp_delta'] / data2['dat_delta']
    data2['dPdt'] = data2['pres_delta'] / data2['dat_delta']
    data3 = data2.drop(columns=['dat'])
    data3 = data3.rolling(20*3).mean().add_suffix('_roll')
    data = data2.join(data3)
    data['date'] = data.index.date
    data['hour'] = data.index.hour
    return data

def serve_layout():
    data = get_data(sid, days)
    return html.Div(
    style={
        'backgroundColor': colors['background_paper'],
    },
    children=[
            
        app.css.append_css({"external_url": "http://kk6gpv.net/includes/style.css"}),    
    
        html.H1(
            style={
                'textAlign': 'center',
                'color': colors['text'],
                'backgroundColor': colors['background_paper'],
            },
            children='KK6GPV'
        ),
        
        html.Div(
            children=[
                dcc.Graph(
                    id='temp-dewpt',
                    config={'displayModeBar': False},
                    figure={
                        'data': [
                            {'x': data.dat, 'y': data.temp_f, 'line': {'color': '#f92500', 'width': 1.5}, 'name': 'temp_f', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.temp_f_roll, 'line': {'color': '#f92500', 'width': 1.5}, 'name': 'temp_f', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.dewpoint_f, 'line': {'color': '#00b2ff', 'width': 1.5}, 'name': 'dewpoint_f', 'xaxis': 'x', 'yaxis': 'y2',},
                            {'x': data.dat, 'y': data.dewpoint_f_roll, 'line': {'color': '#00b2ff', 'width': 1.5}, 'name': 'dewpoint_f', 'xaxis': 'x', 'yaxis': 'y2',},
                        ],
                        'layout': {
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Temp (F)',
                                'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#f92500'}
                            },
                            'yaxis2': {
                                'domain': [0.02, 0.98],
                                'title': 'Dewpoint (F)',
                                'overlaying': 'y', 
                                'side': 'right', 
                                'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#00b2ff'}
                            },
                            'xaxis': {
                                'type': 'date', 
                                #'title': 'Date / Time', 
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'height': 200,
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            },

                        }
                    }
                ),
                dcc.Graph(
                    id='precip',
                    config={'displayModeBar': False},
                    figure={
                        'data': [
                            {'x': data.dat, 'y': data.precip_1hr_in, 'line': {'color': '#00ddff', 'width': 1.5}, 'name': 'precip_1hr_in', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.precip_1hr_in_roll, 'line': {'color': '#00ddff', 'width': 1.5}, 'name': 'precip_1hr_in', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.precip_today_in, 'line': {'color': '#0090ff', 'width': 1.5}, 'name': 'precip_today_in', 'xaxis': 'x', 'yaxis': 'y2',},
                            {'x': data.dat, 'y': data.precip_today_in_roll, 'line': {'color': '#0090ff', 'width': 1.5}, 'name': 'precip_today_in', 'xaxis': 'x', 'yaxis': 'y2',},
                        ],
                        'layout': {
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Precip (in/hr)',
                                #'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#00ddff'}
                            },
                            'yaxis2': {
                                'domain': [0.02, 0.98],
                                'title': 'Precip Cum (in)',
                                'overlaying': 'y', 
                                'side': 'right', 
                                #'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#0090ff'}
                            },
                            'xaxis': {
                                'type': 'date', 
                                #'title': 'Date / Time', 
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'height': 200,
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
                dcc.Graph(
                    id='humid-pressure',
                    config={'displayModeBar': False},
                    figure={
                        'data': [
                            {'x': data.dat, 'y': data.pressure_in, 'line': {'color': '#157248', 'width': 1.5}, 'name': 'pressure', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.pressure_in_roll, 'line': {'color': '#157248', 'width': 1.5}, 'name': 'pressure', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.relative_humidity, 'line': {'color': '#ffea2d', 'width': 1.5}, 'name': 'humidity', 'xaxis': 'x', 'yaxis': 'y2',},
                            {'x': data.dat, 'y': data.relative_humidity_roll, 'line': {'color': '#ffea2d', 'width': 1.5}, 'name': 'humidity', 'xaxis': 'x', 'yaxis': 'y2',},
                        ],
                        'layout': {
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Pressure (inHg)',
                                #'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#157248'}
                            },
                            'yaxis2': {
                                'domain': [0.02, 0.98],
                                'title': 'Relative Humidity (%)',
                                'overlaying': 'y', 
                                'side': 'right', 
                                #'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#ffea2d'}
                            },
                            'xaxis': {
                                'type': 'date', 
                                #'title': 'Date / Time', 
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'height': 200,
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
                dcc.Graph(
                    id='wind',
                    config={'displayModeBar': False},
                    figure={
                        'data': [
                            {'x': data.dat, 'y': data.wind_degrees,
                             'type': 'scatter', 'mode': 'markers',
                             'marker': {'color': '#ff0000', 'size': 8, 'symbol': 'x'}, 'name': 'wind_dir', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.wind_mph, 'line': {'color': '#a7e54b', 'width': 1.5}, 'name': 'wind_mph', 'xaxis': 'x', 'yaxis': 'y2',},
                            {'x': data.dat, 'y': data.wind_mph_roll, 'line': {'color': '#a7e54b', 'width': 1.5}, 'name': 'wind_mph', 'xaxis': 'x', 'yaxis': 'y2',},
                            {'x': data.dat, 'y': data.wind_gust_mph, 'line': {'color': '#15b259', 'width': 1.5}, 'name': 'wind_gust_mph', 'xaxis': 'x', 'yaxis': 'y2',},
                            {'x': data.dat, 'y': data.wind_gust_mph_roll, 'line': {'color': '#15b259', 'width': 1.5}, 'name': 'wind_gust_mph', 'xaxis': 'x', 'yaxis': 'y2',},
                        ],
                        'layout': {
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Wind Direction (deg)',
                                'range': [0, 360], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#ff0000'}
                            },
                            'yaxis2': {
                                'domain': [0.02, 0.98],
                                'title': 'Windspeed / Gust (in)',
                                'overlaying': 'y', 
                                'side': 'right', 
                                #'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#a7e54b'}
                            },
                            'xaxis': {
                                'type': 'date', 
                                #'title': 'Date / Time', 
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'height': 200,
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
                dcc.Graph(
                    id='solar-uv-cloudbase',
                    config={'displayModeBar': False},
                    figure={
                        'data': [
                            {'x': data.dat, 'y': data.solar_radiation, 'line': {'color': '#ff9900', 'width': 1.5}, 'name': 'solar', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.solar_radiation_roll, 'line': {'color': '#ff9900', 'width': 1.5}, 'name': 'solar', 'xaxis': 'x', 'yaxis': 'y',},
                            {'x': data.dat, 'y': data.UV, 'line': {'color': '#ff9990', 'width': 1.5}, 'name': 'UV', 'xaxis': 'x', 'yaxis': 'y2',},
                            {'x': data.dat, 'y': data.UV_roll, 'line': {'color': '#ff9990', 'width': 1.5}, 'name': 'UV', 'xaxis': 'x', 'yaxis': 'y2',},
                            {'x': data.dat, 'y': data.cloudbase, 'line': {'color': '#ff00d4', 'width': 1.5}, 'name': 'cloudbase', 'xaxis': 'x', 'yaxis': 'y3',},
                            {'x': data.dat, 'y': data.cloudbase_roll, 'line': {'color': '#ff00d4', 'width': 1.5}, 'name': 'cloudbase', 'xaxis': 'x', 'yaxis': 'y3',},
                        ],
                        'layout': {
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Solar Radiation (W/m^2)',
                                #'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#ff9900'}
                            },
                            'yaxis2': {
                                'domain': [0.02, 0.98],
                                'title': 'UV',
                                'overlaying': 'y', 
                                'side': 'right', 
                                #'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#ff9990'}
                            },
                            'yaxis3': {
                                'domain': [0.02, 0.98],
                                'title': 'Min Cloudbase (ft AGL)',
                                'overlaying': 'y', 
                                'side': 'right', 
                                #'range': [0, 120], 
                                'fixedrange': True, 
                                'titlefont': {'color': '#ff00d4'}
                            },
                            'xaxis': {
                                'type': 'date', 
                                #'title': 'Date / Time', 
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'height': 200,
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
            ]
        ),
    
        html.Div(
            style={
                'columnCount': 2,
            },
            children=[
                dcc.Graph(
                    id='tdh',
                    config={'displayModeBar': False},
                    figure={
                        'data': [{
                            'x': data.dewpoint_f_roll,
                            'y': data.temp_f_roll,
                            'type': 'scatter',
                            'mode': 'markers',
                            'marker': {
                                'color': data.relative_humidity_roll,
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
                            'xaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Dewpoint (F)', 
                                'fixedrange': True,
                            },
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Temperature (F)',
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'title': 'Temp vs. Dewpoint by Humidity',
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
            
                dcc.Graph(
                    id='dtd',
                    config={'displayModeBar': False},
                    figure={
                        'data': [{
                            'x': data.dat,
                            'y': data.temp_f_roll,
                            'type': 'scatter',
                            'mode': 'markers',
                            'marker': {
                                'color': data.dTdt_roll,
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
                            'xaxis': {
                                'domain': [0.02, 0.98],
                                'type': 'date',
                                #'title': 'Date / Time', 
                                'fixedrange': True,
                            },
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Temperature (F)',
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'title': 'Temp vs. Time by dT/dt',
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
            ]
        ),
    
        html.Div(
            style={
                'columnCount': 2,
            },
            children=[
                dcc.Graph(
                    id='dtdt-solar',
                    config={'displayModeBar': False},
                    figure={
                        'data': [{
                            'x': data.solar_radiation_roll,
                            'y': data.dTdt_roll,
                            'type': 'scatter',
                            'mode': 'markers',
                            'marker': {
                                'color': data.temp_f_roll,
                                'colorscale': colors['scl_main'],
                                'size': 8,
                                'symbol': 'x',
                                'colorbar':{
                                    'title': 'Temp (F)',
                                    'outlinecolor': 'rgba(68,68,68,0)',
                                    'thickness': 20,
                                    'titleside': 'right',
                                    'ticks': 'outside',
                                    'ticklen': 3,
                                    'shoticksuffix': 'last',
                                    'ticksuffix': 'F',
                                    'bgcolor': '#F0FFFF',
                                }
                            },
                        }],
                        'layout': {
                            'xaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Solar Radiation (W/m^2)', 
                                'fixedrange': True,
                            },
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'dT/dt (F/hr)',
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'title': 'dT/dt vs. Solar Radiation by Temp',
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
            
                dcc.Graph(
                    id='dpdt-wind',
                    config={'displayModeBar': False},
                    figure={
                        'data': [{
                            'x': data.wind_mph_roll,
                            'y': data.dPdt_roll,
                            'type': 'scatter',
                            'mode': 'markers',
                            'marker': {
                                'color': data.pressure_in_roll,
                                'colorscale': colors['scl_main'],
                                'size': 8,
                                'symbol': 'x',
                                'colorbar':{
                                    'title': 'Pressure (inHg)',
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
                            'xaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'Windspeed (mph)', 
                                'fixedrange': True,
                            },
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'title': 'dPdt (inHg/hr)',
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'title': 'dP/dt vs. Windspeed by Temp',
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
            ]
        ),

        html.Div(
            style={
                #'columnCount': 2,
            },
            children=[
                dcc.Graph(
                    id='hm-temp',
                    config={'displayModeBar': False},
                    figure={
                        'data': [{
                            'z': data.temp_f_roll,
                            'x': data.date,
                            'y': data.hour,
                            'type': 'heatmap',
                            'colorscale': colors['scl_main'],
                            'connectgaps': True,
                            'zsmooth': 'best',
                            'colorbar':{
                                    'title': 'Temp (F)',
                                    'outlinecolor': 'rgba(68,68,68,0)',
                                    'thickness': 20,
                                    'titleside': 'right',
                                    'ticks': 'outside',
                                    'ticklen': 3,
                                    'shoticksuffix': 'last',
                                    'bgcolor': '#F0FFFF',
                            }
                        }],
                        'layout': {
                            'xaxis': {
                                'domain': [0.02, 0.98],
                                'fixedrange': True,
                            },
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'height': 200,
                            'title': 'Temp Heatmap',
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
            
                dcc.Graph(
                    id='hm-pres',
                    config={'displayModeBar': False},
                    figure={
                        'data': [{
                            'z': data.pressure_in_roll,
                            'x': data.date,
                            'y': data.hour,
                            'type': 'heatmap',
                            'colorscale': colors['scl_main'],
                            'connectgaps': True,
                            'zsmooth': 'best',
                            'colorbar':{
                                    'title': 'Pressure (inHg)',
                                    'outlinecolor': 'rgba(68,68,68,0)',
                                    'thickness': 20,
                                    'titleside': 'right',
                                    'ticks': 'outside',
                                    'ticklen': 3,
                                    'shoticksuffix': 'last',
                                    'bgcolor': '#F0FFFF',
                            }
                        }],
                        'layout': {
                            'xaxis': {
                                'domain': [0.02, 0.98],
                                'fixedrange': True,
                            },
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'height': 200,
                            'title': 'Pressure Heatmap',
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),

                dcc.Graph(
                    id='hm-solar',
                    config={'displayModeBar': False},
                    figure={
                        'data': [{
                            'z': data.solar_radiation,
                            'x': data.date,
                            'y': data.hour,
                            'type': 'heatmap',
                            'colorscale': colors['scl_main'],
                            'connectgaps': True,
                            'zsmooth': 'best',
                            'colorbar':{
                                    'title': 'Solar Radiation (W/m^2)',
                                    'outlinecolor': 'rgba(68,68,68,0)',
                                    'thickness': 20,
                                    'titleside': 'right',
                                    'ticks': 'outside',
                                    'ticklen': 3,
                                    'shoticksuffix': 'last',
                                    'bgcolor': '#F0FFFF',
                            }
                        }],
                        'layout': {
                            'xaxis': {
                                'domain': [0.02, 0.98],
                                'fixedrange': True,
                            },
                            'yaxis': {
                                'domain': [0.02, 0.98],
                                'fixedrange': True,
                            },
                            'margin': {'r': 50, 't': 30, 'b': 30, 'l': 60, 'pad': 0},
                            'showlegend': False,
                            'height': 200,
                            'title': 'Solar Radiation Heatmap',
                            'plot_bgcolor': colors['background'],
                            'paper_bgcolor': colors['background_paper'],
                            'font': {
                                'color': colors['text']
                            }
                        }
                    }
                ),
            ]
        ),
    ]
)

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

app.layout = serve_layout

if __name__ == '__main__':
    app.run_server(debug=True)