<?php

namespace BYOF\models;

use RedBeanPHP\TypedModel as RBModel;
use BYOF\models\Author;
use BYOF\models\Publisher;

class Book extends RBModel
{
    public function author(): Author
    {
        return Author::cast($this->bean->author);
    }

    public function publisher(): Publisher
    {
        return Publisher::cast($this->bean->publisher);
    }
}