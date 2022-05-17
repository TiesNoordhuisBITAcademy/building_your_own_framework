<?php

declare(strict_types=1);

namespace BYOF\services;

use RedBeanPHP\R as R;

class BookService extends ORMService
{
    public function getAllBooks(): array
    {
        return R::findAll('book');
    }

    public function addBook(array $book): void
    {
        R::store(R::dispense('book')->import($book));
    }
}