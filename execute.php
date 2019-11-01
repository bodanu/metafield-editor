<?php
if(!isset($_SESSION)){session_start();}

// Get our helper functions
require_once("vendor/autoload.php");
require_once("inc/functions.php");
require_once("inc/exec.php");
require_once("helpers.php");

$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
if(isset($_GET['resource'])){
  $resource = $_GET['resource'];
}else{
  $resource = $_GET['id'];
}
$shop = $_GET['shop'];
$token = $_SESSION['token'];
$type = $_GET['type'];
$variant = $_GET['resource_variant'];
$message = 'Success! <a href = "javascript:history.back()">view results</a>';

if($type === 'product'){ 
$requestInfo = shopify_call($token, $shop, "/admin/products/{$resource}/metafields.json", $query, $method = 'GET');
  $cacao = json_decode($requestInfo['response'], TRUE);
}elseif($type === 'collection'){
  $requestInfo = shopify_call($token, $shop, "/admin/collections/{$resource}/metafields.json", $query, $method = 'GET');
  $cacao = json_decode($requestInfo['response'], TRUE);
}elseif($type === 'shop'){
  $token = $_SESSION['token'];
  $requestInfo = shopify_call($token, $shop, "/admin/metafields.json", $query, $method = 'GET');
  $cacao = json_decode($requestInfo['response'], TRUE);
}elseif($type === 'product_variant'){
  $setMeta = shopify_call($token, $shop, '/admin/api/2019-10/products/'.$resource.'/variants/'.$variant.'/metafields.json', $query = json_encode($data), $method = 'GET');
  $cacao = json_decode($setMeta['response'], TRUE);
}
function showMeta(){
  if($type === 'product'){ 
    $requestInfo = shopify_call($token, $shop, "/admin/products/{$resource}/metafields.json", $query, $method = 'GET');
      $cacao = json_decode($requestInfo['response'], TRUE);
    }elseif($type === 'collection'){
      $requestInfo = shopify_call($token, $shop, "/admin/collections/{$resource}/metafields.json", $query, $method = 'GET');
      $cacao = json_decode($requestInfo['response'], TRUE);
    }elseif($type === 'shop'){
      $token = $_SESSION['token'];
      $requestInfo = shopify_call($token, $shop, "/admin/metafields.json", $query, $method = 'GET');
      $cacao = json_decode($requestInfo['response'], TRUE);
  //     echo '<pre>';
  // print_r($requestInfo);
  // echo '</pre>';
    }elseif($type === 'product_variant'){
      $setMeta = shopify_call($token, $shop, '/admin/api/2019-10/products/'.$resource.'/variants/'.$variant.'/metafields.json', $query = json_encode($data), $method = 'GET');
      $cacao = json_decode($setMeta['response'], TRUE);
    }
}
  // echo '<pre>';
  // print_r($requestInfo);
  // print_r($token);
  // echo '</pre>';


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<title>Execute</title>
</head>

