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

/**
 * @throws \RouteException when the arguments don't match the required types
 */
function mapArgumentsToParams(string $rawArguments, array $params): array
{
    $is_boolean = function ($value): bool {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
    };

    $numberOfParams = count($params);
    $arguments = explode('/', $rawArguments, $numberOfParams);
    foreach ($params as $index => $param) {
        $arg = &$arguments[$index];
        match ($param) {
            'int' => $arg = is_numeric($arg)
                ? intval($arg)
                : throw new RouteException("Expecting int", $rawArguments, $params),
            'bool' => $arg = $is_boolean($arg)
                ? filter_var($arg, FILTER_VALIDATE_BOOLEAN)
                : throw new RouteException("Expecting bool", $rawArguments, $params),
            'array' && $index === $numberOfParams - 1 => $arg = explode('/', $arguments[$index]),
            default => $arguments[$index] = (string) $arguments[$index]
        };
    }
    return $arguments;
}

function getRootFromFullClassname($className)
{
    $baseClassName = basename(str_replace('\\', '/', $className));
    return strtolower(str_replace('Controller', '', $baseClassName));
}
