<?php

namespace admin;

class Question
{
    private $quizId;
    private $question;
    private $answerA;
    private $answerB;
    private $answerC;
    private $answerD;
    private $correctAnswer;
    private $point;
    private $orderNum;


    public function __construct($quizId, $question, $answerA, $answerB, $answerC, $answerD, $correctAnswer, $point, $orderNum)
    {
        $this->quizId = $quizId;
        $this->question = $question;
        $this->answerA = $answerA;
        $this->answerB = $answerB;
        $this->answerC = $answerC;
        $this->answerD = $answerD;
        $this->correctAnswer = $correctAnswer;
        $this->point = $point;
        $this->orderNum = $orderNum;
    }

    public function getQuizId()
    {
        return $this->quizId;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getAnswerA()
    {
        return $this->answerA;
    }

    public function getAnswerB()
    {
        return $this->answerB;
    }

    public function getAnswerC()
    {
        return $this->answerC;
    }

    public function getAnswerD()
    {
        return $this->answerD;
    }

    public function getCorrectAnswer()
    {
        return $this->correctAnswer;
    }

    public function getPoint()
    {
        return $this->point;
    }

    public function getOrderNum()
    {
        return $this->orderNum;
    }


}