<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"></head>
  <title>Document</title>
</head>
<body>


<?php 
if($resource === 'products')
?>
<div class="col-lg-* col-md-* col-sm-* col-xs-12">
<div class="card" style="width: 15rem;">
      <?php echo '<img src='.$value["image"]["src"]. ' class="card-img-top" alt="" role="presentation">';?>
    <div class="card-body">
      <h3 class="card-title"><?php echo $value['title'] ?></span></h3>
      <p><?php echo   count($value['variants']) ." variants" ?></p>
      <form action="execute.php" method="GET">
    <input type="hidden" name="resource" value="<?php echo $value['id'] ?>">
    <input type="hidden" name="shop" value="<?php echo $_GET['shop'] ?>">
    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
    <input type="submit" class="btn btn-primary" value="Article">
</form>
    </div>  
  </div>
</div>
<?php 
if($resource === 'custom_collection')
?>
<div class="col-lg-* col-md-* col-sm-* col-xs-12">
<div class="card" style="width: 15rem;">
      <?php echo '<img src='.$value["image"]["src"]. ' class="card-img-top" alt="" role="presentation">';?>
    <div class="card-body">
      <h3 class="card-title"><?php echo $value['title'] ?></span></h3>
      <p><?php echo   count($value['variants']) ." variants" ?></p>
      <form action="execute.php" method="GET">
    <input type="hidden" name="resource" value="<?php echo $value['id'] ?>">
    <input type="hidden" name="shop" value="<?php echo $_GET['shop'] ?>">
    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
    <input type="submit" class="btn btn-primary" value="Article">
</form>
    </div>  
  </div>
</div>

<style> 
    .card-img-top{
      height: 100px;
      width: 100px;
      align-self: center;
    }
    .card{
      text-align: center;
      margin: 5px;
      box-shadow: 0px 8px 18px -4px rgba(0,0,0,0.15);
    }
  </style>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>       

</body>
</html>