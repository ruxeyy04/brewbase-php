<?php 
session_start();
if(!isset($_SESSION['usertype'])) {
 echo "<script>window.location.replace('/login/')</script>";
}
if($_SESSION['usertype'] != "In-charge") {
    echo "<script>window.location.replace('/login/')</script>";
}
include '../../server.php';
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brew Base - Mange Product</title>
    <link rel="icon" type="image/x-icon" href="/img/brewbase.ico">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap.min.css">
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/navigation.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="/css/register.css">
    <link rel="stylesheet" href="/admin/styleadmin.css">

</head>
<body class="bg-color">
<?php require_once '../../navigation.php'?>
    <div class="alert-<?php if(isset($_SESSION['mode'])) {echo $_SESSION['mode'];} else {echo "success";}?>" id="notif">
                 <span><?php if(isset($_SESSION['message'])) {echo $_SESSION['message'];}?></span>
                </div>
    <div class="header-sub">
        <div class="content-text">
            <div class="text">
                <h1>Manage Product</h1>
                <p>Home / In-Charge / Manage Product</p>
            </div>
        </div>
        </div>
<div class="container table-responsive" style="margin: 30px auto;">
        <table id="products" class="table table-bordered table-hover" style="margin:auto;">
            <thead>
                <tr>
                    <th>Product #</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th class="col-sm-2">Option</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if(mysqli_num_rows($result)) {
                while($row = mysqli_fetch_assoc($result)) { $date = date_create($row['prod_date']);?>
                <tr>
                    <td class="prodno"><?=$row['prod_no']?></td>
                    <td>  
                <div class="profile" id="profile-id">
               <div class="prof-img" style="
                    margin: 20px auto;
                    width: 100px;
                    height: 100px;
                    border-radius: 10%;
                    background: url('../../productimg/<?php if($row['prod_img'] == NULL) {?>no-img.jpg<?php }  else { echo $row['prod_img']; }?>');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;"></td>
                    <td><?=$row['prod_name']?></td>
                    <td><?=$row['category']?></td>
                    <td><?=$row['prod_description']?></td>
                    <td><?=$row['status']?></td>
                    <td><?=date_format($date,"F d, Y")?></td>
                    <td>₱<?=$row['prod_price']?></td>
                    <td><i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Edit Product"></i><i class="fa fa-trash" data-toggle="tooltip" data-placement="bottom" title="Delete Product"></i>
                    <?php if($row['status'] == "Available") {?>
                        <i class="fa fa-times-circle unavailable" data-toggle="tooltip" data-placement="bottom" title="Set to Not Available">  
                        <?php } else { ?>
                            <i class="fa fa-check-circle available" data-toggle="tooltip" data-placement="bottom" title="Set to Available">  
                        <?php  }  ?>   </td>
                </tr>
                <?php 
                }
            } else {
                echo "<td colspan=9>No Transaction Yet</td>";
            }
                ?>
            </tbody>
            <tfoot>
                <tr>
                <th>Product #</th>
                    <th>PProduct Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Option</th>
                </tr>
            </tfoot>
        </table>
    </div>
<!-- Modal Delete -->
    <div id="del" class="modal-delete">
        <div class="delete-content">
        <div class="modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="fa fa-times"></i>
                    </div>						
                    <h4 class="modal-title">Delete Product</h4>	
                </div>
                <form action="" method="post">
                    <input type="hidden" name="prod_id" id="delete_id">
                <div class="modal-body">
                    <p style="font-weight: 500px">Are You Sure to Delete Product <span id="prdname" style="font-weight: 600"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel">Cancel</button>
                    <button name="delete" type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div> 
    </div>
