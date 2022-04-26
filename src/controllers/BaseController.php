<?php

namespace BYOF\controllers;

class BaseController
{
    protected $view;

    public function __construct($twig)
    {
        $this->view = $twig;
    }
}