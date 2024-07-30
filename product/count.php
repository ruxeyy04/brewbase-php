<?php 
session_start();
include '../server.php';
$userID = $_SESSION['id'];
if(isset($_GET)) {
    $sql = "SELECT COUNT(*) AS count FROM cart_item WHERE id = $userID;";
    $result = mysqli_query($conn, $sql);
    $count = $result->fetch_assoc();
    echo $count['count'];
  }
?>