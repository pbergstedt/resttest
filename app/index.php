
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
          <h2>PCF Training Application</h2>
          <hr noshade size=2 width=240 align=left>
          <h2>Select City for current weather:</h2>

        <?php
        $submittedValue = "";
        $value0 = "";
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
        if ($city == $value1) { $zipc = "45002"; }
        if ($city == $value2) { $zipc = "45044"; }
        if ($city == $value3) { $zipc = "45036"; }
        if ($city == $value4) { $zipc = "45242"; }
        if ($city == $value5) { $zipc = "45202"; }
        if ($city == $value6) { $zipc = "29906"; }
        if ($city == $value7) { $zipc = "89111"; }
        echo "<h3>Weather conditions for $submittedValue ($zipc)</h3>";
        echo "<h4>";
        // http://api.openweathermap.org/data/2.5/weather?zip=45005,us&appid=2de143494c0b295cca9337e1e96b00e0
        $api_key = "44db6a862fba0b067b1930da0d769e98";
        $BASE_URL = "http://api.openweathermap.org/data/2.5/";
        $yql_query = "weather?zip=$zipc,us&appid=$api_key";
        $yql_query_url = $BASE_URL . $yql_query;
        // echo "The base url is:<br> $yql_query_url";
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($session);
        curl_close($session);
        // echo "<br><br>The raw json out is:$json";
        // decode the json
        $tbj = json_decode($json, true);
        // Get tempature
        $kt = $tbj["main"]["temp"];
        // Get Condition
        $weather = $tbj["weather"];
        // print_r($weather);
        $condition = $weather["0"]["description"];
        // print_r($condition);
        // Get Humidity
        $humidity = $tbj["main"]["humidity"];
        // Get Wind Speed
        $wspeed = $tbj["wind"]["speed"];
        // Get Sunrise and set
        $sunr = $tbj["sys"]["sunrise"];
        $suns = $tbj["sys"]["sunset"];
        // convert sun times to est
        date_default_timezone_set('us/eastern');
        $sunrise = date('h:i A (T)', $sunr);
        $sunset = date('h:i A (T)', $suns);

        $kc = $kt - 273.15;
        $km = 1.8;
        $wf = 32;
        $tf = ($kc * $km) + $wf;
        $tf = round($tf, 1);
        // echo "<br><br>The out put for temp in Kelvin is:$kt K";
        echo "Tempature: $tf °F";
        echo "<br><br>Condition: $condition";
        echo "<br><br>Humidity: $humidity %";
        echo "<br><br>Wind speed: $wspeed mph";
        echo "<br><br>Sunset: $sunset";
        echo "<br><br>Sunrise: $sunrise";
        echo "</h4>";
        ?>
        <hr noshade size=2 width=240 align=left>
</HTML>
