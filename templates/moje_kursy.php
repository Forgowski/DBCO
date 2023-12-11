<?php
require_once "header.php";
include_once "../utils/DbConnector.php";
?>
<section>
    <?php
    $dbConn = new DbConnector();
    $coursesId = $dbConn->getUserCoursesId(intval($_SESSION['user_id']));
    foreach ($coursesId as $courseId) {
        $course = $dbConn->getCourseById($courseId);
        ?>
        <div class = 'crs'>
            <a href = "/DBCO/templates/course_content.php?course_id=<?php echo $course->getId(); ?>">
                <h4><?php echo $course->getName(); ?></h4>
                <h5>Autor: <?php echo $course->getAuthor(); ?></h5>
                <p>Kategoria: <?php echo $course->getCategory(); ?></p>
                <p>Przewidywany czas: <?php echo $course->getDuration(); ?> min</p>
                <p><?php echo $course->getDescription(); ?></p>
            </a>
        </div>
    <?php } ?>
</section>
