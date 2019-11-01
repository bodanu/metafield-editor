<?php
if(!isset($_SESSION)){session_start();}

// Get our helper functions
require_once("vendor/autoload.php");
require_once("inc/functions.php");
require_once("helpers.php");
header("Access-Control-Allow-Origin: {$shop}");
header('Access-Control-Allow-Credentials: true');

// Load .env file
$dotenv = new Dotenv\Dotenv(__DIR__ );
$dotenv->load();

// Set variables for our request
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

// ?charge_id=1103888470

if ($_GET['shop'] === $shop && !empty($token)) {
  if(isset($_GET['charge_id'])){
    $chargeId = $_GET['charge_id'];
    $getspecific = shopify_call($token, $shop, '/admin/api/2019-10/application_charges/'.$chargeId.'.json', $query, $method = 'GET');
    $specificcharge = json_decode($getspecific['response'], TRUE);
    if($specificcharge['application_charge']['status'] === 'accepted'){
      
      $_SESSION['token'] = $token;
      include('result.html');
      echo '<div class="container">';
      echo '<div class="row text-center">';
      include("resources.php");
      echo "</div>";
      echo '<div class="row">';
    //   $getcharghes = shopify_call($token, $shop, "/admin/api/2019-10/application_charges.json", $query, $method = 'GET');
		// $charges = json_decode($getcharghes['response'], TRUE);
    // echo '<pre>';
    // print_r($charges);
    // echo '</pre>';
      echo "</div>";
      echo "</div>";
      }else{
       $body = '{"application_charge":{"id":'.$chargeId.',"status":"accepted"}}';
       
        $activate = shopify_call($token, $shop, '/admin/api/2019-10/application_charges/'.$chargeId.'.json', $query = $body, $method = 'POST');
    
        $activationresult = json_decode($getspecific['response'], TRUE);
        if($activationresult['application_charge']['status'] === 'accepted'){
          $_SESSION['token'] = $token;
            include('result.html');
            echo '<div class="container">';
            echo '<div class="row text-center">';
            include("resources.php");
            echo "</div>";
            echo '<div class="row">';
          echo '</pre>';
            echo "</div>";
            echo "</div>";
        }else{
          echo 'Unfortunately some error occured, if you are unable to use the app, please contact us at bogdan.hiriscau@gmail.com';
        }
      }
  }else{
    $_SESSION['token'] = $token;
    include('result.html');
    echo '<div class="container">';
    echo '<div class="row text-center">';
    include("resources.php");
    echo "</div>";
    echo '<div class="row">';
  echo '</pre>';
    echo "</div>";
    echo "</div>";
  }
}else{
  if(!isset($shop)){
    $shop = $_GET['shop'];
  }
  $api_key = $_ENV['API_KEY'];
  $scopes = "read_products,write_products,read_content, write_content";
  $redirect_uri = $_ENV['HOST'] . "/generate_token.php";

// Build install/approval URL to redirect to

if (strpos($shop, 'myshopify') !== false) {
  $install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
}else{
  $install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
}
// Redirect
header("Location: " . $install_url);
die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"></head>
  <title>Metafield-editor</title>
</head>
<body style="background-color: #f4f6f8;">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>       


