<body>
  <font size="3" face='calibri' color="blue">
  <hr noshade size=2 width=240 align=left>
  <h2>Select city for weather:</h2>

  <?php
  $BASE_URL = "http://api.poweredwire.com/";
  $list_query = "?method=weather&format=list";
  $list_query_url = $BASE_URL . $list_query;
  
  $jsonData = file_get_contents($list_query_url);
  $jsonArray = json_decode($jsonData);

  ?>

  <form action="" name="city" method="post">
  <select name="CityZip">

  <?php
  foreach($jsonArray as $jsonValue) {
  echo '<option value =' . $jsonValue->zipcode . '>' . $jsonValue->cityname . '</option>'; }
  ?>

  </select>
  <input type="submit" name="submit" value="Select" />
  </form>
  <br><hr noshade size=2 width=240 align=left>

  <?php
  $submittedValue = isset($_POST["CityZip"]) ? $_POST["CityZip"] : "";
  echo "<h3>Conditions for zipcode: $submittedValue</h3>";
  echo "<h4>";
  ?>
</body>
