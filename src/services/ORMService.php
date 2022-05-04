<?php

declare(strict_types=1);

namespace BYOF\services;

use RedBeanPHP\R as R;

class ORMService
{
    public function __construct()
    {
        if (!R::testConnection()) {
            R::setup('mysql:host=127.0.0.1;dbname=BYOF_serve', 'bit_academy', 'bit_academy');
        }
    }
}