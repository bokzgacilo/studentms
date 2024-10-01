<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
  header('location:logout.php');
} else {

  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | View Students Profile</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://stackpath.bootstrapcdn.co/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  </head>

  <body>
    <div class="container-scroller">
      <?php include_once('includes/header.php'); ?>
      <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> View Students Profile </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> View Students Profile</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <table border="1" class="table table-bordered mg-b-0">
                      <?php
                      $sid = $_SESSION['sturecmsstuid'];
                      $sql = "SELECT tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.StudentClass, tblstudent.Gender, tblstudent.DOB, tblstudent.StuID, tblstudent.FatherName, tblstudent.MotherName, tblstudent.ContactNumber, tblstudent.AltenateNumber, tblstudent.Address, tblstudent.UserName, tblstudent.Password, tblstudent.Image, tblstudent.DateofAdmission, tblclass.ClassName, tblclass.Section 
          FROM tblstudent 
          JOIN tblclass ON tblclass.ID = tblstudent.StudentClass 
          WHERE tblstudent.StuID = :sid";
                      $query = $dbh->prepare($sql);
                      $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                          <tr align="center" class="table-warning">
                            <td colspan="4" style="font-size:20px;color:blue">Students Details</td>
                          </tr>

                          <tr class="table-info">
                            <th>Student Name</th>
                            <td><?php echo $row->StudentName; ?></td>
                            <th>Student Email</th>
                            <td><?php echo $row->StudentEmail; ?></td>
                          </tr>
                          <tr class="table-warning">
                            <th>Student Class</th>
                            <td><?php echo $row->ClassName; ?>       <?php echo $row->Section; ?></td>
                            <th>Gender</th>
                            <td><?php echo $row->Gender; ?></td>
                          </tr>
                          <tr class="table-danger">
                            <th>Date of Birth</th>
                            <td><?php echo $row->DOB; ?></td>
                            <th>Student ID</th>
                            <td><?php echo $row->StuID; ?></td>
                            
                          </tr>
                          <tr class="table-success">
                            <th>Father Name</th>
                            <td><?php echo $row->FatherName; ?></td>
                            <th>Student Contact Number</th>
                            <td><?php echo $row->AltenateNumber; ?></td>
                          </tr>
                          <tr class="table-primary">
                            <th>Contact Number</th>
                            <td><?php echo $row->ContactNumber; ?></td>
                            <th>Mother Name</th>
                            <td><?php echo $row->MotherName; ?></td>
                          </tr>
                          <tr class="table-progress">
                            <th>Address</th>
                            <td><?php echo $row->Address; ?></td>
                            <th>User Name</th>
                            <td><?php echo $row->UserName; ?></td>
                          </tr>
                          <tr class="table-info">
                            <th>Profile Image</th>
                            <td><img src="../<?php echo $row->Image; ?>" width="100" height="100"></td>
                            <th>Date of Admission</th>
                            <td><?php echo $row->DateofAdmission; ?></td>
                          </tr>
                          <tr>
                            <td colspan="4" class="text-center">
                              <button class="btn btn-primary" data-toggle="modal" data-target="#editModal"
                                data-id="<?php echo $row->StuID; ?>" data-name="<?php echo $row->StudentName; ?>"
                                data-email="<?php echo $row->StudentEmail; ?>" data-class="<?php echo $row->StudentClass; ?>"
                                data-gender="<?php echo $row->Gender; ?>" data-dob="<?php echo $row->DOB; ?>"
                                data-father="<?php echo $row->FatherName; ?>" data-mother="<?php echo $row->MotherName; ?>"
                                data-contact="<?php echo $row->ContactNumber; ?>"
                                data-alternate="<?php echo $row->AltenateNumber; ?>"
                                data-address="<?php echo $row->Address; ?>" data-username="<?php echo $row->UserName; ?>"
                                data-dateofadmission="<?php echo $row->DateofAdmission; ?>">Edit Profile</button>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                    </table>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Edit Modal -->
          <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Student Profile</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="studentName">Student Name</label>
                      <input type="text" class="form-control" id="studentName" name="studentName"
                        value="<?php echo htmlspecialchars($row->StudentName); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="studentEmail">Student Email</label>
                      <input type="email" class="form-control" id="studentEmail" name="studentEmail"
                        value="<?php echo htmlspecialchars($row->StudentEmail); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="studentClass">Student Class</label>
                      <select class="form-control" id="studentClass" name="studentClass" required>
                        <?php
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
                      <label for="altenateNumber">Student Contact Number</label>
                      <input type="text" class="form-control" id="altenateNumber" name="altenateNumber"
                        value="<?php echo htmlspecialchars($row->AltenateNumber); ?>">
                    </div>
                    <div class="form-group">
                      <label for="gender">Gender</label>
                      <select class="form-control" id="gender" name="gender" required>
                        <option value="Male" <?php echo ($row->Gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($row->Gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="dob">Date of Birth</label>
                      <input type="date" class="form-control" id="dob" name="dob"
                        value="<?php echo htmlspecialchars($row->DOB); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="fatherName">Father Name</label>
                      <input type="text" class="form-control" id="fatherName" name="fatherName"
                        value="<?php echo htmlspecialchars($row->FatherName); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="motherName">Mother Name</label>
                      <input type="text" class="form-control" id="motherName" name="motherName"
                        value="<?php echo htmlspecialchars($row->MotherName); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="contactNumber">Contact Number</label>
                      <input type="text" class="form-control" id="contactNumber" name="contactNumber"
                        value="<?php echo htmlspecialchars($row->ContactNumber); ?>" required>
                    </div>
                    
                    <div class="form-group">
                      <label for="address">Address</label>
                      <textarea class="form-control" id="address" name="address"
                        required><?php echo htmlspecialchars($row->Address); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="profileImage">Profile Image</label>
                      <input type="file" class="form-control" id="profileImage" name="profileImage">
                    </div>

                    <input type="hidden" name="studentId" value="<?php echo htmlspecialchars($row->StuID); ?>">
                    <button type="submit" class="btn btn-success">Save changes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>

    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <script src="js/file-upload.js"></script>
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
      $(document).ready(function(){
        $('#contactNumber, #altenateNumber').keypress(function(event) {
            var charCode = event.which;
            // Allow only numbers (0-9)
            if (charCode >= 48 && charCode <= 57) {
                return true;
            } else {
                return false;
            }
        });

        $('#studentName, #fatherName, #motherName').keypress(function(event) {
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
      })
    </script>
  </body>

  </html>
<?php } ?>