<!--Modal Add/Update Product-->
    <div id="add" class="add-product">
    <div class="add-form">
        <!--Form-->
        <form id="productform" action="" method="post" enctype="multipart/form-data">
        
        <div class="add-content">
            <!--Insert an Image-->
            <div class="form-product ">     
                <div class="grid">
                    <div class="form-element">
                        <input type="hidden" name="prod_id" id="update_id">
                        <input type="file" id="file-1" name="prodpic" accept="image/*" >
                        <label for="file-1" id="file-1-preview">
                        <img id="img-src" src="../../img/insert-prod.png" alt="">
                        <div>
                        <span>+</span>
                    </div>
                    </label>
                    </div>
                </div>
            </div>

            <!--Product Name-->
            <div class="productinfo">
                <div class="reg-form-div " style="margin: auto;">
                    <input id="prodname" name="prodname" type="text" class="reg-form-input" placeholder=" "  required>
                    <label for="" class="reg-form-label">Product</label>     
                </div>
                <div class="reg-form-div " style="margin: 20px auto;">
                    <input id="prodate" name="date" type="date" class="reg-form-input" placeholder=" "  required>
                    <label for="" class="reg-form-label">Product Date</label> 
                        
                </div>
                <!--Product Category-->
                <div class="reg-form-div" style="margin: 20px auto;">
                    <select id="prodcat" class="selection" name="category" style="width: 180px;" required>
                        <option>Category</option>
                        <option value="Milk Tea" >Milk Tea</option>
                        <option value="Frappe" >Frappe</option>
                        <option value="Fruit Tea">Fruit Tea</option>
                        <option value="Hot Drinks">Hot Drinks</option>
                        <option value="Cold Drinks">Cold Drinks</option>
                        <option value="Lemonade">Lemonade</option>
                        <option value="Soya Drink">Soya Drink</option>
                        <option value="Soda Pops">Soda Pops</option>
                        <option value="Food">Food</option>
                    </select>   
                    <input style="width: 110px; margin-left: 190px;" id="price" name="price" step=".01" type="number" class="reg-form-input" placeholder=" "  required>
                    <label style="margin-left: 190px;" for="" class="reg-form-label">Price</label> 
                </div>
                <!--Product Description-->
                <div class="reg-form-div" style="margin: auto; height: 200px;">
                    <textarea id="desc" style="height: 200px;" name="description" type="text" class="reg-form-input" placeholder=" " required></textarea>
                    <label for="" class="reg-form-label">Product Description</label>     
                </div>
                <div style="display: flex; justify-content: center; margin-top: 20px;">
                    <button id="save" type="submit" name="addprod" class="btn btn-m" style="margin-right: 20px;">Add Product</button>
                    <button type="button" class="btn btn-m btn-red cancel">Cancel</button>
                </div>
            </div>
        
        </div>
        </form>
    </div>
    </div>
