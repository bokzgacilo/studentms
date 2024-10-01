<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | Add Students</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />

  </head>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include_once('includes/header.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
             
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                 
                </ol>
              </nav>
            </div>
            <div class="row">

               <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Add Students</h4>

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  

                    <form id="studentForm" class="forms-sample" enctype="multipart/form-data">

                      <div class="form-group">
                        <label for="exampleInputName1">Student Name</label>
                        <input type="text" name="stuname" id="stuname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Email</label>
                        <input type="text" name="stuemail" value="" class="form-control" required='true'>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputEmail3">Student Class</label>
                        <select name="stuclass" class="form-control" required='true'>
                          <option value="">Select Class</option>
                          <?php

                          $sql2 = "SELECT * from    tblclass ";
                          $query2 = $dbh->prepare($sql2);
                          $query2->execute();
                          $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                          foreach ($result2 as $row1) {
                            ?>
                            <option value="<?php echo htmlentities($row1->ID); ?>">
                              <?php echo htmlentities($row1->ClassName); ?>     <?php echo htmlentities($row1->Section); ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Contact Number</label>
                        <input type="text" name="altconnum" id="altconnum" value="" class="form-control" required='true' maxlength="11">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Gender</label>
                        <select name="gender" value="" class="form-control" required='true'>
                          <option value="">Choose Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date of Birth</label>
                        <input type="date" name="dob" value="" class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Student ID</label>
                        <input type="text" id="stuid" name="stuid" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Photo</label>
                        <input type="file" name="image" value="" class="form-control" required='true'>
                      </div>
                      <h3>Parents/Guardian's details</h3>
                      <div class="form-group">
                        <label for="exampleInputName1">Father's Name</label>
                        <input type="text" name="fname" id="fname" value="" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Mother's Name</label>
                        <input type="text" name="mname" id="mname" value="" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Contact Number</label>
                        <input type="text" name="connum" id="connum" value="" class="form-control" required='true' maxlength="11">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Address</label>
                        <textarea name="address" class="form-control" required='true'></textarea>
                      </div>
                      <h3>Login details</h3>
                      <div class="form-group">
                        <label for="exampleInputName1">User Name</label>
                        <input type="text" id="uname" name="uname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Password</label>
                        <input type="Password" name="password" value="" class="form-control" required='true'>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
                          </div>
    <script>
      $(document).ready(function(){
        $('#studentForm').on('submit', function(event) {
                event.preventDefault();
                
                // Create a FormData object to send the form data including the image file
                var formData = new FormData(this);

                $.ajax({
                    url: 'rest/add-student.php',  // PHP file where the data is sent
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response);  // Show the response in the response div
                    },
                    error: function(xhr, status, error) {
                      alert('<p>An error occurred: ' + xhr.responseText + '</p>');
                    }
                });
            });

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
          // Allow A-Z, a-z and space (charCode 32)
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
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
    <?php include_once('includes/footer.php'); ?>

  </body>

  </html><?php } ?>