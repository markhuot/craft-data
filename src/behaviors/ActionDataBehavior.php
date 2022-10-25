<?php

namespace markhuot\craftdata\behaviors;

use yii\base\Behavior;

class ActionDataBehavior extends Behavior
{
    protected $data;

    function setData($data)
    {
        $this->data = $data;
    }

    function getData()
    {
        return $this->data;
    }
}