<!-- End modal update/add -->
<?php 
    if(isset($_POST['addprod'])) {
        $date = $_POST['date'];
        $prodname = $conn -> real_escape_string($_POST['prodname']);
        $category = $_POST['category'];
        $desc = $conn -> real_escape_string($_POST['description']);
        $price = $_POST['price'];
        $sql = "INSERT INTO product(category, prod_name, prod_description, prod_date, prod_price)
        VALUES('$category','$prodname','$desc','$date','$price')";

        $result = mysqli_query($conn, $sql);
        if($result) {
            if (isset($_FILES['prodpic'])) {
                $img_name = $_FILES['prodpic']['name'];
                $img_size = $_FILES['prodpic']['size'];
                $tmp_name = $_FILES['prodpic']['tmp_name'];
                $error = $_FILES['prodpic']['error'];
            
                if ($error === 0) {
                    if ($img_size > 4000000) {
                            $_SESSION['mode'] = "error";
                            $_SESSION['message'] = "Picture is Large. 4MB Only";
                            echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                            $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                            setTimeout(alert, 2000);
                            function alert() {
                                document.getElementById('notif').style.right = '-500px';
                            }</script>"; 
                            exit(0);
                    }else {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_lc = strtolower($img_ex);
            
                        $allowed_exs = array("jpg", "jpeg", "png", "jfif"); 
            
                        if (in_array($img_ex_lc, $allowed_exs)) {
                            $new_img_name = uniqid("product-", true).'.'.$img_ex_lc;
                            $img_upload_path = '../../productimg/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
            
                            // UPDATE into Database
                            $sql = "UPDATE product SET prod_img='$new_img_name' WHERE prod_name='$prodname'";
                            mysqli_query($conn, $sql);
     
                            $_SESSION['mode'] = "success";
                                    $_SESSION['message'] = "Product Inserted Successfully";
                                    echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                                    $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                                    setTimeout(alert, 2000);
                                    function alert() {
                                        document.getElementById('notif').style.right = '-500px';
                                    }</script>"; 
                                    exit(0);                          
                        }else {
                            $_SESSION['mode'] = "error";
                            $_SESSION['message'] = "Error Occured 2";
                            echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                            $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                            setTimeout(alert, 2000);
                            function alert() {
                                document.getElementById('notif').style.right = '-500px';
                            }</script>"; 
                            exit(0);
                        }
                    }
                }else {
                   
                }
            } 
            $_SESSION['mode'] = "success";
                $_SESSION['message'] = "Product Inserted Successfully";
                echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                setTimeout(alert, 2000);
                function alert() {
                    document.getElementById('notif').style.right = '-500px';
                }</script>"; 
                exit(0);
        }
           
    }
    if(isset($_POST['updateproduct'])) {
        $id = $_POST['prod_id'];
        $prodname = $conn -> real_escape_string($_POST['prodname']);
        $date = $_POST['date'];
        $category = $_POST['category'];
        $desc = $conn -> real_escape_string($_POST['description']);
        $price = $_POST['price'];
        $sql = "UPDATE product SET category = '$category', prod_name = '$prodname', prod_description = '$desc', prod_date = '$date', prod_price = '$price' WHERE prod_no = $id";

        $result = mysqli_query($conn, $sql);
        if($result) {
            if (isset($_FILES['prodpic'])) {
                $img_name = $_FILES['prodpic']['name'];
                $img_size = $_FILES['prodpic']['size'];
                $tmp_name = $_FILES['prodpic']['tmp_name'];
                $error = $_FILES['prodpic']['error'];
            
                if ($error === 0) {
                    if ($img_size > 4000000) {
                            $_SESSION['mode'] = "error";
                            $_SESSION['message'] = "Picture is Large. 4MB Only";
                            echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                            $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                            setTimeout(alert, 2000);
                            function alert() {
                                document.getElementById('notif').style.right = '-500px';
                            }</script>"; 
                            exit(0);
                    }else {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_lc = strtolower($img_ex);
            
                        $allowed_exs = array("jpg", "jpeg", "png"); 
            
                        if (in_array($img_ex_lc, $allowed_exs)) {
                            $new_img_name = uniqid("product-", true).'.'.$img_ex_lc;
                            $img_upload_path = '../../productimg/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
            
                            // UPDATE into Database
                            $sql = "UPDATE product SET prod_img='$new_img_name' WHERE prod_no = $id";
                            mysqli_query($conn, $sql);
     
                                    $_SESSION['mode'] = "success";
                                    $_SESSION['message'] = "Product Updated Successfully";
                                    echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                                    $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                                    setTimeout(alert, 2000);
                                    function alert() {
                                        document.getElementById('notif').style.right = '-500px';
                                    }</script>"; 
                                    exit(0);                          
                        }else {
                            $_SESSION['mode'] = "error";
                            $_SESSION['message'] = "Error Occured 3";
                            echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                            $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                            setTimeout(alert, 2000);
                            function alert() {
                                document.getElementById('notif').style.right = '-500px';
                            }</script>"; 
                            exit(0);
                        }
                    }
                }else {
                   
                }
            } 
            $_SESSION['mode'] = "success";
                $_SESSION['message'] = "Product Updated Successfully";
                echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                setTimeout(alert, 2000);
                function alert() {
                    document.getElementById('notif').style.right = '-500px';
                }</script>"; 
                exit(0);
        }
    }
    if(isset($_POST['delete'])) {
        $id = $_POST['prod_id'];
        $sql = "DELETE FROM product WHERE prod_no = $id";
        $result = mysqli_query($conn, $sql);
        if($result) {
            $sql1 = "ALTER TABLE product AUTO_INCREMENT = 1";
            $result1 = mysqli_query($conn, $sql1);
            if($result1) {
                $_SESSION['mode'] = "success";
                $_SESSION['message'] = "Product Deleted";
                echo "<script type='text/javascript'>window.location.replace('/incharge/product');</script>"; 
                $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                setTimeout(alert, 2000);
                function alert() {
                    document.getElementById('notif').style.right = '-500px';
                }</script>"; 
                exit(0);     
            }
        }
    }
    ?>
