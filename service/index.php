<?php
/*
	This script provides a RESTful API interface for a weather application
	Input:
    $_GET['format'] = [ json | html | xml ]
    $_GET['zipcode'] = []
    $_GET['method'] = weather
	Output:
    A formatted HTTP response
*/

// --- Step 1: Initialize variables and functions

/**
 * Deliver HTTP Response
 * @param string $format The desired HTTP response content type: [json, html, xml]
 * @param string $api_response The desired HTTP response data
 * @return void
 **/
function deliver_response($format, $api_response){

	// Define HTTP responses
	$http_response_code = array(
		200 => 'OK',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		403 => 'Forbidden',
		404 => 'Not Found'
	);

	// Set HTTP Response
	header('HTTP/1.1 '.$api_response['status'].' '.$http_response_code[ $api_response['status'] ]);

	// Process different content types
	if( strcasecmp($format,'json') == 0 ){

		// Set HTTP Response Content Type
		header('Content-Type: application/json; charset=utf-8');

		// Format data into a JSON response
		$json_response = json_encode($api_response);

		// Deliver formatted data
		echo $json_response;

	}elseif( strcasecmp($format,'xml') == 0 ){

		// Set HTTP Response Content Type
		header('Content-Type: application/xml; charset=utf-8');

		// Format data into an XML response (This is only good at handling string data, not arrays)
		$xml_response = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
			'<response>'."\n".
			"\t".'<code>'.$api_response['code'].'</code>'."\n".
			"\t".'<data>'.$api_response['data'].'</data>'."\n".
      "\t".'<city>'.$api_response['city'].'</city>'."\n".
      "\t".'<zipcode>'.$api_response['zipcode'].'</zipcode>'."\n".
      "\t".'<updated>'.$api_response['updated'].'</updated>'."\n".
      "\t".'<tempature>'.$api_response['tempature'].'</tempature>'."\n".
      "\t".'<condition>'.$api_responsee['condition'].'</condition>'."\n".
      "\t".'<humidity>'.$api_response['humidity'].'</humidity>'."\n".
      "\t".'<windspeed>'.$api_response['windspeed'].'</windspeed>'."\n".
      "\t".'<sunrise>'.$api_response['sunrise'].'</sunrise>'."\n".
      "\t".'<sunset>'.$api_response['sunset'].'</sunset>'."\n".
      '</response>';

		// Deliver formatted data
		echo $xml_response;


	}else{

		// Set HTTP Response Content Type (This is only good at handling string data, not arrays)
		header('Content-Type: text/html; charset=utf-8');

		// Deliver formatted data in html format
		echo "<h3>Data: {$api_response['data']} <br>";
    echo "City: {$api_response['city']} <br>";
    echo "Zipcode: {$api_response['zipcode']} <br>";
    echo "Updated: {$api_response['updated']} <br>";
    echo "Tempature: {$api_response['tempature']} <br>";
    echo "Condition: {$api_responsee['condition']} <br>";
    echo "Humidity: {$api_response['humidity']} <br>";
    echo "Windspeed: {$api_response['windspeed']} <br>";
    echo "Sunrise: {$api_response['sunrise']} <br>";
    echo "Sunset: {$api_response['sunset']}</h3>";
		if ($zip ==0) {
      echo "<br><br>";
			echo "Correct usage is:<br>";
			echo "/?method=weather&zipcode=xxxxx&format=json";
    }
	}

	// End script process
	exit;

}

// --- Step 3: Process Request
// get conditions based on zipcode
$zip = htmlspecialchars($_GET["zipcode"]);
// open database
// $user = getenv('DB_USER');
// $pwd = getenv('DB_PWD');
$conn = mysqli_connect("127.0.0.1", 'root', '', "weather");
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM conditions WHERE zipcode = $zip"));
mysqli_close($conn);
// format Output
if( strcasecmp($_GET['method'], "weather") == 0){
	$response['code'] = 1;
	$response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
  $response['data'] = 'weather';
	$response['city'] = $row['cityname'];
  $response['zipcode'] = $zip;
  $response['updated'] = $row['ptime'];
  $response['tempature'] = $row['tempk'];
  $response['condition'] = $row['descript'];
  $response['humidity'] = $row['humidity'];
  $response['windspeed'] = $row['windspd'];
  $response['sunrise'] = $row['sunrise'];
  $response['sunset'] = $row['sunset'];
}

// --- Step 4: Deliver Response
// Return Response to browser
deliver_response($_GET['format'], $response);
?>
