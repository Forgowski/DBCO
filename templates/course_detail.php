<?php
require_once "header.php";
include_once "../utils/DbConnector.php";
include_once "../admin/Course.php";
$courseId = $_GET['course_id'];
$dbConn = new DbConnector();
$course = $dbConn->getCourseById($courseId);
?>
<section>
<h2><?php echo $course->getName(); ?></h2>
<h3><?php echo $course->getAuthor(); ?></h3>
<h4><?php echo $course->getCategory(); ?></h4>
<h4>Cena: <?php echo $course->getPrice(); ?> zł</h4>
<h4>Czas trwania: <?php echo $course->getPrice(); ?> min</h4>
<p><?php echo $course->getDescription()?></p>
<button onclick="location.href='/DBCO/templates/buy_mock.php?course_id=<?php echo $courseId?>'">Kup</button>
</section>