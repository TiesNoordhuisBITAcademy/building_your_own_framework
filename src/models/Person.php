<?php

namespace BYOF\models;

use RedBeanPHP\TypedModel as RBModel;

class Person extends RBModel
{
    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}