<?php 
session_start();
include '../server.php';
$date = date("Y-m-d");
$hours = date("H:i:s");
$userid = $_SESSION['id'];
if(isset($_POST['solo'])) {
    $value = $_POST['solo'];
    $orderID = 2022 . mt_rand(10000,99999);
    $quantity = $_POST['quantity'];
    $addons = $_POST['addons'];
    $payID = 2022 . mt_rand(100000009,999999999);
    $method = $_POST['method'];
    $sql = "INSERT INTO orders(order_id, order_date, status, customer_id) VALUES($orderID, '$date $hours', 'Pending', $userid)";
    $order = mysqli_query($conn, $sql);
    
   

    $prod = "SELECT prod_price FROM product WHERE prod_no = $value";
    $prodresult = mysqli_fetch_assoc(mysqli_query($conn, $prod));
    $price_each = $prodresult['prod_price'];

    $sql1 = "INSERT INTO orderdetail() VALUES($orderID, $value, $quantity, $price_each, $addons)";

    mysqli_query($conn, $sql1);

    $orderamount = "SELECT SUM(((a.quantity * a.price_each) + b.addons_price)) AS amount
    FROM orderdetail a
    INNER JOIN addons b
    ON a.addonsID=b.addonsID
    WHERE a.order_id=$orderID
    GROUP BY a.order_id;";
    $totalamount = mysqli_fetch_assoc(mysqli_query($conn, $orderamount));
    $amount = $totalamount['amount'];
    $sql = "INSERT INTO payment() VALUES($payID, '$date $hours', '$method',$amount, $orderID, $userid)";

    mysqli_query($conn, $sql);

    echo $orderID;
}

if(isset($_POST['multi'])) {
    $cartlist = $_POST['multi'];
    $orderID = 2022 . mt_rand(10000,99999);

    $sql = "INSERT INTO orders(order_id, order_date, status, customer_id) VALUES($orderID, '$date $hours', 'Pending', $userid)";
    $order = mysqli_query($conn, $sql);

    $sql = "SELECT a.*, b.*, c.addons_name,c.addonsID, ((a.quantity * b.prod_price)+c.addons_price) AS total
    FROM cart_item a
    INNER JOIN product b
    ON a.prod_no=b.prod_no
    INNER JOIN addons c
    ON c.addonsID=a.addonsID
    WHERE a.id=$userid AND a.cart_id IN ($cartlist);";
    $listcart = mysqli_query($conn, $sql);
    while($items = mysqli_fetch_assoc($listcart)) {
        $prodno = $items['prod_no'];
        $quantity = $items['quantity'];
        $price_each = $items['prod_price'];
        $addons = $items['addonsID'];
        $sql = "INSERT INTO orderdetail() VALUES($orderID, $prodno, $quantity, $price_each, $addons)";
        mysqli_query($conn, $sql);
    }

    $totalamount = "SELECT SUM((a.quantity * b.prod_price) + c.addons_price) AS totalamount
    FROM cart_item a
    INNER JOIN product b
    ON a.prod_no=b.prod_no
    INNER JOIN addons c
    ON a.addonsID=c.addonsID
    WHERE a.cart_id IN ($cartlist) AND a.id=$userid AND b.status = 'Available'
    GROUP BY a.id";
    $totalprice = mysqli_fetch_assoc(mysqli_query($conn,$totalamount));

    $method = $_POST['method'];
    $payID = 2022 . mt_rand(100000009,999999999);
    $total = $totalprice['totalamount'];
    $sql = "INSERT INTO payment() VALUES($payID, '$date $hours', '$method',$total, $orderID, $userid)";
    mysqli_query($conn, $sql);

    $sql = "DELETE FROM cart_item WHERE cart_id IN ($cartlist)";
    mysqli_query($conn, $sql);

    echo $orderID;
}
?>