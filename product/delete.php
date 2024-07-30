<?php
include '../server.php'; 
if(isset($_POST['delete'])) {
    $cartno = $_POST['delete'];
    $sql = "DELETE FROM cart_item WHERE cart_id = $cartno";
    $result = mysqli_query($conn, $sql);
}

?>