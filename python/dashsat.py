import datetime

import dash
import dash_core_components as dcc
import dash_html_components as html
import plotly
import numpy as np
from dash.dependencies import Input, Output
    
# pip install pyorbital
from pyorbital.orbital import Orbital
satellite = Orbital('TERRA')

mapbox_access_token = 'pk.eyJ1IjoiYXJlZWQxNDUiLCJhIjoiY2phdzNsN2ZoMGh0bjMybzF3cTkycWYyciJ9.4aS7z-guI2VDlP3duMg2FA'

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

def get_bearing(lat0,lon0,lat1,lon1):
    '''
    Calculates the bearing from point 1 to point 0
    '''
    lat0r = np.radians(lat0)
    lon0r = np.radians(lon0)
    lat1r = np.radians(lat1)
    lon1r = np.radians(lon1)
    X = np.cos(lat0r)*np.sin(lon0r-lon1r)
    Y = np.cos(lat1r)*np.sin(lat0r)-np.sin(lat1r)*np.cos(lat0r)*np.cos(lon0r-lon1r)
    b = np.degrees(np.arctan2(X,Y))
    return b

app = dash.Dash(__name__)
app.layout = html.Div(
    html.Div([
        html.H4('TERRA Satellite Live Feed'),
        html.Div(id='live-update-text'),
        dcc.Graph(id='live-update-graph'),
        dcc.Interval(
            id='interval-component',
            interval=1*1000, # in milliseconds
            n_intervals=0
        )
    ])
)

@app.callback(Output('live-update-text', 'children'),
              [Input('interval-component', 'n_intervals')])
def update_metrics(n):
    data = {
        'time': [],
        'Latitude': [],
        'Longitude': [],
        'Altitude': []
    }

    # Collect some data
    for i in range(2):
        time = datetime.datetime.now() - datetime.timedelta(seconds=i*5)
        lon, lat, alt = satellite.get_lonlatalt(
            time
        )
        data['Longitude'].append(lon)
        data['Latitude'].append(lat)
        data['Altitude'].append(alt)
        data['time'].append(time)
    
    b = get_bearing(data['Latitude'][0],
                    data['Longitude'][0],
                    data['Latitude'][1],
                    data['Longitude'][1])

    style = {'padding': '5px', 'fontSize': '16px'}
    return [
        html.Span('Longitude: {0:.2f}'.format(data['Longitude'][0]), style=style),
        html.Span('Latitude: {0:.2f}'.format(data['Latitude'][0]), style=style),
        html.Span('Altitude: {0:0.2f}'.format(data['Altitude'][0]), style=style),
        html.Span('Bearing: {0:0.2f}'.format(b), style=style),
    ]


# Multiple components can update everytime interval gets fired.
@app.callback(Output('live-update-graph', 'figure'),
              [Input('interval-component', 'n_intervals')])
def update_graph_live(n):
    satellite = Orbital('TERRA')
    data = {
        'time': [],
        'Latitude': [],
        'Longitude': [],
        'Altitude': []
    }

    # Collect some data
    for i in range(180):
        time = datetime.datetime.now() - datetime.timedelta(seconds=i*5)
        lon, lat, alt = satellite.get_lonlatalt(
            time
        )
        data['Longitude'].append(lon)
        data['Latitude'].append(lat)
        data['Altitude'].append(alt)
        data['time'].append(time)
    
#    print(data['Latitude'][0], data['Longitude'][0])
    
    b = get_bearing(data['Latitude'][0],
                    data['Longitude'][0],
                    data['Latitude'][1],
                    data['Longitude'][1])

    fig={
        'data': [{
            'lat': data['Latitude'],
            'lon': data['Longitude'],
            'type': 'scattermapbox',
            'mode': 'markers',
            'marker': {
              'color': data['Latitude'],
              'colorscale': colors['scl_main'],
              'reversescale': False,
              'cmin': -90,
              'cmax': 90,
              'opacity': 1,
              'size': 10,
              'colorbar':{
                'title': data,
                'thickness': 20,
                'titleside': 'right',
                'outlinecolor': 'rgba(68,68,68,0)',
                'ticks': 'outside',
                'ticklen': 3,
                'shoticksuffix': 'last',
#                'bgcolor': '#F0FFFF',
               }
             },
        }],
        'layout': {
            'mapbox': {
                'accesstoken': (mapbox_access_token),
                'center': {'lat': data['Latitude'][0], 'lon': data['Longitude'][0]},
                'style': 'mapbox://styles/mapbox/satellite-streets-v9', 
                'zoom': 4,
                'pitch': 60,
                'bearing': b,
            },
            'margin': {
                'l': 0, 'r': 0, 'b': 0, 't': 0
            },
        }
    }

    return fig


if __name__ == '__main__':
    app.run_server(debug=True)