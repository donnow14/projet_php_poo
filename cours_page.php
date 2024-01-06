<?php 

session_start();
include('functions.php');
include('connection.php');
include('comments.php');
include('users.php');
include('cours.php');
include('profs.php');
$connection = new Connection();

if(!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}else{
    $id = $_SESSION["id"]; 
    $row = User::selectuserbyid("users",$connection->conn,$id);

    if (isset($row["full_name"])) {
        $fname = $row["full_name"];
        $semail = $row["email"];
        $profilpic = $row["avatar"];
    } else {
        $_SESSION["error"] = "Cant get data from DB";
        session_destroy();
        header("Location: account.php");
    }
    $id_cours = $_GET['id'];
    $row = Cours::getCours("cours",$connection->conn,$id_cours);
    $cours_name = $row['name'];
    $prof_id = $row['prof'];
    $prof_name = Prof::getnamebyid("profs",$connection->conn,$prof_id);
    $prof_pic = Prof::getavatarbyid("profs",$connection->conn,$prof_id);
    $pdf_name = $row['pdf_name'];
    $cours_date = $row['added_time'];

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
                    <a href="dashboard.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="library.php">
                        <span class="icon">
                        <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Courses</span>
                    </a>
                </li>

                <li>
                    <a href="contact.php">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">Help</span>
                    </a>
                </li>

                <li>
                    <a href="account.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title" id="tosettings">Settings</span>
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
                        <h2><?php echo $cours_name;?></h2>
                    </div>
                    <div class="profile-container">
                        <img src="./profil/<?php echo $prof_pic;?>" alt="Profile Picture" class="profile-pic" width="80" height="80">
                        <div class="profile-info">
                            <h2><?php echo $prof_name;?></h2>
                            <p class="published-date">Published on <?php echo $cours_date;?></p>
                        </div>
                    </div>
                    <div class="pdf-container">
                        <embed
                            src="./pdf/<?php echo $pdf_name;?>"
                            type="application/pdf"
                            frameBorder="0"
                            scrolling="auto"
                            height="100%"
                            width="100%"
                        ></embed>
                        
                        <hr style="color:black;margin:10px;">
                    </div>
                    <br>
                    <div style="" class="user-comment">
                        <div class="profile-container">
                            <img src="./profil/<?php echo $profilpic;?>" alt="Profile Picture" class="profile-pic" width="80" height="80">
                            <div style="width: 100%;display: flex;">
                                <input type="hidden" id="id_commentor" value="<?php echo $id ?>">
                                <input type="hidden" id="id_cours" value="<?php echo $id_cours ?>">
                                <textarea required placeholder="Enter your comment ..." style="flex: 1;display: flex; vertical-align: top;padding: 10px;font-size:15px;" name="" id="commentContent" cols="" rows="2"></textarea>
                                <button style="margin-left:5px;max-width: 150px;display: inline-block; vertical-align: top; height: 100%;" onclick="postComment()" class="user-comment-button">Comment</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="max-height: 200px;overflow-y: auto;">
                        <?php 
                        Getcomments($connection->conn,$id_cours);
                        ?>
                    </div>
                </div>

                <!-- ================= New Customers ================ -->
                
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script>
        function postComment() {
            // Get the comment content from the textarea
            var commentContent = $('#commentContent').val();
            var commentor_id = $('#id_commentor').val();
            var cours_id = $('#id_cours').val();

            // Perform an AJAX request to send the comment to the server
            $.ajax({
                type: 'POST',
                url: 'post_comment.php', // Change this to the actual path of your PHP script
                data: { 
                    content: commentContent,
                    courseId: cours_id,
                    userId: commentor_id
                 },
                success: function(response) {
                    location.reload();
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