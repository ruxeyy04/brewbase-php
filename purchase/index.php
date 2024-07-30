<?php 
session_start();
include '../server.php';
if(!isset($_SESSION['username'])) {
    echo "<script type='text/javascript'>window.location.replace('/login'); </script>"; 
}
$userID = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brew Base - My Purchase</title>
    <link rel="icon" type="image/x-icon" href="/img/brewbase.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/navigation.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/responsive.css">
</head>
<body>

    <?php require_once '../navigation.php';?>
    <div class="header-sub">
        <div class="content-text">
            <div class="text">
                <h1>My Purchase</h1>
                <p>Home / My Purchase</p>
            </div>
        </div>
        </div>

<?php 
$sql = "SELECT * FROM orders WHERE customer_id = $userID ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);


?>

    <div class="container well well-sm bg-info" style="margin-top: 15px; margin-bottom: 15px;">
        <div class="col-sm-12">
            <h4>My Purchase/Order</h4>
        </div>
        <hr>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#all">All</a></li>
            <li><a data-toggle="tab" href="#pending">Pending</a></li>
            <li><a data-toggle="tab" href="#ontheway">On The Way</a></li>
            <li><a data-toggle="tab" href="#received">To Recieve</a></li>
            <li><a data-toggle="tab" href="#completed">Completed</a></li>
            <li><a data-toggle="tab" href="#cancelled">Cancelled</a></li>
          </ul>
        
          <div class="tab-content">
            <div id="all" class="tab-pane fade in active">
  <?php if(mysqli_num_rows($result)) {
      while($allorder = mysqli_fetch_assoc($result)) {
        $date = date_create($allorder['order_date']); 
        $orderid = $allorder['order_id'];
        $sql1 = "SELECT a.*, b.*, c.addons_name, c.addons_price, ((a.quantity * a.price_each) + c.addons_price) AS total
        FROM orderdetail a
        INNER JOIN product b
        ON a.prod_no=b.prod_no
        INNER JOIN addons c
        ON a.addonsID=c.addonsID
        WHERE a.order_id=$orderid";

        $result1 = mysqli_query($conn,$sql1);

        $sql2 = "SELECT * FROM payment WHERE customer_id=$userID AND order_id=$orderid";

        $paymentotal = mysqli_fetch_assoc(mysqli_query($conn, $sql2));
        ?>
            
              <div class="col-sm-12 well well-sm <?php if ($allorder['status'] == "Cancelled") { echo "bg-danger";} elseif($allorder['status'] == "Completed") { echo "bg-success";} else { echo "bg-warning";}?>"> 
                <input type="hidden" name="orderID" value="<?=$allorder['order_id']?>">
				<p>Order ID: <?=$allorder['order_id']?></p>
                <p>Order Status: <?=$allorder['status']?> <strong>|</strong>  Order Date/Time: <?=date_format($date,"F d, Y h:i A")?></p>
                  <div class="container-fluid table-responsive">
                      <table class=" table table-hover table-condensed ">
                          <thead>
                              <tr>
                                  <th class="text-center">Product</th>
                                  <th class="text-center">Quantity</th>
                                  <th class="text-center">Add-ons</th>
                                  <th class="col-sm-2 text-center">Add-ons Price</th>
                                  <th class="col-sm-2 text-center">Product Price</th>
                                  <th class="col-sm-2 text-center">Total</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php while($item = mysqli_fetch_assoc($result1)) {?>
                              <tr>
                                  <td class="col-sm-5">         
                                  <div class="media">
                                      <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$item['prod_name']?>"><img class="img-res" src="/productimg/<?=$item['prod_img']?>" style="width: 72px; height: 72px;"></a>
                                      <div class="media-body">
                                          <h4 class="media-heading"><a href="/product/prod-item?name="><?=$item['prod_name']?></a></h4>
                                          <h5 class="media-heading">Category: <?=$item['category']?></h5>
                                          <span>Status: </span><span class="text-<?=$item['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$item['status']?></strong></span>
                                      </div>
                                  </div>
                                  </td>
                                  <td class="col-sm-1" style="text-align: center"><?=$item['quantity']?></td>
                                  <td class="col-sm-2"><?=$item['addons_name']?></td>
                                  <td class="col-sm-2 text-center"><strong>₱<?=$item['addons_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['prod_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['total']?></strong></td>
                              </tr>
                              <?php }?>
                          </tbody>
                      </table>

                  </div>
                  <?php if($allorder['status'] == "Completed") {?>
                    <button type="button" class="vkf4df btn-success" onclick="window.location.replace('/product/')">Buy Again</button>   
                  <?php } elseif($allorder['status'] == "Pending") {?>
                    <button type="button" class="vkf4df btn-primary tracking">Track Order</button>  
                    <button type="button" class="vkf4df btn-danger ordercancel" data-toggle="modal" data-target="#cancelorder">Cancel</button>            
                  <?php } elseif($allorder['status'] == "Cancelled") { ?>
                    <button type="button" class="vkf4df btn-success" onclick="window.location.replace('/product/')">Buy Again</button>  
                 <?php } elseif($allorder['status'] == "To Receive") { ?>
                    <button type="button" class="vkf4df btn-primary tracking">Track Order</button>  
                    <button type="button" class="vkf4df btn-success orderreceive" data-toggle="modal" data-target="#receivedorder">Order Received</button>   
                <?php }  else {?>
                    <button type="button" class="vkf4df btn-primary tracking">Track Order</button>  
                    <?php }?>  
                  <h4 class="pull-right">Order Total: ₱<?=$paymentotal['amount']?></h4>   
              </div>  
              <?php         
      }
    } else {
        echo "<h3 class='text-center'>No Info</h3>";
    }?>
            </div>
            <div id="pending" class="tab-pane fade">
<?php 
$sql = "SELECT * FROM orders WHERE customer_id = $userID AND status = 'Pending' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);

?>
            <?php if(mysqli_num_rows($result)) {
            while($allorder = mysqli_fetch_assoc($result)) {
                $date = date_create($allorder['order_date']); 
                $orderid = $allorder['order_id'];
                $sql1 = "SELECT a.*, b.*, c.addons_name, c.addons_price, ((a.quantity * a.price_each) + c.addons_price) AS total
                FROM orderdetail a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.order_id=$orderid";
        
                $result1 = mysqli_query($conn,$sql1);
        
                $sql2 = "SELECT * FROM payment WHERE customer_id=$userID AND order_id=$orderid";
        
                $paymentotal = mysqli_fetch_assoc(mysqli_query($conn, $sql2));?>
              <div class="col-sm-12 well well-sm bg-warning"> 
              <input type="hidden" name="orderID" value="<?=$allorder['order_id']?>">
                <p>Order ID: <?=$allorder['order_id']?></p>
                <p>Order Status: <?=$allorder['status']?> <strong>|</strong>  Order Date/Time: <?=date_format($date,"F d, Y h:i A")?></p>
                  <div class="container-fluid table-responsive">
                      <table class=" table table-hover table-condensed ">
                          <thead>
                              <tr>
                                  <th class="text-center">Product</th>
                                  <th class="text-center">Quantity</th>
                                  <th class="text-center">Add-ons</th>
                                  <th class="col-sm-2 text-center">Add-ons Price</th>
                                  <th class="col-sm-2 text-center">Product Price</th>
                                  <th class="col-sm-2 text-center">Total</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php while($item = mysqli_fetch_assoc($result1)) {?>
                              <tr>
                                  <td class="col-sm-5">         
                                  <div class="media">
                                      <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$item['prod_name']?>"><img class="img-res" src="/productimg/<?=$item['prod_img']?>" style="width: 72px; height: 72px;"></a>
                                      <div class="media-body">
                                          <h4 class="media-heading"><a href="/product/prod-item?name="><?=$item['prod_name']?></a></h4>
                                          <h5 class="media-heading">Category: <?=$item['category']?></h5>
                                          <span>Status: </span><span class="text-<?=$item['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$item['status']?></strong></span>
                                      </div>
                                  </div>
                                  </td>
                                  <td class="col-sm-1" style="text-align: center"><?=$item['quantity']?></td>
                                  <td class="col-sm-2"><?=$item['addons_name']?></td>
                                  <td class="col-sm-2 text-center"><strong>₱<?=$item['addons_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['prod_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['total']?></strong></td>
                              </tr>
                              <?php }?>
                          </tbody>
                      </table>

                  </div>
                  <?php if($allorder['status'] == "Pending") {?>
                    <button type="button" class="vkf4df btn-primary tracking">Track Order</button>   
                    <button type="button" class="vkf4df btn-danger ordercancel" data-toggle="modal" data-target="#cancelorder">Cancel</button>  
                  <?php } else {?>
                    <button type="button" class="vkf4df btn-primary tracking">Track Order</button>           
                  <?php }?>  
                  <h4 class="pull-right">Order Total: ₱<?=$paymentotal['amount']?></h4>   
              </div>  
              <?php }
            } else {?>
              <h3 class="text-center">No Info</h3>
              <?php }?>
            </div>
            <div id="ontheway" class="tab-pane fade">
            <?php 
$sql = "SELECT * FROM orders WHERE customer_id = $userID AND status = 'On The Way' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);

?>
            <?php if(mysqli_num_rows($result)) {
            while($allorder = mysqli_fetch_assoc($result)) {
                $date = date_create($allorder['order_date']); 
                $orderid = $allorder['order_id'];
                $sql1 = "SELECT a.*, b.*, c.addons_name, c.addons_price, ((a.quantity * a.price_each) + c.addons_price) AS total
                FROM orderdetail a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.order_id=$orderid";
        
                $result1 = mysqli_query($conn,$sql1);
        
                $sql2 = "SELECT * FROM payment WHERE customer_id=$userID AND order_id=$orderid";
        
                $paymentotal = mysqli_fetch_assoc(mysqli_query($conn, $sql2));?>
              <div class="col-sm-12 well well-sm bg-warning"> 
              <input type="hidden" name="orderID" value="<?=$allorder['order_id']?>">
                <p>Order ID: <?=$allorder['order_id']?></p>
                <p>Order Status: <?=$allorder['status']?> <strong>|</strong>  Order Date/Time: <?=date_format($date,"F d, Y h:i A")?></p>
                  <div class="container-fluid table-responsive">
                      <table class=" table table-hover table-condensed ">
                          <thead>
                              <tr>
                                  <th class="text-center">Product</th>
                                  <th class="text-center">Quantity</th>
                                  <th class="text-center">Add-ons</th>
                                  <th class="col-sm-2 text-center">Add-ons Price</th>
                                  <th class="col-sm-2 text-center">Product Price</th>
                                  <th class="col-sm-2 text-center">Total</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php while($item = mysqli_fetch_assoc($result1)) {?>
                              <tr>
                                  <td class="col-sm-5">         
                                  <div class="media">
                                      <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$item['prod_name']?>"><img class="img-res" src="/productimg/<?=$item['prod_img']?>" style="width: 72px; height: 72px;"></a>
                                      <div class="media-body">
                                          <h4 class="media-heading"><a href="/product/prod-item?name="><?=$item['prod_name']?></a></h4>
                                          <h5 class="media-heading">Category: <?=$item['category']?></h5>
                                          <span>Status: </span><span class="text-<?=$item['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$item['status']?></strong></span>
                                      </div>
                                  </div>
                                  </td>
                                  <td class="col-sm-1" style="text-align: center"><?=$item['quantity']?></td>
                                  <td class="col-sm-2"><?=$item['addons_name']?></td>
                                  <td class="col-sm-2 text-center"><strong>₱<?=$item['addons_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['prod_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['total']?></strong></td>
                              </tr>
                              <?php }?>
                          </tbody>
                      </table>

                  </div>
                  <?php if($allorder['status'] == "Completed") {?>
                    <button type="button" class="vkf4df btn-success" onclick="window.location.replace('/product/')">Buy Again</button>   
                  <?php } else {?>
                    <button type="button" class="vkf4df btn-primary tracking">Track Order</button>           
                  <?php }?>  
                  <h4 class="pull-right">Order Total: ₱<?=$paymentotal['amount']?></h4>   
              </div>  
              <?php }
            } else {?>
              <h3 class="text-center">No Info</h3>
              <?php }?>
            </div>
            <div id="received" class="tab-pane fade">
            <?php 
$sql = "SELECT * FROM orders WHERE customer_id = $userID AND status = 'To Receive' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);

?>
            <?php if(mysqli_num_rows($result)) {
            while($allorder = mysqli_fetch_assoc($result)) {
                $date = date_create($allorder['order_date']); 
                $orderid = $allorder['order_id'];
                $sql1 = "SELECT a.*, b.*, c.addons_name, c.addons_price, ((a.quantity * a.price_each) + c.addons_price) AS total
                FROM orderdetail a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.order_id=$orderid";
        
                $result1 = mysqli_query($conn,$sql1);
        
                $sql2 = "SELECT * FROM payment WHERE customer_id=$userID AND order_id=$orderid";
        
                $paymentotal = mysqli_fetch_assoc(mysqli_query($conn, $sql2));?>
              <div class="col-sm-12 well well-sm bg-warning"> 
              <input type="hidden" name="orderID" value="<?=$allorder['order_id']?>">
                <p>Order ID: <?=$allorder['order_id']?></p>
                <p>Order Status: <?=$allorder['status']?> <strong>|</strong>  Order Date/Time: <?=date_format($date,"F d, Y h:i A")?></p>
                  <div class="container-fluid table-responsive">
                      <table class=" table table-hover table-condensed ">
                          <thead>
                              <tr>
                                  <th class="text-center">Product</th>
                                  <th class="text-center">Quantity</th>
                                  <th class="text-center">Add-ons</th>
                                  <th class="col-sm-2 text-center">Add-ons Price</th>
                                  <th class="col-sm-2 text-center">Product Price</th>
                                  <th class="col-sm-2 text-center">Total</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php while($item = mysqli_fetch_assoc($result1)) {?>
                              <tr>
                                  <td class="col-sm-5">         
                                  <div class="media">
                                      <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$item['prod_name']?>"><img class="img-res" src="/productimg/<?=$item['prod_img']?>" style="width: 72px; height: 72px;"></a>
                                      <div class="media-body">
                                          <h4 class="media-heading"><a href="/product/prod-item?name="><?=$item['prod_name']?></a></h4>
                                          <h5 class="media-heading">Category: <?=$item['category']?></h5>
                                          <span>Status: </span><span class="text-<?=$item['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$item['status']?></strong></span>
                                      </div>
                                  </div>
                                  </td>
                                  <td class="col-sm-1" style="text-align: center"><?=$item['quantity']?></td>
                                  <td class="col-sm-2"><?=$item['addons_name']?></td>
                                  <td class="col-sm-2 text-center"><strong>₱<?=$item['addons_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['prod_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['total']?></strong></td>
                              </tr>
                              <?php }?>
                          </tbody>
                      </table>

                  </div>
                  <?php if($allorder['status'] == "Completed") {?>
                    <button type="button" class="vkf4df btn-success" onclick="window.location.replace('/product/')">Buy Again</button>   
                  <?php } else {?>
                    <button type="button" class="vkf4df btn-primary tracking" >Track Order</button> 
                    <button type="button" class="vkf4df btn-success orderreceive" data-toggle="modal" data-target="#receivedorder">Order Recieved</button>          
                  <?php }?>  
                  <h4 class="pull-right">Order Total: ₱<?=$paymentotal['amount']?></h4>   
              </div>  
              <?php }
            } else {?>
              <h3 class="text-center">No Info</h3>
              <?php }?>
            </div>
            <div id="completed" class="tab-pane fade">
            <?php 
$sql = "SELECT * FROM orders WHERE customer_id = $userID AND status = 'Completed' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);

?>
            <?php if(mysqli_num_rows($result)) {
            while($allorder = mysqli_fetch_assoc($result)) {
                $date = date_create($allorder['order_date']); 
                $orderid = $allorder['order_id'];
                $sql1 = "SELECT a.*, b.*, c.addons_name, c.addons_price, ((a.quantity * a.price_each) + c.addons_price) AS total
                FROM orderdetail a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.order_id=$orderid";
        
                $result1 = mysqli_query($conn,$sql1);
        
                $sql2 = "SELECT * FROM payment WHERE customer_id=$userID AND order_id=$orderid";
        
                $paymentotal = mysqli_fetch_assoc(mysqli_query($conn, $sql2));?>
              <div class="col-sm-12 well well-sm bg-success"> 
              <input type="hidden" name="orderID" value="<?=$allorder['order_id']?>">
                <p>Order ID: <?=$allorder['order_id']?></p>
                <p>Order Status: <?=$allorder['status']?> <strong>|</strong>  Order Date/Time: <?=date_format($date,"F d, Y h:i A")?></p>
                  <div class="container-fluid table-responsive">
                      <table class=" table table-hover table-condensed ">
                          <thead>
                              <tr>
                                  <th class="text-center">Product</th>
                                  <th class="text-center">Quantity</th>
                                  <th class="text-center">Add-ons</th>
                                  <th class="col-sm-2 text-center">Add-ons Price</th>
                                  <th class="col-sm-2 text-center">Product Price</th>
                                  <th class="col-sm-2 text-center">Total</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php while($item = mysqli_fetch_assoc($result1)) {?>
                              <tr>
                                  <td class="col-sm-5">         
                                  <div class="media">
                                      <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$item['prod_name']?>"><img class="img-res" src="/productimg/<?=$item['prod_img']?>" style="width: 72px; height: 72px;"></a>
                                      <div class="media-body">
                                          <h4 class="media-heading"><a href="/product/prod-item?name="><?=$item['prod_name']?></a></h4>
                                          <h5 class="media-heading">Category: <?=$item['category']?></h5>
                                          <span>Status: </span><span class="text-<?=$item['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$item['status']?></strong></span>
                                      </div>
                                  </div>
                                  </td>
                                  <td class="col-sm-1" style="text-align: center"><?=$item['quantity']?></td>
                                  <td class="col-sm-2"><?=$item['addons_name']?></td>
                                  <td class="col-sm-2 text-center"><strong>₱<?=$item['addons_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['prod_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['total']?></strong></td>
                              </tr>
                              <?php }?>
                          </tbody>
                      </table>

                  </div>
                  <?php if($allorder['status'] == "Completed") {?>
                    <button type="button" class="vkf4df btn-success" onclick="window.location.replace('/product/')">Buy Again</button>   
                  <?php } else {?>
                    <button type="button" class="vkf4df btn-primary tracking">Track Order</button>           
                  <?php }?>  
                  <h4 class="pull-right">Order Total: ₱<?=$paymentotal['amount']?></h4>   
              </div>  
              <?php }
            } else {?>
              <h3 class="text-center">No Info</h3>
              <?php }?>
            </div>
            <div id="cancelled" class="tab-pane fade">
            <?php 
$sql = "SELECT * FROM orders WHERE customer_id = $userID AND status = 'Cancelled' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);

?>
            <?php if(mysqli_num_rows($result)) {
            while($allorder = mysqli_fetch_assoc($result)) {
                $date = date_create($allorder['order_date']); 
                $orderid = $allorder['order_id'];
                $sql1 = "SELECT a.*, b.*, c.addons_name, c.addons_price, ((a.quantity * a.price_each) + c.addons_price) AS total
                FROM orderdetail a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.order_id=$orderid";
        
                $result1 = mysqli_query($conn,$sql1);
        
                $sql2 = "SELECT * FROM payment WHERE customer_id=$userID AND order_id=$orderid";
        
                $paymentotal = mysqli_fetch_assoc(mysqli_query($conn, $sql2));?>
              <div class="col-sm-12 well well-sm bg-danger"> 
                  
                <p>Order ID: <?=$allorder['order_id']?></p>
                <p>Order Status: <?=$allorder['status']?> <strong>|</strong>  Order Date/Time: <?=date_format($date,"F d, Y h:i A")?></p>
                  <div class="container-fluid table-responsive">
                      <table class=" table table-hover table-condensed ">
                          <thead>
                              <tr>
                                  <th class="text-center">Product</th>
                                  <th class="text-center">Quantity</th>
                                  <th class="text-center">Add-ons</th>
                                  <th class="col-sm-2 text-center">Add-ons Price</th>
                                  <th class="col-sm-2 text-center">Product Price</th>
                                  <th class="col-sm-2 text-center">Total</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php while($item = mysqli_fetch_assoc($result1)) {?>
                              <tr>
                                  <td class="col-sm-5">         
                                  <div class="media">
                                      <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$item['prod_name']?>"><img class="img-res" src="/productimg/<?=$item['prod_img']?>" style="width: 72px; height: 72px;"></a>
                                      <div class="media-body">
                                          <h4 class="media-heading"><a href="/product/prod-item?name="><?=$item['prod_name']?></a></h4>
                                          <h5 class="media-heading">Category: <?=$item['category']?></h5>
                                          <span>Status: </span><span class="text-<?=$item['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$item['status']?></strong></span>
                                      </div>
                                  </div>
                                  </td>
                                  <td class="col-sm-1" style="text-align: center"><?=$item['quantity']?></td>
                                  <td class="col-sm-2"><?=$item['addons_name']?></td>
                                  <td class="col-sm-2 text-center"><strong>₱<?=$item['addons_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['prod_price']?></strong></td>
                                  <td class="col-sm-1 text-center"><strong>₱<?=$item['total']?></strong></td>
                              </tr>
                              <?php }?>
                          </tbody>
                      </table>

                  </div>
                  <?php if($allorder['status'] == "Cancelled") {?>
                    <button type="button" class="vkf4df btn-success" onclick="window.location.replace('/product/')">Buy Again</button>   
                  <?php }?>
                  <h4 class="pull-right">Order Total: ₱<?=$paymentotal['amount']?></h4>   
              </div>  
              <?php }
            } else {?>
              <h3 class="text-center">No Info</h3>
              <?php }?>
            </div>
          </div>
 
    </div>
    <div class="container">

      </div>
      <?php require_once '../footer.php';?>
<!--Modal for cart item-->
<?php 
if(isset($_SESSION['username'])) {
?>
<div class="cart">
<i class="fa fa-shopping-cart"></i>
    
</div>
<div class="cart-count">
    <h6 class="cart-num"></h6>
</div>
<?php }?>
<?php 
        if(isset($_SESSION['username'])) {
       

        ?>
<div class="cart-item">
    <div class="closebutton">
    <i class="fa fa-close" style="font-size:24px;"></i>
</div>
    <div class="cart-content">
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <table class="table table-hover">
                <thead > 
                    <tr >
                        <th></th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Add-ons</th>
                        <th class="text-center">Added On</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="cart-items">
                   
                </tbody>
                <tfoot class="cart-items-foot fade-in">

                </tfoot>
            </table>
        </div>
    </div>
</div>
    </div>
    
</div>
		<?php }?>
 <!-- Modal Track Order -->
 <div class="modal fade" id="tracking" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tracking Details</h4>
        </div>
        <div class="modal-body track-body">
        <!-- <div class="track">
            <div class="step active"> <span class="icon"> <i class="fa fa-clock-o"></i> </span> <span class="text">Pending</span> </div>
            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Confirmed</span> </div>
            <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
            <div class="step"> <span class="icon"> <i class="fa fa-archive"></i> </span> <span class="text">Ready for pickup</span> </div>
        </div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 <!-- Modal Cancel Order -->
 <div class="modal fade" id="cancelorder" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center"><strong>Cancel Order</strong></h4>
        </div>

        <div class="modal-body">
        <p class="text-center"><strong>Cancel Order #: <span class="orderid">NULL</span></strong></p>
        <div class="warn_info">
          <h4 class="text-center"><i class="fa fa-warning"></i> Warning</h4>
          <p class="text-center">Cannot be undone</p>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="vkf4df btn-info" data-dismiss="modal">Close</button>
          <button type="button" class="vkf4df btn-danger cvldkfk">Confirm</button>
        </div>
      </div>
      
    </div>
  </div>
 <!-- Modal Received Order -->
 <div class="modal fade" id="receivedorder" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center"><strong>Order Received</strong></h4>
        </div>
        <div class="modal-body">
        <p class="text-center"><strong>Received Order #: <span class="orderid1">NULL</span></strong></p>
        <div class="warn_info">
          <h4 class="text-center"><i class="fa fa-warning"></i> Warning</h4>
          <p class="text-center">Cannot be undone</p>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="vkf4df btn-warning" data-dismiss="modal">Close</button>
          <button type="button" class="vkf4df btn-success pgktkvo">Received</button>
        </div>
      </div>
      
    </div>
  </div>
 <!-- Modal Already Confirmed -->
 <div class="modal fade" id="noticeorder" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center"><strong>Notice</strong></h4>
        </div>
        <div class="modal-body">
        <div class="warn_info">
          <h4 class="text-center"><i class="fa fa-warning"></i> Warning</h4>
          <p class="text-center">Your Order Already Accepted</p>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="vkf4df btn-warning accept">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script src="../js/jquery.countTo.min.js"></script>
    <script src="../js/jquery.shuffle.min.js"></script>
    <script src="../js/script.js"></script>
<script>

  $('.tracking').click(function() {
  var orderid =  $(this).closest('div').find('input[name=orderID]').val()
    $.ajax({
            type: "POST",
            url: "track.php",
            data: {orderid: orderid},
            success: function(response) {
                $('.track-body').html(response);
                jQuery.noConflict();
                $('#tracking').modal()
                
            }
        })
})

//=====order cancel===================================
$('.ordercancel').on('click', function () {
    var orderid =  $(this).closest('div').find('input[name=orderID]').val()
    $('.orderid').text(orderid)
})
$('.cvldkfk').click(function () {
    var orderid = $('.orderid').text()
    $.ajax({
            type: "POST",
            url: "process.php",
            data: {cancel: orderid},
            success: function(response) {
              jQuery.noConflict();
              if(response == 1) {
                  location.reload();
                } else {
                  $('#cancelorder').modal('hide');
                  $("#noticeorder").modal({backdrop: "static"});
                  $('#noticeorder').modal('show');
                  $('.accept').click(function () {
                    location.reload();
                  })
                }
            }
        })
}) 
//====order receive==============================
$('.orderreceive').on('click', function () {
    var orderid =  $(this).closest('div').find('input[name=orderID]').val()
    $('.orderid1').text(orderid)
})
$('.pgktkvo').click(function () {
    var orderid = $('.orderid1').text()
    $.ajax({
            type: "POST",
            url: "process.php",
            data: {receive: orderid},
            success: function(response) {
                location.reload();
            }
        })
})
//=================================================

</script>
</body>
</html>