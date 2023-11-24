<?php

namespace utils;
use mysqli;

class DbConnector
{
    private $INSERT_INT0_USER = "INSERT INTO user (firstName, lastName, email, password, isAdmin) VALUES (?, ?, ?, ?, ?);";

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $databaseName = "dbc";
    //will be private
    public $connection;

    public function __construct()
    {
    }

    public function createUser($account)
    {
        $this->connect();
        $stmt = $this->connection->prepare($this->INSERT_INT0_USER);
        $stmt->bind_param("ssssi", $account->getFirstName(), $account->getLastName(), $account->getMail(), $account->getPassword(), $account->getIsAdmin());
        $stmt->execute();
        $stmt->close();
        $this->close();
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