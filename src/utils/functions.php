<?php

use BYOF\exceptions\RouteException;

function getMethodParams(string $className, string $methodName): array
{
    $reflectionMethod = new \ReflectionMethod($className, $methodName);
    $params = $reflectionMethod->getParameters();
    return array_map(function ($param) {
        return $param->getType()->getName();
    }, $params);
}

function mapArgumentsToParams(string $rawArguments, array $params): array
{
    $numberOfParams = count($params);
    $arguments = explode('/', $rawArguments, $numberOfParams);
    foreach ($params as $index => $param) {
        $arg = &$arguments[$index];
        match ($param) {
            'int' => $arg = is_numeric($arg)
                ? intval($arg)
                : throw new RouteException("Expecting int", $rawArguments, $params),
            'bool' => $arg = is_bool($arg)
                ? boolval($arg)
                : throw new RouteException("Expecting bool", $rawArguments, $params),
            'array' && $index === $numberOfParams - 1 => $arg = explode('/', $arguments[$index]),
            default => $arguments[$index] = (string) $arguments[$index]
        };
    }
    return $arguments;
}

