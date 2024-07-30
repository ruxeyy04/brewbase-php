<?php 
include '../../server.php';
$sql = "SELECT * FROM product";
if(isset($_POST['data'])) {
    $value = $_POST['data'];
    $sql .= " WHERE prod_no = $value";
    $prod = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $output = array('prodno'=>$prod['prod_no'],
                    'prodimg'=>$prod['prod_img'],
                    'prodname'=>$prod['prod_name'], 
                    'date'=>$prod['prod_date'], 
                    'category'=>$prod['category'],
                    'price'=>$prod['prod_price'],
                    'desc'=>$prod['prod_description']);
    echo json_encode($output);
}
?>