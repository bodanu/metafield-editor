<?php
if (!isset($_SESSION)){
  session_start();
}


$shopName = $_GET['shop'];
$_SESSION['shop'] = $shopName;
$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");
$db_connection = pg_connect("host=ec2-79-125-2-142.eu-west-1.compute.amazonaws.com dbname={$db["path"]} user=sejdrendkcnwkk password=e559f2c4d1dca89ffefc51533257fa1978212c445e8410737ebb4759d16ca1f3");
$info = "SELECT shop_name, shop_token FROM metafieldapp WHERE shop_name = '$shopName'";
$exec = pg_query($db_connection, $info);
$row = pg_fetch_array($exec);
// print_r($row);
$shop = $row[0];
$token = $row[1];
// print_r($shop ." ".$secret);