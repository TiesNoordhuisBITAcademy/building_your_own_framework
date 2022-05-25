<?php

declare(strict_types=1);

namespace BYOF\services;

use RedBeanPHP\R as R;
use RedBeanPHP\BeanHelper\SimpleFacadeBeanHelper as SimpleFacadeBeanHelper;

class ORMService
{
    public function __construct()
    {
        define('REDBEAN_MODEL_PREFIX', 'BYOF\\models\\');
        if (!R::testConnection()) {
            R::setup('mysql:host=127.0.0.1;dbname=BYOF_serve', 'bit_academy', 'bit_academy');
        }
    }
}