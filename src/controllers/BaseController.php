<?php

declare(strict_types = 1);

namespace BYOF\controllers;

use BYOF\services\ViewService;

class BaseController
{
    protected ViewService $view;

    public function __construct(ViewService $viewService)
    {
        $this->view = $viewService;
    }
}