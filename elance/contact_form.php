<?php
//require_once 'Mail.php';
$wgSMTP = array(
    'host' => 'tls://smtp.sendgrid.net',
    'IDHost' => 'demo.quickvturesults.com',
    'port' => 587,
    'username' => getenv("quickvturesults"), 
    'password' => getenv("MANJUNIKHIL@123"),
    'auth' => true
 );
  $email = $_POST['email'] ;
  $subject = "Contact us Form-mMStore";
  $message = $_POST['message'] ;
  mail("kalburgimanjunath@gmail.com", $subject, $message, "From:" . $email);
  echo "<script>alert('Thank you for using our mail form');window.location.href = 'contactform.php';</script>";

?>