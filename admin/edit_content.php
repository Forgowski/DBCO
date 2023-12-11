<?php
require_once '../templates/header.php';
include '../utils/DbConnector.php';

$type = $_GET['type'];
?>
<section>
    <?php
    $dbConn = new DbConnector();
    $content = $dbConn->getContent(intval($_GET['course_id']), intval($_GET['order']));
    if($type == 'article'){
        $article = $dbConn->getArticle($content->getExtResourceId());
    ?>
        <form action="CourseHandler.php" method="post">
                <label for="title">Tytuł</label><input id="title" name="title" type="text"
                value=<?php echo $content->getTitle();?>>
                <textarea name="article" id="article" rows="10" cols="80">
                    <?php
                    echo $article;
                    ?>
                </textarea>
                <input type="hidden" name="_ext_id" value='<?php echo $content->getExtResourceId()?>'>
                <input type="hidden" name="_course_id" value='<?php echo $content->getCourseId()?>'>
                <input type="hidden" name="_order_num" value='<?php echo $content->getOrderNum()?>'>
                <input type="hidden" name="_action" value="EDIT_ARTICLE">
                <input type="submit" value="Stwórz artykuł">
            </form>
    <?php
    }
    ?>

</section>
