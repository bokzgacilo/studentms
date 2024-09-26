<?php
  include('../includes/restconnection.php');
  $violationID = $_GET['violationID'];

  $sql = "SELECT violations.*, tblstudent.* FROM violations 
  INNER JOIN tblstudent ON violations.student_id = tblstudent.ID  WHERE violations.id = $violationID ";
  $result = mysqli_query($conn, $sql);  
  $row = $result -> fetch_assoc();

  if(!$row) {
    header("location: ../manage-violations.php");
  }
?>

<style>
table {
  border-collapse: collapse;
  border: 1px solid #ccc;
}

th, td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;

}

img {
  width: 100px;
  height: 100px;
}

main {
  display: grid;
  place-items: center;
}

.container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

button {
  padding: 0.5rem 1rem;
}

@media print {
  @page {
    size: A4; /* Set page size to A4 */
    margin: 1cm; /* Set margins to 1 cm */
  }

  button {
    display: none;
  }
  /* Print-specific styles */
}

</style>


<main>
  <div class="container">
    <img src="../images/<?php echo $row['Image']?>" />
    <table>
      <tr>
        <th>Student Details</th>
      </tr>
      <tr>
        <td>Student Name: </td>
        <td><?php echo $row['StudentName']; ?></td>
      </tr>
      <tr>
        <td>Student Email: </td>
        <td><?php echo $row['StudentEmail']; ?></td>
      </tr>
      <tr>
        <td>Student Class: </td>
        <td>
          <?php 
            $getClassName = "SELECT ClassName, Section FROM tblclass WHERE ID = ".$row['StudentClass']." ";
            $getClassName = mysqli_query($conn, $getClassName);
            $ClassName = $getClassName -> fetch_assoc();
            
            echo $ClassName['ClassName'] . ' ' . $ClassName['Section'];
            ?>
        </td>
      </tr>
      <tr>
        <td>Admission Date: </td>
        <td><?php echo $row['DateofAdmission']; ?></td>
      </tr>
      <tr>
        <th>Violation Details</th>
      </tr>
      <tr>
        <td>Date: </td>
        <td><?php echo $row['violation_date']; ?></td>
      </tr>
      <tr>
        <td>Type: </td>
        <td><?php echo $row['violation_type']; ?></td>
      </tr>
      <tr>
        <td>Description: </td>
        <td><?php echo $row['description']; ?></td>
      </tr>
      <tr>
        <td>Severity: </td>
        <td><?php echo $row['severity']; ?></td>
      </tr>
      <tr>
        <td>Penalty: </td>
        <td>
          <?php 
            $getpenalty = mysqli_query($conn, "SELECT penalty FROM tblviolations WHERE description = '".$row['description']."' ");
            $penalty = $getpenalty -> fetch_assoc();
            
            echo $penalty['penalty'];

            $conn -> close();
            ?>
        </td>
      </tr>
    </table>

    <button onclick='window.print()'>Print</button>
  </div>
</main>

