#!/usr/bin/env python

from PIL import Image
import mysql.connector
import sys

im = Image.open(sys.argv[1], 'r')
im = im.convert('RGB')

width, height = im.size

pixel_values = list(im.getdata())

dataForPanel = ""

if(sys.argv[3] == 1):
    startRangeH = 0
    startRangeW = 0
    endRangeH = height/2
    endRangeW = width
else:
    startRangeH = height/2
    startRangeW = 0
    endRangeH = height
    endRangeW = width

for y in range (startRangeH, endRangeH):
    dataForPanel += "\""
    for x in range (startRangeW, endRangeW):

        r = str(oct(pixel_values[endRangeW*y+x][0]))
        g = str(oct(pixel_values[endRangeW*y+x][1]))
        b = str(oct(pixel_values[endRangeW*y+x][2]))

        r = r[0:0:] + r[2::]
        g = g[0:0:] + g[2::]
        b = b[0:0:] + b[2::]

        dataForPanel += ("\\" + r)
        dataForPanel += ("\\" + g)
        dataForPanel += ("\\" + b)
    dataForPanel += ("\"\n")

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="ledpanel"
)

mycursor = mydb.cursor()

sql = "INSERT INTO panelData (panelID, module, data) VALUES ({}, {}, {})"
val = (sys.argv[2], sys.argv[3], dataForPanel)

mycursor.execute(sql, val)

mydb.commit()
