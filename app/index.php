
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Hello Clarice</title>
        <link rel="shortcut icon" type="image/x-icon" href="hk_icon.png" />
    </head>
      <body>
        <font size="3" face='calibri' color="blue">
        <img src=hk_logo.png height="70px" style="display:inline;margin:1px 1px 1px 65px;">
        <hr noshade size=2 width=240 align=left>
        <h2>HK Weather Application</h2>
        <hr noshade size=2 width=240 align=left>
        <h2>Select city for weather:</h2>

        <?php
        $BASE_URL = "http://api.poweredwire.com/";
        $list_query = "?method=weather&format=list";
        $list_query_url = $BASE_URL . $list_query;

        $jsonData = file_get_contents($list_query_url);
        $jsonArray = json_decode($jsonData);
        $zipc = "";
        ?>

        <form action="" name="city" method="post">
        <select name="CityZip">
        <option value = "0" >Select City </option>

        <?php
        foreach($jsonArray as $jsonValue) {
        echo '<option value =' . $jsonValue->zipcode . '>' . $jsonValue->cityname . '</option>'; }
        ?>
        </select>
        <input type="submit" name="submit" value="Select" />
        </form>
        <br><hr noshade size=2 width=240 align=left>

        <?php
        if(!empty($_POST['CityZip'])) {
          $zipc = isset($_POST["CityZip"]) ? $_POST["CityZip"] : "";
          foreach($jsonArray as $jsonValue) {
            if ($jsonValue->zipcode == $zipc) {
              $cityname = $jsonValue->cityname;
            }
          }
          echo "<h3>Conditions in: $cityname<br>";
          echo "<br>Data for zipcode: $zipc</h3>";
          echo "<h4>";

          // create base url variable
          $cond_query = "?method=weather&zipcode=$zipc&format=json";
          $cond_query_url = $BASE_URL . $cond_query;
          // pull data from RESTful api & decode the json
          $cond_json = file_get_contents($cond_query_url);
          $cond_array = json_decode($cond_json, true);
          // set variables for output
          $condition = $cond_array["condition"];
          $humidity = $cond_array["humidity"];
          $wspeed = $cond_array["windspeed"];
          // convert sun times to est
          date_default_timezone_set('us/eastern');
          $sunrise = date('h:i A (T)', $cond_array["sunrise"]);
          $sunset = date('h:i A (T)', $cond_array["sunset"]);
          $ut = date('M jS \a\t h:i A (T)', $cond_array["updated"]);
          // convert temp from Kelvin to Fahrenheit
          $kc = $cond_array["tempature"] - 273.15;
          $km = 1.8;
          $wf = 32;
          $tf = ($kc * $km) + $wf;
          $tf = round($tf, 1);
          if ($tf < -400 ) {$tf = "";}
          // display results formatted in html
          echo "Updated: $ut";
          echo "<br><br>Tempature: $tf °F";
          echo "<br><br>Condition: $condition";
          echo "<br><br>Humidity: $humidity %";
          echo "<br><br>Wind speed: $wspeed mph";
          echo "<br><br>Sunset: $sunset";
          echo "<br><br>Sunrise: $sunrise";
          echo "</h4>";
        }
        ?>

        <hr noshade size=2 width=240 align=left>
        </font>
        <font size="2" face='arial' color="black">
        <br>Test application for RESTful service<br>
        Data source: api.poweredwire.com<br>
        Powered by PCF and AWS EC2
        </font>
      </body>
</HTML>
