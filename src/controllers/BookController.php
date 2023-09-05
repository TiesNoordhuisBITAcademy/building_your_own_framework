<?php

declare(strict_types=1);

namespace BYOF\controllers;

use BYOF\services\ViewService;
use BYOF\services\BookService;

class BookController extends BaseController
{
    private BookService $bookService;

    public function __construct(ViewService $viewService, BookService $bookService = null)
    {
        parent::__construct($viewService);
        $this->bookService = $bookService ?? new BookService();
    }

    public function index()
    {
        $books = $this->bookService->getAllBooks();
        $this->viewService->display('index', ['books' => $books]);
    }

    public function add()
    {
        $this->viewService->display('add');
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
        $this->viewService->display('view', ['book' => $book]);
    }
}