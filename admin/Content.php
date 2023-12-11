<?php

namespace admin;

class Content
{
    private $id;
    private $title;
    private $type;
    private $courseId;
    private $orderNum;
    private $extResourceId;

    public function __construct($id, $title, $type, $courseId, $orderNum, $extResourceId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->courseId = $courseId;
        $this->orderNum = $orderNum;
        $this->extResourceId = $extResourceId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCourseId()
    {
        return $this->courseId;
    }

    public function getOrderNum()
    {
        return $this->orderNum;
    }

    public function getExtResourceId()
    {
        return $this->extResourceId;
    }


}