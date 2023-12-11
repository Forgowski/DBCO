<?php
require_once '../templates/header.php';
include_once '../utils/DbConnector.php';

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
    elseif($type == 'quiz'){
        $dbConn = new DbConnector();
        $questions = $dbConn->getAllQuestionForQuiz($content->getExtResourceId());
    ?>
    <div>Dodaj nowe pytanie</div>
    <form action="QuizHandler.php" method="post">
        <label for="question">Pytanie:</label><input type="text" name="question" id="question" class="question">
        <label for="answerA">A</label><input type="text" name="answerA" id="answerA" class = "answer">
        <label for="answerB">B</label><input type="text" name="answerB" id="answerB" class = "answer">
        <label for="answerC">C</label><input type="text" name="answerC" id="answerC" class = "answer">
        <label for="answerD">D</label><input type="text" name="answerD" id="answerD" class = "answer">
        <label for="answerCorr">Poprawna</label><input type="text" name="answerCorr" id="answerCorr" class = "answer">
        <label for="point">Punkty do zdobycia</label><input type="number" max="3" min="1" name="point" id="point" value="1">
        <input type="hidden" name="_action" value='ADD_QUESTION'>
        <input type="hidden" name="_ext_id" value='<?php echo $content->getExtResourceId()?>'>
        <input type="submit" value="zapisz">

    </form>
        <div>Usuń pytanie</div>
        <?php
        foreach ($questions as $question) {
        ?>
        <div class = 'crs'>
            <span><?php echo $question->getQuestion();?></span>
            <span><?php echo $question->getPoint();?></span>
            <span>
            <a href='/DBCO/admin/delete_question.php?id=<?php echo $question->getQuizId(); ?>&order=<?php echo $question->getOrderNum(); ?>&point=<?php echo $question->getPoint();?>'>
                Usuń
            </a>
        </span>
        </div>

<?php }} ?>
</section>
