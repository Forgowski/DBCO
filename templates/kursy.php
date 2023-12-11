<?php
require_once "header.php";
include_once "../utils/DbConnector.php";
include_once "../admin/Course.php";
?>
<section>
    <?php
        $dbConn = new DbConnector();
        $courses = $dbConn->getAllCourses();
        foreach ($courses as $course) {
    ?>
        <div class = 'crs'>
            <a href = "/DBCO/templates/course_detail.php?course_id=<?php echo $course->getId(); ?>">
            <h4><?php echo $course->getName(); ?></h4>
            <h5><?php echo $course->getAuthor(); ?></h5>
            <p><?php echo $course->getCategory(); ?></p>
            <p><?php echo $course->getPrice(); ?></p>
            </a>
        </div>
    <?php } ?>
</section>