<body style="background-color: #f4f6f8;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="h1 text-center">Metafields for resource id: <?php 
      if($type === "shop"){
        echo "shop";
      }elseif($type === "product"){
        echo $resource;
      }elseif($type === 'product_variant'){
        echo $variant;
      }elseif($type === 'collection'){
        echo $resource;
      }
        ?>
        </div>
      <div class="subtitle">
        <p>Metafields have three parts:</p>
        <ul>
          <li><strong>Namespace</strong> - A category or container that differentiates your metadata from other metafields.</li>
          <li><strong>Key</strong> - The name of the metafield.</li>
          <li><strong>Value</strong> - The content of the metafield. In most cases, the value is what will be displayed on the storefront or used by the app.</li>
        </ul>
        <p>To create a new metafield simply enter these 3 required parts in the form below and hit submit</p>
        <p>To edit/delete a metafield simply select it from the list, delete it and if necessary create it again</p>
      </div>
      <hr>
      </div>
      
      <div class="col-md-6">
        <form action="" method="get">
          <div class="form-group">
            <label for="name">Namespace</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter namespace">
            <small id="emailHelp" class="form-text text-muted">Maximum length is 12 characters</small>
          </div>
          <div class="form-group">
            <label for="key">Key</label>
            <input type="text" class="form-control" id="key" name="key" placeholder="Key">
          </div>
          <div class="form-group">
            <label for="value">value</label>
            <input type="text" class="form-control" id="value" name="value" placeholder="Value">
          </div>
          <input type="hidden" name="shop" value=<?php echo $shop?>>
          <input type="hidden" name="token" value=<?php echo $token?>>
          <input type="hidden" name="resource" value=<?php echo $resource?>>
          <input type="hidden" name="type" value=<?php echo $type?>>
          <input type="hidden" name="resource_variant" value=<?php echo $variant?>>
          <button type="submit" class="btn btn-primary btn-submit">Save</button>
        </form>
      </div>
      <div class="col-md-6">
        <div class="row">
          <h4>List of metafields</h4>
        </div>
        <div class="row">
          <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
              <?php foreach($cacao['metafields'] as $item){
            echo '<a class="list-group-item list-group-item-action" id="list-'.$item['id'].'-list" data-toggle="list" href="#list-'.$item['id'].'" role="tab" aria-controls="settings">'.$item["key"].'</a>';
          }?>
            </div>
          </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <?php foreach($cacao['metafields'] as $item){
                // echo '<pre>';
                // print_r($item);
                // echo "</pre>";
            echo '<div class="tab-pane fade" id="list-'.$item['id'].'" role="tabpanel" aria-labelledby="list-'.$item['id'].'-list">'.$item["value"];
            echo '<form action="" method="get">';
            echo '<input type="hidden" name="shop" value='.$shop.'>';
            echo '<input type="hidden" name="token" value='.$token.'>';
            echo '<input type="hidden" name="type" value='.$type.'>';
            echo '<input type="hidden" name="resource" value='.$item["id"].'>';
            echo '<input type="hidden" name="action" value=delete>';
            echo '<button type="submit" class="btn btn-danger">Delete Metafield</button>';
            echo '</form>';
            echo '</div>';
          }?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
 <form action="index.php" method="get">
 <input type="hidden" name="shop" value=<?php echo $shop?>>
 <button type="submit" class="btn btn-primary">Back Home</button>
 </form>
 <hr>
  </div>

  <?php  

if(isset($_GET['action'])){
  $deleteMeta = shopify_call($token, $shop, "/admin/api/2019-10/metafields/{$resource}.json", $query, $method = 'DELETE');
  if (isset($referer)) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}else{
  echo $message;
  }
}
if(isset($_GET['name'])){
  showMeta();
  if (isset($referer)) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}else{
  echo $message;
  }
  $data = array(
      "metafield" => array(
          "namespace" => $_GET['name'],
          "key" => $_GET['key'],
          "value" => $_GET['value'],
          "value_type" => "string"
      )
      );
     if($type === 'product'){ 
  $setMeta = shopify_call($token, $shop, '/admin/api/2019-10/products/'.$resource.'/metafields.json', $query = json_encode($data), $method = 'POST');
  $shit = json_decode($setMeta['response'], TRUE);
     }elseif($type === 'collection'){
      $setMeta = shopify_call($token, $shop, '/admin/api/2019-10/collections/'.$resource.'/metafields.json', $query = json_encode($data), $method = 'POST');
      $shit = json_decode($setMeta['response'], TRUE);
     }elseif($type === 'shop'){
      $token = $_SESSION['token'];
      $setMeta = shopify_call($token, $shop, '/admin/api/2019-10/metafields.json', $query = json_encode($data), $method = 'POST');
      $shit = json_decode($setMeta['response'], TRUE);
  //     echo '<pre>';
  // print_r($setMeta);
  // echo '</pre>';
     }elseif($type === 'product_variant'){
      $setMeta = shopify_call($token, $shop, '/admin/api/2019-10/products/'.$resource.'/variants/'.$variant.'/metafields.json', $query = json_encode($data), $method = 'POST');
      $shit = json_decode($setMeta['response'], TRUE);
    }
  }
    
    // print_r($shit);
    // print_r($setMeta);
?>

  <style>
    .card-img-top {
      height: 100px;
      width: 100px;
      align-self: center;
    }

    .card {
      text-align: center;
      margin: 5px;
      box-shadow: 0px 8px 18px -4px rgba(0, 0, 0, 0.15);
    }

    form {
      width: 70%;
      margin: 10px;
    }

    .btn-submit {
      width: 50%;
      margin: 10px;
    }
    .list-group{
      margin-top: 10px;
    }
    .subtitle {
      background-color: #fdf7e3;
      border-top: 2px solid indianred;
      border-radius: 3px;
      padding: 20px;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>

</body>

</html>