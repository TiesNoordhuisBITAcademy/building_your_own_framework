<?php

declare(strict_types=1);

namespace BYOF\exceptions;

use BYOF\exceptions\FrameworkException;

class RouteException extends FrameworkException
{
    public string $originalRoute;
    public string $expectedRoute;

    public function __construct(
        string $message,
        string $originalRoute,
        array $expectedRoute,
        string $source = 'Router',
        int $code = 0,
        \Throwable $previous = null
    ) {
        $this->originalRoute = $originalRoute;
        $this->expectedRoute = implode('/', $expectedRoute);
        parent::__construct($message, $source, $code, $previous);
    }
}