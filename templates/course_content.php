<?php
require_once "header.php";
include_once "../utils/DbConnector.php";
include_once "../admin/Content.php";

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
$courseId = intval($_GET['course_id']);
$contents = $dbConn->getContentOfCourse($courseId);
?>
<section>
    <?php
        foreach ($contents as $content){
            ?>
            <div>
                <?php
                if($content->getType()=="article"){
                ?>
                <a href ='/DBCO/templates/article.php?course_id=<?php echo $courseId?>&ext_id=<?php echo $content->getExtResourceId()?>'>
                <?php
                }
                else{
                ?>
                    <a href ='/DBCO/templates/quiz.php?course_id=<?php echo $courseId?>&ext_id=<?php echo $content->getExtResourceId()?>'>
                    <?php
                        }
                    ?>
                    <span><?php echo $content->getTitle()?></span>
                    <span><?php echo $content->getType()?></span>
                </a>
            </div>
        <?php
        }
        ?>

</section>
