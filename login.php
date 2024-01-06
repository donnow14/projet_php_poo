<?php 
session_start();
include('connection.php');
$connection = new Connection();

$_SESSION["error"]= "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitlogin'])) {
    $emailValue = $_POST["email"];
    $passwordValue = $_POST["pass"];
    $password = password_hash($passwordValue, PASSWORD_DEFAULT);
    // Validate user credentials
    $sql = "SELECT id,password FROM users WHERE email = '$emailValue'";
    $result = $connection->execute($sql);
    if(mysqli_num_rows($result) > 0){
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row["password"];
        if (password_verify($passwordValue, $storedHashedPassword)) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["error"] = "";
            header("Location: dashboard.php"); // Redirect to the dashboard or another secured page
        } else {
            $_SESSION["error"] = "Invalid password";
        }
    }else{
        $_SESSION["error"] = "Invalid email";
    }
    
    
}
if(isset($_SESSION["id"])) {
    header("Location: dashboard.php");
    exit();
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
    <section id="login" class="form-container" style="">

        <form action="" method="post" enctype="multipart/form-data">
        
           <h3 >Students Portal</h3>
           <div class="errormsg" ><?php echo $_SESSION["error"];?></div>
           <p>Email <span>*</span></p>
           <input type="email" name="email" placeholder="Enter your email" value="<?php if(isset($_POST["email"])){echo $_POST["email"];}?>" required maxlength="50" class="box">
           <p>Password<span>*</span></p>
           <input type="password" name="pass" placeholder="Enter your password" required maxlength="20" class="box">
           <a class="link" href="">Forgot password ?</a>
           <input type="submit" value="Login" name="submitlogin" class="btn login">
           <input type="submit" value="Signup" onclick="ToSignup()" name="submit" class="btn signup">
           <input type="submit" value="Profs Portal" onclick="ToProf()" name="submit" class="btn signup">
        </form>
        <br><br><br><br>
     </section>
    
     <script>
        function ToProf(){
            window.location.href = 'prof_login.php';
        }
        function ToSignup(){
            window.location.href = 'register.php';
        }
    </script>
</body>


</html>
