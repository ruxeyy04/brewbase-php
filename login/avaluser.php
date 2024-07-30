<?php
include '../server.php';
if(isset($_POST) && !empty($_POST))
{
    $username = $_POST['username'];
    $sql = "SELECT * FROM userinfo WHERE username = '$username'";
    $result=mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
   
    if($count > 0) {
       echo '<div style="color: red;"><b>'.$username.'</b> is not Available </div>
       <script>
       document.getElementById("save").disabled = true;
        document.getElementById("username").style.borderColor = "#f52d2d";
        </script>';
    } else {
       echo '<div style="color: green;"><b>'.$username.'</b> is Available </div>
       <script>
       document.getElementById("save").disabled = false;
        document.getElementById("username").style.borderColor = "#4fee27";
       </script>';
    }
   }
?>