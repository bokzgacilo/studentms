<?php
  include("admin/includes/restconnection.php");

  $userid = $_GET['stuid'];
  $code = $_GET['code'];

  if(!isset($userid) || empty($userid)){
    header("location: index.php");  
    exit();
  }else {
    $sql = "UPDATE tblstudent SET verify=1 WHERE StuID='$userid' AND code='$code'";

    if ($conn->query($sql) === TRUE) {
      echo "
      <p>Your account has been verified</p>
      <a href='user/login.php'>Log In</a>
      ";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
  }
?>