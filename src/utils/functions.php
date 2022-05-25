<?php

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
        match ($param) {
            'int' => $arguments[$index] = (int) $arguments[$index],
            'bool' => $arguments[$index] = (bool) $arguments[$index],
            'array' && $index === $numberOfParams - 1 => $arguments[$index] = explode('/', $arguments[$index]),
            default => $arguments[$index] = (string) $arguments[$index]
        };
    }
    return $arguments;
}

