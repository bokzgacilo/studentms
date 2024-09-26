<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $student_id = 0;
    $violation_date = $_POST['violation_date'];
    $violation_type = $_POST['violation_type'];
    $description = $_POST['description'];
    $severity = $_POST['severity'];
    $penalty = $_POST['penalty'];

    // Check for existing violations for the same student and date
    $ret = "SELECT * FROM tblviolations WHERE student_id = :student_id AND violation_date = :violation_date";
    $query = $dbh->prepare($ret);
    $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $query->bindParam(':violation_date', $violation_date, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() == 0) {
      $sql = "INSERT INTO tblviolations (student_id, violation_date, violation_type, description, severity, penalty) 
                    VALUES (:student_id, :violation_date, :violation_type, :description, :severity, :penalty)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
      $query->bindParam(':violation_date', $violation_date, PDO::PARAM_STR);
      $query->bindParam(':violation_type', $violation_type, PDO::PARAM_STR);
      $query->bindParam(':description', $description, PDO::PARAM_STR);
      $query->bindParam(':severity', $severity, PDO::PARAM_INT);
      $query->bindParam(':penalty', $penalty, PDO::PARAM_STR);

      $query->execute();

      $LastInsertId = $dbh->lastInsertId();
      if ($LastInsertId > 0) {
        echo '<script>alert("Violation has been added.")</script>';
        echo "<script>window.location.href ='add-violations.php'</script>";
      } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
      }
    } else {
      echo "<script>alert('Violation already exists for the same student and date.');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE | Manage Violations</title>
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once('includes/sidebar.php'); ?>
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
                  <h4 class="card-title" style="text-align: center;">Add Offense</h4>
                  <form class="forms-sample" method="post">
                    <div hidden class="form-group">
                      <label for="student_id">Student ID</label>
                      <select name="student_id" class="form-control select2" style="width:100%" required='true'>
                        <?php
                        // Fetching existing students
                        $sql = "SELECT id, StudentName FROM tblstudent";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {
                            echo "<option value='" . htmlentities($result->id) . "'>" . htmlentities($result->StudentName) . " : " . htmlentities($result->id) . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="violation_date">Violation Date</label>
                      <input type="date" name="violation_date" class="form-control" required='true'>
                    </div>
                    <div class="form-group">
                      <label for="violation_type">Violation Type</label>
                      <select name="violation_type" class="form-control select2" style="width:100%" required='true'>
                        <?php
                        // Fetching existing violation types
                        $sql = "SELECT DISTINCT violation_type FROM tblviolations";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {
                            echo "<option value='" . htmlentities($result->violation_type) . "'>" . htmlentities($result->violation_type) . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="description">Offense</label>
                      <select name="description" class="form-control select2" style="width:100%" required='true'>
                        <option value="">Select Offense</option>
                        <?php
                        // Fetching existing offenses
                        $sql = "SELECT DISTINCT description FROM tblviolations";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {
                            echo "<option value='" . htmlentities($result->description) . "'>" . htmlentities($result->description) . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="severity">Severity</label>
                      <select name="severity" class="form-control" required='true'>
                        <option value="">Select Severity</option>
                        <option value="1">1st Offense </option>
                        <option value="2">2nd Offense </option>
                        <option value="3">3rd Offense </option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="penalty">Penalty</label>
                      <textarea id="penalty" name="penalty" class="form-control"></textarea>
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
        <?php include_once('includes/footer.php'); ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
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

  <script>
    $(document).ready(function () {
      $('select[name="description"], select[name="severity"]').on('change', function () {
        var description = $('select[name="description"]').val();
        var severity = $('select[name="severity"]').val();
        console.log(severity)
        console.log(description)
        console.log(":Test")

        if (description && severity) {

          $.ajax({
            url: 'fetch_penalty.php',  // The PHP file that will handle the request
            method: 'POST',
            data: { description: description, severity: severity },
            dataType: 'json',
            success: function (response) {
              console.log(response)
              if (response.status === 'success') {
                $('#penalty').val(response.penalty);
              } else {
                $('#penalty').val('');
              }
            }
          });
        } else {
          $('#penalty').val('');
        }
      });
    });


    $(document).ready(function () {
      $('.select2').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        theme: 'bootstrap',
      });
    });
  </script>
  <!-- End custom js for this page -->
</body>

</html>