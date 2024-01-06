<?php
session_start();
include('connection.php');
include('cours.php');

if(!isset($_SESSION["prof"])) {
    header("Location: login.php");
    exit();
}
$prof = $_SESSION["prof"];
$connection = new Connection();


// Check if file and description are received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['pdfFile'], $_POST['name'])) {
    $errors     = array();
    $file_name  = $_FILES['pdfFile']['name'];
    $file_size  = $_FILES['pdfFile']['size'];
    $file_tmp   = $_FILES['pdfFile']['tmp_name'];
    $file_type  = $_FILES['pdfFile']['type'];
    $file_name_parts = explode('.', $file_name); // Split the file name into parts
    $file_ext = strtolower(end($file_name_parts));
    $description = mysqli_real_escape_string($connection->conn, $_POST['name']); // Sanitize description input

    $extensions = array("pdf"); // Allowed extensions
    $uploadPath = "./pdf/"; // Upload directory
    $uniqueName = uniqid('pdf_') . '.' . $file_ext; // Create unique file name

    // Check for file extension and size
    if (!in_array($file_ext, $extensions)) {
        $errors[] = "extension not allowed, please choose a PDF file.";
    }

    if ($file_size > 20971520) {
        $errors[] = 'File size must be exactly 20 MB or less';
    }

    // Upload file and insert into database if no errors
    if (empty($errors)) {
        // Ensure upload path exists
        // Move file to the specified directory
        if (move_uploaded_file($file_tmp, $uploadPath . $uniqueName)) {
            // SQL query to insert into database
            $new_course = new Cours($description,$prof,$uniqueName);
            $result = $new_course->insertCours("cours",$connection->conn);
            
            
            if ($result == 1) {
                echo "File is uploaded and data inserted successfully.";
            } else {
                echo "Error: " . Cours::$errorMsg;
            }
        } else {
            echo "Error uploading file";
        }
    } else {
        foreach($errors as $error) {
            echo $error;
        }
    }
} else {
    echo "No file or description";
}


?>
