<?php
require_once "../templates/header.php";
?>
<section>
    <form action="CourseHandler.php" method="POST">
        <label class="lb-registry" for="courseName">Nazwa kursu</label><input class="inp-txt-input" id="courseName" name="courseName" type="text">
        <label class="lb-registry" for="price">Cena kursu</label><input class="inp-txt-input" id="price" name="price" type="number" step="0.01">
        <label class="lb-registry" for="category">Kategoria</label><input class="inp-txt-input" id="category" name="category" type="text">
        <label class="lb-registry" for="timeToComp">Przewidywane czas nauki w minutach</label><input class="inp-txt-input" id="timeToComp" name="timeToComp" type="number">
        <label class="lb-registry" for="description">Opis</label>
        <textarea name="description" id="description" rows="6" cols="50" placeholder="Wprowadź opis kursu"></textarea>
        <input type="hidden" name="_action" value="CREATE_COURSE">
        <input type="submit" value="Stwórz kurs">
    </form>
</section>
