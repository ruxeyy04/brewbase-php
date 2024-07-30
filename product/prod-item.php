<?php 
session_start();
include '../server.php';
if(isset($_GET['name'])) {
    $item = $_GET['name'];
    $sql = "SELECT * FROM `product` WHERE prod_name = '$item'";
    $result = mysqli_query($conn,$sql);
    $info = $result->fetch_assoc(); 
    if(!$result->num_rows > 0) {
        echo "<script>window.location.replace('/product')</script>";
    }
    $date = $info['prod_date'];
    $date = date_create("$date");
    $category = $info['category']; 
    $sql1 = "SELECT * FROM `product` WHERE category = '$category' EXCEPT SELECT * FROM `product` WHERE prod_name = '$item' ORDER BY prod_date  DESC LIMIT 8 ;";
    $addons = "SELECT * FROM addons EXCEPT SELECT * FROM addons WHERE addonsID = 0";
    $addon = mysqli_query($conn, $addons);
   
} else {
    echo "<script>window.location.replace('/product')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="/img/brewbase.ico">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/responsive.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/profile.css">
        <link rel="stylesheet" href="../css/navigation.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/style.css">
        <title>Brew Base -  Product Item</title>
    </head>
<body>
<?php require_once '../navigation.php'; ?>
    <div class="alert-success">
                 <span id="message"></span>
                </div>
<div class="header-sub">
<div class="content-text">
    <div class="text">
        <h1>Product</h1>
        <p>Home / Product / Product Item</p>
    </div>
</div>
</div>
                            
            <div class="container">
                <input type="hidden" class="prodID" value="<?=$info['prod_no']?>">
                <h1 id="proname"><?=$info['prod_name']?></h1>
                <div class="row">         
                    <div class="col-md-8">     
                        <div class="productimg">
                            <img src="/productimg/<?=$info['prod_img']?>" class="img-res" alt="">
                        </div>
                    </div>
                    <aside class="col-md-4">
                        <div class="product-info">
                            <h5 style="font-weight: 600;">Description</h5>

                            <p class="product-description"><?=$info['prod_description']?></p>

                            <div class="product-info">
                                <p><span> Status: </span><text class="text-<?=$info['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$info['status']?></strong></text></p>
                                <p><span>Date: </span><?=date_format($date,"F j, Y")?></p>        
                                <p><span>Category: </span><?=$info['category']?></p>
                                <p><span >Price: </span>₱<?=$info['prod_price']?></p>
                                <p><div style="display: flex; align-items: center" >
                                <span class="span" style="margin-right: 10px">Add-ons: </span>
                                <select id="slick" class="select-addons">
                                    <option value="0" data-description=" ">Select Add-ons</option>
                                    <?php while($row1 = mysqli_fetch_assoc($addon)) {?>
                                    <option value="<?=$row1['addonsID']?>" data-imagesrc="/addonsimg/<?=$row1['addons_img']?>"
                                    data-description="Price: ₱ <?=$row1['addons_price']?>"><?=$row1['addons_name']?></option>
                                        <?php } ?>
                                </select>
                                </div></p>
                                <p><span>Quantity: </span><button id="decrement" onclick="stepper(this)"> - </button>
        <input  class="quantity" type="number" min="1" max="20" step="1" value="1" id="my-input" readonly>
        <button id="increment" onclick="stepper(this)"> + </button></p>
                            </div>
                            <div class="order-buttons">
                            <button type="button" class="btn-oval btn-info add-cart">Add to Cart</button>
                            <button type="button" class="btn-oval btn-success <?=$info['status'] == "Available" ? 'add-order' : '';?>" data-toggle="modal" data-target="<?=$info['status'] == "Available" ? '#order' : '#notavailable';?>">Order Now</button>
                        </div>             
                        </div>
                    </aside>
                </div>
            </div>
            
       

        <section class="site-section subpage-site-section section-related-projects">
            <div class="container">
                <?php 
                 $result1 = mysqli_query($conn, $sql1);
                if($result1->num_rows > 0){
                    ?>
                <div class="text-left">
                    <h2>Related Product</h2>
                </div>
                <div class="row">
            <?php
                while($row = mysqli_fetch_assoc($result1)) {
            ?>
                <div class="col-lg-3 col-md-4 col-xs-6">
                    <div class="product-item">
                        <img src="/productimg/<?=$row['prod_img']?>" class="img-res" alt="">
                        <h4  class="product-item-title"> <textarea placeholder="<?=$row['prod_description']?>" name="" id="" cols="30" rows="10" style="width: 150px; 
                            resize: none;
                            border: none;
                            outline: none;
                            overflow: hidden;
                            text-align: center;
                            background: none" readonly></textarea></h4>
                        <a href="/product/prod-item?name=<?=$row['prod_name']?>">Read More <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div><!-- /.product-item -->
                </div>
                  <?php }
                  } else {
                      echo '<div class="text-left">
                      <h2>No Related Product Yet</h2>
                  </div>';
                  } ?>
            </div>
            </div>
        </section><!-- /.section-portfolio -->

<!--Modal for cart item-->
<?php 
if(isset($_SESSION['username'])) {
?>
<div class="cart">
<i class="fa fa-shopping-cart"></i>
    
</div>
<div class="cart-count">
    <h6 class="cart-num"></h6>
</div>
<?php }?>
<?php 
        if(isset($_SESSION['username'])) {
       

        ?>
<div class="cart-item">
    <div class="closebutton">
    <i class="fa fa-close" style="font-size:24px;"></i>
</div>
    <div class="cart-content">
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <table class="table table-hover ">
                <thead > 
                    <tr>
                        <th></th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Add-ons</th>
                        <th class="text-center">Added On</th>
                        <th class="text-center">Price</th>
                        <th class="col-sm-2 text-center">Total</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="cart-items">
                   
                </tbody>
                <tfoot class="cart-items-foot">

                </tfoot>
            </table>
        </div>
    </div>
</div>
    </div>
    
</div>
		<?php }?>
 <!-- Modal Not Available -->
 <div class="modal fade" id="notavailable" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center"> <strong>Product Not Available</strong> </h4>
        </div>
        <div class="modal-body bg-warning">
            <p>Product Name: <?=$info['prod_name']?></p>
            <p><span> Status: </span><text class="text-<?=$info['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$info['status']?></strong></text></p>
            <p><span>Product Date: </span><?=date_format($date,"F j, Y")?></p>        
            <p><span>Category: </span><?=$info['category']?></p>
            <p><span>Price: </span>₱<?=$info['prod_price']?></p>
        </div>
        <div class="modal-footer bg-danger">
          <button type="button" class="vkf4df btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

 <!-- Modal Confirmation to Order -->
 <div class="modal fade" id="order" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center"> <strong>Order Details</strong> </h4>
        </div>
        <div class="modal-body bg-warning">
            <p>Product Name: <?=$info['prod_name']?></p>
            <p><span> Status: </span><text class="text-<?=$info['status'] == "Available" ? 'success' : 'danger';?>"><strong><?=$info['status']?></strong></text></p>
            <p><span>Product Date: </span><?=date_format($date,"F j, Y")?></p>        
            <p><span>Category: </span><?=$info['category']?></p>
            <p><span>Price: </span>₱<?=$info['prod_price']?></p>
            <p>Add-ons: <span id="addons1"></span></p>
            <p>Quantity: <span id="quantity1"></span></p>
            <p><strong>Total Amount: ₱<span id="totalamount"></span></strong></p>
        </div>
        <div class="modal-footer bg-success">
          <button type="button" class="vkf4df btn-warning" data-dismiss="modal">Close</button>
          <button id="dxkfjk4" type="button" class="vkf4df btn-success">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col">
                    <h4>Website</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Our Products</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Keep in touch</h4>
                    <ul>
                        <li><a href="mailto:brewbase@gmail.com">brewbase@gmail.com</a></li>
                        <li><a href="+639123456789">+63 9123-34323-32</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Products</h4>
                    <ul>
                        <li><a href="#">Food</a></li>
                        <li><a href="#">Original Tea</a></li>
                        <li><a href="#">Hot Drinks</a></li>
                        <li><a href="#">Cold Drinks</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fa fa-facebook-f"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
            <p style="color: white;">&copy; <span style="font-weight: 700;">Brew Base</span> Educational Puposes Only</p>
        </div>
        </div>
    </footer>



    <!-- Bootstrap core JavaScript-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-select.min.js"></script>
<script src="../js/jquery.slicknav.min.js"></script>
<script src="../js/jquery.countTo.min.js"></script>
<script src="../js/jquery.shuffle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js" integrity="sha256-/H4YS+7aYb9kJ5OKhFYPUjSJdrtV6AeyJOtTkw6X72o=" crossorigin="anonymous"></script>
<script src="../js/script.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js" ></script>
<script>
    //Add Order=========
    $('.add-order').click(function () {
       <?php  if(isset($_SESSION['username'])) { ?>
        var addons = $(".dd-selected-text").text()

        
      if(addons == "Select Add-ons") {
        $('#addons1').text('None');
      } else {
        $('#addons1').html(addons);
      }
       $('#quantity1').text($('#my-input').val());
       var quantity = parseInt($('#my-input').val());
        var addonsprice = parseInt($('.dd-selected-description').text().replace(/[Price ₱ :]/g,''));
      var prodprice = <?=$info['prod_price']?>;
      if(!addonsprice) {
        addonsprice = 0;
      }
      var totalamount = (quantity * prodprice) + addonsprice;
      $('#totalamount').text(totalamount);



         <?php } else { ?>
            window.location.replace('/login/');
        <?php } ?>
    });
    //Add to Cart==========
    $('.add-cart').click(function () {
        
       <?php 
        if(isset($_SESSION['username'])) { ?>

            $.post("process.php",
            {prodID: $('.prodID').val(),
             userID: <?=$_SESSION['id'] ?>,
             quantity: $('#my-input').val(),
             addonsID: $(".dd-selected-value").val()
            }, function(response)
            {
  
                $('#message').text('Item is Added to Cart');
                $('.alert-success').addClass('show');
                setTimeout(notifout, 2500)
                    function notifout() {
                        $('.alert-success').removeClass('show');
                        get_table();
                    }
            
                
            });


         <?php } else { ?>
            window.location.replace('/login/');
        <?php } ?>
    });
//===================================
const myInput = document.getElementById("my-input");
function stepper(btn){
    let id = btn.getAttribute("id");
    let min = myInput.getAttribute("min");
    let max = myInput.getAttribute("max");
    let step = myInput.getAttribute("step");
    let val = myInput.getAttribute("value");
    let calcStep = (id == "increment") ? (step*1) : (step * -1);
    let newValue = parseInt(val) + calcStep;

    if(newValue >= min && newValue <= max){
        myInput.setAttribute("value", newValue);
    }
}
//=============================================

$('#slick').ddslick({
        width: "250px",
        imagePosition: "right",
        onSelected: function(data) {
            $('#selected').html(data.selectedData.value);
        }
    })
    $('.select-addons').ddslick({
        width: "250px",
        imagePosition: "right",
        onSelected: function(data) {
            $('#selected').html(data.selectedData.value);
        }
    })
   
</script>
</body>
</html>