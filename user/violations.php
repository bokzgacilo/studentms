<?php
session_start();
include('includes/dbconnection.php'); // This includes the dbconnection.php file

$student_id = $_SESSION['sturecmsuid'];
$query = "SELECT * FROM violations WHERE student_id = :student_id";
$stmt = $dbh->prepare($query); // Use $dbh for the prepared statement
$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$stmt->execute();
$violations = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo updateIsReading($_SESSION['sturecmsuid'], false);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE |View Notice</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
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
                  <table border="1" class="table table-bordered mg-b-0">
                    <thead>
                      <tr align="center" class="table-warning">
                        <th colspan="5" style="font-size:20px;color:blue">Violations List</th>
                      </tr>
                      <tr class="table-info">
                        <th>Violation Date</th>
                        <th>Violation Type</th>
                        <th>Description</th>
                        <th>Severity</th>
                        <th>Penalty</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (count($violations) > 0) {
                        foreach ($violations as $violation) {
                          echo "<tr>
                          <td>{$violation['violation_date']}</td>
                          <td>{$violation['violation_type']}</td>
                          <td>{$violation['description']}</td>
                          <td>";

                          switch ($violation['severity']) {
                            case 1:
                              echo '1st offense';
                              break;
                            case 2:
                              echo '2nd offense';
                              break;
                            case 3:
                              echo '3rd offense';
                              break;
                            default:
                              echo $violation['severity'];
                              break;
                          }
                        }

                        echo " <td>{$violation['penalty']}</td>";

                      } else {
                        echo "<tr>
                                <td colspan='5' align='center'>No data found</td>
                              </tr>";
                      }

                      ?>

                    </tbody>
                  </table>
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
  <!-- End custom js for this page -->
</body>

</html>