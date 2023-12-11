<?php
require_once '../templates/header.php';
?>
<section>
    <form action="CourseHandler.php" method="POST">
        <label for="title">Tytuł</label><input id="title" name="title" type="text">
        <textarea name="article" id="article" rows="10" cols="80">
        </textarea>
        <input type="hidden" name="_courseId" value='<?php echo $_GET['id']?>'>
        <input type="hidden" name="_action" value="CREATE_ARTICLE">
        <input type="submit" value="Stwórz artykuł">
    </form>
</section>
