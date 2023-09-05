<?php

declare(strict_types=1);

namespace BYOF\controllers;

use BYOF\services\ViewService;
use BYOF\services\AuthorService;

class AuthorController extends BaseController
{
    private AuthorService $authorService;

    public function __construct(ViewService $viewService, AuthorService $authorService = null)
    {
        parent::__construct($viewService);
        $this->authorService = $authorService ?? new AuthorService();
    }

    public function index()
    {
        $authors = $this->authorService->getAllAuthors();
        $this->viewService->display('index', ['authors' => $authors]);
    }

    public function addAuthor()
    {
        $this->viewService->display('add');
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
        $this->viewService->display('view', ['author' => $author]);
    }
}