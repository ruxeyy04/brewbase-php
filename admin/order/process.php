<?php
session_start();
include '../../server.php';
if(isset($_POST['status'])) {
$status = $_POST['status'];
$orderid = $_POST['orderid'];
$userid = $_SESSION['id'];
$sql = "UPDATE orders SET status = '$status', prepared_by = $userid WHERE order_id = $orderid";
mysqli_query($conn, $sql);
}
?>