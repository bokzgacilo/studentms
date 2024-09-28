<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','1nd3p3nd3nT@');
define('DB_NAME','studentmsdb');
// Establish database connection.
try {
  $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

  $removeLastSeen = "UPDATE tblstudent SET isReading = false WHERE last_seen < NOW() - INTERVAL 1 HOUR";
  $q = $dbh -> prepare($removeLastSeen);
  $q -> execute();  
}
  catch (PDOException $e)
{
  exit("Error: " . $e->getMessage());
}


function updateIsReading($studentId, $status) {
  global $dbh;
  try {
      // Prepare the SQL statement to update the column
      $sql = "UPDATE tblstudent SET isReading = :status, last_seen = NOW() WHERE ID = :studentId";
      $query = $dbh->prepare($sql);
      
      // Bind the parameter
      $query->bindParam(':status', $status, PDO::PARAM_BOOL);
      $query->bindParam(':studentId', $studentId, PDO::PARAM_INT);
      
      // Execute the query
      $query->execute();
  } catch (PDOException $e) {
      return "Error: " . $e->getMessage();
  }
}
?>