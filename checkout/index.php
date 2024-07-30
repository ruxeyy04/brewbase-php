<?php 
session_start();

$date = date("Y-m-d");
$hours = date("H:i:s");

include '../server.php';
if(!isset($_SESSION['username'])) {
    echo "<script>window.location.replace('/')</script>";
}
$userid = $_SESSION['id'];
$fsdfg = "SELECT * FROM person WHERE id=$userid";
$address = mysqli_fetch_assoc(mysqli_query($conn,$fsdfg));

function evpKDF($password, $salt, $keySize = 8, $ivSize = 4, $iterations = 1, $hashAlgorithm = "md5") {
    $targetKeySize = $keySize + $ivSize;
    $derivedBytes = "";
    $numberOfDerivedWords = 0;
    $block = NULL;
    $hasher = hash_init($hashAlgorithm);
    while ($numberOfDerivedWords < $targetKeySize) {
        if ($block != NULL) {
            hash_update($hasher, $block);
        }
        hash_update($hasher, $password);
        hash_update($hasher, $salt);
        $block = hash_final($hasher, TRUE);
        $hasher = hash_init($hashAlgorithm);
        // Iterations
        for ($i = 1; $i < $iterations; $i++) {
            hash_update($hasher, $block);
            $block = hash_final($hasher, TRUE);
            $hasher = hash_init($hashAlgorithm);
        }
        $derivedBytes .= substr($block, 0, min(strlen($block), ($targetKeySize - $numberOfDerivedWords) * 4));
        $numberOfDerivedWords += strlen($block)/4;
    }
    return array(
        "key" => substr($derivedBytes, 0, $keySize * 4),
        "iv"  => substr($derivedBytes, $keySize * 4, $ivSize * 4)
    );
}

function decrypt($ciphertext, $password) {
    $ciphertext = base64_decode($ciphertext);
    if (substr($ciphertext, 0, 8) != "Salted__") {
        return false;
    }
    $salt = substr($ciphertext, 8, 8);
    $keyAndIV = evpKDF($password, $salt);
    $decryptPassword = openssl_decrypt(
        substr($ciphertext, 16),
        "aes-256-cbc",
        $keyAndIV["key"],
        OPENSSL_RAW_DATA, // base64 was already decoded
        $keyAndIV["iv"]);
    return $decryptPassword;
}




if(isset($_GET['v']) || isset($_GET['a']) || isset($_GET['q'])) {
    $key  =  "Secret Passphrase";
    $strg = str_replace(' ','+',$conn->real_escape_string($_GET['v']));
    $strg1 = str_replace(' ','+',$conn->real_escape_string($_GET['a']));

    $rawText = decrypt($strg, $key);
    $rawText1 = decrypt($strg1, $key);
    
    $prodno =  $rawText . PHP_EOL;
    $addon = $rawText1 . PHP_EOL;
    
    $quantity = $_GET['q'];

    if($rawText == false) {
        echo "<script>window.location.replace('/product')</script>";
    }
    $sql = "SELECT a.prod_img, a.prod_name, a.category, b.addons_name, b.addons_price, a.prod_price, (($quantity * a.prod_price) + b.addons_price) AS total
    FROM product a
    INNER JOIN addons b
    WHERE a.prod_no = $prodno AND b.addonsID =$addon";
    
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
}
if(isset($_GET['c'])) {
    $key  =  "Secret Passphrase";
    $strg2 = str_replace(' ','+',$conn->real_escape_string($_GET['c']));
    $rawText2 = decrypt($strg2, $key);
    $cartno = $rawText2 . PHP_EOL;
    if($rawText2 == false) {
        echo "<script>window.location.replace('/')</script>";
    }
    $subtotal = "SELECT SUM(a.quantity * b.prod_price) AS prodtotal, SUM(c.addons_price) AS addonstotal
    FROM cart_item a
    INNER JOIN product b
    ON a.prod_no=b.prod_no
    INNER JOIN addons c
    ON a.addonsID=c.addonsID
    WHERE a.cart_id IN ($cartno) AND a.id=$userid AND b.status = 'Available'";
    $subtotal1 = mysqli_fetch_assoc(mysqli_query($conn,$subtotal));

    $totalamount = "SELECT SUM((a.quantity * b.prod_price) + c.addons_price) AS totalamount
    FROM cart_item a
    INNER JOIN product b
    ON a.prod_no=b.prod_no
    INNER JOIN addons c
    ON a.addonsID=c.addonsID
    WHERE a.cart_id IN ($cartno) AND a.id=$userid AND b.status = 'Available'
    GROUP BY a.id";
    $totalprice = mysqli_fetch_assoc(mysqli_query($conn,$totalamount));

    $cartitems = "SELECT a.*, b.*, c.addons_name,c.addonsID,c.addons_price, ((a.quantity * b.prod_price)+c.addons_price) AS total
    FROM cart_item a
    INNER JOIN product b
    ON a.prod_no=b.prod_no
    INNER JOIN addons c
    ON c.addonsID=a.addonsID
    WHERE a.id=$userid AND a.cart_id IN ($cartno)";

    $items = mysqli_query($conn, $cartitems);
} 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brew Base - Checkout</title>
    <link rel="icon" type="image/x-icon" href="/img/brewbase.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="background: rgba(255, 221, 170, 0.5);">
