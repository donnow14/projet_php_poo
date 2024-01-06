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


if(isset($_GET['id'])){
    $recordId = $_GET['id'];
    $query = "DELETE FROM cours WHERE id = $recordId";
    $connection->execute($query);
    $query = "DELETE FROM comments WHERE course_id = $recordId";
    $connection->execute($query);
}

header('Location: prof_library.php');


?>