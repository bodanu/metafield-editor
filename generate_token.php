<?php
if(!isset($_SESSION)){session_start();}

// Get our helper functions
require_once("vendor/autoload.php");
require_once("inc/functions.php");

// Load .env file
$dotenv = new Dotenv\Dotenv(__DIR__ );
$dotenv->load();

// Set variables for our request
$api_key = $_ENV['API_KEY'];
$shared_secret = $_ENV['SECRET'];
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter
$shop = $params['shop']; // Get current shop

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token

	

	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];
	$token = $access_token;

	// Save token to db
	$db = parse_url(getenv("DATABASE_URL"));
	$db["path"] = ltrim($db["path"], "/");
	$db_connection = pg_connect("host=ec2-79-125-2-142.eu-west-1.compute.amazonaws.com dbname={$db["path"]} user=sejdrendkcnwkk password=e559f2c4d1dca89ffefc51533257fa1978212c445e8410737ebb4759d16ca1f3");
	
	if (!$db_connection) {
		echo "An error occurred.\n";
		exit;
	}

	$verify = "SELECT shop_name, shop_token FROM metafieldapp WHERE shop_name = '$shop'";
	$exec = pg_query($db_connection, $verify);
	$row = pg_fetch_array($exec);
	// To test or to install on dev shop, simply put test:true below
	$charge = '{
		"application_charge":{
			"name": "App charge",
   			"price": 4.99,
			"return_url": "https:\/\/'.$shop.'/admin/apps/metafield-demo-1",
			"test":"true"
	}
}';
	if ($row[0] === $shop && $row[1] === $access_token && !empty($access_token)) {	
		// Redirect /admin/api/2019-10/application_charges.json
		$getcharghes = shopify_call($token, $shop, "/admin/api/2019-10/application_charges.json", $query, $method = 'GET');
		$charges = json_decode($getcharghes['response'], TRUE);
		if(!empty($charghes)){
			$getspecific = shopify_call($token, $shop, '/admin/api/2019-10/application_charges/'.$charges["id"].'.json', $query, $method = 'GET');
			$specificcharge = json_decode($getspecific['response'], TRUE);
		}else{
			$createCharge = shopify_call($token, $shop, "/admin/api/2019-10/application_charges.json", $query = $charge, $method = 'POST');
			$chargeinfo = json_decode($createCharge['response'], TRUE);
			header('Location:'.$chargeinfo['application_charge']['confirmation_url']);
		}
		// header("Location: https://" . $shop . "/admin/apps/metafield-editor-3");
		die();
	
	} else {
		if($row[0] === $shop && $row[1] !== $access_token && !empty($access_token)){
			$query = "UPDATE metafieldapp SET shop_token = '$access_token' WHERE shop_name = '$shop'";
			$result = pg_query($db_connection, $query);	
		}else{
			$query = "INSERT INTO metafieldapp (shop_name, shop_token) VALUES ('$shop', '$access_token')";
			$result = pg_query($db_connection, $query);	
		}
	}

	// Redirect
	$getcharghes = shopify_call($token, $shop, "/admin/api/2019-10/application_charges.json", $query, $method = 'GET');
		$charges = json_decode($getcharghes['response'], TRUE);
		if(!empty($charghes)){
			$getspecific = shopify_call($token, $shop, '/admin/api/2019-10/application_charges/'.$charges["id"].'.json', $query, $method = 'GET');
			$specificcharge = json_decode($getspecific['response'], TRUE);
		}else{
			$createCharge = shopify_call($token, $shop, "/admin/api/2019-10/application_charges.json", $query = $charge, $method = 'POST');
			$chargeinfo = json_decode($createCharge['response'], TRUE);
			header('Location:'.$chargeinfo['application_charge']['confirmation_url']);
		}

	// header("Location: https://" . $shop . "/admin/apps/metafield-editor-3");
	die();

} else {
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}