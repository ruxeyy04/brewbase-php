<?php 
  if(isset($_POST)){
    $emailTo="ruxepasok356@gmail.com";
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $subject=$_POST['subject'];
    $message = $_POST['message'];
    $content = "Name : $name \nSubject : $subject \nPhone : $phone \nMessage : $message";
    $headers='From: '.$_POST['email'];

    if(mail($emailTo,$subject,$content,$headers)){
      echo 1;
    }else{
      echo 0;
    }
  }
?>