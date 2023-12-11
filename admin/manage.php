<?php
require_once '../templates/header.php';
include_once 'Course.php';
include_once '../utils/DbConnector.php';
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
if ($admin != 1) {
    header("Location: /DBCO/templates/index.php");
    exit();
}
?>
<section>
    <?php
    $dbConn = new DbConnector();
    $allCourses = $dbConn->getAllCourses();
    foreach ($allCourses as $course) {
    ?>
        <div class = 'crs'>

                <h4><?php echo $course->getName(); ?></h4>
                <h5><?php echo $course->getAuthor(); ?></h5>
            <a href='/DBCO/admin/course_detail_manage.php?id=<?php echo $course->getId(); ?>'>
                Edytuj kurs
            </a>
            <a href='/DBCO/admin/delete_course.php?id=<?php echo $course->getId(); ?>'>
                Usuń kurs
            </a>
        </div>
    <?php
    }
    ?>
</section>
