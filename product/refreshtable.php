
<?php 

session_start();
include '../server.php';
if(isset($_SESSION['username'])) {
$addons = "SELECT * FROM addons";
$addon = mysqli_query($conn, $addons);
while($row1 = mysqli_fetch_assoc($addon)) { 
    $addon1[] = $row1;
}
$userID = $_SESSION['id'];
if(isset($GET['cartlist'])) {


    $value = $_GET['cartlist'];
    echo "test";
$subtotal = "SELECT SUM(a.quantity * b.prod_price) AS prodtotal, SUM(c.addons_price) AS addonstotal
                FROM cart_item a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.cart_id IN (90,91) AND a.id=$userID AND b.status = 'Available'
                GROUP BY a.id";
$subtotal1 = mysqli_fetch_assoc(mysqli_query($conn,$subtotal));
//calculation on total amount
$totalamount = "SELECT SUM((a.quantity * b.prod_price) + c.addons_price) AS totalamount
                FROM cart_item a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON a.addonsID=c.addonsID
                WHERE a.cart_id IN (90,91) AND a.id=$userID AND b.status = 'Available'
                GROUP BY a.id";
$totalprice = mysqli_fetch_assoc(mysqli_query($conn,$totalamount));
}

//displaying cart in the items
  $cartitems = "SELECT a.*, b.*, c.addons_name,c.addonsID, ((a.quantity * b.prod_price)+c.addons_price) AS total
                FROM cart_item a
                INNER JOIN product b
                ON a.prod_no=b.prod_no
                INNER JOIN addons c
                ON c.addonsID=a.addonsID
                WHERE a.id=$userID";
         $listcart = mysqli_query($conn, $cartitems);
         //--------------------------------
   
?>

            <?php while($items = mysqli_fetch_assoc($listcart)) {  $date = date_create($items['created_at']); ?>
          
                <tr>
                
                       <td><div class="checkbox">
                      
                        <input name="cartno"  type="checkbox" value="<?=$items['cart_id']?>" <?=$items['status'] == "Available" ? '' : 'disabled';?>>
                        <input type="hidden" id="cartlist">
                    </div></td>
                        <td class="col-sm-3">
                        
                        <div class="media">
 
                            <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$items['prod_name']?>"><img class="img-res" src="/productimg/<?=$items['prod_img']?>" style="width: 72px; height: 72px;"></a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="/product/prod-item?name=<?=$items['prod_name']?>"><?=$items['prod_name']?></a></h4>
                                <h5 class="media-heading">Category: <?=$items['category']?></h5>
                                <span>Status: </span><span class="text-<?=$items['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$items['status']?></strong></span>
                            </div>
                        </div></td>
                        <td class="col-sm-2" style="text-align: center">
                        <input type="hidden" value="<?=$items['cart_id']?>" class="cart_id">
                        <button id="decrement" class="subtract"> - </button>
                            <input class="quantity skdl3" type="number" min="1" max="20" step="1" value="<?=$items['quantity']?>" readonly>
                            <button id="increment" class="add"> + </button>
                        </td>
                        <td class="col-sm-8 col-md-2"> 
                        <select class="form-control addons">
                        
                           <?php foreach($addon1 as $addon) { 
                               ?>
                        <option value="<?=$addon['addonsID']?>" <?=$addon['addonsID'] == $items['addonsID'] ? ' selected="selected"' : '';?> ><?=$addon['addons_name']?></option>
                      <?php } ?>
                        </select> 
                        </td>
                        <td class="col-sm-1"><?=date_format($date,"F d, Y h:i A")?></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>₱<?=$items['prod_price']?></strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>₱</strong><strong class="totalitem"><?=$items['total']?></strong></td>
                        <td class="col-sm-1 col-md-1">
                        <button type="button" class="vkf4df btn-danger delete-cart">
                            <span class="fa fa-times"></span> Remove
                        </button></td>
                    </tr>

                          
                    
            <?php }?>

    <?php }?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
<script>

