<?php

declare(strict_types=1);

namespace BYOF\services;

use RedBeanPHP\R as R;
use BYOF\models\Book;
use BYOF\exceptions\FrameworkException;

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

    public function getBook(int $id): Book
    {
        if ($book = R::findOne('book', 'id = ?', [$id])) {
            return Book::cast($book);
        }
        throw new FrameworkException("Book does not exist", get_class($this), 1);
    }
}