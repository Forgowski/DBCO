<?php
include_once "../admin/Content.php";
include_once "../admin/Question.php";
include_once "../admin/Course.php";

class DbConnector
{
    private $INSERT_INT0_USER = "INSERT INTO user (firstName, lastName, email, password, isAdmin) VALUES (?, ?, ?, ?, ?);";
    private $GET_USER_BY_ID = "SELECT firstName, lastName, email, isAdmin FROM user WHERE id = ?;";
    private $GET_ID_AFTER_REG = "SELECT id FROM user WHERE email = ? AND password = ?; ";
    private $UPDATE_USER = "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?;";
    private $UPDATE_USER_PASSWORD = "UPDATE user SET password = ? WHERE id = ?;";
    private $DELETE_USER_BY_ID = "DELETE FROM user WHERE id = ?;";
    private $UPDATE_COURSE = "UPDATE course SET name = ?, author = ?, description = ?, price = ?, category = ?, aprox_lenght_min = ? WHERE id = ?;";

    private $DELETE_COURSE_BY_ID = "DELETE FROM course WHERE id = ?;";
    private $DELETE_CONTENT_BY_ID = "DELETE FROM content WHERE order_num = ? AND course_id = ?;";
    private $FIND_LAST_ORDER_NUM = "SELECT order_num FROM content WHERE course_id = ? ORDER BY order_num DESC LIMIT 1;";
    private $FIND_LAST_QUESTION_ORDER_NUM = "SELECT order_num FROM question WHERE quizId = ? ORDER BY order_num DESC LIMIT 1;";

    private $UPDATE_CONTENT_TITLE = "UPDATE content SET title = ? WHERE course_id = ? AND order_num = ?;";
    private $CREATE_QUIZ = "INSERT INTO quiz (max_point) VALUES (?)";
    private $INSERT_QUESTION = "INSERT INTO question (quizId, question, answerA, answerB, answerC, answerD, correctAnswer, point, order_num) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";


    private $CREATE_COURSE = "INSERT INTO course (name, author, description, price, category, aprox_lenght_min, rate, vote_num) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    private $GET_CONTENT_ASSOCIATE_WITH_COURSE = "SELECT * FROM content WHERE course_id = ? ORDER BY order_num";
    private $GET_COURSE_BY_NAME = "SELECT * FROM course WHERE name = ?;";
    private $GET_COURSE_BY_ID = "SELECT * FROM course WHERE id = ?;";
    private $GET_ALL_COURSES = "SELECT * FROM course";
    private $CREATE_ARTICLE = "INSERT INTO article (text_content) VALUES (?)";
    private $UPDATE_ARTICLE = "UPDATE article SET text_content = ? WHERE id = ?";
    private $GET_ARTICLE = "SELECT text_content FROM article WHERE ID = ?;";
    private $INSERT_TO_CONTENT = "INSERT INTO content (course_id, order_num, type, ext_resource_id, title) VALUES (?, ?, ?, ?, ?);";
    private $GET_CONTENT = "SELECT * FROM content WHERE course_id = ? AND order_num = ?;";
    private $GET_QUIZ_MAX_POINT = "SELECT max_point FROM quiz WHERE id = ?;";
    private $UPDATE_MAX_POINT = "UPDATE quiz SET max_point = ? WHERE id = ?;";
    private $GET_ALL_QUESTION_FOR_QUIZ = "SELECT * FROM question where quizId = ? order by order_num;";
    private $DELETE_QUESTION = "DELETE FROM question WHERE quizId = ? AND order_num = ?;";
    private $MOCK_ORDER = "INSERT INTO  order_t (user_id, course_id) VALUES (?, ?);";
    private $GET_USER_COURSES_ID = "SELECT course_id FROM order_t WHERE user_id = ?;";
    private $HAVE_ACCESS_TO_COURSE = "SELECT id FROM order_t WHERE user_id = ? AND course_id = ?;";
    private $GET_USER_SCORE = "SELECT point FROM score WHERE user_id = ? AND quiz_id = ?;";
    private $UPDATE_USER_SCORE = "UPDATE score SET point = ? WHERE user_id = ? AND quiz_id = ?;";
    private $INSERT_USER_SCORE = "INSERT INTO score (user_id, quiz_id, point) VALUES (?,?,?);";

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $databaseName = "dbc";
    //will be private
    public $connection;

    public function __construct()
    {
    }

