<?php session_start();
include '../server.php';
if(isset($_POST['signin'])) {
    $user = $conn -> real_escape_string($_POST["username"]);
    $pass = $conn -> real_escape_string($_POST["password"]);
    $email = $conn -> real_escape_string($_POST["username"]);

    $sql = "SELECT * FROM userinfo WHERE username='$user' OR BINARY email='$email' AND BINARY password='$pass'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        if($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["password"] = $row["password"];
            $_SESSION["usertype"] = $row["usertype"];
            $_SESSION["useremail"] = $row["email"];

            $sql1 = "SELECT * FROM person WHERE id='$id'";
            $result1 = $conn->query($sql1);

            if($result1->num_rows > 0) {
                if($row1 = $result1->fetch_assoc()) {
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

                    if($_SESSION['gender'] == "Male") {
                        $prefix = "Mr.";
                    } elseif($_SESSION['gender'] == "Female") {
                        $prefix = "Ms.";
                    } else {
                        $prefix = "";
                    }
                    $message = "Welcome, $prefix $fname $midinit $lname
                    <meta http-equiv='refresh' content='2; URL=/' />";
                }
            }

        }
    } else {
        $message = 'Wrong Username or Password
            <meta http-equiv="refresh" content="2; URL=/login" />';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/navigation.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/register.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Login</title>
</head>
<body style="background: rgba(255, 221, 170, 0.5);">
<?php require_once '../navigation.php'; ?>

<div class="l-form">
    <form action="" method="post" class="form">
        <?php if(!isset($_POST['signin'])) { ?>
        <h1 class="formtitle t-c">Sign In</h1>
        <div class="formdiv">
            <input type="text" name="username" class="forminput bdr-default" placeholder=" ">
            <label for="" class="formlabel">Email or Username</label>
        </div>
        <div class="formdiv">
            <input type="password" name="password" class="forminput bdr-default" placeholder=" ">
            <label for="" class="formlabel">Password</label>
        </div>
        <div class="flex j-c">
            <button name="signin" type="submit" class="btn btn-m">Sign In</button>
        </div>
        <div class="flex j-c" style="margin-top:2rem;">
            <button type="button" id="createacc" class="btn-create-account">Create an Account</button>
        </div>
        <?php } else { ?>
            <h2 class="t-c"><?=$message ?></h2>
            <?php } ?>
    </form>
</div>
<!--Regitration form Modal-->
    <div class="register" id="modal-register">
        <form action="" class="register-form" enctype="multipart/form-data" method="post">
            <h1 class="formtitle t-c">Register an Account</h1>
            <div class="form-profile">
                <div class="grid">
                  <div class="form-element">
                    <input type="file" id="file-1" name="my_pic" accept="image/*">
                    <label for="file-1" id="file-1-preview">
                      <img src="../profilepic/default-pic.png" alt="">
                      <div>
                        <span>+</span>
                      </div>
                    </label>
                  </div>
                  </div>
                  </div>
                  <h1 class="reg-form-title t-c">User Account</h1>
        <div class="row-form">
            <div class="reg-form-div">
                <input name="user" id="username" type="text" class="forminput bdr-default" placeholder=" " >
                <label for="" class="formlabel">Username</label>
                
            </div>
            
        </div>
        <div class="row-form">
            <span id="usernameLoading"></span>
            <span id="usernameResult"></span>
        </div>
        <div class="row-form">
            <div class="reg-form-div">
                <input id="password" type="password" class="forminput bdr-default" placeholder=" " onkeyup="check_pass()">
                <label id="label" for="" class="formlabel">Password</label>
            </div>
        </div>
        <div class="row-form"  style="margin-bottom: 20px;">
            <div class="reg-form-div">
                <input name="pass" id="confirm_password" type="password" class="forminput bdr-default" placeholder=" " onkeyup="check_pass()">
                <label id="label1" for="" class="formlabel">Confirm Password</label>
            </div>
        </div>
                  <h1 class="reg-form-title t-c">Customer's Full Name</h1>
    <div class="row-form">
            <div class="reg-form-div">
                <input name="fname" type="text" class="reg-form-input" placeholder=" " required>
                <label for="" class="reg-form-label">First Name</label>     
            </div>
            <div class="reg-form-div">
                <input name="lname" type="text" class="reg-form-input" placeholder=" " required>
                <label for="" class="reg-form-label">Last Name</label>     
            </div>
            <div class="reg-form-div">
                <input name="midinit" type="text" class="reg-form-input" placeholder=" ">
                <label for="" class="reg-form-label">Middle Initial</label>     
            </div>
            <div class="reg-form-div" style="width: 200px;">
                <select class="selection" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Untold">Rather Not to Say</option>
                </select>   
            </div>
        </div>
        <h1 class="reg-form-title t-c">Birth Date</h1>
        <div class="row-form">
    
        <div class="reg-form-div" style="width: 200px;">
            <select class="selection" name="month" required>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
        <div class="reg-form-div" style="max-width: 150px;">
            <input name="day" type="number" class="reg-form-input" placeholder=" " style="max-width: 150px;" min="1" max="31" required>
            <label for="" class="reg-form-label">Day</label>     
        </div>
        <div class="reg-form-div" style="max-width: 150px;">
            <input name="year" type="number" class="reg-form-input" placeholder=" " style="max-width: 150px;" min="1920" required>
            <label for="" class="reg-form-label">Year</label>     
        </div>
    </div>
    <h1 class="reg-form-title t-c">Address Information</h1>
    <div class="row-form">
        <div class="reg-form-div">
            <input name="street" type="text" class="reg-form-input" placeholder=" " >
            <label for="" class="reg-form-label">Street</label>     
        </div>
        <div class="reg-form-div">
            <input name="barangay" type="text" class="reg-form-input" placeholder=" " >
            <label for="" class="reg-form-label">Barangay</label>     
        </div>
        <div class="reg-form-div">
            <input name="city" type="text" class="reg-form-input" placeholder=" " required>
            <label for="" class="reg-form-label">City/Municipality</label>     
        </div> 
    </div>
    <div class="row-form">
        <div class="reg-form-div">
            <input name="postalcode" type="text" class="reg-form-input" placeholder=" " required>
            <label for="" class="reg-form-label">Postal Code</label>     
        </div>
        <div class="reg-form-div">
            <input name="province" type="text" class="reg-form-input" placeholder=" " required>
            <label for="" class="reg-form-label">Province</label>     
        </div> 
        <div class="reg-form-div">
            <select id="country" class="selection" name="country" style="width: 300px;">
                <option>Country</option>
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
             </select>
        </div>
    </div>
    <h1 class="reg-form-title t-c">Contact Information</h1>
    <div class="row-form" style="margin-bottom: 20px;">
        <div class="reg-form-div">
            <input name="contact" type="text" class="reg-form-input" placeholder=" " required>
            <label for="" class="reg-form-label">Contact Number</label>     
        </div>
        <div class="reg-form-div">
            <input name="email" type="email" class="reg-form-input" placeholder=" " required>
            <label for="" class="reg-form-label">Email Address</label>     
        </div>  
    </div>
    
            <div class="flex j-c">
            <button id="save" type="submit" name="create" class="btn btn-m" style="margin-right: 20px;">Create</button>
            <button type="button"  id="cancel" class="btn btn-m btn-red">Cancel</button>
        </div>
        <div class="flex j-c" style="margin-top:2rem;">
        
        </div>
        </form>
        
    </div>
<!--End og modal registration-->
<?php 

$message ="";
if(isset($_POST['create'])) {
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$midinit = $conn -> real_escape_string($_POST['midinit']);
$gender = $_POST['gender'];
$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];
$street = $_POST['street'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$postalcode = $_POST['postalcode'];
$province = $_POST['province'];
$country = $_POST['country'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$user = $conn -> real_escape_string($_POST['user']);
$pass = $_POST['pass'];

$sql = "INSERT INTO person (fname, lname, mid_init, contact_no, gender, birthdate, street, barangay, city, province, country, postalcode)
VALUES('$fname','$lname','$midinit','$contact','$gender','$year-$month-$day','$street','$barangay','$city','$province','$country','$postalcode')";

$result=mysqli_query($conn,$sql);
if($result) {
    $last_id = $conn->insert_id;
    $sql1 = "INSERT INTO userinfo(id, email, username, password)
    VALUES($last_id, '$email','$user','$pass')";
    $result1 =mysqli_query($conn,$sql1);
        if($result1) { 
            if (isset($_FILES['my_pic'])) {
        $fname = $_POST['fname'];
        $img_name = $_FILES['my_pic']['name'];
        $img_size = $_FILES['my_pic']['size'];
        $tmp_name = $_FILES['my_pic']['tmp_name'];
        $error = $_FILES['my_pic']['error'];

        if ($error === 0) {
            if ($img_size > 4000000) {
                $em = "Sorry, your file is too large.";
                header("Location: ?error=$em");
            }else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png"); 

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                    $img_upload_path = '../profilepic/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // update into Database
                    $sql2 = "UPDATE person SET profile_img='$new_img_name' WHERE fname='$fname'";
                    mysqli_query($conn, $sql2);

            
    $_SESSION['message'] = '
    <div class="popup center active">
        <div class="icon">
            <i class="fa fa-check"></i>
        </div>
        <div class="title">
            Success!
        </div>
        <div class="description">
            The Registration Was Successfull
        </div>
        
        <div class="dismiss-btn">
    <button id="dismiss-popup-btn">Dismiss</button>

        </div>
    </div>
    <script type="text/javascript">
    
        document.getElementById("dismiss-popup-btn").addEventListener("click", function() {
        document.getElementsByClassName("popup")[0].classList.remove("active");
                });
            </script>';
            echo "<script type='text/javascript'>window.location.replace('/login'); </script>"; 
            exit(0);
                          
                }else {
                    $em = "You can't upload files of this type";
                
                }
            }
        } else {
            $em = "unknown error occurred!";
          
                    }
                } 
                  $_SESSION['message'] = '
                  <div class="popup center active">
                      <div class="icon">
                          <i class="fa fa-check"></i>
                      </div>
                      <div class="title">
                          Success!
                      </div>
                      <div class="description">
                          The Registration Was Successfull
                      </div>
                      
                      <div class="dismiss-btn">
                  <button id="dismiss-popup-btn">Dismiss</button>
              
                      </div>
                  </div>
                  <script type="text/javascript">
                  
                      document.getElementById("dismiss-popup-btn").addEventListener("click", function() {
                      document.getElementsByClassName("popup")[0].classList.remove("active");
                              });
                          </script>';
                          echo "<script type='text/javascript'>window.location.replace('/login'); </script>"; 
                          exit(0);
                
            } else {
              echo "<script>alert('Userinfo table Error'); window.location.replace('/login/');</script>";
            }
    } else {
      echo "<script>alert('Person Error'); window.location.replace('/login/');</script>";
    }
}
?>
<?php
if(isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
    
}

