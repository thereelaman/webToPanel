#!/usr/bin/env python

from PIL import Image
import mysql.connector
import sys

imagePath = "/var/www/thedisplay.studio/userimages/" + sys.argv[1]
im = Image.open(imagePath, 'r')
im = im.convert('RGB')

width, height = im.size

pixel_values = list(im.getdata())

dataForPanel = ""

if(int(sys.argv[3]) == 1):
    print("1")
    startRangeH = int(0)
    startRangeW = int(0)
    endRangeH = int(height/2)
    endRangeW = int(width)
else:
    startRangeH = int(height/2)
    startRangeW = int(0)
    endRangeH = int(height)
    endRangeW = int(width)

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

sql = "INSERT INTO panelData (panelID, module, data, token) VALUES (%s, %s, %s, %s)"
val = (sys.argv[2], sys.argv[3], dataForPanel, sys.argv[4])

mycursor.execute(sql, val)

mydb.commit()
