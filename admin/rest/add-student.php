<?php
  include('../includes/restconnection.php');

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
          move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);
  
          // Insert new student data
          $sql = "INSERT INTO tblstudent (StudentName, StudentEmail, StudentClass, Gender, DOB, StuID, FatherName, MotherName, ContactNumber, AltenateNumber, Address, UserName, Password, Image) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ssssssssssssss", $stuname, $stuemail, $stuclass, $gender, $dob, $stuid, $fname, $mname, $connum, $altconnum, $address, $uname, $password, $image);
  
          if ($stmt->execute()) {
              echo 'Student has been added.';
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