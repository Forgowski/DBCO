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
    $point = $dbConn->getUserScore(intval($_SESSION['user_id']), intval($_GET['ext_id']));
    if(isset($point)){
        ?>
        <div>Twój najlepszy wynik to <?php echo $point?></div>
    <?php
    }
    ?>
    <form action ="../admin/QuizHandler.php" method="post">
    <?php
    $questions = $dbConn->getAllQuestionForQuiz(intval($_GET['ext_id']));
    $i = 0;
    foreach ($questions as $question){
        ?>
    <div>
        <div><?php echo $question->getQuestion()?></div>
        <input type="radio" name="pytanie<?php echo $i?>" value="<?php echo $question->getAnswerA();?>"><?php echo $question->getAnswerA()?><br>
        <input type="radio" name="pytanie<?php echo $i?>" value="<?php echo $question->getAnswerB();?>"><?php echo $question->getAnswerB()?><br>
        <input type="radio" name="pytanie<?php echo $i?>" value="<?php echo $question->getAnswerC();?>"><?php echo $question->getAnswerC()?><br>
        <input type="radio" name="pytanie<?php echo $i?>" value="<?php echo $question->getAnswerD();?>"><?php echo $question->getAnswerD()?><br>
    </div>
    <?php
        $i = $i +1;
        }
    ?>
        <input type="hidden" name="_quiz_id" value='<?php echo $_GET['ext_id']?>'>
        <input type="hidden" name="_action" value="CHECK_QUIZ">
        <input type="submit" value="Wyślij">
    </form>
</section>
</body>
</html