<?php if(isset($_GET['v']) || isset($_GET['a']) || isset($_GET['q'])) {?>
<input id="solo" type="hidden" value="<?=$prodno?>">
<?php } 
if(isset($_GET['c'])) {
?>
<input id="multi" type="hidden" value="<?=$cartno?>">
<?php }?>
<div class="loader-wrapper">
        <svg class="tea" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="var(--secondary)" stroke-width="2"></path>
            <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="var(--secondary)" stroke-width="2"></path>
            <path id="teabag" fill="var(--secondary)" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
            <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="var(--secondary)"></path>
            <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="var(--secondary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </div>
<?php require_once '../navigation.php'; ?>
<div style="height: 60px;"></div>

<div class=" container bg-light well well-sm animate" style=" margin-top: 10px; margin-bottom: 10px;">
    <div class=" bg-success well well-sm ">
        <h4 class="text-center"> <strong>Checkout Details</strong> </h4>
      </div>
    <div class="container" style="max-width:1000px; margin: auto;">
        <h3>Delivery Address </h3>
        
        <div class="well">
        <p>
        <?php
        if($address['street'] != NULL) {
            echo $address['street'] . ', ';
        }
        if($address['barangay'] != NULL) {
            echo $address['barangay'] . ', ';
        }
        echo $address['city'] . ', ';
        echo $address['province'] . ' ';
        echo $address['postalcode'] . ' ';
        echo $address['country'];
        ?>
           </p>
            <button type="button" class="vkf4df btn-primary" onclick="window.location.replace('/profile')">Change Address</button>                 
        </div>
        
        <h3>Item Details</h3>
        <div class="col-sm-12 well well-sm">
           
            <div class="container-fluid table-responsive">
                <table class=" table table-hover table-condensed ">
                    <thead>
                        <tr>
                            <th class="text-center">Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Add-ons</th>
                            <th class="col-sm-2 text-center">Add-ons Price</th>
                            <th class="col-sm-2 text-center">Product Price</th>
                            <th class="col-sm-2 text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($_GET['v']) || isset($_GET['a']) || isset($_GET['q'])) { ?>
                        <tr>
                            <td class="col-sm-5">         
                            <div class="media">
                                <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$result['prod_name']?>"><img class="img-res" src="/productimg/<?=$result['prod_img']?>" style="width: 72px; height: 72px;"></a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="/product/prod-item?name=<?=$result['prod_name']?>"><?=$result['prod_name']?></a></h4>
                                    <h5 class="media-heading">Category: <?=$result['category']?></h5>
                                </div>
                            </div>
                            </td>
                            <td class="col-sm-1" style="text-align: center"><?=$quantity?></td>
                            <td class="col-sm-2"><?=$result['addons_name']?></td>
                            <td class="col-sm-2 text-center"><strong>₱<?=$result['addons_price']?></strong></td>
                            <td class="col-sm-1 text-center"><strong>₱<?=$result['prod_price']?></strong></td>
                            <td class="col-sm-1 text-center"><strong>₱<?=$result['total']?></strong></td>
                        </tr>

                 <?php   } ?>
                        <?php if(isset($_GET['c'])) { 
                            if(mysqli_num_rows($items)) {
                                while ($row = mysqli_fetch_assoc($items)) { ?>
                             <tr>
                            <td class="col-sm-5">         
                            <div class="media">
                                <a class="thumbnail pull-left" href="/product/prod-item?name=<?=$row['prod_name']?>"><img class="img-res" src="/productimg/<?=$row['prod_img']?>" style="width: 72px; height: 72px;"></a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="/product/prod-item?name=<?=$row['prod_name']?>"><?=$row['prod_name']?></a></h4>
                                    <h5 class="media-heading">Category: <?=$row['category']?></h5>
                                </div>
                            </div>
                            </td>
                            <td class="col-sm-1" style="text-align: center"><?=$row['quantity']?></td>
                            <td class="col-sm-2"><?=$row['addons_name']?></td>
                            <td class="col-sm-2 text-center"><strong>₱<?=$row['addons_price']?></strong></td>
                            <td class="col-sm-1 text-center"><strong>₱<?=$row['prod_price']?></strong></td>
                            <td class="col-sm-1 text-center"><strong>₱<?=$row['total']?></strong></td>
                        </tr>
                             <?php   }
                            } else { 
                                echo "<script>window.location.replace('/')</script>";
                            }?>
                            
                     <?php   }?>
                       
                    </tbody>
                </table>
            </div>
        </div>
        <h3>Select Payment Method</h3>
        <input type="hidden" name="method">
        <div class="panel-group">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <button data-toggle="collapse" data-target="#cod" class="vkf4df btn-primary btn-block cod">Cash on Delivery</button>
              </h4>
            </div>
            <div id="cod" class="panel-collapse collapse">
            <div class="panel-body">
            <?php 
            if(isset($_GET['v']) || isset($_GET['a']) || isset($_GET['q'])) { ?>
                <p class="lead"><strong>Summary</strong></p>
                <p class="">Total Product: ₱<?=$result['prod_price']?></p>
                <p class="">Total Add-ons: ₱<?=$result['addons_price']?></p>
                <hr>
                <h4><strong>Total Amount: </strong>₱<?=$result['total']?></h4>
                <hr>
            <?php } 
            if(isset($_GET['c'])) { ?>
                <p class="lead"><strong>Summary</strong></p>
                <p class="">Total Product: ₱<?=isset($subtotal1['prodtotal']) ? $subtotal1['prodtotal'] : '0.00';?></p>
                <p class="">Total Add-ons: ₱<?=isset($subtotal1['addonstotal']) ? $subtotal1['addonstotal'] : '0.00';?></p>
                <hr>
                <h4><strong>Total Amount: </strong>₱<?=isset($totalprice['totalamount']) ? $totalprice['totalamount'] : '0.00';?></h4>
                <hr>
          <?php  }  ?>
                <p class=""><strong>Delivery Address: </strong></p>
                <p>
        <?php
        if($address['street'] != NULL) {
            echo $address['street'] . ', ';
        }
        if($address['barangay'] != NULL) {
            echo $address['barangay'] . ', ';
        }
        echo $address['city'] . ', ';
        echo $address['province'] . ' ';
        echo $address['postalcode'] . ' ';
        echo $address['country'];
        ?>
           </p>
                </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <button data-toggle="collapse" data-target="#credit" class="vkf4df btn-primary btn-block credit">Credit Card</button>
              </h4>
            </div>
            <div id="credit" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="col-lg-6">
                <?php 
            if(isset($_GET['v']) || isset($_GET['a']) || isset($_GET['q'])) { ?>
                <p class="lead"><strong>Summary</strong></p>
                <p class="">Total Product: ₱<?=$result['prod_price']?></p>
                <p class="">Total Add-ons: ₱<?=$result['addons_price']?></p>
                <hr>
                <h4><strong>Total Amount: </strong>₱<?=$result['total']?></h4>
                <hr>
            <?php } 
            if(isset($_GET['c'])) { ?>
                <p class="lead"><strong>Summary</strong></p>
                <p class="">Total Product: ₱<?=isset($subtotal1['prodtotal']) ? $subtotal1['prodtotal'] : '0.00';?></p>
                <p class="">Total Add-ons: ₱<?=isset($subtotal1['addonstotal']) ? $subtotal1['addonstotal'] : '0.00';?></p>
                <hr>
                <h4><strong>Total Amount: </strong>₱<?=isset($totalprice['totalamount']) ? $totalprice['totalamount'] : '0.00';?></h4>
                <hr>
          <?php  }  ?>
                <p class=""><strong>Delivery Address: </strong></p>
                <p>
        <?php
        if($address['street'] != NULL) {
            echo $address['street'] . ', ';
        }
        if($address['barangay'] != NULL) {
            echo $address['barangay'] . ', ';
        }
        echo $address['city'] . ', ';
        echo $address['province'] . ' ';
        echo $address['postalcode'] . ' ';
        echo $address['country'];
        ?>
           </p>         
                </div>
               
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group"> 
                                <label>CARD NUMBER</label>
                                <div class="input-group"> 
                                <input type="text" id="cr_no" class="form-control" placeholder="0000 0000 0000 0000" minlength="19" maxlength="19" size="18"/> 
                                <span class="input-group-addon"><span class="fa fa-credit-card"></span></span> 
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group"> 
                                <label><span class="hidden-xs">EXPIRATION</span>
                                    <span class="visible-xs-inline">EXP</span> DATE</label> 
                                    <input type="text" id="exp" class="form-control" placeholder="MM / YY" size="6" id="exp" minlength="5" maxlength="5"/> 
                                </div>
                        </div>
                        <div class="col-xs-12 col-md-6 pull-right">
                            <div class="form-group"> <label>CV CODE</label> <input type="password" class="form-control" name="cvv" placeholder="000" size="1" minlength="3" maxlength="3" /> </div>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group"> <label>CARD OWNER</label> <input type="text" class="form-control" placeholder="Card Owner Name" /> </div>
                            <div class=" pull-right"> <button type="button" class="vkf4df btn-warning confirm-card">Confirm Card Details</button> </div>
                        </div>                   
                    </div>          
                </div>
            </div>
          </div>
        </div>    
        <div class="well well-sm ">
            <button type="button" class="vkf4df btn-danger" onclick="window.location.replace('/product')">Cancel</button>
            <button id="confirm" type="button" class="vkf4df disabled-btn pull-right" disabled>Confirm Order</button>
          </div>         
    </div>
