<?php
include_once "../utils/DbConnector.php";
$dbConn = new DbConnector();
session_start();
$userId = intval($_SESSION['user_id']);
$courseId = intval($_GET['course_id']);
$dbConn->mockOrder($userId, $courseId);
session_write_close();
header("Location: /DBCO/templates/moje_kursy.php");
exit();