    public function getCourseById($id){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_COURSE_BY_ID);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $name = null;
        $author = null;
        $description = null;
        $price = null;
        $category = null;
        $aprox_lenght_min = null;
        $rate = null;
        $vote_num = null;
        $stmt->bind_result($id, $name, $author, $description, $price, $category, $aprox_lenght_min, $rate, $vote_num);
        $stmt->fetch();
        $course = new \admin\Course($id, $name, $price, $aprox_lenght_min, $author, $category, $description, $rate, $vote_num);
        $stmt->close();
        $this->close();
        return $course;
    }

    public function getCourseByName($name){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_COURSE_BY_NAME);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $id = null;
        $author = null;
        $description = null;
        $price = null;
        $category = null;
        $aprox_lenght_min = null;
        $rate = null;
        $vote_num = null;
        $stmt->bind_result($id, $name, $author, $description, $price, $category, $aprox_lenght_min, $rate, $vote_num);
        $course = new \admin\Course($id, $name, $price, $aprox_lenght_min, $author, $category, $description, $rate, $vote_num);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $course;
    }


    public function updateCourse($name, $author, $description, $price, $category, $aprox_lenght_min, $id){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_COURSE);
        $aproxInt = intval($aprox_lenght_min);
        $stmt->bind_param("sssdsii", $name, $author, $description, $price, $category, $aproxInt, $id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function createCourse($name, $author, $description, $price, $category, $aprox_lenght_min, $rate=0, $vote_num=0){
        $aproxInt = intval($aprox_lenght_min);
        $this->connect();
        $stmt = $this->connection->prepare($this->CREATE_COURSE);
        $stmt->bind_param("sssdsiii", $name, $author, $description, $price, $category, $aproxInt, $rate, $vote_num);
        $stmt->execute();
        $stmt->close();
        $this->close();
        return $this->getCourseByName($name);
    }

    public function deleteCourse($id){
        $this->connect();
        $stmt = $this->connection->prepare($this->DELETE_COURSE_BY_ID);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }
    public function getAllCourses(){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_ALL_COURSES);
        $stmt->execute();

        $stmt->bind_result($id, $name, $author, $description, $price, $category, $aprox_lenght_min, $rate, $vote_num);

        $courses = array();

        while ($stmt->fetch()) {
            $course = new \admin\Course($id, $name, $price, $aprox_lenght_min, $author, $category, $description, $rate, $vote_num);
            $courses[] = $course;
        }

        $stmt->close();
        $this->close();

        return $courses;
    }
    public function getContent($courseId, $orderNum){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_CONTENT);
        $stmt->bind_param("ii", $courseId, $orderNum);
        $stmt->execute();
        $stmt->bind_result($id, $courseId, $orderNum, $type, $extResourceId, $title);
        $stmt->fetch();
        $content = new \admin\Content($id, $title, $type, $courseId, $orderNum, $extResourceId);
        $stmt->close();
        $this->close();
        return $content;
    }

    public function updateContentTitle($title, $couserId, $orderNum){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_CONTENT_TITLE);
        $stmt->bind_param("sii", $title, $couserId, $orderNum);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }
    public function getArticle($ext_id){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_ARTICLE);
        $stmt->bind_param("i", $ext_id);
        $stmt->execute();
        $stmt->bind_result($article);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $article;
    }
    public function updateArticle($article, $ext_id){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_ARTICLE);
        $stmt->bind_param("si", $article,  $ext_id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }
    public function createQuiz($maxPoint){
        $this->connect();
        $stmt = $this->connection->prepare($this->CREATE_QUIZ);
        $stmt->bind_param("i", $maxPoint);
        $stmt->execute();
        $lastInsertedId = $this->connection->insert_id;
        $stmt->close();
        $this->close();
        return $lastInsertedId;
    }

    public function getMaxPoint($id){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_QUIZ_MAX_POINT);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($maxPoint);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $maxPoint;
    }
    public function updateMaxPoint($id, $maxPoint){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_MAX_POINT);
        $stmt->bind_param("ii", $maxPoint, $id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function createQuestion($quizId, $question, $answerA, $answerB, $answerC, $answerD, $correctAnswer, $point, $order_num){
        $this->connect();
        $stmt = $this->connection->prepare($this->INSERT_QUESTION);
        $stmt->bind_param("issssssii", $quizId, $question, $answerA, $answerB, $answerC, $answerD, $correctAnswer, $point, $order_num);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }
    public function getLastQuestionOrderNum($quizId){
        $lastOrderNum = NULL;
        $this->connect();
        $stmt = $this->connection->prepare($this->FIND_LAST_QUESTION_ORDER_NUM);
        $stmt->bind_param("i", $quizId);
        $stmt->execute();
        $stmt->bind_result($lastOrderNum);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $lastOrderNum;
    }

    public function deleteQuestion($quizId, $orderNum){

        $this->connect();
        $stmt = $this->connection->prepare($this->DELETE_QUESTION);
        $stmt->bind_param("ii", $quizId, $orderNum);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function getAllQuestionForQuiz($quizId){

        $this->connect();
        $stmt = $this->connection->prepare($this->GET_ALL_QUESTION_FOR_QUIZ);
        $stmt->bind_param("i", $quizId);

        $stmt->execute();

        $stmt->bind_result($quizId, $question, $answerA, $answerB, $answerC, $answerD, $correctAnswer, $point, $orderNum);

        $questions = array();

        while ($stmt->fetch()) {
            $question = new \admin\Question($quizId, $question, $answerA, $answerB, $answerC, $answerD, $correctAnswer, $point, $orderNum);
            $questions[] = $question;
        }

        $stmt->close();
        $this->close();

        return $questions;
    }


    public function getContentOfCourse($courseId){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_CONTENT_ASSOCIATE_WITH_COURSE);
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        $contents = array();
        $stmt->bind_result($id, $courseId, $orderNum, $type, $extResourceId, $title);

        while ($stmt->fetch()) {
            $content = new \admin\Content($id, $title, $type, $courseId, $orderNum, $extResourceId);
            $contents[] = $content;
        }

        $stmt->close();
        $this->close();
        return $contents;
    }
    public function deleteContent($id, $orderNum){
        $this->connect();
        $stmt = $this->connection->prepare($this->DELETE_CONTENT_BY_ID);
        $stmt->bind_param("ii", $orderNum, $id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function createArticle($text){
        $this->connect();
        $stmt = $this->connection->prepare($this->CREATE_ARTICLE);
        $stmt->bind_param("s", $text);
        $stmt->execute();
        $lastInsertedId = $this->connection->insert_id;
        $stmt->close();
        $this->close();
        return $lastInsertedId;
    }

    public function putInContent($courseId, $orderNum, $ext_resource_Id, $type, $title){
        $this->connect();
        $stmt = $this->connection->prepare($this->INSERT_TO_CONTENT);
        $stmt->bind_param("iisis", $courseId, $orderNum, $type, $ext_resource_Id, $title);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function getLastOrderNum($courseId){
        $lastOrderNum = NULL;
        $this->connect();
        $stmt = $this->connection->prepare($this->FIND_LAST_ORDER_NUM);
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        $stmt->bind_result($lastOrderNum);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $lastOrderNum;
    }
    public function createUser($firstName, $lastName, $mail, $hashPassword, $isAdmin=0)
    {
        $user_id = null;
        $this->connect();
        $stmt = $this->connection->prepare($this->INSERT_INT0_USER);
        $stmt->bind_param("ssssi", $firstName, $lastName, $mail, $hashPassword, $isAdmin);
        $stmt->execute();
        $stmt->close();
        $this->close();
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_ID_AFTER_REG);
        $stmt->bind_param("ss", $mail, $hashPassword);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $user_id;
    }

    public function login($email, $hashPassword){
        $user_id=NULL;
        $this->connect();
        $stmt = $this->connection->prepare("SELECT try_log_in(?, ?)");
        $stmt->bind_param("ss", $email, $hashPassword);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $user_id;
    }

    public function updateUserData($firstName, $lastName, $email, $id){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_USER);
        $stmt->bind_param("sssi", $firstName, $lastName, $email, $id);
        $stmt->execute();
        $this->close();
    }

    public function getUser($id){
        $isAdmin = NULL;
        $email = NULL;
        $lastName = NULL;
        $firstName = NULL;

        $this->connect();
        $stmt = $this->connection->prepare($this->GET_USER_BY_ID);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($firstName, $lastName, $email, $isAdmin);
        $stmt->fetch();
        $user = new account\User($firstName, $lastName, $email, $isAdmin);
        $stmt->close();
        $this->close();
        return $user;
    }

    public function updateUserPassword($hash_password, $id){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_USER_PASSWORD);
        $stmt->bind_param("si", $hash_password ,$id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function deleteUser($id){
        $this->connect();
        $stmt = $this->connection->prepare($this->DELETE_USER_BY_ID);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function isAdmin($id){
        $admin = NULL;
        $this->connect();
        $stmt = $this->connection->prepare("SELECT is_admin(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($admin);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $admin;
    }

    public function mockOrder($userId, $courseId){
        $this->connect();
        $stmt = $this->connection->prepare($this->MOCK_ORDER);
        $stmt->bind_param("ii", $userId ,$courseId);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }
    public function haveAccessToCourse($userId, $courseId){
        $this->connect();
        $stmt = $this->connection->prepare($this->HAVE_ACCESS_TO_COURSE);
        $stmt->bind_param("ii", $userId ,$courseId);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $id;
    }
    public function getUserCoursesId($userId){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_USER_COURSES_ID);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($courseId);
        $coursesId = array();
        while ($stmt->fetch()) {
            $coursesId[] = $courseId;
        }
        $stmt->close();
        $this->close();
        return $coursesId;
    }
    public function getUserScore($userId, $quizId){
        $this->connect();
        $stmt = $this->connection->prepare($this->GET_USER_SCORE);
        $stmt->bind_param("ii", $userId, $quizId);
        $stmt->execute();
        $stmt->bind_result($point);
        $stmt->fetch();
        $stmt->close();
        $this->close();
        return $point;
    }

    public function updateUserScore($point, $userId, $quizId){
        $this->connect();
        $stmt = $this->connection->prepare($this->UPDATE_USER_SCORE);
        $stmt->bind_param("iii",$point, $userId, $quizId);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }

    public function insertUserScore($userId, $quizId, $point){
        $this->connect();
        $stmt = $this->connection->prepare($this->INSERT_USER_SCORE);
        $stmt->bind_param("iii",$userId, $quizId, $point);
        $stmt->execute();
        $stmt->close();
        $this->close();
    }
    private function connect(){
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->databaseName);
        if ($this->connection->connect_error) {
            die("Błąd połączenia: " . $this->connection->connect_error);
        }
    }
    private function close(){
        $this->connection->close();
    }
}