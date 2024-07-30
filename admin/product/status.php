<?php 
include '../../server.php';
if(isset($_POST['available'])) {
    $prodid = $_POST['available'];

    $sql = "UPDATE product SET status = 'Available' WHERE prod_no = $prodid";

    $result = mysqli_query($conn, $sql);

    if($result) {
        echo "Available";
    }
}
if(isset($_POST['unavailable'])) {
    $prodid = $_POST['unavailable'];

    $sql = "UPDATE product SET status = 'Not Available' WHERE prod_no = $prodid";

    $result = mysqli_query($conn, $sql);

    if($result) {
        echo "Not Available";
    }
}
?>