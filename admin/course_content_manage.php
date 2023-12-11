<?php
require_once '../templates/header.php';
include '../utils/DbConnector.php';
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
if($admin!=1){
    header("Location: /DBCO/templates/index.php");
    exit();
}
$id = isset($_SESSION['course_id']) ? intval($_SESSION['course_id']) : null;
$dbConn = new DbConnector();
$contents = $dbConn->getContentOfCourse($id);

?>
<section>
    <?php
    foreach ($contents as $content) {
    ?>
    <div class = 'crs'>
            <span><?php echo $content->getTitle();?></span>
            <span><?php echo $content->getType();?></span>
        <span>
        <a href='/DBCO/admin/edit_content.php?course_id=<?php echo $content->getCourseId(); ?>&order=<?php echo $content->getOrderNum(); ?>&type=<?php echo $content->getType();?>'>
            Edytuj zawartość
        </a>
        </span>
        <span>
        <a href='/DBCO/admin/delete_content.php?id=<?php echo $id; ?>&order=<?php echo $content->getOrderNum(); ?>'>
            Usuń zawartość
        </a>
        </span>
    </div>
    <?php
    }
    ?>
    <button onclick="location.href='/DBCO/admin/create_article.php?id=<?php echo $id;?>'">Dodaj nowy artykuł</button>
    <button onclick="location.href='/DBCO/admin/create_quiz.php?id=<?php echo $id;?>'">Dodaj nowy quiz</button>
</section>