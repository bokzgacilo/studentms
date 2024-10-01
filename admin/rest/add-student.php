<?php
  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
  
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
  
    return $randomString;
  }

  include('../includes/restconnection.php');
  include('../../mailer.php');

  $code = generateRandomString(10);

  $stuname = $_POST['stuname'];
  $stuemail = $_POST['stuemail'];
  $stuclass = $_POST['stuclass'];
  $gender = $_POST['gender'];
  $dob = $_POST['dob'];
  $stuid = $_POST['stuid'];
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $connum = $_POST['connum'];
  $altconnum = $_POST['altconnum'];
  $address = $_POST['address'];
  $uname = $_POST['uname'];
  $password = $_POST['password'];
  $image = $_FILES["image"]["name"];
  
  // Check if username or student ID already exists
  $ret = "SELECT UserName FROM tblstudent WHERE UserName=? OR StuID=?";
  $stmt = $conn->prepare($ret);
  $stmt->bind_param("ss", $uname, $stuid);
  $stmt->execute();
  $stmt->store_result();
  
  if ($stmt->num_rows == 0) {
      $stmt->close();
  
      // Check file extension for the image
      $extension = substr($image, strlen($image) - 4, strlen($image));
      $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
      if (!in_array($extension, $allowed_extensions)) {
          echo "<script>alert('Logo has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
      } else {
          $image = md5($image) . time() . $extension;
          move_uploaded_file($_FILES["image"]["tmp_name"], "../../user/images/profile/" . $image);
          $image_url = "user/images/profile/" . $image;
  
          // Insert new student data
          $sql = "INSERT INTO tblstudent (StudentName, StudentEmail, StudentClass, Gender, DOB, StuID, FatherName, MotherName, ContactNumber, AltenateNumber, Address, UserName, Password, Image, code) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sssssssssssssss", $stuname, $stuemail, $stuclass, $gender, $dob, $stuid, $fname, $mname, $connum, $altconnum, $address, $uname, $password, $image_url, $code);
  
          if ($stmt->execute()) {
              echo 'Student has been added.';
              sendEmail($stuid, $stuemail, $stuname, $code);
          } else {
              echo 'Something Went Wrong. Please try again';
          }
  
          $stmt->close();
      }
  } else {
      echo 'Username or Student Id already exists. Please try again';
  }
  
  $conn->close();
  
?>