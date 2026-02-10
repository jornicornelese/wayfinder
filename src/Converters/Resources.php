<?php

namespace Laravel\Wayfinder\Converters;

use Laravel\Ranger\Components\Resource;
use Laravel\Wayfinder\Langs\TypeScript;

class Resources extends Converter
{
    public function convert(Resource $resource): null
    {
        TypeScript::addFqnToNamespaced(
            $resource->name,
            TypeScript::type(
                str($resource->name)->afterLast('\\'),
                TypeScript::objectToTypeObject($resource->getFields(), false),
            )
                ->referenceClass($resource->name, $resource->filePath())
                ->export(),
        );

        return null;
    }
}
