<?php

declare(strict_types=1);

namespace BYOF\exceptions;

class FrameworkException extends \Exception
{
    public string $source;

    public function __construct(string $message, string $source, int $code = 0, \Throwable $previous = null)
    {
        $this->source = $source;
        parent::__construct("from [$source]: [$message]", $code, $previous);
    }
}