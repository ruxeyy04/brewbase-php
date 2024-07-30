<?php 
session_start();
include 'server.php';
$sql = "SELECT * FROM `product` ORDER BY prod_date DESC LIMIT 8;";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brew Base</title>
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
<body>
<?php require_once 'navigation.php';?>
<div class="header">
  <div class="content">
    <div class="text">
        <h1>Welcome to Brew Base</h1>
        <p>Motivate yourself with a cup of tea</p>
        <button type="button" onclick="window.location.replace('/product/')">View Products</button>
    </div>
  </div>  
</div>


<main>
    <section class="site-section section-features">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <h2>Brew Base</h2>
                    <p>Brew Base is a beverage originating from Philippines but is influenced by the British in their long stint in the region. 
                        It is consist of black tea with evaporated milk or condensed milk. 
                        Unlike Chinese Tea which is served plain, milk tea uses condensed milk and sugar that gives the tea a richer feel.</p>
                </div>
                <div class="imgfeature">

                </div>
            </div>
        </div>
    </section><!-- /.section-features -->

    <section class="site-section section-product gray-bg text-center">
        <div class="container">
            <h2 class="heading-separator">Our Products</h2>
            <p class="subheading-text">Open up your senses with a cup of tea</p>
            <div class="row">
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="/img/milktea.jpg" alt="">
                        </div>
                        <h3 class="service-title">Milktea</h3>
                    </div><!-- /.product -->
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="/img/frappe.jpg" alt="">
                        </div>
                        <h3 class="service-title">Frappe</h3>
                    </div><!-- /.product -->
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="/img/Fruit-Tea.jpg" alt="">
                        </div>
                        <h3 class="service-title">Fruit Tea</h3>
                    </div><!-- /.product -->
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="/img/hotdrink.png" alt="">
                        </div>
                        <h3 class="service-title">Hotdrinks</h3>
                    </div><!-- /.product -->
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="/img/iced.jpg" alt="">
                        </div>
                        <h3 class="service-title">Cold Drinks</h3>
                    </div><!-- /.product -->
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="/img/lemonade.jpeg" alt="">
                        </div>
                        <h3 class="service-title">Lemonade</h3>
                    </div><!-- /.product -->
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="/img/soya.png" alt="">
                        </div>
                        <h3 class="service-title">Soya Drink</h3>
                    </div><!-- /.product -->
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="/img/sodapops.jpg" alt="">
                        </div>
                        <h3 class="service-title">Soda Pops</h3>
                    </div><!-- /.product -->
                </div>
            </div>
        </div>
    </section><!-- /.section-product -->
    <section class="site-section section-product">
        <div class="container">
            <div class="text-center">
                <h2 class="heading-separator">Latest Product</h2>
            </div>
            <div class="row">
            <?php $result = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {
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
                  <?php } ?>
            </div>
        </div>
    </section><!-- /.section-product -->

</main>

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
            <table class="table table-hover">
                <thead > 
                    <tr >
                        <th></th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Add-ons</th>
                        <th class="text-center">Added On</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="cart-items">
                   
                </tbody>
                <tfoot class="cart-items-foot fade-in">

                </tfoot>
            </table>
        </div>
    </div>
</div>
    </div>
    
</div>
		<?php }?>

<?php require_once 'footer.php';?>
<script>
    window.addEventListener('scroll', function(){
        let header = document.getElementsByClassName('site-header')[0];
        let windowPosition = window.scrollY > 0;
        header.classList.toggle('scroll-active', windowPosition);
    })
</script>
<!--Javascript for bootstrap-->

<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/jquery.slicknav.min.js"></script>
<script src="js/jquery.countTo.min.js"></script>
<script src="js/jquery.shuffle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>