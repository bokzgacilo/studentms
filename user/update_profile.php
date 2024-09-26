<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];
    $studentName = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $studentClass = $_POST['studentClass'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $contactNumber = $_POST['contactNumber'];
    $altenateNumber = $_POST['altenateNumber'];
    $address = $_POST['address'];
    $admissionDate = isset($_POST['admissionDate']) ? $_POST['admissionDate'] : '';

    // Handle file upload
    $profileImage = isset($_FILES['profileImage']['name']) ? $_FILES['profileImage']['name'] : '';
    $target_dir = "../admin/images/";
    $newImageName = $studentId . '.' . pathinfo($profileImage, PATHINFO_EXTENSION);
    $target_file = $target_dir . basename($newImageName);

    if ($profileImage) {
        // Ensure directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target_file)) {
            $imageStatus = "Image uploaded successfully.";
            $imageName = $newImageName;
            $imagePath = $target_file;
        } else {
            $imageStatus = "Image upload failed. Please try again.";
            $imageName = '';
            $imagePath = '';
        }
    } else {
        $imageStatus = "No image uploaded.";
        $imageName = '';
        $imagePath = '';
    }

    // Update the student profile
    if ($profileImage) {
        $sql = "UPDATE tblstudent SET 
                StudentName = :studentName,
                StudentEmail = :studentEmail,
                StudentClass = :studentClass,
                Gender = :gender,
                DOB = :dob,
                FatherName = :fatherName,
                MotherName = :motherName,
                ContactNumber = :contactNumber,
                AltenateNumber = :altenateNumber,
                Address = :address,
                DateofAdmission = :admissionDate,
                Image = :profileImage
                WHERE StuID = :studentId";
    } else {
        $sql = "UPDATE tblstudent SET 
                StudentName = :studentName,
                StudentEmail = :studentEmail,
                StudentClass = :studentClass,
                Gender = :gender,
                DOB = :dob,
                FatherName = :fatherName,
                MotherName = :motherName,
                ContactNumber = :contactNumber,
                AltenateNumber = :altenateNumber,
                Address = :address,
                DateofAdmission = :admissionDate
                WHERE StuID = :studentId";
    }

    $query = $dbh->prepare($sql);

    $query->bindParam(':studentName', $studentName, PDO::PARAM_STR);
    $query->bindParam(':studentEmail', $studentEmail, PDO::PARAM_STR);
    $query->bindParam(':studentClass', $studentClass, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':fatherName', $fatherName, PDO::PARAM_STR);
    $query->bindParam(':motherName', $motherName, PDO::PARAM_STR);
    $query->bindParam(':contactNumber', $contactNumber, PDO::PARAM_STR);
    $query->bindParam(':altenateNumber', $altenateNumber, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':admissionDate', $admissionDate, PDO::PARAM_STR);
    $query->bindParam(':studentId', $studentId, PDO::PARAM_STR);

    if ($profileImage) {
        $query->bindParam(':profileImage', $imageName, PDO::PARAM_STR);
    }

    if ($query->execute()) {
        $updateStatus = "Student profile updated successfully.";
    } else {
        $updateStatus = "Something went wrong. Please try again.";
    }

    // Debugging output
    echo "<h2>Debugging Information:</h2>";
    echo "<p><strong>Student ID:</strong> $studentId</p>";
    echo "<p><strong>Student Name:</strong> $studentName</p>";
    echo "<p><strong>Student Email:</strong> $studentEmail</p>";
    echo "<p><strong>Student Class:</strong> $studentClass</p>";
    echo "<p><strong>Gender:</strong> $gender</p>";
    echo "<p><strong>DOB:</strong> $dob</p>";
    echo "<p><strong>Father's Name:</strong> $fatherName</p>";
    echo "<p><strong>Mother's Name:</strong> $motherName</p>";
    echo "<p><strong>Contact Number:</strong> $contactNumber</p>";
    echo "<p><strong>Alternate Number:</strong> $altenateNumber</p>";
    echo "<p><strong>Address:</strong> $address</p>";
    echo "<p><strong>Date of Admission:</strong> $admissionDate</p>";
    echo "<p><strong>Image Upload Status:</strong> $imageStatus</p>";
    if ($imageStatus == "Image uploaded successfully.") {
        echo "<p><strong>Image Name:</strong> $imageName</p>";
        echo "<p><strong>Image Path:</strong> $imagePath</p>";
    }
    echo "<p><strong>Database Update Status:</strong> $updateStatus</p>";

    header("Location: student-profile.php");
}
?>