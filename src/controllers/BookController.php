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
        $this->viewService->addPath('./views/book', 'book');
    }

    public function index()
    {
        $books = $this->bookService->getAllBooks();
        $this->viewService->display('@book/index.html', ['books' => $books]);
    }

    public function add()
    {
        $this->viewService->display('@book/add.html');
    }

    public function addPost()
    {
        $book = $_POST;
        $this->bookService->addBook($book);
        header("location: /book");
        exit();
    }

    public function view(int $id)
    {
        $book = $this->bookService->getBook($id);
        $this->viewService->display('@book/view.html', ['book' => $book]);
    }
}