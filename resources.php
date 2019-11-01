<?php
$token = $_SESSION['token'];

?>
<div class="row">
    <div class="text-center heading info">
        <h1>Edit/create metafields for the following resources</h1>
        <p>You can use metafields to add custom fields to objects such as products, customers, and orders.
             Metafields are useful for storing specialized information, such as part numbers, customer titles,
             or blog post summaries. They can be used by apps and channels to track data for internal use.</p>
        <p>To create a new metafield, select a specific resource and follow the instructions</p>
    </div>
</div>

<div class="col-lg-12 text-center" style="justify-content: center;display: flex;">
    <div class="col-lg-* col-md-* col-sm-* col-xs-12">
        <div class="card" style="width: 15rem;">
            <div class="card-body">
                <h3 class="card-title">Custom Collections</span></h3>
                <p>Metafield resource for custom collections</p>
                <form action="display.php" method="GET">
                    <input type="hidden" name="shop" value="<?php echo $_GET['shop'] ?>">
                    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
                    <input type="hidden" name="resource" value="custom_collections">
                    <input type="submit" class="btn btn-primary" value="Collections">
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-* col-md-* col-sm-* col-xs-12">
        <div class="card" style="width: 15rem;">
            <div class="card-body">
                <h3 class="card-title">Smart Collections</span></h3>
                <p>Metafield resource for smart collections</p>
                <form action="display.php" method="GET">
                    <input type="hidden" name="shop" value="<?php echo $_GET['shop'] ?>">
                    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
                    <input type="hidden" name="resource" value="smart_collections">
                    <input type="submit" class="btn btn-primary" value="Collections">
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-* col-md-* col-sm-* col-xs-12">
        <div class="card" style="width: 15rem;">
            <div class="card-body">
                <h3 class="card-title">Products</span></h3>
                <p>Metafield resource for products</p>
                <form action="display.php" method="GET">
                    <input type="hidden" name="shop" value="<?php echo $_GET['shop'] ?>">
                    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
                    <input type="hidden" name="resource" value="products">
                    <input type="submit" class="btn btn-primary" value="Products">
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-* col-md-* col-sm-* col-xs-12">
        <div class="card" style="width: 15rem;">
            <div class="card-body">
                <h3 class="card-title">Shop</span></h3>
                <p>Metafield resource for your shop</p>
                <form action="execute.php" method="GET">
                    <input type="hidden" name="shop" value="<?php echo $_GET['shop'] ?>">
                    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
                    <input type="hidden" name="resource" value="">
                    <input type="hidden" name="type" value="shop">
                    <input type="submit" class="btn btn-primary" value="Shop">
                </form>
            </div>
        </div>
    </div>
</div>
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

    .heading {
        margin: 10px 0 10px 0;
        text-align: center;
    }
    .info {
      background-color: #fdf7e3;
      border-top: 2px solid indianred;
      border-radius: 3px;
      padding: 20px;
    }
</style>
<style>

.body{
        background-color: #f4f6f8;
    }
</style>