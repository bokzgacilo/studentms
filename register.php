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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('includes/dbconnection.php');
  include('mailer.php');

  $code = generateRandomString(10);

  // Retrieve form data
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

  // Handle file upload
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($image_tmp, $target_file);
  } else {
    $image = "user/images/faces/default.jpg";
  }

  // Insert data into the database
  $sql = "INSERT INTO tblstudent (StudentName, StudentEmail, StudentClass, Gender, DOB, StuID, FatherName, MotherName, ContactNumber, AltenateNumber, Address, UserName, Password, Image, code) 
    VALUES (:stuname, :stuemail, :stuclass, :gender, :dob, :stuid, :fname, :mname, :connum, :altconnum, :address, :uname, :password, :image, :code)";

  $stmt = $dbh->prepare($sql);

  $stmt->execute([
    ':stuname' => $stuname,
    ':stuemail' => $stuemail,
    ':stuclass' => $stuclass,
    ':gender' => $gender,
    ':dob' => $dob,
    ':stuid' => $stuid,
    ':fname' => $fname,
    ':mname' => $mname,
    ':connum' => $connum,
    ':altconnum' => $altconnum,
    ':address' => $address,
    ':uname' => $uname,
    ':password' => $_POST['password'],
    ':image' => $image,
    ':code' => $code
  ]);


  echo "Student added successfully!";

  sendEmail($stuid, $stuemail, $stuname, $code);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../images/logo.png" type="image/png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Custom CSS -->
  <style>
    .container {
      margin-top: 20px;
    }

    .form-section {
      margin-bottom: 30px;
    }
  </style>
</head>

<body>
  <div class="container">
    <form class="form-section" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="stuname">Student Name</label>
        <input type="text" name="stuname" id="stuname" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="stuemail">Student Email</label>
        <input type="email" name="stuemail" id="stuemail" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="studentClass">Student Class</label>
        <select class="form-control" id="stuclass" name="stuclass" required>
          <?php
          include('includes/dbconnection.php');
          // Fetch classes for the dropdown
          $classSql = "SELECT ID, ClassName, Section FROM tblclass";
          $classQuery = $dbh->prepare($classSql);
          $classQuery->execute();
          $classes = $classQuery->fetchAll(PDO::FETCH_OBJ);
          foreach ($classes as $class) {
            $selected = ($class->ID == $row->StudentClass) ? 'selected' : '';
            $displayText = htmlspecialchars($class->ClassName) . ' - ' . htmlspecialchars($class->Section);
            echo '<option value="' . htmlspecialchars($class->ID) . '" ' . $selected . '>' . $displayText . '</option>';
          }
          ?>
        </select>

      </div>
      <div class="form-group">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" class="form-control" required>
          <option value="">Choose Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="stuid">Student ID</label>
        <input type="text" name="stuid" id="stuid" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="altconnum">Contact Number</label>
        <input type="text" name="altconnum" id="altconnum" class="form-control" required pattern="\d{11}"
          title="Contact number must be exactly 11 digits">
      </div>
      <div class="form-group">
        <label for="exampleInputName1">Student Photo</label>
        <input type="file" name="image" value="" class="form-control">
      </div>
      <h4>Parents/Guardian's details</h4>
      <div class="form-group">
        <label for="fname">Father's Name</label>
        <input type="text" name="fname" id="fname" class="form-control">
      </div>
      <div class="form-group">
        <label for="mname">Mother's Name</label>
        <input type="text" name="mname" id="mname" class="form-control">
      </div>
      <div class="form-group">
        <label for="connum">Contact Number</label>
        <input type="text" name="connum" id="connum" class="form-control" pattern="\d{11}"
          title="Contact number must be exactly 11 digits">
      </div>
      

      <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control" required></textarea>
      </div>
      <h4>Login details</h4>
      <div class="form-group">
        <label for="uname">Student Code</label>
        <input type="text" name="uname" id="uname" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
  </div>
  <script>
    $(document).ready(function(){
      $('#connum, #altconnum').keypress(function(event) {
            var charCode = event.which;
            // Allow only numbers (0-9)
            if (charCode >= 48 && charCode <= 57) {
                return true;
            } else {
                return false;
            }
        });

      $('#stuname, #fname, #mname').keypress(function(event) {
          var charCode = event.which;
          if ((charCode >= 65 && charCode <= 90) || 
              (charCode >= 97 && charCode <= 122) || 
              charCode == 32) {
              return true;
          } else {
              return false;
          }
      });

      // Bind the input event to validate while typing
      $('#uname, #stuid').on('input', function() {
        // Get the current value of the input field
        var inputVal = $(this).val();

        // Remove any non-alphanumeric characters
        inputVal = inputVal.replace(/[^\w]/g, '');

        // Format the input value and add hyphens automatically
        if (inputVal.length > 2) {
            inputVal = inputVal.substring(0, 2) + '-' + inputVal.substring(2);
        }
        if (inputVal.length > 4) {
            inputVal = inputVal.substring(0, 4) + '-' + inputVal.substring(4);
        }
        if (inputVal.length > 6) {
            inputVal = inputVal.substring(0, 6) + '-' + inputVal.substring(6, 10);
        }

        // Set the formatted value back to the input field
        $(this).val(inputVal);

        // If the input doesn't match the required pattern, show an error
        var pattern = /^[A-Za-z0-9]{2}-[A-Za-z0-9]{2}-[A-Za-z0-9]{4}$/;
        if (pattern.test(inputVal)) {
            console.log('correct');
        } else {
            console.log('error');
        }
    });
  });
  </script>
  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>