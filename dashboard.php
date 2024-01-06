<?php 

session_start();
include('functions.php');
include('connection.php');
include('users.php');
include('cours.php');
include('comments.php');
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
    <title>Dashboard</title>
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
                    <a href="#">
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
            <div id="cardbox" class="cardBox" >
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo GetCommentsN($connection->conn);?></div>
                        <div class="cardName">Comments</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php echo GetCoursN($connection->conn);?></div>
                        <div class="cardName">courses</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="book-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php echo GetProfsN($connection->conn);?></div>
                        <div class="cardName">Profs</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="person-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php echo GetStudentsN($connection->conn);?></div>
                        <div class="cardName">Students</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent course</h2>
                        <a href="library.php" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td style="text-align:center;">Date</td>
                                <td>Prof</td>
                                <td>File</td>
                                <td>View</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            Getcours($connection->conn);
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent Students</h2>
                    </div>

                    <table>
                        <?php 
                        GetStudents($connection->conn);
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script>

    </script>
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
</body>
</html>