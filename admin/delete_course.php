<?php
include_once '../utils/DbConnector.php';
session_start();
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
if($admin!=1){
    header("Location: /DBCO/templates/index.php");
    exit();
}
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$dbConn = new DbConnector();
$dbConn->deleteCourse($id);
