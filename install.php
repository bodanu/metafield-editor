<?php
if(!isset($_SESSION)){session_start();}

// Get our helper functions
require_once("vendor/autoload.php");

// Load .env file
$dotenv = new Dotenv\Dotenv(__DIR__ );
$dotenv->load();

// Set variables for our request
$shop = $_GET['shop'];
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