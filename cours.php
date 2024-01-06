<?php 
class Cours{
    public $id;
    public $name;
    public $publisher;
    public $pdf_name;
    public $time;
    public static $errorMsg = "";

    public static $successMsg = "";

    public function __construct(
        $name,
        $publisher,
        $pdf_name
    ) {
        //initialize the attributs of the class with the parameters, and hash the password
        $this->name = $name;
        $this->publisher = $publisher;
        $this->pdf_name = $pdf_name;
    }

    public function insertCours($tableName, $conn)
    {
        $sql = "INSERT INTO $tableName (name, prof, pdf_name) VALUES ('$this->name', '$this->publisher', '$this->pdf_name')";
        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "New record created successfully";
            return 1;
        } else {
            self::$errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
            return 0;
        }
    }

    static function CountCours($tableName, $conn)
    {    
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        return $result->num_rows;
    }
    public static function showCours($tableName, $conn)
    {
        $sql = "SELECT id,name,prof,pdf_name,added_time FROM cours LIMIT 7";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }
    public static function getCours($tableName, $conn, $id)
    {
        $sql = "SELECT id,name,prof,pdf_name,added_time FROM $tableName WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public static function getCoursID($tableName, $conn, $prof)
    {
        $sql = "SELECT id,name,prof,pdf_name,added_time FROM $tableName WHERE prof='$prof'";
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