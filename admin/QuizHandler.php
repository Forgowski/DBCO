<?php

namespace admin;
include_once '../utils/DbConnector.php';
session_start();

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
            elseif($_POST['_action'] == "CHECK_QUIZ"){
                $this->checkQuiz();
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
    private function checkQuiz(){
        $dbConn = new \DbConnector();
        $quizId = $_POST['_quiz_id'];
        $questions = $dbConn->getAllQuestionForQuiz(intval($quizId));
        $i = 0;
        $point = 0;
        foreach ($questions as $question){
            $k = 'pytanie' . $i;
            if($question->getCorrectAnswer() == $_POST[$k]){
                $point = $point + intval($question->getPoint());
            }
        }
        $userId = intval($_SESSION['user_id']);
        $oldScore = $dbConn->getUserScore($userId, intval($quizId));
        if(empty($oldScore)){
            $dbConn->insertUserScore($userId, intval($quizId), $point);
        }
        elseif($oldScore < $point){
            $dbConn->updateUserScore($point, $userId, intval($quizId));
        }
        header("Location: /DBCO/templates/moje_kursy.php");
        exit();
    }
}
$quizHandler = new QuizHandler();