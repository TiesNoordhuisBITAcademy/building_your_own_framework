<?php

declare(strict_types=1);

namespace BYOF\services;

use BYOF\models\Author;
use RedBeanPHP\R as R;

class AuthorService extends ORMService
{
    public function getAllAuthors(): array
    {
        return R::findAll('author');
    }

    public function addAuthor(array $author): void
    {
        R::store(R::dispense('author')->import($author));
    }

    public function getAuthor(int $id): Author
    {
        return Author::cast(R::findOne('author', 'id = ?', [$id]));
    }
}