//====================
$("input[name=cartno]").ready(function () {
    $("input[name=cartno]").each(function() {
    if (this.checked) {
      let old_text = $('#cartlist').val() ? $('#cartlist').val()+ ', ' : '';
     $('#cartlist').val(old_text + $(this).val());
    } 

  })
  var listcart = $('#cartlist').val();
  $.ajax({
                type: "POST",
                url: "/product/totalamount.php",
                data: ({cartlist: listcart}),
                success: function(data) {
                    $('.cart-items-foot').html(data);
                }
            });
})
//=======================
$("input[name=cartno]").change(function() {

    $('#cartlist').val('');
  $("input[name=cartno]").each(function() {
    if (this.checked) {
      let old_text = $('#cartlist').val() ? $('#cartlist').val()+ ', ' : '';
     $('#cartlist').val(old_text + $(this).val());
    } 

  })

  var listcart = $('#cartlist').val();
  $.ajax({
                type: "POST",
                url: "/product/totalamount.php",
                data: ({cartlist: listcart}),
                success: function(data) {
                    $('.cart-items-foot').html(data);
                }
            });
});

//===================================
    $('.addons').on('change', function () {
        var number = $(this).closest('tr').find('.cart_id').val();
        var value = $(this).closest('tr').find('.addons').val();
        var totalitem = $(this).closest('tr').find('.totalitem');

         $.post('/product/process.php', {addons: value, cart: number}, function (response) {
             var value = JSON.parse(response)
            
            if(value.value == true) {
                totalitem.text(value.total);
                var listcart = $('#cartlist').val();
                 $.ajax({
                    type: "POST",
                    url: "/product/totalamount.php",
                    data: ({cartlist: listcart}),
                    success: function(data) {
                    $('.cart-items-foot').html(data);
                        }
                  });
            } else {
                alert('Error Updating Quantity');
            }
        })
        
        

      
    })
    //==================================================
$('.add').click(function () {
var input = $(this).closest('tr').find('.skdl3').val();
var min = $(this).closest('tr').find('.skdl3').attr('min');


if(input != min) {
    $(this).closest('tr').find('.skdl3').val(parseInt(input) + 1);
}

$(this).closest('tr').find('.skdl3').val(parseInt(input) + 1);
}) 
$('.subtract').click(function () {
var input = $(this).closest('tr').find('.skdl3').val();
var min = $(this).closest('tr').find('.skdl3').attr('min');
if(input != min) {
    $(this).closest('tr').find('.skdl3').val(parseInt(input) - 1);
} 
}) 
//=========================
$('.subtract').on('click', function () {
        var number = $(this).closest('tr').find('.cart_id').val();
        var quantity = $(this).closest('tr').find('.skdl3').val();
     
        var totalitem = $(this).closest('tr').find('.totalitem');

        $.post('/product/process.php', {quantitychange: quantity, cart_id: number}, function (response) {
            var value = JSON.parse(response);
            if(value.value == true) {
                totalitem.text(value.total);
                var listcart = $('#cartlist').val();
                 $.ajax({
                    type: "POST",
                    url: "/product/totalamount.php",
                    data: ({cartlist: listcart}),
                    success: function(data) {
                    $('.cart-items-foot').html(data);
                        }
                  });
            } else {
                alert('Error Updating Quantity');
            }
        })      
    })
$('.add').on('click', function () {
        var number = $(this).closest('tr').find('.cart_id').val();
        var quantity = $(this).closest('tr').find('.skdl3').val();
 
        var totalitem = $(this).closest('tr').find('.totalitem');

        $.post('/product/process.php', {quantitychange: quantity, cart_id: number}, function (response) {
            var value = JSON.parse(response);
            if(value.value == true) {      
                totalitem.text(value.total);
                var listcart = $('#cartlist').val();
                 $.ajax({
                    type: "POST",
                    url: "/product/totalamount.php",
                    data: ({cartlist: listcart}),
                    success: function(data) {
                    $('.cart-items-foot').html(data);
                        }
                  });
            } else {
                alert('Error Updating Quantity');
            }
        })
        var listcart = $('#cartlist').val();      
    })
$('.delete-cart').click(function () {
    var number = $(this).closest('tr').find('.cart_id').val();

    $.post('/product/delete.php', {delete: number}, function () {
        get_table();
        get_amount();
    })
   
 });


 function get_table() {
            jQuery.ajax({
                type: "GET",
                url: "/product/refreshtable.php",
                data: "",
                success: function(data) {
                    $('.cart-items').html(data);
                }
            });
        }
function get_amount() {
            jQuery.ajax({
                type: "GET",
                url: "/product/totalamount.php",
                data: "",
                success: function(data) {
                    $('.cart-items-foot').html(data);
                }
            });
        }  
</script>