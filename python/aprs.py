#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Jul 16 17:22:18 2018

@author: areed145
"""

import pandas as pd
import numpy as np
import requests

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
data2 = data.resample('60S').mean()

data2.to_csv('data.csv')