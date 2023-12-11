<?php

namespace account;
class User
{
    private $firstName;
    private $lastName;
    private $mail;
    private $isAdmin; //boolean

    public function __construct($firstName, $lastName, $mail, $isAdmin=0)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->mail = $mail;
        $this->isAdmin = $isAdmin;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
}