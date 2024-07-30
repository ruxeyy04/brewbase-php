<?php 
include '../../server.php';

if(isset($_POST['promoteincharge'])) {
    $userid = $_POST['promoteincharge'];
    $sql = "UPDATE userinfo SET usertype = 'In-charge' WHERE id=$userid";
    mysqli_query($conn, $sql);
}
if(isset($_POST['removeadmin'])) {
    $userid = $_POST['removeadmin'];
    $sql = "UPDATE userinfo SET usertype = 'In-charge' WHERE id=$userid";
    mysqli_query($conn, $sql);
}
if(isset($_POST['demoteincharge'])) {
    $userid = $_POST['demoteincharge'];
    $sql = "UPDATE userinfo SET usertype = 'Customer' WHERE id=$userid";
    mysqli_query($conn, $sql);
}
if(isset($_POST['promoteadmin'])) {
    $userid = $_POST['promoteadmin'];
    $sql = "UPDATE userinfo SET usertype = 'Admin' WHERE id=$userid";
    mysqli_query($conn, $sql);
}
if(isset($_POST['viewprofile'])) {
    $userid = $_POST['viewprofile'];
    $sql = "SELECT a.*, b.email FROM person a INNER JOIN userinfo b ON a.id=b.id WHERE a.id=$userid";
    $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $date = date_create($row['birthdate']);
    $output = array('fname'=>$row['fname'],
                    'lname'=>$row['lname'], 
                    'midinit'=>$row['mid_init'], 
                    'gender'=>$row['gender'], 
                    'birthdate'=>date_format($date, 'F d, Y'), 
                    'contactno'=>$row['contact_no'], 
                    'email'=>$row['email'],
                    'street'=>$row['street'], 
                    'barangay'=>$row['barangay'], 
                    'city'=>$row['city'],
                    'province'=>$row['province'], 
                    'postalcode'=>$row['postalcode'],
                    'country'=>$row['country']);
    echo json_encode($output);
}
?>