<?php

declare(strict_types=1);

namespace BYOF\controllers;

use BYOF\services\SetupService;

class HomeController extends BaseController
{
    public function index()
    {
        $this->viewService->display('homeIndex.html');
    }

    public function setup()
    {
        $setupService = new SetupService();
        $setupService->setupORM();
        header("location: /");
        exit();
    }

    public function info()
    {
        echo phpinfo();
    }
}