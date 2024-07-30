<?php 
session_start();
if(!isset($_SESSION['usertype'])) {
 echo "<script>window.location.replace('/login/')</script>";
}
if($_SESSION['usertype'] != "Admin") {
    echo "<script>window.location.replace('/login/')</script>";
}
include '../../server.php';
$sql = "SELECT a.profile_img, a.id, a.fname, a.lname, b.username, b.password, b.usertype
FROM person a
INNER JOIN userinfo b
ON a.id=b.id";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brew Base - Manage User</title>
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
    <link rel="stylesheet" href="/admin/styleadmin.css">

</head>
<body class="bg-color">
    <?php require_once '../../navigation.php'?>
    <div class="header-sub">
        <div class="content-text">
            <div class="text">
                <h1>Manage User</h1>
                <p>Home / Admin / Transactions</p>
            </div>
        </div>
        </div>
<div class="container table-responsive" style="margin: 30px auto;">
        <table id="transactions" class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Profile Picture</th>
                    <th>Customer ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              <?php 
                if(mysqli_num_rows($result)) {
                while($row = mysqli_fetch_assoc($result)) {?>
                <tr>
                    <td class="userid"><?=$row['id']?></td>
                    <td>  <div class="profile" id="profile-id">
               <div class="prof-img" style="
                    margin: 20px auto;
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    background: url('../../profilepic/<?php if($row['profile_img'] == NULL) {?>default-pic.png<?php }  else { echo $row['profile_img']; }?>');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;">
                </div></td>          
                    <td><?=$row['fname']?> <?=$row['lname']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['password']?></td>
                    <td><?=$row['usertype']?></td>
                    <td>
                    <?php if($row['usertype'] == "Customer") {
                        echo '<button class="vkf4df btn-success promoteincharge" style="margin: 10px">Promote In-charge</button>';
                    } elseif ($row['usertype'] == "Admin") {
                        echo '<button class="vkf4df btn-danger removeadmin" style="margin: 10px">Remove Admin</button>';
                    } elseif($row['usertype'] == "In-charge") {
                        echo '<button class="vkf4df btn-danger demoteincharge" >Demote In-charge</button> <br>';
                        echo '<button class="vkf4df btn-success promoteadmin" style="margin: 10px">Promote Admin</button>';
                    } 
                    ?> 
                   
                     <br>
                    <button class="vkf4df btn-info viewaccount">View Account Info</button><br>
                </td>
                </tr>
                <?php 
                }
            } else {
                echo "<td colspan=7>No Transaction Yet</td>";
            }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Profile Picture</th>
                    <th>Customer ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>

<!-- Modal Profile Order -->
  <div class="modal fade" id="profile" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span id="fullname">NULL</span> Profile Info</h4>
        </div>
        <div class="modal-body track-body">
        <!--  -->

        <div class="col-sm-12 well well-sm">
        <div class="profile" id="profile-id">
                <div class="prof-img1" style="
                        margin: 10px auto;
                        width: 150px;
                        height: 150px;
                        border-radius: 50%;
                        background: url('../../profilepic/default-pic.png');
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;">
                    </div>
            </div>
        <div class="col-sm-4">
        <h3>Name</h3>
            <hr style="border: 1px solid black;">
            <strong>First Name: </strong><span id="fname">N/A</span><br>
            <strong>Last Name: </strong><span id="lname">N/A</span><br>
            <strong>Middle Initial: </strong><span id="midinit">N/A</span>
        
        </div>
        <div class="col-sm-4">
        <h3>Details</h3>
            <hr style="border: 1px solid black;">
            <strong>Gender: </strong><span id="gender">N/A</span><br>
            <strong>Birth Date: </strong><span id="birthdate">N/A</span><br>
            <strong>Contact No: </strong><span id="contactno">N/A</span><br>
            <strong>Email Address: </strong><span id="email">N/A</span>
        </div>
           <div class="col-sm-4">
           <h3>Address</h3>
            <hr style="border: 1px solid black;">
            <strong>Street: </strong><span id="street">N/A</span><br>
            <strong>Barangay: </strong><span id="barangay">N/A</span><br>
            <strong>City: </strong><span id="city">N/A</span><br>
            <strong>Province: </strong><span id="province">N/A</span><br>
            <strong>Postal Code: </strong><span id="postal">N/A</span><br>
            <strong>Country: </strong><span id="country">N/A</span><br>
           </div>

        </div>

           
            
        <!--  -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- End Profile -->
<?php require_once '../../footer.php'?>
<!--Javascript for bootstrap-->

<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/jquery.slicknav.min.js"></script>
<script src="/js/jquery.countTo.min.js"></script>
<script src="/js/jquery.shuffle.min.js"></script>
<script src="/js/script.js"></script>
<script>

//=============== viewaccount
 
$('.viewaccount').click(function () {
    var userid = $(this).closest('tr').find('.userid').text();
    var url = $(this).closest('tr').find('.prof-img').css('background-image');
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {viewprofile: userid},
        success: function(response) {
            var info = JSON.parse(response)     
            $('.prof-img1').css('background-image', url);
            $('#fullname').text(info.fname + ' ' + info.lname);
            $('#fname').text(info.fname);
            $('#lname').text(info.lname);
            $('#midinit').text(info.midinit);
            $('#gender').text(info.gender);
            $('#birthdate').text(info.birthdate);
            $('#contactno').text(info.contactno);
            $('#email').text(info.email);
            $('#street').text(info.street);
            $('#barangay').text(info.barangay);
            $('#city').text(info.city);
            $('#province').text(info.province);
            $('#postal').text(info.postal);
            $('#country').text(info.country);
            $('#profile').modal()
        }
    })
})
//===============promoteincharge
$('.promoteincharge').click(function () {
    var userid = $(this).closest('tr').find('.userid').text();
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {promoteincharge: userid},
        success: function() {
            location.reload();
        }
    })
})
//=================removeadmin
$('.removeadmin').click(function () {
    var userid = $(this).closest('tr').find('.userid').text();
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {removeadmin: userid},
        success: function() {
            location.reload();
        }
    })
})
//================demoteincharge
$('.demoteincharge').click(function () {
    var userid = $(this).closest('tr').find('.userid').text();
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {demoteincharge: userid},
        success: function() {
            location.reload();
        }
    })
})
//================promoteadmin
$('.promoteadmin').click(function () {
    var userid = $(this).closest('tr').find('.userid').text();
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {promoteadmin: userid},
        success: function() {
            location.reload();
        }
    })
})
//===================================
$(document).ready(function() {
    $('#transactions').DataTable();
} );

</script>
</body>
</html>