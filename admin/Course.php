<?php

namespace admin;

class Course
{
    private $id;
    private $name;
    private $price;
    private $duration;
    private $author;
    private $description;
    private $category;
    private $rate;
    private $votes_num;

    public function __construct($id, $name, $price, $duration, $author,$category, $description, $rate, $votes_num)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->duration = $duration;
        $this->author = $author;
        $this->description = $description;
        $this->rate = $rate;
        $this->votes_num = $votes_num;
        $this->category = $category;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getVotesNum()
    {
        return $this->votes_num;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function setVotesNum($votes_num)
    {
        $this->votes_num = $votes_num;
    }

}