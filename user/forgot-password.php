<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $newpassword = md5($_POST['newpassword']);
  $sql = "SELECT StudentEmail FROM tblstudent WHERE StudentEmail=:email and ContactNumber=:mobile";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    $con = "UPDATE tblstudent SET Password=:newpassword WHERE StudentEmail=:email AND ContactNumber=:mobile";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
    $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
    $chngpwd1->execute();
    echo "<script>alert('Your password was successfully changed');</script>";
  } else {
    echo "<script>alert('Invalid email or mobile number');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE | Student Forgot Password</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript">
    function valid() {
      if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("New Password and Confirm Password fields do not match!!");
        document.chngpwd.confirmpassword.focus();
        return false;
      }
      return true;
    }
  </script>
  <style>
    .container-scroller {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .content-wrapper {
      background: none !important;
    }

    .auth-form-light {
      background: #fff;
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .brand-logo {
      width: 100px;
      height: 100px;
      background-color: #f8f9fa;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto 20px;
    }

    .brand-logo img {
      width: 60%;
    }

    .loginbtn {
      background-color: #28a745;
      border: none;
    }

    .loginbtn:hover {
      background-color: #218838;
    }

    .auth-link {
      color: #28a745;
      text-decoration: underline;
    }

    body {
      background-image: url("../images/login.jpg");
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="../images/logo.png" alt="Logo">
              </div>
              <h4>RECOVER PASSWORD</h4>
              <h6 class="font-weight-light">Enter your email address and mobile number to update your password!</h6>
              <form class="pt-3" id="login" method="post" name="login" onsubmit="return valid();">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" placeholder="Email Address" required="true"
                    name="email">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="mobile" placeholder="Mobile Number"
                    required="true" maxlength="10" pattern="[0-9]+">
                </div>
                <div class="form-group">
                  <input class="form-control form-control-lg" type="password" name="newpassword"
                    placeholder="New Password" required="true" />
                </div>
                <div class="form-group">
                  <input class="form-control form-control-lg" type="password" name="confirmpassword"
                    placeholder="Confirm Password" required="true" />
                </div>
                <div class="mt-3">
                  <button class="btn btn-success btn-block loginbtn" name="submit" type="submit">Update</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <a href="login.php" class="auth-link text-black">Sign in</a>
                </div>
                <div class="mb-2">
                  <a href="../index.php" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="icon-social-home mr-2"></i>Back Home
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
</body>

</html>