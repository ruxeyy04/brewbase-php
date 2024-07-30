<?php session_start();
include '../server.php';

if(!isset($_SESSION['username'])) {
    echo "<script type='text/javascript'>window.location.replace('/login'); </script>"; 
}
$birth = $_SESSION['birthdate'];
$date = date_create("$birth");

/*
 $_SESSION["id"] = $row["id"];
 $_SESSION["username"] = $row["username"];
 $_SESSION["password"] = $row["password"];
 $_SESSION["usertype"] = $row["usertype"];
 $_SESSION["useremail"] = $row["email"];
 $_SESSION['fname'] = $row1["fname"];
 $_SESSION['lname'] = $row1["lname"];
 $_SESSION['midinit'] = $row1["mid_init"];
 $fname = $_SESSION['fname'];
 $lname = $_SESSION['lname'];
 $midinit = $_SESSION['midinit'];
 $_SESSION['contact'] = $row1["contact_no"];
 $_SESSION['gender'] = $row1["gender"];
 $_SESSION['birthdate'] = $row1["birthdate"];
 $_SESSION['street'] = $row1["street"];
 $_SESSION['barangay'] = $row1["barangay"];
 $_SESSION['city'] = $row1["city"];
 $_SESSION['province'] = $row1["province"];
 $_SESSION['country'] = $row1["country"];
 $_SESSION['postalcode'] = $row1["postalcode"];
 $_SESSION['profileimg'] = $row1["profile_img"];
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=3, user-scalable=yes, minimal-ui">
    <link rel="icon" type="image/x-icon" href="/img/brewbase.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Brew Base -  Profile</title>
</head>
<body>

<?php require_once '../navigation.php';?>
    <div class="alert-<?php if(isset($_SESSION['mode'])) {echo $_SESSION['mode'];} else {echo "success";}?>" id="notif">
                 <span><?php if(isset($_SESSION['message'])) {echo $_SESSION['message'];}?></span>
                </div>
<div class="header-sub">
<div class="content-text">
    <div class="text">
        <h1>Profile</h1>
        <p>Home / Account</p>
    </div>
</div>
</div>
  
<div class="container">

    <div class="main">
        <div class="row">
    
           <div class="profile" id="profile-id">
               <div class="prof-img" style="
                    margin: 20px auto;
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                    background: url('../profilepic/<?php if($_SESSION['profileimg'] == NULL) {?>default-pic.png<?php }  else { echo $_SESSION['profileimg']; }?>');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;">
                </div>
    <form action="" method="post" id="form1" enctype="multipart/form-data">
            <div class="form-profile none">
                
                <div class="grid">
                  <div class="form-element">
                      <input type="file" id="file-1" name="mypic" accept="image/*" >
                    <label for="file-1" id="file-1-preview">
                      <img src="../profilepic/<?php if($_SESSION['profileimg'] == NULL) {?>default-pic.png<?php }  else { echo $_SESSION['profileimg']; }?>" alt="">
                      <div>
                        <span>+</span>
                      </div>
                    </label>
                  </div>
                  </div>
                
                  </div>
               <div class="prof-content">
                   <h3><?php 
                    if($_SESSION['gender'] == "Male") {
                        $prefix = "Mr.";
                    } elseif($_SESSION['gender'] == "Female") {
                        $prefix = "Ms.";
                    } else {
                        $prefix = "";
                    }
                   echo $prefix," ", $_SESSION['fname']," ", $_SESSION['midinit']," ", $_SESSION['lname'];
                   
                   ?></h3>
                   <button id="edit-profile" type="button" >Edit Info</button>
                   <button id="change-pass" type="button">Change Password</button>
                   <button id="change-pic" name="save-pic" type="button" class="" style="width:200px">Change Profile Picture</button>
                   <button id="cancel-pic" type="button" class="none">Cancel</button>
                   </form> 
                   <?php 
                   //Profile Picture
                   if(isset($_POST['save-pic'])) {
                    if (isset($_FILES['mypic'])) {
                        $id = $_SESSION['id'];
                        $img_name = $_FILES['mypic']['name'];
                        $img_size = $_FILES['mypic']['size'];
                        $tmp_name = $_FILES['mypic']['tmp_name'];
                        $error = $_FILES['mypic']['error'];
                    
                        if ($error === 0) {
                            if ($img_size > 4000000) {
                                $_SESSION['profileimg'] = $new_img_name;
                                    $_SESSION['mode'] = "error";
                                    $_SESSION['message'] = "Picture is Large. 4Mb Only";
                                    echo "<script type='text/javascript'>window.location.replace('/profile');</script>"; 
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
                                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                                    $img_upload_path = '../profilepic/'.$new_img_name;
                                    move_uploaded_file($tmp_name, $img_upload_path);
                    
                                    // UPDATE into Database
                                    $sql = "UPDATE person SET profile_img='$new_img_name' WHERE id='$id'";
                                    mysqli_query($conn, $sql);
                                    
                                    $_SESSION['profileimg'] = $new_img_name;
                                    $_SESSION['mode'] = "success";
                                    $_SESSION['message'] = "Profile Picture Changed";
                                    echo "<script type='text/javascript'>window.location.replace('/profile');</script>"; 
                                    $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                                    setTimeout(alert, 2000);
                                    function alert() {
                                        document.getElementById('notif').style.right = '-500px';
                                    }</script>"; 
                                    exit(0);
                                }else {
                                    $em = "Error2";
                                    header("Location: ?error=$em");
                                
                                }
                            }
                        }else {
                            $_SESSION['profileimg'] = $new_img_name;
                                    $_SESSION['mode'] = "error";
                                    $_SESSION['message'] = "Error Occured";
                                    echo "<script type='text/javascript'>window.location.replace('/profile');</script>"; 
                                    $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                                    setTimeout(alert, 2000);
                                    function alert() {
                                        document.getElementById('notif').style.right = '-500px';
                                    }</script>"; 
                                    exit(0);
                        }
                    } else {
                        $_SESSION['profileimg'] = $new_img_name;
                                    $_SESSION['mode'] = "error";
                                    $_SESSION['message'] = "No Picture Inserted";
                                    echo "<script type='text/javascript'>window.location.replace('/profile');</script>"; 
                                    $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                                    setTimeout(alert, 2000);
                                    function alert() {
                                        document.getElementById('notif').style.right = '-500px';
                                    }</script>"; 
                                    exit(0);
                    }
                   }
                   
                   ?>
               </div>
               <div class="change-pass none animate">
                <form action="" method="post" id="form3">
                <div class="reg-form-div">
                    <input id="oldpass" type="hidden" value="<?=$_SESSION['password']?>"  >
                    <input id="oldpass1" name="oldpassword" type="password" class="reg-form-input" placeholder=" " onkeyup="checkOldPass()" required>
                    <label for="" class="reg-form-label">Old Password</label>     
                </div>
                
                <div class="reg-form-div">
                    <input id ="password" type="password" class="reg-form-input" placeholder=" " onkeyup="checkPass()" required>
                    <label for="" class="reg-form-label">New Password</label>     
                </div>
                <div class="reg-form-div">
                    <input id="confirm_password" name="password" type="password" class="reg-form-input" onkeyup="checkPass()" placeholder=" " required>
                    <label for="" class="reg-form-label">Confirm Password</label>     
                </div>
                <div class="reg-form-div">
                    <button id="change-pass1" name="change-pass" type="submit">Update</button>
                    <button id="cancel" type="button">Cancel</button>
                </div>
                </form>
                <?php 
                if(isset($_POST['change-pass'])) {
                    $id = $_SESSION['id'];
                    $pass = $_POST['password'];
                    $sql = "UPDATE userinfo SET password='$pass' WHERE id='$id'";
                    $result = mysqli_query($conn, $sql);

                    if($result) {
                        $_SESSION['password'] = $pass;
                                    $_SESSION['mode'] = "success";
                                    $_SESSION['message'] = "Password Changed";
                                    echo "<script type='text/javascript'>window.location.replace('/profile');</script>"; 
                                    $_SESSION['script'] =  "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                                    setTimeout(alert, 2000);
                                    function alert() {
                                        document.getElementById('notif').style.right = '-500px';
                                    }</script>"; 
                                    exit(0);
                                   
                    }

                }
                
                
                
                ?>
               </div>
           </div>
           
           <div class="profile-info">
            <form action="" method="post" id="form2">
               <h2 class="text-center">Account Personal Info</h2>
               <hr>
                <div class="info">
                    <h3>Name</h3> 
                    <div class="col-md-3">
                        <h4>Username</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input name="username" id="input" class="no-outline" type="text" value="<?=$_SESSION['username']?>" readonly></h4>
                    </div>
                    <div class="col-md-3">
                        <h4>First Name</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input name="fname" id="input" class="no-outline" type="text" value="<?=$_SESSION['fname']?>" readonly></h5>
                    </div>
                    <div class="col-md-3">
                        <h4>Middle Initial</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input style="width: 40px;" name="midinit" id="input" class="no-outline" type="text" value="<?=$_SESSION['midinit']?>" readonly></h4>
                    </div>
                    <div class="col-md-3">
                        <h4>Last Name</h5>
                    </div>
                    <div class="col-md-9" style="margin-bottom: 20px;">
                        <h4><input name="lname" id="input" class="no-outline" type="text" value="<?=$_SESSION['lname']?>" readonly></h4>
                    </div>
                    <h3>Details</h3>   
                    <div class="col-md-3">
                        <h4>Gender</h4>
                    </div>
                    <div class="col-md-9">
                        <h4 style="margin-left: 10px;"><select name="gender" id="select" disabled>
                            <option value="Male" <?=$_SESSION['gender'] == 'Male' ? ' selected="selected"' : '';?>>Male</option>
                            <option value="Female" <?=$_SESSION['gender'] == 'Female' ? ' selected="selected"' : '';?>>Female</option>
                            <option value="Untold" <?=$_SESSION['gender'] == 'Untold' ? ' selected="selected"' : '';?>>Rather not to Say</option>
                        </select></h4>
                    </div>
                    <div class="col-md-3">
                        <h4>Birth Date:</h5>
                    </div>
                    <div class="col-md-9">
                        <h4 style="margin-left: 10px;">Month: <select name="month" id="select"  disabled>
                            <option value="01" <?=date_format($date,"m") == '01' ? ' selected="selected"' : '';?>>January</option>
                            <option value="02" <?=date_format($date,"m") == '02' ? ' selected="selected"' : '';?>>February</option>
                            <option value="03" <?=date_format($date,"m") == '03' ? ' selected="selected"' : '';?>>March</option>
                            <option value="04" <?=date_format($date,"m") == '04' ? ' selected="selected"' : '';?>>April</option>
                            <option value="05" <?=date_format($date,"m") == '05' ? ' selected="selected"' : '';?>>May</option>
                            <option value="06" <?=date_format($date,"m") == '06' ? ' selected="selected"' : '';?>>June</option>
                            <option value="07" <?=date_format($date,"m") == '07' ? ' selected="selected"' : '';?>>July</option>
                            <option value="08" <?=date_format($date,"m") == '08' ? ' selected="selected"' : '';?>>August</option>
                            <option value="09" <?=date_format($date,"m") == '09' ? ' selected="selected"' : '';?>>September</option>
                            <option value="10" <?=date_format($date,"m") == '10' ? ' selected="selected"' : '';?>>October</option>
                            <option value="11" <?=date_format($date,"m") == '11' ? ' selected="selected"' : '';?>>November</option>
                            <option value="12" <?=date_format($date,"m") == '12' ? ' selected="selected"' : '';?>>December</option>
                        </select>
                    </h4>
                        <h4 style="margin-left: 10px;">Day:<input style="width: 40px;" name="day" id="input" class="no-outline" type="number" value="<?=date_format($date,"d")?>" min="1" max="31" readonly></h4>
                        <h4 style="margin-left: 10px;">Year: <input style="width: 70px;" name="year" id="input" class="no-outline" type="number" value="<?=date_format($date,"Y")?>" min="1920" readonly></h4>
                    </div>
                    <div class="col-md-3">
                        <h4>Contact No.</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input name="contactno" id="input" class="no-outline" type="text" value="<?=$_SESSION['contact']?>" readonly></h5>
                    </div>
                    <div class="col-md-3">
                        <h4>Email Address</h5>
                    </div>
                    <div class="col-md-9" style="margin-bottom: 20px;">
                        <h4><input style="width: 250px;" name="email" id="input" class="no-outline" type="text" value="<?=$_SESSION['useremail']?>" readonly></h5>
                    </div>
                    <h3>Address</h3>   
                    <div class="col-md-3">
                        <h4>Street</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input name="street" id="input" class="no-outline" type="text" value="<?=$_SESSION['street']?>" readonly></h5>
                    </div>
                    <div class="col-md-3">
                        <h4>Barangay</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input name="barangay" id="input" class="no-outline" type="text" value="<?=$_SESSION['barangay']?>" readonly></h4>
                    </div>
                    <div class="col-md-3">
                        <h4>City</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input name="city" id="input" class="no-outline" type="text" value="<?=$_SESSION['city']?>" readonly></h4>
                    </div>
                    <div class="col-md-3">
                        <h4>Province</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input name="province" id="input" class="no-outline" type="text" value="<?=$_SESSION['province']?>" readonly></h4>
                    </div>
                    <div class="col-md-3">
                        <h4>Postal Code</h5>
                    </div>
                    <div class="col-md-9">
                        <h4><input style="width: 90px;" name="postalcode" id="input" class="no-outline" type="text" value="<?=$_SESSION['postalcode']?>" readonly></h4>
                    </div>
                    <div class="col-md-3">
                        <h4>Country</h5>
                    </div>
                    <div class="col-md-9">
                        <h4 style="margin-left: 10px;"><select name="country" id="select" disabled>
                            <option value="<?=$_SESSION['country']?>"><?=$_SESSION['country']?></option>
                            <option value="Afganistan">Afghanistan</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bonaire">Bonaire</option>
                            <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Canary Islands">Canary Islands</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Channel Islands">Channel Islands</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos Island">Cocos Island</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote DIvoire">Cote DIvoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Curaco">Curacao</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="East Timor">East Timor</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands">Falkland Islands</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Ter">French Southern Ter</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Great Britain">Great Britain</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="India">India</option>
                            <option value="Iran">Iran</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea North">Korea North</option>
                            <option value="Korea Sout">Korea South</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Laos">Laos</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libya">Libya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macau">Macau</option>
                            <option value="Macedonia">Macedonia</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Midway Islands">Midway Islands</option>
                            <option value="Moldova">Moldova</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Nambia">Nambia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherland Antilles">Netherland Antilles</option>
                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                            <option value="Nevis">Nevis</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau Island">Palau Island</option>
                            <option value="Palestine">Palestine</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Pitcairn Island">Pitcairn Island</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                            <option value="Republic of Serbia">Republic of Serbia</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russia">Russia</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="St Barthelemy">St Barthelemy</option>
                            <option value="St Eustatius">St Eustatius</option>
                            <option value="St Helena">St Helena</option>
                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                            <option value="St Lucia">St Lucia</option>
                            <option value="St Maarten">St Maarten</option>
                            <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                            <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                            <option value="Saipan">Saipan</option>
                            <option value="Samoa">Samoa</option>
                            <option value="Samoa American">Samoa American</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syria">Syria</option>
                            <option value="Tahiti">Tahiti</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania">Tanzania</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Erimates">United Arab Emirates</option>
                            <option value="United States of America">United States of America</option>
                            <option value="Uraguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Vatican City State">Vatican City State</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Vietnam">Vietnam</option>
                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                            <option value="Wake Island">Wake Island</option>
                            <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zaire">Zaire</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                        </select></h4>
                    </div>
                    
                </div>

                
                <button id="btn1"  name="update-profile" type="submit">Update</button>
                <button id="btn2"  type="button">Cancel</button>
            </form>
            <?php 
            if(isset($_POST['update-profile'])) {
                $id = $_SESSION['id'];
                $user = $_POST['username'];
                $fname = $_POST['fname'];
                $midinit = $_POST['midinit'];
                $lname = $_POST['lname'];
                $gender = $_POST['gender'];
                $month = $_POST['month'];
                $day = $_POST['day'];
                $year = $_POST['year'];
                $contact = $_POST['contactno'];
                $email = $_POST['email'];
                $street = $_POST['street'];
                $barangay = $_POST['barangay'];
                $city = $_POST['city'];
                $province = $_POST['province'];
                $postal = $_POST['postalcode'];
                $country = $_POST['country'];

                $sql = "UPDATE person SET 
                fname = '$fname', lname = '$lname', mid_init = '$midinit', contact_no = '$contact', 
                gender = '$gender', birthdate = '$year-$month-$day', street = '$street', barangay = '$barangay', city = '$city', 
                province = '$province', postalcode = '$postal', country = '$country' WHERE id = $id";

                $sql1 = "UPDATE userinfo SET username = '$user' WHERE id = $id";

                $result = mysqli_query($conn, $sql);

                if($result) {
                    $result1 = mysqli_query($conn, $sql1);
                    if($result1) {
                        //Success Query
                        $_SESSION["username"] = $user;
                        $_SESSION["useremail"] = $email;
                        $_SESSION['fname'] = $fname;
                        $_SESSION['lname'] = $lname;
                        $_SESSION['midinit'] = $midinit;
                        $_SESSION['contact'] = $contact;
                        $_SESSION['gender'] = $gender;
                        $_SESSION['birthdate'] = "$year-$month-$day";
                        $_SESSION['street'] = $street;
                        $_SESSION['barangay'] = $barangay;
                        $_SESSION['city'] = $city;
                        $_SESSION['province'] = $province;
                        $_SESSION['country'] = $country;
                        $_SESSION['postalcode'] = $postal;
                            $_SESSION['mode'] = "success";
                            $_SESSION['message'] = "Profile Info Updated";
                            echo "<script type='text/javascript'>window.location.replace('/profile');</script>"; 
                            $_SESSION['script'] =  
                            "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                            setTimeout(alert, 2000);
                            function alert() {
                            document.getElementById('notif').style.right = '-500px';
                            }</script>"; 
                             exit(0);
                    } else {
                        //Error on Sql1
                        $_SESSION['mode'] = "error";
                        $_SESSION['message'] = "Error Occured";
                        echo "<script type='text/javascript'>window.location.replace('/profile');</script>"; 
                        $_SESSION['script'] =  
                        "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                            setTimeout(alert, 2000);
                            function alert() {
                            document.getElementById('notif').style.right = '-500px';
                            }</script>"; 
                             exit(0);
                    }
                } else {
                    //Error on Sql
                    $_SESSION['mode'] = "error";
                    $_SESSION['message'] = "Error Occured";
                    echo "<script type='text/javascript'>window.location.replace('/profile');</script>"; 
                    $_SESSION['script'] =  
                    "<script type='text/javascript'>document.getElementById('notif').style.right = '0px';
                        setTimeout(alert, 2000);
                        function alert() {
                        document.getElementById('notif').style.right = '-500px';
                        }</script>"; 
                         exit(0);
                }
            } 
            
            
            ?>
            </div> 
            
            
        
        </div>
    
    </div>

</div>
<?php 
if(isset($_SESSION['script'])) {

    echo $_SESSION['script'];
    unset($_SESSION['script']);
}
?>
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
<!--Javascript for bootstrap-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-select.min.js"></script>
<script src="../js/jquery.slicknav.min.js"></script>
<script src="../js/jquery.countTo.min.js"></script>
<script src="../js/jquery.shuffle.min.js"></script>
<script src="../js/script.js"></script>
<script> 
    //To Edit the Profile Picture
    document.getElementById('change-pic').onclick = function() {
        document.getElementById('edit-profile').classList.add('none');
        document.getElementById('change-pass').classList.add('none');
        document.getElementById('cancel-pic').classList.remove('none');
        document.getElementById('change-pic').textContent = "Save Picture";
        document.getElementsByClassName('prof-img')[0].classList.add('none');
        document.getElementsByClassName('form-profile')[0].classList.remove('none');
        
        setTimeout(submit, 500);

    }
    document.getElementById('cancel-pic').onclick = function() {
        document.getElementById('change-pic').type = "button";
        document.getElementById('edit-profile').classList.remove('none');
        document.getElementById('change-pass').classList.remove('none');
        document.getElementById('cancel-pic').classList.add('none');
        document.getElementById('change-pic').textContent = "Change Profile Picture";
        document.getElementsByClassName('prof-img')[0].classList.remove('none');
        document.getElementsByClassName('form-profile')[0].classList.add('none');
        
    }
    function submit() {
        document.getElementById('change-pic').type = "submit";
    }
    //To Check the Old Password
    function checkOldPass() {
if (document.getElementById('oldpass').value == document.getElementById('oldpass1').value) {
        document.getElementById('change-pass1').disabled = false;
        document.getElementById('oldpass1').style.borderColor = '#4fee27';
	} else {
		document.getElementById('change-pass1').disabled = true;
        document.getElementById('oldpass1').style.borderColor = '#f52d2d';
	}
}
//To Check the New Password
    function checkPass() {
if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
        document.getElementById('change-pass1').disabled = false;
        document.getElementById('password').style.borderColor = '#4fee27';
        document.getElementById('confirm_password').style.borderColor = '#4fee27';
	} else {
		document.getElementById('change-pass1').disabled = true;
        document.getElementById('password').style.borderColor = '#f52d2d';
        document.getElementById('confirm_password').style.borderColor = '#f52d2d';
	}
}
//To Edit the Profile
    var input = document.getElementById("input");
    var btn = document.getElementById("btn1");
    var edit = document.getElementById("edit-profile");
    var select = document.getElementById("select");
    edit.onclick = function() {
        $("input").removeClass("no-outline");
        $("input").removeAttr("readonly");
        $("select").removeAttr("disabled");
        $("#btn1").css("display", "block");
        $("#btn2").css("display", "block");
        document.getElementById("change-pic").classList.add("none");
        document.getElementById("change-pass").classList.add("none");
    
   
    }
    document.getElementById("btn2").onclick = function() {
        $("input").addClass("no-outline");
        $("input").attr("readonly", true);
        $("select").attr("disabled", true);
        $("#btn1").css("display", "none");
        $("#btn2").css("display", "none");
        document.getElementById("change-pic").classList.remove("none");
        document.getElementById("change-pass").classList.remove("none");
    }
//To Change the Password
    document.getElementById("change-pass").onclick = function() {
        document.getElementById("profile-id").style.height = "550px";
        $("#oldpass1").attr("readonly", false);
        $("#password").attr("readonly", false);
        $("#confirm_password").attr("readonly", false);
        setTimeout(removeNone, 500);
        document.getElementById("change-pic").classList.add("none");
        document.getElementById("edit-profile").classList.add("none");
    }
    function removeNone () {
        document.getElementsByClassName("change-pass")[0].classList.remove("none");
    }
    document.getElementById("cancel").onclick = function() {
        document.getElementById("profile-id").style.height = "360px";
        document.getElementsByClassName("change-pass")[0].classList.add("none");
        document.getElementById("change-pic").classList.remove("none");
        document.getElementById("edit-profile").classList.remove("none");
        
    }
//Preview Picture
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