<?php 
if(isset($_SESSION['script'])) {

    echo $_SESSION['script'];
    unset($_SESSION['script']);
}
?>
<?php require_once '../../footer.php'?>
<!--Javascript for bootstrap-->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/jquery.slicknav.min.js"></script>
<script src="/js/jquery.countTo.min.js"></script>
<script src="/js/jquery.shuffle.min.js"></script>
<script src="/js/script.js"></script>
<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('#products').DataTable();
    $('.dataTables_length')
    .append('<button id="addprod" class="vkf4df btn-success" style="margin-left: 10px">Add Product</button>')
    $('#addprod').click(function () {
        $('#add').addClass('show')
        document.getElementById('save').textContent = "Add Product";
        $("#save").attr("name","addprod");
})
})
    //Update status
    $('.available').click(function () {
        var prodid = $(this).closest('tr').find('.prod_id').text();
        var prodname = $(this).closest('tr').find('.prodname').text();
        $.post('status.php', {available: prodid}, function(response) {
            if(response == "Available") {
                alert(prodname+" is Set to "+response);
                location.reload();
               
            }
        })
        
    }) 
    $('.unavailable').click(function () {
        var prodid = $(this).closest('tr').find('.prod_id').text();
        var prodname = $(this).closest('tr').find('.prodname').text();
        $.post('status.php', {unavailable: prodid}, function(response) {
            if(response == "Not Available") {
                alert(prodname+" is Set to "+response);
                location.reload();
            }
        })
    }) 
//Edit product=================
$('.available').click(function () {
    var data = $(this).closest('tr').children("td").map(function(){
    return $(this).text();
    }).get();
        $.post('status.php', {available: data[0]}, function(response) {
            if(response == "Available") {
                alert(data[3]+" is Set to "+response);
                location.reload();
               
            }
        })
        
    }) 
    $('.unavailable').click(function () {
    var data = $(this).closest('tr').children("td").map(function(){
    return $(this).text();
    }).get();
        $.post('status.php', {unavailable: data[0]}, function(response) {
            if(response == "Not Available") {
                alert(data[3]+" is Set to "+response);
                location.reload();
            }
        })
    }) 
$('.fa-edit').on('click', function () {
    document.getElementById('save').textContent = "Update Product";
    $("#save").attr("name","updateproduct");
    var data = $(this).closest('tr').children("td").map(function(){
    return $(this).text();
    }).get();
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {data: data[0]},
        success: function(response) {
           var data = JSON.parse(response)
           $('#img-src').attr('src', '/productimg/'+data.prodimg)
           $('#prodname').val(data.prodname)
           $('#prodate').val(data.date)
           $("#prodcat option[value='"+ data.category +"']").attr("selected", "selected")
           $('#price').val(data.price)
           $('#desc').val(data.desc)
           $('#add').addClass('show')
            $('#update_id').val(data.prodno)
           console.log(data)
        }
    })
})
//delete product==============
$('.fa-trash').on('click', function () {
    var data = $(this).closest('tr').children("td").map(function(){
    return $(this).text();
    }).get();
    $('#delete_id').val(data[0])
    $('#prdname').text(data[2])
    $('#del').addClass('show1')
})
/* $('tr').on('click', function() {
    var data = $(this).children("td").map(function(){
    return $(this).text();
    }).get();
    console.log(data);
}) */
//========================================================================
$('.cancel').click(function () {
    $('#del').removeClass('show1')
    $("#prodcat option").removeAttr("selected");
    $('#add').removeClass('show')
    $("#prodcat option").removeAttr("selected");
        $("#img-src").attr("src","/img/insert-prod.png");
        $('input').val(null)
        $('#desc').val(null)
    
})
    var modal = document.getElementById('add');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.classList.remove('show');
        $("#prodcat option").removeAttr("selected");
        $("#img-src").attr("src","/img/insert-prod.png");
        $('input').val(null)
        $('#desc').val(null)
    }
}
function previewBeforeUpload(id){
      document.querySelector("#"+id).addEventListener("change",function(e){
        if(e.target.files.length == 0){
          return;
        }
        let file = e.target.files[0];
        let url = URL.createObjectURL(file);
        document.querySelector("#"+id+"-preview div").innerText = file.name;
        document.querySelector("#"+id+"-preview img").src = url;
      });
    }
    
    previewBeforeUpload("file-1");
    </script>
</body>
</html>