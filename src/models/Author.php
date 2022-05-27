<?php

namespace BYOF\models;

class Author extends Person
{
    public function books()
    {
        return array_map(function ($book) {
            return Book::cast($book);
        }, $this->ownBookList);
    }
}