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
    <title>Brew Base - About</title>
    <link rel="icon" type="image/x-icon" href="/img/brewbase.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/profile.css">
    <link rel="stylesheet" href="/css/navigation.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php require_once '../navigation.php';?>
<div class="header-sub">
        <div class="content-text">
            <div class="text">
                <h1>About Us</h1>
                <p>Home / About</p>
            </div>
        </div>
        </div>
        <div class="about-content">
<div class="about-size">
    <div class="about-design">
        <img class ="img-res" src="../img/brewbase.png" />
        <h2>BrewBase</h2>
        <p>Brew Base is a beverage originating from Philippines but is influenced by the British in their long stint in the region.</p>
    </div>
    <div class="about-design">
    <img class ="img-res" src="../img/ruxe.png" />
        <h2>Developer</h2>
        <p>My name is Ruxe E. Pasok, 2nd Year College in BSIT.  I'm currently studying at Misamis University located at H.T Feliciano St, Ozamiz City.</p>
    </div>
</div>
</div>
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

<?php require_once '../footer.php';?>
<script>
    window.addEventListener('scroll', function(){
        let header = document.getElementsByClassName('site-header')[0];
        let windowPosition = window.scrollY > 0;
        header.classList.toggle('scroll-active', windowPosition);
    })
</script>
<!--Javascript for bootstrap-->

<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/jquery.slicknav.min.js"></script>
<script src="/js/jquery.countTo.min.js"></script>
<script src="/js/jquery.shuffle.min.js"></script>
<script src="/js/script.js"></script>
</body>
</html>