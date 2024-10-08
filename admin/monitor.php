<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <link rel="icon" href="../images/logo.png" type="image/png">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>Monitor Online</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/4.1.0/turn.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../pdf/css/flipbook.style.css" />
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
            <div class="col-12 p-4" style="background-color: #fff;">
              <h3 class="page-title">Monitor Online Students</h3>
              <table class="table" id="table">
                <thead>
                  <tr>
                    <th class="font-weight-bold">S.No</th>
                    <th class="font-weight-bold">Student ID</th>
                    <th class="font-weight-bold">Student Class</th>
                    <th class="font-weight-bold">Student Name</th>
                    <th class="font-weight-bold">Student Email</th>
                    <th class="font-weight-bold">Last Seen</th>
                    <th class="font-weight-bold">Active</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                  } else {
                    $pageno = 1;
                  }
                  // Formula for pagination
                  $no_of_records_per_page = 10;
                  $offset = ($pageno - 1) * $no_of_records_per_page;
                  
                  $ret = "SELECT ID FROM tblstudent";

                  $query1 = $dbh->prepare($ret);
                  $query1->execute();
                  $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                  $total_rows = $query1->rowCount();
                  $total_pages = ceil($total_rows / $no_of_records_per_page);
                  $sql = "SELECT tblstudent.StuID, tblstudent.isReading, tblstudent.last_seen, tblstudent.ID as sid, tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.DateofAdmission, tblclass.ClassName, tblclass.Section
                    FROM tblstudent
                    JOIN tblclass ON tblclass.ID = tblstudent.StudentClass
                    ";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);

                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                    foreach ($results as $row) { ?>
                      <tr>
                        <td><?php echo htmlentities($cnt); ?></td>
                        <td><?php echo htmlentities($row->StuID); ?></td>
                        <td><?php echo htmlentities($row->ClassName); ?>
                          <?php echo htmlentities($row->Section); ?>
                        </td>
                        <td><?php echo htmlentities($row->StudentName); ?></td>
                        <td><?php echo htmlentities($row->StudentEmail); ?></td>
                        <td>
                          <?php 
                            // echo htmlentities($row->last_seen); 
                            $datetime = new DateTime($row->last_seen);
                            $formattedDate = $datetime->format('F d, Y h:i A');
                            echo $formattedDate;
                          ?>
                        </td>
                        <td>
                          <?php
                            if(htmlentities($row->isReading)){
                              echo "Active Now";
                            }else {
                              date_default_timezone_set('Asia/Manila');
                              $datetime1 = new DateTime($row->last_seen);
                              $datetime2 = new DateTime();

                              $interval = $datetime1->diff($datetime2);

                              $minutesDifference = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

                              if ($minutesDifference < 60) {
                                // Less than 1 hour
                                echo "$minutesDifference minutes ago.";
                              } elseif ($minutesDifference < 1440) { // 1440 minutes = 24 hours
                                // Less than 1 day
                                $hoursDifference = floor($minutesDifference / 60);
                                echo "$hoursDifference hour" . ($hoursDifference > 1 ? 's' : '') . " ago.";
                              } else {
                                // More than or equal to 1 day
                                $daysDifference = $interval->days;
                                echo "$daysDifference day" . ($daysDifference > 1 ? 's' : '') . " ago.";
                              }
                            }
                          ?>
                        </td>
                      </tr><?php $cnt = $cnt + 1;
                    }
                  } ?>
                </tbody>
              </table>
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
    <?php include_once('includes/footer.php'); ?>

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

  </html><?php } ?>