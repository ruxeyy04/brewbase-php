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
    <title>Brew Base</title>
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
<body class="bg-contact">
<?php require_once '../navigation.php';?>
<div class="header-sub">
        <div class="content-text">
            <div class="text">
                <h1>Concern</h1>
                <p>Home / Concern</p>
            </div>
        </div>
</div>
<div class="alert-success">
                 <span id="message"></span>
                </div>
     <div class="container CI53DF" style="margin: 50px auto">
		
            <div class="contact-box">
                <div class="contact-left">
                    <h3>SEND YOUR CONCERN</h3>
    
                        <div class="POLDEW-row">
                            <div class="POLDEW-group">
                                <label class="PKDKE">Name</label>
                                <input type="text" name="name" class="POLDEW" placeholder="Your Name" required>
                            </div>
                            <div class="POLDEW-group">
                                <label class="PKDKE">Phone</label>
                                <input type="text" name="phone" class="POLDEW" placeholder="(+63) 09123456789" required>
                            </div>
                        </div>
                        <div class="POLDEW-row">
                            <div class="POLDEW-group">
                                <label class="PKDKE">Email</label>
                                <input type="email" name="email" class="POLDEW" placeholder="Your Email" required>
                            </div>
                            <div class="POLDEW-group">
                                <label class="PKDKE">Subject</label>
                                <input type="text" name="subject" class="POLDEW" placeholder="Your Subject" required>
                            </div>
                        </div>
                        <label class="PKDKE">Message</label>
                        <textarea class="QOXDKD" name="message" rows="7" placeholder="Your Message" required></textarea>
						<button class="PLLFRC" type="submit" name="submit" >Contact Us</button>
              
                </div>
                <div class="contact-right">
                    <h3>CONTACT INFORMATION</h3>
                    <table>
                        <tr class="KVIRKV">
                            <td>Email</td>
                            <td>ruxepasok356@gmail.com</td>
                        </tr>
                        <tr class="KVIRKV">
                            <td>Phone</td>
                            <td>(+63) 9982853572</td>
                        </tr>
                        <tr class="KVIRKV">
                            <td>Address</td>
                            <td>Ozamiz City, Misamis Occidental, Philippines</td>
                        </tr>
                        
                    </table>
                    <div class="social-links">
                        <h3>SOCIAL MEDIA LINKS</h3>
                        <ul class="social">
                            <li><a class="facebook-bg" href="https://www.facebook.com/pasok.ruxe.4/"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="twitter-bg" href="https://twitter.com/ruxeyy_4"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="instagram-bg" href="https://www.instagram.com/ruxe.04/"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                        
                    </table>
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
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/jquery.slicknav.min.js"></script>
<script src="/js/jquery.countTo.min.js"></script>
<script src="/js/jquery.shuffle.min.js"></script>
<script src="/js/script.js"></script>
<script>

$('.PLLFRC').click(function() {
    
    $.ajax({
        type: "POST",
        url: "mail.php",
        data: {phone: $('input[name=phone]').val(),
                name: $('input[name=name]').val(),
                subject: $('input[name=subject]').val(),
                message: $('input[name=message]').val(),
                email: $('input[name=email]').val()},
        success: function (response) {
            $('#message').text('Concern Sent Successfully');
                $('.alert-success').addClass('show');
                setTimeout(notifout, 2500)
                    function notifout() {
                        $('.alert-success').removeClass('show');
                        get_table();
                    }
        }
    })
})
</script>
</body>
</html>