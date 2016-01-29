USE weather;

DROP TABLE IF EXISTS conditions;
CREATE TABLE conditions
(
  id              int unsigned NOT NULL auto_increment, # Unique ID for the record
  cityname        varchar(255) NOT NULL,                # Name of City
  zipcode         decimal(5,0) NOT NULL,                # Zip Code for City
  tempk           decimal(5,2) NOT NULL,                # Tempature in Kelvin
  descript        varchar(255) NOT NULL,                # Current conditions
  humidity        decimal(3,0) NOT NULL,                # Percent of humidity
  windspd         decimal(3,1) NOT NULL,                # Wind speed mph
  sunrise         decimal(10,0) NOT NULL,               # sunrise in unix time UTC
  sunset          decimal(10,0) NOT NULL,               # sunset in unix time UTC
  ptime           decimal(10,0) NOT NULL,               # Time of data calculation, unix, UTC

  PRIMARY KEY     (id)
);
