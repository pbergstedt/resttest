<?php

$zip = '45402';

//  || $zip != "45042" || $zip != "45036" || $zip != "45241" || $zip != "45202" || $zip != "29901" || $zip != "89101")
if (empty($zip))
{
  echo "<br><br>";
  echo "Correct usage is:<br>";
  echo "/?method=weather&zipcode=xxxxx&format=json [xml] [html]<br>";
  echo "Valid zipcodes are: 45402, 45042, 45036, 45241, 45202, 29901, 89101";
}

?>
