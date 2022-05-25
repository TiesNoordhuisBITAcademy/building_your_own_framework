<?php

declare(strict_types=1);

namespace BYOF\services;

use RedBeanPHP\R as R;

class SetupService extends ORMService
{
    public function setupORM(): void
    {
        R::nuke();
        list($books, $publisher, $author) = R::dispenseAll('book*2,publisher,author');
        $books[0]->title = 'The Hobbit';
        $books[0]->author = $author;
        $books[0]->publisher = $publisher;
        $books[1]->title = 'Lord of the Rings';
        $books[1]->author = $author;
        $books[1]->publisher = $publisher;
        $publisher->firstName = 'Houghton';
        $publisher->lastName = 'Mifflin';
        $author->firstName = 'J.R.R.';
        $author->lastName = 'Tolkien';
        R::storeAll([...$books, $publisher, $author]);
    }
}