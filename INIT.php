<?php


require 'connection.php'; 

$conn = new Connection();
##################################################################### CREATE TABLE USERS AND ADD 1 USER

$sql = "CREATE TABLE USERS (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default.png',
    role VARCHAR(50) DEFAULT 'student',
    reg_date TIMESTAMP,
    password VARCHAR(255) NOT NULL DEFAULT '" . password_hash('password', PASSWORD_DEFAULT) . "'
)";


$conn->createTable($sql);

$fullName = "oussama el mestame";
$email = "oussamaht@outlook.com";
$password = "123"; // You should prompt the user for this, not hard code it

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Create the INSERT statement
$sql = "INSERT INTO USERS (full_name, email, password) VALUES ('$fullName', '$email', '$hashedPassword')";

// Execute the query
$result = $conn->execute($sql);
echo "<br>";
if($result) {
    echo "New record (oussama el mestame) created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn->conn);
}
echo "<br>";
######################################################################### CREATE TABLE PROFS and add 1 prof
// SQL to create table
$sql = "CREATE TABLE profs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'prof.png',
    password VARCHAR(255) NOT NULL DEFAULT '" . password_hash('password', PASSWORD_DEFAULT) . "',
    ref_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->createTable($sql);
echo "<br>";
$fullName = "mohammed alaoui";
$email = "mohammed@maroc.ma";
$avatar = "prof.png";
$plaintextPassword = "123";  // The plaintext password to be hashed

// Hash the password for security
$hashedPassword = password_hash($plaintextPassword, PASSWORD_DEFAULT);

// SQL to insert a new record into the profs table
$sql = "INSERT INTO profs (full_name, email, password, ref_date, avatar) VALUES ('$fullName', '$email', '$hashedPassword', NOW(), '$avatar')";

// Execute the query
$result = $conn->execute($sql);

if($result) {
    echo "New record (mohammed alaoui) created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn->conn);
}
echo "<br>";

######################################################################  create course and add 1 course

$sql = "CREATE TABLE cours (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    prof INT(6) UNSIGNED,
    pdf_name VARCHAR(255),
    added_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";


$conn->createTable($sql);
echo "<br>";



####################################################################### create comments table

$sql = "CREATE TABLE comments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content TEXT,
    commentor_id INT(6) UNSIGNED,
    course_id INT(6) UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";


$conn->createTable($sql);

echo "<br>";
echo "ALL DONE YOU CAN TRY THE APP NOW :)";

?>
