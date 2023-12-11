<?php
include '../utils/DbConnector.php';
include 'Course.php';
session_start();
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
if($admin!=1){
    header("Location: /DBCO/templates/index.php");
    exit();
}
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$_SESSION['course_id'] = $id;
$dbConn = new DbConnector();
$course = $dbConn->getCourseById($id);
?>
<form action="CourseHandler.php" method="POST">
            <label class="lb-registry" for="name">Nazwa kursu</label>
            <input class="inp-txt-input" id="name" name="name" type="text"
                   value="<?php echo $course->getName(); ?>">
            <label class="lb-registry" for="author">Autor</label>
            <input class="inp-txt-input" id="author" name="author" type="text"
                   value="<?php echo $course->getAuthor(); ?>">
            <label class="lb-registry" for="category">Kategoria</label>
            <input class="inp-txt-input" id="category" name="category" type="text"
                   value="<?php echo $course->getCategory(); ?>">
            <input class="inp-txt-input" id="category" name="category" type="text"
            value="<?php echo $course->getCategory(); ?>">
            <label class="lb-registry" for="price">Cena kursu</label>
            <input class="inp-txt-input" id="price" name="price" type="number" step="0.01"
                   value="<?php echo $course->getPrice(); ?>">
            <label class="lb-registry" for="timeToComp">Przewidywane czas nauki w minutach</label>
            <input class="inp-txt-input" id="timeToComp" name="timeToComp" type="number"
                   value="<?php echo $course->getDuration(); ?>">
            <label class="lb-registry" for="description">Opis</label>
            <textarea name="description" id="description" rows="6" cols="50">
                <?php
                echo $course->getDescription();
                ?>
            </textarea>
            <input type="hidden" name="_course_id" value=<?php echo $course->getId();?>>

            <input type="hidden" name="_action" value="UPDATE">
            <input type="submit" value="Zaktualizuj">
        </form>

<button onclick="location.href='/DBCO/admin/course_content_manage.php'">Zarządzaj zawartością kursu</button>