?>
<?php require_once '../footer.php'; ?>






<script>  
$(window).on('load',function () {
    $(".loader-wrapper").fadeOut("slow");
})
$(document).ready(function() {
    $('#username').keyup(function()
    {
        $.post("avaluser.php",
        {username: $('#username').val()
        }, function(response)
        {
            
                $('#usernameResult').fadeOut();
                setTimeout("Userresult('usernameResult', '"+escape(response)+"')",350);
        });
        return false;
    });
});
    function Userresult(id, response) 
    {
        $('#usernameLoading').hide();
        $('#'+id).html(unescape(response));
        $('#'+id).fadeIn();
    }
    function check_pass() {
if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
        document.getElementById('save').disabled = false;
        document.getElementById('password').style.borderColor = '#4fee27';
        document.getElementById('confirm_password').style.borderColor = '#4fee27';
	} else {
		document.getElementById('save').disabled = true;
        document.getElementById('password').style.borderColor = '#f52d2d';
        document.getElementById('confirm_password').style.borderColor = '#f52d2d';
	}
}
    window.addEventListener('scroll', function(){
        let header = document.getElementsByClassName('site-header')[0];
        let windowPosition = window.scrollY > 0;
        header.classList.toggle('scroll-active', windowPosition);
    })
    var modal = document.getElementById('modal-register');
    var btn = document.getElementById('createacc');
    var btn1 = document.getElementById('cancel');
    $('#createacc').click(function () {
        $('.register').addClass('fegfe')
    })
    btn1.onclick = function() {
        $('.register').removeClass('fegfe')
    }

</script>
<script>
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
<!--Javascript for bootstrap-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script src="../js/jquery.countTo.min.js"></script>
    <script src="../js/jquery.shuffle.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>