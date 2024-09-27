<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "SELECT ID FROM tbladmin WHERE UserName=:username and Password=:password";
  $query = $dbh->prepare($sql);
  $query->bindParam(':username', $username, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      $_SESSION['sturecmsaid'] = $result->ID;
    }

    if (!empty($_POST["remember"])) {
      // COOKIES for username
      setcookie("user_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
      // COOKIES for password
      setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
    } else {
      if (isset($_COOKIE["user_login"])) {
        setcookie("user_login", "");
      }
      if (isset($_COOKIE["userpassword"])) {
        setcookie("userpassword", "");
      }
    }
    $_SESSION['login'] = $_POST['username'];
    
    echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
  } else {
    echo "<script>alert('Invalid Details');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE | Login Page</title>
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

    .register-link {
      text-align: center !important;
      color: #28a745;
    }

    .auth-link:hover {
      text-decoration: underline;
    }

    .form-check-label {
      margin-left: 10px;
    }

    .register-link {
      margin-top: 20px;
      font-size: 14px;
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
    <div class="content-wrapper d-flex align-items-center auth">
      <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left p-5">
            <div class="brand-logo">
              <img src="../images/prmsu.png" alt="Logo">
            </div>
            <h4>Hello! Let's get started</h4>
            <h6 class="font-weight-light">Sign in to continue.</h6>
            <form class="pt-3" id="login" method="post" name="login">
              <div class="form-group">
                <input id="usernameInput" type="text" class="form-control form-control-lg" placeholder="Enter your username"
                  required="true" name="username" value="<?php if (isset($_COOKIE["user_login"])) {
                    echo $_COOKIE["user_login"];
                  } ?>">
              </div>
              <div class="form-group">
                <input type="password" class="form-control form-control-lg" placeholder="Enter your password"
                  name="password" required="true" value="<?php if (isset($_COOKIE["userpassword"])) {
                    echo $_COOKIE["userpassword"];
                  } ?>">
              </div>
              <div class="mt-3">
                <button class="btn btn-success btn-block loginbtn" name="login" type="submit">Login</button>
              </div>
              <div class="my-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" id="remember" class="form-check-input" name="remember" <?php if (isset($_COOKIE["user_login"])) { ?> checked <?php } ?> /> Keep me signed in
                  </label>
                </div>
                <a href="forgot-password.php" class="auth-link text-black">Forgot password?</a>
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
  </div>
  <script>
        $(document).ready(function(){
            // Bind the input event to validate while typing
            $('#usernameInput').on('input', function() {
                // Get the input value
                var inputVal = $(this).val();
                console.log(inputVal)
                
                // Define the regex pattern for validation
                var pattern = /^21-\d-\d-\d{4}$/;

                // Validate the input value against the pattern
                if (pattern.test(inputVal)) {
                    console.log('correct')
                } else {
                  console.log('error')
                }
            });
        });
    </script>
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
</body>

</html>