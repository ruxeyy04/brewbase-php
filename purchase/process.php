<?php 
include '../server.php';
$sql = "SELECT status FROM orders";
if(isset($_POST['cancel'])) {
$orderid = $_POST['cancel'];
$sql = "SELECT status FROM orders WHERE order_id = $orderid";
$result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
if($result['status'] == "Pending") {
$sql = "UPDATE orders SET status='Cancelled' WHERE order_id = $orderid";
mysqli_query($conn, $sql);
echo 1;
} else {
    echo 0;
}
}
if(isset($_POST['receive'])) {
$orderid = $_POST['receive'];
$sql = "UPDATE orders SET status='Completed' WHERE order_id = $orderid";
mysqli_query($conn, $sql);
}
?>