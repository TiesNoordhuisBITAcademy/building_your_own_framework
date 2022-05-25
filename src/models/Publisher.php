<?php

namespace BYOF\models;

class Publisher extends Person
{
    public function books()
    {
        return $this->ownBookList;
    }
}