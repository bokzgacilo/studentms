<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
  $stuid = $_POST['stuid'];
  $password = $_POST['password'];

  // Modify the query to also check the 'verify' column
  $sql = "SELECT StuID, ID, StudentClass, verify FROM tblstudent WHERE (UserName=:stuid || StuID=:stuid) and Password=:password";
  $query = $dbh->prepare($sql);
  $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);

  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      // Check if the account is verified
      if ($result->verify == 0) {
        // echo "<script>alert('Account not verified. Please verify your account before logging in.');</script>";
        echo "
        <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
          <div id='verifyToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='toast-header'>
              <strong class='me-auto'>Account Verification</strong>
              <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
            <div class='toast-body'>
              Account not verified. Please verify your account before logging in.
            </div>
          </div>
        </div>
        <script>
          var verifyToast = new bootstrap.Toast(document.getElementById('verifyToast'));
          verifyToast.show();
        </script>
        ";
        echo "<script type='text/javascript'> document.location ='../user/login.php'; </script>";
        exit;
      }

      $_SESSION['sturecmsstuid'] = $result->StuID;
      $_SESSION['sturecmsuid'] = $result->ID;
      $_SESSION['stuclass'] = $result->StudentClass;
    }

    // Handle "Remember Me" functionality
    if (!empty($_POST["remember"])) {
      setcookie("user_login", $_POST["stuid"], time() + (10 * 365 * 24 * 60 * 60));
      setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
    } else {
      if (isset($_COOKIE["user_login"])) {
        setcookie("user_login", "");
      }
      if (isset($_COOKIE["userpassword"])) {
        setcookie("userpassword", "");
      }
    }

    $_SESSION['login'] = $_POST['stuid'];
    echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
  } else {
    echo "
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
      <div id='invalidToast' class='toast text-bg-danger' role='alert' aria-live='assertive' aria-atomic='true'>
        <div class='toast-body'>
          Invalid Details. Please try again.
        </div>
      </div>
    </div>
    <script>
      var invalidToast = new bootstrap.Toast(document.getElementById('invalidToast'));
      invalidToast.show();
    </script>
    ";
    // echo "<script>alert('Invalid Details');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE | Student Login</title>
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
            <br>
            <h4>Hello! Let's get started</h4>
            <h6 class="font-weight-light">Sign in to continue.</h6>
            <form class="pt-3" id="login" method="post" name="login">
              <div class="form-group">
                <input id="usernameInput" type="text" class="form-control form-control-lg" placeholder="Enter your student ID or username"
                  required="true" name="stuid" value="<?php if (isset($_COOKIE["user_login"])) {
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
              <a href="javascript:void(0);" class="auth-link" id="openModal">Don't have an account? Register here</a>

              <!-- The Modal -->
              <div id="registerModal" class="modal">
                <div class="modal-content">
                  <span class="close" id="closeModal">&times;</span>
                  <iframe id="register-frame" src=""></iframe>
                </div>
              </div>

              <script>
                // Get the modal
                var modal = document.getElementById("registerModal");

                // Get the link that opens the modal
                var openModal = document.getElementById("openModal");

                // Get the <span> element that closes the modal
                var closeModal = document.getElementById("closeModal");

                // When the user clicks on the link, open the modal 
                openModal.onclick = function () {
                  modal.style.display = "block";
                  document.getElementById('register-frame').src = '../register.php';
                }

                // When the user clicks on <span> (x), close the modal
                closeModal.onclick = function () {
                  modal.style.display = "none";
                  document.getElementById('register-frame').src = ''; // Clear the iframe source
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                  if (event.target == modal) {
                    modal.style.display = "none";
                    document.getElementById('register-frame').src = ''; // Clear the iframe source
                  }
                }
              </script>
              <style>
                .auth-link {
                  cursor: pointer;
                  color: blue;
                  text-decoration: underline;
                }

                /* Modal styles */
                .modal {
                  display: none;
                  /* Hidden by default */
                  position: fixed;
                  /* Stay in place */
                  z-index: 1;
                  /* Sit on top */
                  left: 0;
                  top: 0;
                  width: 100%;
                  /* Full width */
                  height: 100%;
                  /* Full height */
                  overflow: auto;
                  /* Enable scroll if needed */
                  background-color: rgb(0, 0, 0);
                  /* Fallback color */
                  background-color: rgba(0, 0, 0, 0.4);
                  /* Black w/ opacity */
                }

                .modal-content {
                  background-color: #fefefe;
                  margin: 10% auto;
                  /* 15% from the top and centered */
                  padding: 20px;
                  border: 1px solid #888;
                  width: 80%;
                  /* Could be more or less, depending on screen size */
                }

                .close {
                  color: #aaa;
                  float: right;
                  font-size: 28px;
                  font-weight: bold;
                }

                .close:hover,
                .close:focus {
                  color: black;
                  text-decoration: none;
                  cursor: pointer;
                }

                iframe {
                  width: 100%;
                  height: 500px;
                  /* Adjust height as needed */
                  border: none;
                }
              </style>
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
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
</body>

</html>