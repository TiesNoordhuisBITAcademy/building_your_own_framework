<?php

declare(strict_types=1);

namespace BYOF\controllers;

use BYOF\services\ViewService;
use BYOF\services\AuthorService;

class AuthorController extends BaseController
{
    public function __construct(ViewService $viewService, AuthorService $authorService = null)
    {
        parent::__construct($viewService);
        $this->authorService = $authorService ?? new AuthorService();
        $this->viewService->addPath('./views/author', 'author');
    }

    public function index()
    {
        $authors = $this->authorService->getAllAuthors();
        $this->viewService->display('@author/index.html', ['authors' => $authors]);
    }

    public function addAuthor()
    {
        $this->viewService->display('@author/add.html');
    }

    public function addAuthorPost()
    {
        $author = $_POST;
        $this->authorService->addAuthor($author);
        header("location: /author");
        exit();
    }

    public function view(int $id)
    {
        $author = $this->authorService->getAuthor($id);
        $this->viewService->display('@author/view.html', ['author' => $author]);
    }
}