<?php 

$conn = new mysqli("localhost", "root", "", "brewbase");

if($conn->connect_error) {
 die("Connection failed: " . $conn->connection_error);
}

if(isset($_GET['logout'])) {
session_destroy();
echo "<script type='text/javascript'>window.location.replace('/'); </script>"; 
}
?>