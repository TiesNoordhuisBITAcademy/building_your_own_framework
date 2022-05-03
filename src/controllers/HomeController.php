<?php

declare(strict_types = 1);

namespace BYOF\controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $this->view->display('homeIndex.html');
    }
}