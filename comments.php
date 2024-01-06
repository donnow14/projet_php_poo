<?php 
class Comment{
    public $id;
    public $content;
    public $user;
    public $cours;
    public $time;
    public static $errorMsg = "";

    public static $successMsg = "";

    public function __construct(
        $content,
        $user,
        $cours
    ) {
        //initialize the attributs of the class with the parameters, and hash the password
        $this->content = $content;
        $this->user = $user;
        $this->cours = $cours;
    }

    public function insertComment($tableName, $conn)
    {
        $sql = "INSERT INTO $tableName (content, commentor_id, course_id) VALUES ('$this->content', '$this->user', '$this->cours')";
        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "New comment created successfully";
        } else {
            self::$errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    static function CountComments($tableName, $conn)
    {    
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        return $result->num_rows;
    }
    
    public static function getComments($tableName, $conn, $course_id)
    {
        $sql = "SELECT id,content,commentor_id,created_at FROM $tableName WHERE course_id='$course_id' ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }


    
}











?>