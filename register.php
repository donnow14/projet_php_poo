<?php 

session_start();
include('connection.php');
include('users.php');
$connection = new Connection();
$_SESSION["error"]= "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitreg'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $passwordc = $_POST["passc"];
    if($password == $passwordc && !empty($email) && !empty($password)) {
        $name = mysqli_real_escape_string($connection->conn, $name);
        $email = mysqli_real_escape_string($connection->conn, $email);
        $password = mysqli_real_escape_string($connection->conn, $password);

        // Check if the username or email already exists
        $checkQuery = "SELECT * FROM users WHERE email='$email'";
        $checkResult = $connection->execute($checkQuery);

        if ($checkResult->num_rows > 0) {
            $_SESSION["error"] = "Email already exists.";
        }else{
            $user = new User($name,$email,$password);

            if ($user->insertUsers("users",$connection->conn)) {
                $_SESSION["success"] = User::$successMsg;
                $_SESSION["error"] = "";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION["error"] = User::$errorMsg;
            }
        }
       
    }else{
        $_SESSION["error"] = "Password does not match, please try again";
    }
    
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   

   
   <link rel="stylesheet" href="css/astyle.css">

</head>
<body class="bg-light">
    <header>
    <div class="logo"><img src="images/EMSI1.png" alt="logo"></div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <ul>
                <li>
                    <a href="index.php" >Home</a>
                </li>
                <li>
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="contact.php">Contact us</a>
                </li>
                <li>
                    <a href="#" class="active">My Account</a>
                </li>
            </ul>
        </nav>
        <label for="nav_check" class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </header>
     <section id="signup" class="form-container" style="display: ;">

        <form action="" method="post" enctype="multipart/form-data">
           <h3>Create Account</h3>
           <div class="errormsg" ><?php echo $_SESSION["error"];?></div>
           <p>Name <span>*</span></p>
           <input type="text" name="name" placeholder="Enter your name" required maxlength="50" class="box">
           <p>Email <span>*</span></p>
           <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
           <p>Password<span>*</span></p>
           <input type="password" name="pass" placeholder="Enter your password" required maxlength="20" class="box">
           <p>Confirm Password<span>*</span></p>
           <input type="password" name="passc" placeholder="confirm your password" required maxlength="20" class="box">
           <input type="submit" value="Signup" name="submitreg" class="btn login">
           <input type="button" value="Login" onclick="ToLogin()" name="submit" class="btn signup">
        </form>
        
        <br><br><br><br>
     </section>
     <script>
        function ToLogin(){
            window.location.href = 'login.php';
        }
    </script>
</body>


</html>
