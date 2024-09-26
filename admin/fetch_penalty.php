<?php
include('includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $severity = $_POST['severity'];

    $sql = "SELECT penalty FROM tblviolations WHERE description = :description AND severity = :severity LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':severity', $severity, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result) {
        echo json_encode(['status' => 'success', 'penalty' => $result->penalty]);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>