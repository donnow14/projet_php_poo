<?php

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $reg_date;
    public $role;
    public $avatar;

    public static $errorMsg = "";

    public static $successMsg = "";

    public function __construct(
        $name,
        $email,
        $password,
        $avatar = "default.png"
    ) {
        //initialize the attributs of the class with the parameters, and hash the password
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->role = "student";
        $this->avatar = $avatar;
    }

    public function insertUsers($tableName, $conn)
    {
        //insert a client in the database, and give a message to $successMsg and $errorMsg
        $sql = "INSERT INTO $tableName (full_name, email, password, role, avatar) VALUES ('$this->name', '$this->email', '$this->password', '$this->role', '$this->avatar')";
        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "New record created successfully";
            return true;
        } else {
            self::$errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
            return false;
        }
    }
    public static function selectuserbyid($tableName, $conn, $id)
    {
        $sql = "SELECT full_name,email,avatar FROM $tableName WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        }
    }
    public static function selectAllStudents($tableName, $conn)
    {
        $sql = "SELECT full_name,email,avatar FROM $tableName WHERE role = 'student' LIMIT 7";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    static function CountUsers($tableName, $conn)
    {    
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        return $result->num_rows;
    }

    
    static function updateUsers($user, $tableName, $conn, $id)
    {

        $sql = "UPDATE $tableName SET full_name='$user->name',email='$user->email',avatar='$user->avatar' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "New record updated successfully";
            return 1;
            //header("Location:read.php");
        } else {
            self::$errorMsg = "Error updating record: " . mysqli_error($conn);
            return 0;
        }
    }

    static function deleteUsers($tableName, $conn, $id)
    {
        //delet a client by his id, and send the user to read.php
        $sql = "DELETE FROM $tableName WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "Record deleted successfully";
            //header("Location:read.php");
        } else {
            self::$errorMsg = "Error deleting record: " . mysqli_error($conn);
        }
    }

    static function getnamebyid($tableName, $conn, $id)
    {
        $sql = "SELECT full_name FROM $tableName WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["full_name"];
    }
    static function getavatarbyid($tableName, $conn, $id)
    {
        $sql = "SELECT avatar FROM $tableName WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["avatar"];
    }
}

?>
