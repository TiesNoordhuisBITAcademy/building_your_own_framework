<?php

declare(strict_types=1);

namespace BYOF\services;

use BYOF\models\Author;
use BYOF\exceptions\FrameworkException;
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
        if ($author = R::findOne('author', 'id = ?', [$id])) {
            return Author::cast($author);
        }
        throw new FrameworkException("Author does not exist", get_class($this), 1);
    }
}