
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Hello Clarice</title>
        <link rel="shortcut icon" type="image/x-icon" href="hk_icon.png" />
    </head>
      <body>
        <font size="3" face='calibri' color="blue">
        <img src=go_logo.jpg height="70px" style="display:inline;margin:1px 1px 1px 65px;">
        <hr noshade size=2 width=240 align=left>
        <h2>GO Weather Application</h2>
        <hr noshade size=2 width=240 align=left>
        <h2>Select city for weather:</h2>

        <?php
        $submittedValue = "";
        $value0 = "Select";
        $value1 = "Dayton";
        $value2 = "Middletown";
        $value3 = "Lebonan";
        $value4 = "Blue Ash";
        $value5 = "Cincinnati";
        $value6 = "Beaufort";
        $value7 = "Las Vegas";
        if (isset($_POST["FruitList"])) {
            $submittedValue = $_POST["FruitList"];
        }
        ?>
        <form action="" name="fruits" method="post">
        <select project="FruitList" id="FruitList" name="FruitList">
          <option value = "<?php echo $value0; ?>"<?php echo ($value0 == $submittedValue)?" SELECTED":""?>><?php echo $value0; ?></option>
          <option value = "<?php echo $value1; ?>"<?php echo ($value0 == $submittedValue)?" SELECTED":""?>><?php echo $value1; ?></option>
          <option value = "<?php echo $value2; ?>"<?php echo ($value0 == $submittedValue)?" SELECTED":""?>><?php echo $value2; ?></option>
          <option value = "<?php echo $value3; ?>"<?php echo ($value0 == $submittedValue)?" SELECTED":""?>><?php echo $value3; ?></option>
          <option value = "<?php echo $value4; ?>"<?php echo ($value0 == $submittedValue)?" SELECTED":""?>><?php echo $value4; ?></option>
          <option value = "<?php echo $value5; ?>"<?php echo ($value0 == $submittedValue)?" SELECTED":""?>><?php echo $value5; ?></option>
          <option value = "<?php echo $value6; ?>"<?php echo ($value0 == $submittedValue)?" SELECTED":""?>><?php echo $value6; ?></option>
          <option value = "<?php echo $value7; ?>"<?php echo ($value0 == $submittedValue)?" SELECTED":""?>><?php echo $value7; ?></option>
        </select>
        <input type="submit" name="submit" id="submit" value="Submit" />
        </form>

        <?php
        $city = $submittedValue;
        $zipc = "";
        if ($city == $value1) { $zipc = "45402"; }
        if ($city == $value2) { $zipc = "45042"; }
        if ($city == $value3) { $zipc = "45036"; }
        if ($city == $value4) { $zipc = "45241"; }
        if ($city == $value5) { $zipc = "45202"; }
        if ($city == $value6) { $zipc = "29901"; }
        if ($city == $value7) { $zipc = "89101"; }
        echo "<br><hr noshade size=2 width=240 align=left>";
        echo "<h3>Conditions for $submittedValue ($zipc)</h3>";
        echo "<h4>";

        // create base url variable
        $BASE_URL = "http://weather.poweredwire.com/";
        $yql_query = $zipc;
        $yql_query_url = $BASE_URL . $yql_query;
        // pull data from RESTful api using curl
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($session);
        curl_close($session);
        // decode the json
        $tbj = json_decode($json, true);
        // Get update time
        $updated = $tbj["updated"];
        // Get tempature
        $kt = $tbj["tempature"];
        // Get Condition
        $condition = $tbj["condition"];
        // Get Humidity
        $humidity = $tbj["humidity"];
        // Get Wind Speed
        $wspeed = $tbj["windspeed"];
        // Get Sunrise and set
        $sunr = $tbj["sunrise"];
        $suns = $tbj["sunset"];
        // convert sun times to est
        date_default_timezone_set('us/eastern');
        $sunrise = date('h:i A (T)', $sunr);
        $sunset = date('h:i A (T)', $suns);
        $ut = date('M jS \a\t h:i A (T)', $updated);
        // convert temp from Kelvin to Fahrenheit
        $kc = $kt - 273.15;
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
        ?>
        <hr noshade size=2 width=240 align=left>
        </font>
        <font size="2" face='arial' color="black">
        <br>Test application for RESTful service written in golang<br>
        Data source: weather.poweredwire.com<br>
        Powered by PCF and AWS EC2, MySQL with Golang based service
        </font>
      </body>
</HTML>
