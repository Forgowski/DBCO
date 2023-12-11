<?php

namespace admin;
use DbConnector;
use Validator;

include '../account/User.php';
include '../utils/Validator.php';
include '../utils/DbConnector.php';
include 'Course.php';
class CourseHandler
{
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['_action']) && $_POST['_action'] == 'CREATE_COURSE') {
                echo 'wchodze';
                $this->createCourse();
            }
        }
    }
    private function createCourse(){
        $validator = new Validator();
        $result = $validator->createCourseValidation($_POST['courseName'], $_POST['price'],  $_POST['description'], $_POST['timeToComp'], $_POST['category']);
        if($result == 0){
            echo 'tutez';
            session_start();
            $dbConn = new DbConnector();
            $user = $dbConn->getUser($_SESSION['user_id']);
            $author = sprintf("%s %s", $user->getFirstName(), $user->getLastName());
            $dbConn->createCourse($_POST['courseName'], $author, $_POST['description'], $_POST['price'], $_POST['category'], $_POST['timeToComp']);
            session_write_close();
        }
        echo $result;
    }
}
$courseHandler = new CourseHandler();