</div>
    <!-- Order Success Modal -->
    <div class="order-modal">
            <div class="success center-modal-success">
                <div class="icon">
                    <i class="fa fa-check"></i>
                </div>
                <div class="title">
                    Order Success
                </div>
                <div class="description">
                Order #: <span id="ordernumber">NULL</span>
                </div>
                <div class="dismiss-btn">
                    <button id="dismiss-success-btn">
                        Thank You
                    </button>
                </div>
            </div>
        </div>
    <!-- END MODAL -->



    <?php require_once '../footer.php'; ?>
<!--Javascript for bootstrap-->
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-select.min.js"></script>
<script src="../js/jquery.slicknav.min.js"></script>
<script src="../js/jquery.countTo.min.js"></script>
<script src="../js/jquery.shuffle.min.js"></script>
<script src="../js/script.js"></script>
<script>
$('#confirm').on('click', function () {
<?php if(isset($_GET['v']) || isset($_GET['a']) || isset($_GET['q'])) {?>
    var solo = $('#solo').val();
    $(".loader-wrapper").fadeIn("slow");
   $.ajax({
        type: "POST",
        url: "process.php",
        data: {solo: solo, quantity: <?=$_GET['q']?>, addons: <?=$addon?>, method: $('input[name=method]').val()},
        success: function(response) {
            setTimeout(ordersuccess, 3000);
            $('#ordernumber').text(response);
            $('#dismiss-success-btn').click(function () {
                window.location.replace('/purchase')
            })
        }
    })
<?php } 
if(isset($_GET['c'])) {?>
    var multi = $('#multi').val();
    $(".loader-wrapper").fadeIn("slow");
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {multi: multi, method: $('input[name=method]').val()},
        success: function(response) {
            setTimeout(ordersuccess, 3000);
            $('#ordernumber').text(response);
            $('#dismiss-success-btn').click(function () {
                window.location.replace('/purchase')
            })
        }
    })
<?php }?>   
})

