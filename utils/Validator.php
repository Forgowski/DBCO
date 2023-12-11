<?php

class Validator
{

    public function registerValidation($password, $confirmPassword, $firstName, $lastName, $email)
    {

        if ($password !== $confirmPassword) {
            return "Password and confirmation do not match.";
        }

        if (!$this->checkPassword($password)) {
            return "Password does not meet requirements.";
        }

        if (!$this->checkName($firstName) || !$this->checkName($lastName)) {
            return "First name and last name should contain only letters.";
        }

        if (!$this->checkEmail($email)) {
            return "Invalid email format.";
        }


        return 0;
    }
    public function updateDataValidation($firstName, $lastName, $email)
    {

        if (!$this->checkName($firstName) || !$this->checkName($lastName)) {
            return "First name and last name should contain only letters.";
        }

        if (!$this->checkEmail($email)) {
            return "Invalid email format.";
        }
        return 0;
    }

    public function updatePasswordValidation($password, $confirmPassword)
    {

        if ($password !== $confirmPassword) {
            return "Password and confirmation do not match.";
        }

        if (!$this->checkPassword($password)) {
            return "Password does not meet requirements.";
        }
        return 0;
    }

    public function createCourseValidation($name, $price, $description, $duration, $category)
    {
        if (empty($name) || empty($price) || empty($description) || empty($duration) || empty($category)) {
            return "All fields are required.";
        }

        if (!ctype_alnum($name)) {
            return "Name should be alphanumeric.";
        }

        if (!ctype_alnum($description)) {
            return "Description should be alphanumeric.";
        }

        if (!ctype_alnum($category)) {
            return "Category should be alphanumeric.";
        }

        if (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
            return "Invalid price format. Use a number with up to two decimal places.";
        }

        if (!preg_match('/^\d+$/', $duration)) {
            return "Duration should be an integer.";
        }

        return 0;
    }


    private function checkPassword($password)
    {
        return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s]).{7,}$/', $password);
    }

    private function checkName($text)
    {
        return preg_match('/^[A-Za-z]+$/u', $text);
    }

    private function checkEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

