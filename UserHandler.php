<?php

include_once 'utils/DbConnector.php';
include_once 'utils/Validator.php';
include_once 'account/User.php';

class UserHandler
{
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['_action']) && $_POST['_action'] == 'UPDATE'){
                $this->updateUser();
            }
            elseif(isset($_POST['_action']) && $_POST['_action'] == 'UPDATE_PASS'){
                $this->updateUserPassword();
            }
            elseif(isset($_POST['firstName'])){
                $this->register();
            }
            else{
                $this->login();
            }
        } else {
            echo 'Błąd: Nieprawidłowa metoda żądania.';
        }
    }

    private function register()
    {
        $validator = new Validator();
        $response = $validator->registerValidation($_POST['password'], $_POST['re-password'], $_POST['firstName'], $_POST['lastName'], $_POST['email']);
        if($response == 0) {
            $hashPassword = md5($_POST['password']);
            $dbConect = new DbConnector();
            $user_id = $dbConect->createUser($_POST['firstName'],  $_POST['lastName'], $_POST['email'], $hashPassword);
            session_start();
            $_SESSION['user_id'] = $user_id;
            $admin = $dbConect->isAdmin($user_id);
            $_SESSION['admin'] = $admin;
            session_write_close();
            header("Location: templates/index.php");
            exit();
        }
        else{
            //tutaj zwracanie błędów do sesji
            echo $response;
        }
    }
    private function login(){
        session_start();
        $hashPassword = md5($_POST['password']);
        $dbConn = new DbConnector();
        $user_id = $dbConn->login($_POST['email'], $hashPassword);
        if($user_id == -1 || $user_id == NULL){
            echo "Niepoprawne dane logowania";
            session_write_close();
        }
        else{
            $_SESSION['user_id'] = $user_id;
            $admin = $dbConn->isAdmin($user_id);
            $_SESSION['admin'] = $admin;
            session_write_close();
            header("Location: templates/index.php");
            exit();
        }
    }

    private function updateUser(){
        session_start();
        $validator = new Validator();
        $response = $validator->updateDataValidation($_POST['firstName'], $_POST['lastName'], $_POST['email']);
        if($response == 0) {
            $dbConect = new DbConnector();
            $dbConect->updateUserData($_POST['firstName'],  $_POST['lastName'], $_POST['email'], $_SESSION['user_id']);
        }
        
        session_write_close();
        header("Location: templates/ustawienia.php");
        exit();
    }

    private function updateUserPassword(){
        session_start();
        $dbConn = new DbConnector();
        $user = $dbConn->getUser($_SESSION['user_id']);
        $oldPasswordHaslo = md5($_POST['old_password']);
        $confirm_user_id = $dbConn->login($user->getMail(), $oldPasswordHaslo);
        if($_SESSION['user_id'] == $confirm_user_id) {
            $validator = new Validator();
            $result = $validator->updatePasswordValidation($_POST['password'], $_POST['re-password']);
            if ($result == 0) {
                $dbConn = new DbConnector();
                $hashPassword = md5($_POST['password']);
                $dbConn->updateUserPassword($hashPassword, $_SESSION['user_id']);
            }
            else{
                echo $result;
            }
        }
        else{
            echo "incorect old password";
        }
    }
}

$userHandler = new UserHandler();
