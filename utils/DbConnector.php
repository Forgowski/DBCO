<?php


//use mysqli;

class DbConnector
{
    private $INSERT_INT0_USER = "INSERT INTO user (firstName, lastName, email, password, isAdmin) VALUES (?, ?, ?, ?, ?);";
    private $GET_USER_BY_ID = "SELECT firstName, lastName, email, isAdmin FROM user WHERE id = ?;";
    private $GET_ID_AFTER_REG = "SELECT id FROM user WHERE email = ? AND password = ?; ";
    private $UPDATE_USER = "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?;";
    private $UPDATE_USER_PASSWORD = "UPDATE user SET password = ? WHERE id = ?;";
    private $DELETE_USER_BY_ID = "DELETE FROM user WHERE id = ?;";

    private $DELETE_COURSE_BY_ID = "DELETE FROM course WHERE id = ?;";
    private $CREATE_COURSE = "INSERT INTO course (name, author, description, price, category, aprox_lenght_min, rate, vote_num) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    private $GET_COURSE_BY_NAME = "SELECT * FROM course WHERE name = ?";
    private $GET_COURSE_BY_ID = "SELECT * FROM course WHERE id = ?";

    private $GET_ALL_COURSES = "SELECT * FROM course";
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $databaseName = "dbc";
    //will be private
    public $connection;

    public function __construct()
    {
    }

    public function getCourseById($id){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_COURSE_BY_ID);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $name = null;
        $author = null;
        $description = null;
        $price = null;
        $category = null;
        $aprox_lenght_min = null;
        $rate = null;
        $vote_num = null;
        $stmt->bind_result($id, $name, $author, $description, $price, $category, $aprox_lenght_min, $rate, $vote_num);
        $course = new \admin\Course($id, $name, $price, $aprox_lenght_min, $author, $category, $description, $rate, $vote_num);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $course;
    }

    public function getCourseByName($name){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_COURSE_BY_NAME);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $id = null;
        $author = null;
        $description = null;
        $price = null;
        $category = null;
        $aprox_lenght_min = null;
        $rate = null;
        $vote_num = null;
        $stmt->bind_result($id, $name, $author, $description, $price, $category, $aprox_lenght_min, $rate, $vote_num);
        $course = new \admin\Course($id, $name, $price, $aprox_lenght_min, $author, $category, $description, $rate, $vote_num);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $course;
    }

    public function getAllCourses(){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_ALL_COURSES);
        $stmt->execute();

        $stmt->bind_result($id, $name, $author, $description, $price, $category, $aprox_lenght_min, $rate, $vote_num);

        $courses = array();

        while ($stmt->fetch()) {
            $course = new \admin\Course($id, $name, $price, $aprox_lenght_min, $author, $category, $description, $rate, $vote_num);
            $courses[] = $course;
        }

        $stmt->close();
        $this->close();

        return $courses;


    }

    public function createCourse($name, $author, $description, $price, $category, $aprox_lenght_min, $rate=0, $vote_num=0){
        $aproxInt = intval($aprox_lenght_min);
        $this->connect();
        $stmt = $this->connection->prepare($this->CREATE_COURSE);
        $stmt->bind_param("sssdsiii", $name, $author, $description, $price, $category, $aproxInt, $rate, $vote_num);
        $stmt->execute();
        $stmt->close();
        $this->close();
        return $this->getCourseByName($name);
    }

    public function deleteCourse($id){
        $this->connect();
        $stmt = $this->connection->prepare($this->DELETE_COURSE_BY_ID);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function createUser($firstName, $lastName, $mail, $hashPassword, $isAdmin=0)
    {
        $user_id = null;
        $this->connect();
        $stmt = $this->connection->prepare($this->INSERT_INT0_USER);
        $stmt->bind_param("ssssi", $firstName, $lastName, $mail, $hashPassword, $isAdmin);
        $stmt->execute();
        $stmt->close();
        $this->close();
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_ID_AFTER_REG);
        $stmt->bind_param("ss", $mail, $hashPassword);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $user_id;
    }

    public function login($email, $hashPassword){
        $user_id=NULL;
        $this->connect();
        $stmt = $this->connection->prepare("SELECT try_log_in(?, ?)");
        $stmt->bind_param("ss", $email, $hashPassword);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $user_id;
    }

    public function updateUserData($firstName, $lastName, $email, $id){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_USER);
        $stmt->bind_param("sssi", $firstName, $lastName, $email, $id);
        $stmt->execute();
        $this->close();
    }

    public function getUser($id){
        $isAdmin = NULL;
        $email = NULL;
        $lastName = NULL;
        $firstName = NULL;

        $this->connect();
        $stmt = $this->connection->prepare($this->GET_USER_BY_ID);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($firstName, $lastName, $email, $isAdmin);
        $stmt->fetch();
        $user = new account\User($firstName, $lastName, $email, $isAdmin);
        $stmt->close();
        $this->close();
        return $user;
    }

    public function updateUserPassword($hash_password, $id){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_USER_PASSWORD);
        $stmt->bind_param("si", $hash_password ,$id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function deleteUser($id){
        $this->connect();
        $stmt = $this->connection->prepare($this->DELETE_USER_BY_ID);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function isAdmin($id){
        $admin = NULL;
        $this->connect();
        $stmt = $this->connection->prepare("SELECT is_admin(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($admin);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $admin;
    }

    private function connect(){
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->databaseName);
        if ($this->connection->connect_error) {
            die("Błąd połączenia: " . $this->connection->connect_error);
        }
    }
    private function close(){
        $this->connection->close();
    }
}