<?php 

session_start();
include('functions.php');
include('connection.php');
include('comments.php');
include('users.php');
include('cours.php');
include('profs.php');
$connection = new Connection();

if(!isset($_SESSION["prof"])) {
    header("Location: login.php");
    exit();
}else{
    $id = $_SESSION["prof"]; 
    $row = Prof::selectProfbyid("profs",$connection->conn,$id);

    if (isset($row["full_name"])) {
        $fname = $row["full_name"];
        $semail = $row["email"];
        $profilpic = $row["avatar"];
    } else {
        $_SESSION["error"] = "Cant get data from DB";
        session_destroy();
        header("Location: account.php");
    }
    

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_destroy();
    header("Location: account.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                <a href="#">
                        <span style="" class="icon">
                            <img  width="60px" src="images/EMSI.png" alt="">
                        </span>
                        <span class="title">Courses portal</span>
                    </a>
                </li>

               
                <li>
                    <a href="prof_library.php">
                        <span class="icon">
                        <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Courses</span>
                    </a>
                </li>

               

                
                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title" id="logout">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                

                <div class="user">
                    <img src="<?php if(isset($profilpic)){
                            echo "profil/$profilpic";
                        }else{
                            echo "profil/default.png";
                        } ?>" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            

            <!-- ================ Order Details List ================= -->
            <div class="detailsbook">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Add Course</h2>
                    </div>
                    
                    <br>
                    <div style="" class="user-comment">
                        <div class="profile-container" >
                            <img src="./profil/<?php echo $profilpic;?>" alt="Profile Picture" class="profile-pic" width="80" height="80">
                            <div style="width: 100%;display: block;">
                               
                                <input required placeholder="Enter the course name" style="min-width:50%;display: block; vertical-align: top;padding: 10px;font-size:15px;" name="name_cours" id="name_cours" cols="" rows="2"></input>
                                <input type="file" name="pdfFile" id="pdfFile" style="min-width:50%;display: block; vertical-align: top;padding: 10px;font-size:15px;" accept=".pdf">
                                <button disabled style="margin-left:5px;width: 100px;; vertical-align: top; height: 50px;" id="submitButton" onclick="publish()" class="user-comment-button">Publish</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="max-height: 200px;overflow-y: auto;">
                        
                    </div>
                </div>

                <!-- ================= New Customers ================ -->
                
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var textField = document.getElementById('name_cours');
            var fileField = document.getElementById('pdfFile');
            var button = document.getElementById('submitButton');

            function checkFields() {
                // Check if text field is not empty and file has been chosen
                if(textField.value.trim() !== "" && fileField.value !== "") {
                    button.disabled = false; // Enable the button
                } else {
                    button.disabled = true; // Disable the button
                }
            }

            // Attach the event listeners to input fields
            textField.addEventListener('input', checkFields);
            fileField.addEventListener('change', checkFields); // Note the 'change' event for file input
        });

        function publish(){
            var formData = new FormData();
            var pdfFile = $('#pdfFile')[0].files[0]; // Getting the selected file from form
            var name = $('#name_cours').val();
            // Append the file to the formData object
            // 'pdfFile' is the key which will be accessed on server side to get the file
            formData.append('pdfFile', pdfFile);
            formData.append('name', name);


            $.ajax({
                type: 'POST',
                url: 'upload_pdf.php', // Change this to the actual path of your PHP upload handler script
                data: formData,
                contentType: false, // Tell jQuery not to process the data
                processData: false, // Tell jQuery not to set contentType
                success: function(response) {
                    location.href = "prof_library.php"; // Handle the response from server
                    // Optionally, you might want to refresh or update part of your page, or display a message, etc.
                },
                error: function(){
                    alert("There was an error uploading the file!");
                }
            });
        }
    </script>
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>
</html>