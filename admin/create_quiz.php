<?php
require_once '../templates/header.php';
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
if ($admin != 1) {
    header("Location: /DBCO/templates/index.php");
    exit();
}
$questNum = isset($_GET['quest']) ? $_GET['quest'] : null;
?>

<section>
    <form action="QuizHandler.php" method="post">
        <label for="title">Tytuł:</label><input type="text" name="title" id="title">

        <label for="question">Pytanie:</label><input type="text" name="question" id="question" class="question">
        <label for="answerA">A</label><input type="text" name="answerA" id="answerA" class = "answer">
        <label for="answerB">B</label><input type="text" name="answerB" id="answerB" class = "answer">
        <label for="answerC">C</label><input type="text" name="answerC" id="answerC" class = "answer">
        <label for="answerD">D</label><input type="text" name="answerD" id="answerD" class = "answer">
        <label for="answerCorr">Poprawna</label><input type="text" name="answerCorr" id="answerCorr" class = "answer">
        <label for="point">Punkty do zdobycia</label><input type="number" max="3" min="1" name="point" id="point" value="1">
        <input type="hidden" name="_action" value='CREATE_QUIZ'>
        <input type="hidden" name="_course_id" value='<?php echo $_GET['id']?>'>



        <input type="submit" value="Zapisz">
    </form>
</section>