function ordersuccess() {
    $(".loader-wrapper").fadeOut("slow");
    $('.order-modal').addClass('active');
    $('.success').addClass('active');
    setTimeout(orderlink, 10000);
}
function orderlink() {
 window.location.replace('/purchase')
}
$(window).on('load',function () {
    $(".loader-wrapper").fadeOut("slow");
})
  //For Cash on Delivery
  $('.cod').click(function () {
        $('#credit').collapse('hide')
        $(this).toggleClass('btn-success')
        $('.credit').removeClass('btn-success')
        $('#confirm').toggleClass('disabled-btn').toggleClass('btn-success')
        $('input[name=method]').val('Cash on Delivery')
        if($(this).hasClass('btn-success')) {
            $('#confirm').prop('disabled', false)
        } else {
            $('#confirm').prop('disabled', true)
        }
    })
    //Confirm card details
    $('.confirm-card').click(function () {
        $('.form-group').addClass('has-success')
        $('input').prop('disabled', true)
        $('#confirm').removeClass('disabled-btn').prop('disabled', false).addClass('btn-success')
        $('input[name=method]').val('Credit Card')
    })
    //For Credit Card
    $('.credit').click(function () {
        $('input').prop('disabled', false)
        $('.form-group').removeClass('has-success')
        $('#cod').collapse('hide')
        $(this).toggleClass('btn-success')
        $('.cod').removeClass('btn-success')
        $('#confirm').addClass('disabled-btn').prop('disabled',true).removeClass('btn-success')
    })
    //For Card Number formatted input
    var cardNum = document.getElementById('cr_no');
    cardNum.onkeyup = function (e) {
    if (this.value == this.lastValue) return;
    var caretPosition = this.selectionStart;
    var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
    var parts = [];
    
    for (var i = 0, len = sanitizedValue.length; i < len; i +=4) { 
        parts.push(sanitizedValue.substring(i, i + 4)); 
    } 
    for (var i=caretPosition - 1; i>= 0; i--) {
        var c = this.value[i];
        if (c < '0' || c> '9') {
            caretPosition--;
            }
            }
            caretPosition += Math.floor(caretPosition / 4);
    
            this.value = this.lastValue = parts.join(' ');
            this.selectionStart = this.selectionEnd = caretPosition;
            }
    
            //For Date formatted input
            var expDate = document.getElementById('exp');
            expDate.onkeyup = function (e) {
            if (this.value == this.lastValue) return;
            var caretPosition = this.selectionStart;
            var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
            var parts = [];
    
            for (var i = 0, len = sanitizedValue.length; i < len; i +=2) { parts.push(sanitizedValue.substring(i, i + 2)); } for (var i=caretPosition - 1; i>= 0; i--) {
                var c = this.value[i];
                if (c < '0' || c> '9') {
                    caretPosition--;
                    }
                    }
                    caretPosition += Math.floor(caretPosition / 2);
    
                    this.value = this.lastValue = parts.join('/');
                    this.selectionStart = this.selectionEnd = caretPosition;
                    }
    
        

</script>
</body>
</html>