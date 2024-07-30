<?php 
session_start();
include '../server.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Brew Base -  Product</title>
    <link rel="icon" type="image/x-icon" href="/img/brewbase.ico">

</head>
<body>

<?php require_once '../navigation.php';?>

<div class="header-sub">
<div class="content-text">
    <div class="text">
        <h1>Product</h1>
        <p>Home / Product</p>
    </div>
</div>
</div>
    <main id="" class="site-main gray-bg">

        <section class="site-section subpage-site-section section-product">
            <div class="container">
                <?php 
                if(isset($_GET['search'])) {
                    $value = $_GET['search'];
                    $sql = "SELECT category FROM `product` WHERE CONCAT(prod_name, category) LIKE '%$value%'\n"
                    . "GROUP BY category;";
                    $sql1 = "SELECT * FROM product WHERE CONCAT(prod_name, category) LIKE '%$value%'";
                    $result = mysqli_query($conn, $sql);
                    $result1 = mysqli_query($conn,$sql1);
                } else {
                    $sql = "SELECT category FROM `product`\n"
                    . "GROUP BY category;";
                    $sql1 = "SELECT * FROM product";
                    $result = mysqli_query($conn, $sql);
                    $result1 = mysqli_query($conn, $sql1);
                }


                ?>
                <ul class="product-sorting list-inline text-center">         
                    <li><a href="#" class="btn active" data-group="all">All</a></li>
                    <?php if($result->num_rows > 0) { 
                        while ($cat = mysqli_fetch_assoc($result)) {?>
                    <li><a href="#" class="btn" data-group="<?=$cat['category'] ?>"><?=$cat['category'] ?></a></li>
                    <?php }
                        }?>
                </ul><!-- /.product-sorting  -->
               
                <div id="grid" class="row">
                <?php if($result1->num_rows > 0) { 
                        while ($prod = mysqli_fetch_assoc($result1)) {?>
                    <div class="col-lg-3 col-md-4 col-xs-6" data-groups='["<?=$prod['category'] ?>"]'>
                        <div class="product-item">
                            <img src="/productimg/<?=$prod['prod_img']?>" class="img-res" alt="">
                            <h4  class="product-item-title"> <textarea placeholder="<?=$prod['prod_description']?>" name="" id="" cols="30" rows="10" style="width: 150px; 
                            resize: none;
                            border: none;
                            outline: none;
                            overflow: hidden;
                            text-align: center;
                            background: none" readonly></textarea></h4>
                            <a style="width: 140px;" href="prod-item?name=<?=$prod['prod_name']?>">Read More <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
						<!-- /.product-item -->
						
                    </div>   
                    <?php }
                }?>    
                </div>
            
                <div class="text-center" style="margin-top: 20px">
                    <a class="btn btn-gray" href="#" id="loadMore">Load More</a>
                </div>
            </div>
            
        </section><!-- /.section-product -->

    </main><!-- /#main -->
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
                <tfoot class="cart-items-foot">

                </tfoot>
            </table>
        </div>
    </div>
</div>
    </div>
    
</div>
		<?php }?>
        <?php require_once '../footer.php';?>
    <!-- JS for Bootstrap-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script src="../js/jquery.countTo.min.js"></script>
    <script src="../js/jquery.shuffle.min.js"></script>
    <script src="../js/script.js"></script>


  
</body>
</html>