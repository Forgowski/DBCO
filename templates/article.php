<?php
require_once "header.php";
include_once "../utils/DbConnector.php";
if(!isset($_SESSION['user_id']) || !isset($_GET['course_id'])){
    header("Location: /DBCO/templates/index.php");
    exit();
}
$dbConn = new DbConnector();
$access = $dbConn->haveAccessToCourse(intval($_SESSION['user_id']), intval($_GET['course_id']));
if(empty($access)){
    header("Location: /DBCO/templates/index.php");
    exit();
}
?>
<section>
    <?php
    $dbConn = new DbConnector();
    $article = $dbConn->getArticle(intval($_GET['ext_id']));
    ?>
    <div>
        <?php
        echo $article;
        ?>
    </div>
</section>
