<?php

namespace BYOF\models;

class Author extends Person
{
    public function works()
    {
        return $this->ownBookList;
    }
}