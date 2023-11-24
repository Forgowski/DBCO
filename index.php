<?php

use account\User;
use utils\DbConnector;

//tymczasowy plik do testów


include 'utils/DbConnector.php';
include 'account/User.php';

$dbConnector = new DbConnector();
$dbConnector->connect();
if ($dbConnector->connection->connect_error) {
    die("Connection failed: " . $dbConnector->connection->connect_error);
}
echo "Connected successfully";
$dbConnector->close();
$user = new User("Marcin", "Bober", "marcin.bober2@gmail.com", 'haslo123');
@$dbConnector->createUser($user);
