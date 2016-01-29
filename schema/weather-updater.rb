#!/usr/bin/ruby
# open weather api call
# encoding: utf-8
require 'mysql2'
require 'rubygems'
require 'json'
require 'open-uri'

# Call the open weather api for current conditions.
base_uri = 'http://api.openweathermap.org/data/2.5/weather'
apikey = '44db6a862fba0b067b1930da0d769e98'
# Open local database
user = ENV['DB_USER']
pwd = ENV['DB_PWD']
con = Mysql2::Client.new(host: 'localhost', username: user, password: pwd, database: 'weather', encoding: 'utf8' )
# get zipcodes from database
ar = con.query("SELECT * FROM conditions").each
# create hash of zipcodes
zips = Hash.new
ar.each do | row |
   id = row["id"]
   zip = row["zipcode"]
   zips[id] = "#{zip}"
end
nz = zips.length
# loop thru locations based on zipcode
for i in 1..nz
   i.to_i
   key = i
   zipcode = zips[i]
   # make API call
   json = open(base_uri + "?zip=#{zipcode},us&appid=#{apikey}").read
   # parse the json into needed variables
   json = JSON.parse(json)
   weather = json['weather']
   wcarray = { 'tempk' => json['main']['temp'],
               'descript' => weather[0]['description'],
               'humidity' => json['main']['humidity'],
               'windspd' => json['wind']['speed'],
               'sunrise' => json['sys']['sunrise'],
               'sunset' => json['sys']['sunset'],
               'ptime' => json['dt']
             }
  #update database with new weather data
  wcarray.each do | var |
    pst = con.prepare "UPDATE conditions SET #{var[0]} = ? WHERE Id = ?"
    pst.execute "#{var[1]}", "#{key}"
  end
end
# close database
con.close
