<?php
session_start();
include('connection.php');
include('comments.php');
$connection = new Connection();
if(!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}else{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
        $content = $_POST['content'];
        $userId = $_SESSION["id"];
        $courseId = $_POST['courseId'];
    
        $comment = new Comment($content,$userId,$courseId);
    
        $comment->insertComment("comments",$connection->conn);
    }
}
?>