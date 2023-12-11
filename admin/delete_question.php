<?php

include '../utils/DbConnector.php';
session_start();
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
if ($admin != 1) {
    header("Location: /DBCO/templates/index.php");
    exit();
}
$dbConn = new DbConnector();
$point = isset($_GET['order']) ? intval($_GET['order']) : null;
$orderNum = isset($_GET['order']) ? intval($_GET['order']) : null;
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$maxPoint = $dbConn->getMaxPoint($id);
$newMaxPoint = $maxPoint - $point;
echo "tutaj jestem";
$dbConn->updateMaxPoint($id, $newMaxPoint);

$dbConn->deleteQuestion($id, $orderNum);