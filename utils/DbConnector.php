<?php


//use mysqli;

class DbConnector
{
    private $INSERT_INT0_USER = "INSERT INTO user (firstName, lastName, email, password, isAdmin) VALUES (?, ?, ?, ?, ?);";
    private $GET_USER_BY_ID = "SELECT firstName, lastName, email, isAdmin FROM user WHERE id = ?;";
    private $UPDATE_USER = "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?;";
    private $UPDATE_USER_PASSWORD = "UPDATE user SET password = ? WHERE id = ?;";
    private $DELETE_USER_BY_ID = "DELETE user WHERE id = ?;";

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $databaseName = "dbc";
    //will be private
    public $connection;

    public function __construct()
    {
    }

    public function createUser($firstName, $lastName, $mail, $hashPassword, $isAdmin=0)
    {
        $this->connect();
        $stmt = $this->connection->prepare($this->INSERT_INT0_USER);
        $stmt->bind_param("ssssi", $firstName, $lastName, $mail, $hashPassword, $isAdmin);
        $stmt->execute();
        $stmt->close();
        $this->close();
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

    //will be private
    public function connect(){
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->databaseName);
        if ($this->connection->connect_error) {
            die("Błąd połączenia: " . $this->connection->connect_error);
        }
    }
    //will be private
    public function close(){
        $this->connection->close();
    }
}