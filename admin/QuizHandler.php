<?php

namespace admin;
include_once '../utils/DbConnector.php';
session_start();
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
if ($admin != 1) {
    header("Location: /DBCO/templates/index.php");
    exit();
}
class QuizHandler
{
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['_action'] == "CREATE_QUIZ"){
                $this->createQuiz();
            }
            elseif($_POST['_action'] == "ADD_QUESTION"){
                $this->addQuestion();
            }
        }
    }
    private function createQuiz(){
        $maxPoint = $_POST['point'];
        $dbConn = new \DbConnector();
        $quizId = $dbConn->createQuiz($maxPoint);
        $lastQuestionId = $dbConn->getLastQuestionOrderNum($quizId);
        $courseId = intval($_POST['_course_id']);

        if(isset($lastQuestionId)){
            $orderNumQuestion = $lastQuestionId + 1;
        }
        else{
            $orderNumQuestion=0;
        }
        $dbConn->createQuestion($quizId,$_POST['question'], $_POST['answerA'], $_POST['answerB'], $_POST['answerC'],
            $_POST['answerD'], $_POST['answerCorr'], $_POST['point'], $orderNumQuestion);

        $lastOrderNum = $dbConn->getLastOrderNum($courseId);
        if(isset($lastOrderNum)){
            $orderNum = $lastOrderNum + 1;
        }
        else{
            $orderNum=0;
        }
        $dbConn->putInContent($_POST['_course_id'], $orderNum, $quizId, 'quiz', $_POST['title']);
        header("Location: /DBCO/templates/admin_panel.php");
        exit();
    }

    private function addQuestion(){
        $dbConn = new \DbConnector();
        $quizId = $_POST['_ext_id'];
        $lastQuestionId = $dbConn->getLastQuestionOrderNum($quizId);
        $oldMaxPoint = $dbConn->getMaxPoint($quizId);
        $maxPoint = $oldMaxPoint + intval($_POST['point']);
        $dbConn->updateMaxPoint($quizId, $maxPoint);
        if(isset($lastQuestionId)){
            $orderNumQuestion = $lastQuestionId + 1;
        }
        else{
            $orderNumQuestion=0;
        }
        $dbConn->createQuestion($quizId,$_POST['question'], $_POST['answerA'], $_POST['answerB'], $_POST['answerC'],
            $_POST['answerD'], $_POST['answerCorr'], $_POST['point'], $orderNumQuestion);
        header("Location: /DBCO/templates/admin_panel.php");
        exit();
    }
}
$quizHandler = new QuizHandler();