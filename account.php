<?php 

require('connection.php');
require('users.php');
$connection = new Connection();
session_start();
$_SESSION["error"]= "";
$_SESSION["success"]= "";
if(!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}else{
    $id = $_SESSION["id"]; 
    $row = User::selectuserbyid("users",$connection->conn,$id);
    if (isset($row)) {
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $old_password = $_POST["old_pass"];
    $password = $_POST["new_pass"];
    $passwordc = $_POST["c_pass"];
    $id = $_SESSION["id"]; 
    $sql = "SELECT * FROM users WHERE id = $id";
    //$result = $conn->query($sql);
    $result = $connection->execute($sql);
    if ($_FILES["avatar"]["error"] == UPLOAD_ERR_OK) {
        $uploadDir = 'profil/';
        $uploadFileName = uniqid() . '_' . basename($_FILES['avatar']['name']);
        $uploadFile = $uploadDir . $uploadFileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
            // Insert data into the database
            //$sql = "INSERT INTO users (avatar) VALUES ('$uploadFile') WHERE id=$id";
            $sql = "UPDATE users SET avatar = '$uploadFileName' WHERE id = $id";
            $profilpic = $uploadFileName;
            if ($connection->execute($sql) === TRUE) {
            } else {
                $_SESSION["error"]="failed Upload profil db";
            }
        } else {
            $_SESSION["error"]="failed to move profil";
        }
    } else {
        $_SESSION["error"]="Upload profil error";
    }
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $db_password = $row["password"];
    } else {
        $_SESSION["error"] = "Cant get data from DB";
        session_destroy();
        header("Location: account.php");
    }
    //password_verify($old_password, $db_password)
    if(password_verify($old_password, $db_password)) {
        if($password == $passwordc && !empty($password) && !empty($name) && !empty($email)) {
            $hashed_pass = password_hash($passwordc, PASSWORD_DEFAULT);
            $new_data = new User($name,$email,$hashed_pass,$profilpic);
            //$updateQuery = "UPDATE users SET full_name = '$name', email = '$email', password = '$hashed_pass' WHERE id = $id";
            $updateResult = user::updateUsers($new_data,"users",$connection->conn,$id);
            if ($updateResult == 1) {
                $_SESSION["success"] = "Profile updated successfully.";
                $_SESSION["error"] = "";
            } else {
                $_SESSION["error"] = "Failed to update profile. Please try again.";
            }





        }else{
            $_SESSION["error"] = "Please fill all the fields correctly";
        }
    }else{
        $_SESSION["error"] = "Incorrect password, please try again";
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
     <section id="profil" class="form-container" style="display: ;">

        <form action="" method="post" enctype="multipart/form-data">
           <h3>Edit profil</h3>
           <img class="avatar" src="<?php if(isset($profilpic)){
            echo "profil/$profilpic";
        }else{
            echo "profil/default.png";
        } ?>" alt="">
           <p>Name</p>
           <input type="text" name="name" value="<?php echo $fname ?>" maxlength="50" class="box">
           <p>Email</p>
           <input type="email" name="email" value="<?php echo $semail ?>" maxlength="50" class="box">
           <p>Old Password<P>
           <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20" class="box">
           <p>New Password</p>
           <input type="password" name="new_pass" placeholder="enter your old password" maxlength="20" class="box"  >
           <p>Confirm Password</p>
           <input type="password" name="c_pass" placeholder="confirm your new password" maxlength="20" class="box"  >
           <p>Avatar</p>
           <input type="file" accept="image/*" name="avatar" class="box">
           <div class="errormsg" ><?php echo $_SESSION["error"];?></div>
           <div class="successmsg" ><?php echo $_SESSION["success"];?></div>
           <input type="submit" value="update profile" name="update" class="btn login">
           <input type="submit" value="Logout" name="logout" class="btn signup">
        </form>

     
     </section>
</body>


</html>
