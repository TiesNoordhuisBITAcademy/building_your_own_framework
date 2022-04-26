<?php

namespace BYOF\controllers;

require "BaseController.php";
use BYOF\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        echo "home index";
        // $this->view->render('home/index');
    }
}