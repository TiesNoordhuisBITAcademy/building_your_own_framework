<?php

declare(strict_types=1);

namespace BYOF\controllers;

use BYOF\services\ViewService;
use BYOF\services\BookService;

class BookController extends BaseController
{
    public function __construct(ViewService $viewService, BookService $bookService = null)
    {
        parent::__construct($viewService);
        $this->bookService = $bookService ?? new BookService();
        $this->viewService->addPath('./views/books', 'books');
    }

    public function index()
    {
        $books = $this->bookService->getAllBooks();
        $this->viewService->display('@books/index.html', ['books' => $books]);
    }

    public function addBook()
    {
        $this->viewService->display('@books/add.html');
    }

    public function addBookPost()
    {
        $book = $_POST;
        $this->bookService->addBook($book);
        header("location: /books");
        exit();
    }
}