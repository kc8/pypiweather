#!/usr/bin/env python

# Uses python 3.4
# Gets the weather in selected area and attempts to put it into 
# database.
# Program design is a rough working design, needs redesign.
# Uses MySQLdb API and python weather API.

import pywapi #import pywapi https://code.google.com/p/python-weather-api/
import MySQLdb #Use MySQL to add weather data to a database

# Try to make a connection to the database, if that fails print an error occurred
# ***** ALL usernames and passwords have been removed****** 
try:
    db = MySQLdb.connect(host="localhost",
                         user= "root",
                         passwd="cooper8",
                         db="Weather")
    cur=db.cursor()
except:
    print("Could not create the connection to the database")
    print("Is the connection still valid, password change? wrong DB? or wrong host?")
    print("Is the database still there?")
 
# Now try and get the weather 
try: 
    weather = pywapi.get_weather_from_weather_com('ZIP', 'imperial') # Zip, measurement system 

    #Get the location name
    weather_loc = weather['location']['name']
    loc = str(weather_loc)

    #get Temperature and units
    temp_unit = weather['units']['temperature']
    temp_current = weather['current_conditions']['temperature']
    temp = str(temp_current) +  str(temp_unit)

    #get wind info:
    #wind units:
    wind_speed = weather['units']['speed']
    wind_pres = weather['units']['pressure'] #Not used
    #Get the dictionary for wind
    wind_dict = weather['current_conditions']['wind']
    #Use the keys to get specific info about the wind
    wind_g = wind_dict['gust']
    wind_s = wind_dict['speed']
    wind_d = wind_dict['text'] #direction in N,S,E,W
    #Cast wind info, and add units
    w_speed = str(wind_s) + str(wind_speed)
    w_gust = str(wind_g) + str(wind_speed)
    w_direc = str(wind_d)

    #Humidity information:
    humidity = weather['current_conditions']['humidity']
    hum = str(humidity)

    #the current conditions (sunny, cludy, rain, thunder etc):
    cond_dict = weather['current_conditions']['text']
    cur_con = str(cond_dict)

    #Get the barometer reading (pressure) and units
    bar_cond = weather['current_conditions']['barometer']
    bar_read = bar_cond['reading']
    bar_unt = weather['units']['pressure']
    baro = str(bar_read) + str(bar_unt) 

    #Get the current moon phase
    phase_dict = weather['current_conditions']['moon_phase']
    moon_phase = phase_dict['text']
    m_phase = str(moon_phase)

    #Get the visibility
    vis_dict = weather['current_conditions']['visibility']
    vis_units = weather['units']['distance']
    visibility = str(vis_dict)+ str(vis_units)

    #Get the UV index
    uv_dict = weather['current_conditions']['uv']
    uv_index = uv_dict['index']
    uv_alert = uv_dict['text']
    uv_ind = str(uv_index)
    uv_al = str(uv_alert)
        
    #-------------ADD TO DATABASE---------------------#
    #-------------------------------------------------#

    #Query string to insert
    add = ("INSERT INTO Conditions (time, location, temp,windSpeed, windGusts, windDirection, humidity, currentCondition, barometer, moonPhase, visibility, uvIndex, uvAlert ) VALUES (NOW(), %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)")
    #Execute the insert statement with the added variables
    cur.execute(add,(loc, temp, w_speed ,w_gust, w_direc, hum, cur_con, baro, m_phase, visibility, uv_ind, uv_al))
    #done with the database, "commit" changes and close the connection:
    db.commit()
    cur.close()
    db.close()
except:
    # If any errors occurs we will print out a failure (This is a problem if 
    # you are running as job) 
    print("An 'except' statement has occurred in attempting to get the weather \n or adding to the database")
    print("Please check whether the weather stream is valid")
    print("Or something has gone wrong with adding to the database")

