

<?php 
session_start();
include '../server.php';
$userID = $_SESSION['id'];

if(isset($_POST['cartlist'])) {
    $value = $_POST['cartlist'];
    if($value == NULL) {
        $value = 0;
    }
} else {
    $value = 0;
    
}



$subtotal = "SELECT SUM(a.quantity * b.prod_price) AS prodtotal, SUM(c.addons_price) AS addonstotal
                FROM cart_item a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.cart_id IN ($value) AND a.id=$userID AND b.status = 'Available'";
$subtotal1 = mysqli_fetch_assoc(mysqli_query($conn,$subtotal));
//calculation on total amount
$totalamount = "SELECT SUM((a.quantity * b.prod_price) + c.addons_price) AS totalamount
                FROM cart_item a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.cart_id IN ($value) AND a.id=$userID AND b.status = 'Available'
                GROUP BY a.id";
$totalprice = mysqli_fetch_assoc(mysqli_query($conn,$totalamount));

$cartitems = "SELECT a.*, b.*, c.addons_name,c.addonsID, ((a.quantity * b.prod_price)+c.addons_price) AS total\n"

. "FROM cart_item a\n"

. "INNER JOIN product b\n"

. "ON a.prod_no=b.prod_no\n"

. "INNER JOIN addons c\n"

. "ON c.addonsID=a.addonsID\n"

. "WHERE a.id=$userID;";
$listcart = mysqli_query($conn, $cartitems);

?>     
                <?php if(mysqli_num_rows($listcart) > 0) { ?>
                    <?php if(isset($totalprice['totalamount'])) {?>
                   <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td><h5>Total Product</h5></td>
                       <td><h5><strong>₱<?=isset($subtotal1['prodtotal']) ? $subtotal1['prodtotal'] : '0.00';?></strong></h5></td>
                   </tr>
                   <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td><h5>Total Add-ons</h5></td>
                       <td><h5><strong>₱<?=isset($subtotal1['addonstotal']) ? $subtotal1['addonstotal'] : '0.00';?></strong></h5></td>
                   </tr>
                   <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td><h3>Total</h3></td>
                       <td><h3><strong>₱<?=isset($totalprice['totalamount']) ? $totalprice['totalamount'] : '0.00';?></strong></h3></td>
                   </tr>
                   <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td>
                       <button type="button" onclick="window.location.replace('/product')" class="vkf4df btn-info">
                           <span class="fa fa-shopping-cart"></span> Browse
                       </button></td>
                       <td>
                           <?php 
                           if(isset($totalprice['totalamount'])) { ?>
                           <button type="button" id="checkout" class="vkf4df btn-success">Checkout <span class="fa fa-arrow-right"></span></button>
                        <?php   }
                        
                           ?>
                      </td>
                   </tr>
                   <?php } else {?>
                    <tr>
                       <td colspan="8"><h5>Select an Item to Checkout</h5></td>
                   </tr>
                   <tr>
                   <td colspan="8">
                       <button type="button" onclick="window.location.replace('/product')" class="vkf4df btn-info">
                           <span class="fa fa-shopping-cart"></span> Browse
                       </button></td>
                   </tr>
                    <?php }?>
                   <?php } else {?>
                   <tr>
                       <td colspan="8"><h5>No Items in the Cart Yet</h5></td>
                   </tr>
                   <tr>
                   <td colspan="8">
                       <button type="button" onclick="window.location.replace('/product')" class="vkf4df btn-info">
                           <span class="fa fa-shopping-cart"></span> Browse
                       </button></td>
                   </tr>
                   <?php }  ?>

               
 <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js" integrity="sha256-/H4YS+7aYb9kJ5OKhFYPUjSJdrtV6AeyJOtTkw6X72o=" crossorigin="anonymous"></script>    
<?php if(isset($_POST['cartlist'])) {?>
<script>
$('#checkout').on('click',function () {
    
    var encrypted = CryptoJS.AES.encrypt('<?=$_POST['cartlist']?>', "Secret Passphrase");
    window.location.replace('/checkout/?c='+encrypted);
})
</script>
<?php }?> 