<?php

namespace BYOF\models;

use RedBeanPHP\SimpleModel as RedBean_SimpleModel;

class Person extends RedBean_SimpleModel
{
    public function getFullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}