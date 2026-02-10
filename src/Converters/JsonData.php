<?php

namespace Laravel\Wayfinder\Converters;

use Laravel\Ranger\Components\JsonResponse;
use Laravel\Ranger\Components\Route;
use Laravel\Wayfinder\Langs\TypeScript;

class JsonData extends Converter
{
    public function convert(JsonResponse $response, Route $route): ?string
    {
        if (! $route->hasController()) {
            return null;
        }

        if ($response->resourceClass !== null) {
            return $this->convertResourceResponse($response);
        }

        return (string) TypeScript::objectToRecord($response->data, false);
    }

    protected function convertResourceResponse(JsonResponse $response): string
    {
        $resourceType = str_replace('\\', '.', $response->resourceClass);

        $innerType = $response->isCollection ? $resourceType.'[]' : $resourceType;

        if ($response->wrap !== null) {
            return '{ '.$response->wrap.': '.$innerType.' }';
        }

        return $innerType;
    }
}
