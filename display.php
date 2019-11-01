<?php
if(!isset($_SESSION)){session_start();}

// Get our helper functions
require_once("vendor/autoload.php");
require_once("inc/functions.php");
require_once("helpers.php");

// Load .env file
$dotenv = new Dotenv\Dotenv(__DIR__ );
$dotenv->load();

// Set variables for our request
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically


$resource = $_GET['resource'];
$shop = $_SESSION['shop'];
$token = $_SESSION['token'];
// print_r($token);

  $requestInfo = shopify_call($token, $shop, "/admin/{$resource}.json", $query = array(), $method = 'GET');
  $cacao = json_decode($requestInfo['response'], TRUE);
  echo '<body style="background-color: #f4f6f8;">';
    echo '<div class="container">';
      echo '<div class="row text-center">';
          if($cacao['products']){
            include('cards/product-head.html');
            echo '<div class="col-lg-8 col-xs-12">';
            echo '<div id="accordion">';
          foreach($cacao['products'] as $value){
            
            include("cards/product-list.php");
            
        }
        echo '</div>';
        echo '</div>';
        echo '<div class="col-lg-4 col-xs-12">';
        include("inc/product-infobar.html");
        echo '</div>';
      }elseif($cacao['custom_collections']){
        include('cards/collection-head.html');
        echo '<div class="col-lg-8 col-xs-12">';
        echo '<div id="accordion">';
        foreach($cacao['custom_collections'] as $value){
          include("cards/collections-list.php");
      }
      echo '</div>';
    echo '</div>';
    echo '<div class="col-lg-4 col-xs-12">';
    include("inc/collection-infobar.html");
    echo '</div>';
    }elseif($cacao['smart_collections']){
      include('cards/collection-head.html');
        echo '<div class="col-lg-8 col-xs-12">';
        echo '<div id="accordion">';
        foreach($cacao['smart_collections'] as $value){
          include("cards/collections-list.php");
      }
      echo '</div>';
    echo '</div>';
    echo '<div class="col-lg-4 col-xs-12">';
    include("inc/collection-infobar.html");
    echo '</div>';
    }
    echo "</div>";
  echo "</div>";
// echo '<pre>';
// print_r($cacao);
// print_r($requestInfo);
// echo '</pre>';