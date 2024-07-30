<?php 
try {
  $date = date("Y-m-d");
  $hours = date("H:i:s");
include '../server.php';
if(isset($_POST['prodID'])) {
    $prodID = $_POST['prodID'];
    $userID = $_POST['userID'];
    $quantity = $_POST['quantity'];
    $addonsID = $_POST['addonsID'];
  $checking = "SELECT * FROM cart_item WHERE id = $userID";
  $checkresult = mysqli_query($conn, $checking);

  while ($row = mysqli_fetch_assoc($checkresult)) {
    $checkProdId = $row['prod_no'];
  }
  
  if($checkProdId === $prodID) {
        $sql = "UPDATE cart_item SET quantity = $quantity, addonsID = $addonsID WHERE prod_no = $prodID";
  } else {
 $sql = "INSERT INTO cart_item(prod_no, id, quantity, created_at, addonsID) VALUES($prodID, $userID, $quantity,'$date $hours',$addonsID)";
 
  }
 
  if($conn->query($sql) === TRUE) {
    echo "0";
  } 
}

}catch(Exception $e) {
    echo "1";
}

if(isset($_POST['quantitychange'])) {
  $quantity = $_POST['quantitychange'];
  $cartno = $_POST['cart_id'];
  $sql = "UPDATE cart_item SET quantity = $quantity WHERE cart_id=$cartno";

  $result = mysqli_query($conn, $sql);
  
  $cartitems = "SELECT a.*, b.*, c.addons_name,c.addonsID, ((a.quantity * b.prod_price)+c.addons_price) AS total\n"

  . "FROM cart_item a\n"

  . "INNER JOIN product b\n"

  . "ON a.prod_no=b.prod_no\n"

  . "INNER JOIN addons c\n"

  . "ON c.addonsID=a.addonsID\n"

  . "WHERE a.cart_id=$cartno;";
  $listcart = mysqli_query($conn, $cartitems);
  $items = mysqli_fetch_assoc($listcart);
  $totalamount = $items['total'];
  $output = array('value'=>$result,'total'=>$totalamount);

  echo json_encode($output);
   
}
if(isset($_POST['addons'])) {
  $addons = $_POST['addons'];
  $cartno = $_POST['cart'];

  $sql = "UPDATE cart_item SET addonsID = $addons WHERE cart_id = $cartno";

  $result = mysqli_query($conn, $sql);
  $cartitems = "SELECT a.*, b.*, c.addons_name,c.addonsID, ((a.quantity * b.prod_price)+c.addons_price) AS total\n"

  . "FROM cart_item a\n"

  . "INNER JOIN product b\n"

  . "ON a.prod_no=b.prod_no\n"

  . "INNER JOIN addons c\n"

  . "ON c.addonsID=a.addonsID\n"

  . "WHERE a.cart_id=$cartno;";
  $listcart = mysqli_query($conn, $cartitems);
  $items = mysqli_fetch_assoc($listcart);
  $totalamount = $items['total'];
  $output = array('value'=>$result,'total'=>$totalamount);

  echo json_encode($output);
}

?>