<?php
require_once '../templates/header.php';
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
if ($admin != 1) {
    header("Location: /DBCO/templates/index.php");
    exit();
}
?>
<section>
    <form action="CourseHandler.php" method="POST">
        <label for="title">Tytuł</label><input id="title" name="title" type="text">
        <textarea name="article" id="article" rows="10" cols="80">
        </textarea>
        <input type="hidden" name="_course_id" value='<?php echo $_GET['id']?>'>
        <input type="hidden" name="_action" value="CREATE_ARTICLE">
        <input type="submit" value="Stwórz artykuł">
    </form>
</section>
