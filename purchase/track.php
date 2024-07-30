<?php 
session_start();
include '../server.php';
$userID = $_SESSION['id'];
if(isset($_POST['orderid'])) {
$orderID = $_POST['orderid'];

$sql = "SELECT a.*, b.fname, b.lname
        FROM orders a
        INNER JOIN person b
        ON a.prepared_by=b.id
        WHERE a.order_id =$orderID";
$allorder =mysqli_fetch_assoc(mysqli_query($conn, $sql));

if (isset($allorder['status'])) {$date = date_create($allorder['order_date']); }
if (isset($allorder['status'])) {$hrs = date_format($date,"h:i"); }
if (isset($allorder['status'])) {$time = strtotime($hrs);}
if (isset($allorder['status'])) {$est = date("h:i", strtotime('+20 minutes', $time));}




?>

<div class="well">
    <div class="row">
        <div class="col-sm-3 col-xs-12"> <strong>Estimated Delivery time:</strong> <br><?=date_format($date,"F d, Y | $est A")?></div>
        <div class="col-sm-3 col-xs-12"> <strong>Prepared by:</strong> <br> <?=isset($allorder['status']) ? $allorder['status'] == "Pending" ? 'Waiting for In-charge' : 'In-charge: '. $allorder['fname'] . ' ' . $allorder['lname'] : 'Waiting for In-charge';?> </div>
        <div class="col-sm-3 col-xs-12"> <strong>Status:</strong> <br> <?=isset($allorder['status']) ? $allorder['status'] : 'Pending';?> </div>
        <div class="col-sm-3 col-xs-12"> <strong>Order #:</strong> <br> <?=$orderID?> </div>
    </div>
</div>
    <div class="track">
    <div class="step active"> <span class="icon"> <i class="fa fa-clock-o"></i> </span> <span class="text">Pending</span> </div>
    <div class="step <?php 
    if(isset($allorder['status'])) {
        if($allorder['status'] == "Order Confirmed") {
            echo "active";
        } elseif ($allorder['status'] == "On The Way") {
            echo "active";
        } elseif($allorder['status'] == "To Receive") {
            echo "active";
        }
    } 

    ?>"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Confirmed</span> </div>
    <div class="step <?php 
        if(isset($allorder['status'])) {
    if ($allorder['status'] == "On The Way") {
        echo "active";
    } elseif($allorder['status'] == "To Receive")  {
        echo "active";
    } 
}
    ?>"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On The Way </span> </div>
    <div class="step <?php 
            if(isset($allorder['status'])) {
    if ($allorder['status'] == "To Receive") {
        echo "active";
    }  
}
    ?>"> <span class="icon"> <i class="fa fa-archive"></i> </span> <span class="text">Ready To Receive</span> </div>
</div> 

<div class="row well well-sm" style="margin: 70px 1px 0px 1px">
<?php 
        $sql1 = "SELECT a.*, b.*, c.addons_name, c.addons_price, ((a.quantity * a.price_each) + c.addons_price) AS total
        FROM orderdetail a
        INNER JOIN product b
        ON a.prod_no=b.prod_no
        INNER JOIN addons c
        ON a.addonsID=c.addonsID
        WHERE a.order_id=$orderID";

        $result1 = mysqli_query($conn,$sql1);

        $sql2 = "SELECT * FROM payment WHERE customer_id=$userID AND order_id=$orderID";

        $paymentotal = mysqli_fetch_assoc(mysqli_query($conn, $sql2));

        while($item = mysqli_fetch_assoc($result1)) {
?>
    <div class="col-sm-4" style="margin:5px auto;">
        <div class="media">
            <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$item['prod_name']?>" style="margin-right: 40px"><img class="img-res" src="/productimg/<?=$item['prod_img']?>" style="width: 72px; height: 72px;"></a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="/product/prod-item?name="><?=$item['prod_name']?></a></h4>
                    <h5 class="media-heading">Category: <?=$item['category']?></h5>
                    <span>Price: ₱</span><strong><?=$item['prod_price']?></strong>
                </div>
        </div>           
    </div>
<?php }?>
</div>
<?php }?>