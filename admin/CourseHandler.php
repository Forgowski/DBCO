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
                $this->createCourse();
            }
            elseif(isset($_POST['_action']) && $_POST['_action'] == 'UPDATE'){
                $this->updateCourse();
            }
            elseif(isset($_POST['_action']) && $_POST['_action'] == 'CREATE_ARTICLE'){
                $this->createArticle();
            }
            elseif(isset($_POST['_action']) && $_POST['_action'] == 'EDIT_ARTICLE'){
                $this->editArticle();
            }
    }
    }
    private function updateCourse(){
        $course_id = intval($_POST['_course_id']);
        $validator = new Validator();
        $result = $validator->courseValidation($_POST['name'], $_POST['price'],  $_POST['description'], $_POST['timeToComp'], $_POST['category']);
        if($result == 0){
            $dbConn = new DbConnector();
            $dbConn->updateCourse($_POST['name'], $_POST['author'], $_POST['description'], $_POST['price'], $_POST['category'], $_POST['timeToComp'], $course_id);
        }
    }
    private function createCourse(){
        $validator = new Validator();
        $result = $validator->courseValidation($_POST['courseName'], $_POST['price'],  $_POST['description'], $_POST['timeToComp'], $_POST['category']);
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
    private function createArticle(){
        $title = $_POST['title'];
        $article = $_POST['article'];
        $courseId = intval($_POST['_course_id']);
        $dbConn = new DbConnector();
        $lastOrderNum = $dbConn->getLastOrderNum($courseId);
        if(isset($lastOrderNum)){
            $orderNum = $lastOrderNum + 1;
        }
        else{
            $orderNum=0;
        }
        $articleId = $dbConn->createArticle($article);
        $dbConn->putInContent($courseId, $orderNum, $articleId, 'article', $title);
    }
    private function editArticle()
    {
        $title = $_POST['title'];
        $article = $_POST['article'];
        $courseId = intval($_POST['_course_id']);
        $orderNum = intval($_POST['_order_num']);
        $extId = intval($_POST['_ext_id']);
        $dbConn = new DbConnector();
        $dbConn->updateContentTitle($title, $courseId, $orderNum);
        $dbConn->updateArticle($article, $extId);
    }
}
$courseHandler = new CourseHandler();