<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\Api\OperationType;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\LocationsCountries\LocationsCountriesInputPatch;
use App\Entity\LocationsCountries;
use Error;

class LocationsCountriesInputPatchDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): LocationsCountries
    {
        if (is_null($object->name) && is_null($object->prefix) && is_null($object->code)) {
            throw new Error('At least one parameter must be filled');
        }

        $locationsCountries = $context['object_to_populate'];

        if ($object->name) {
            $locationsCountries->setName($object->name);
        }

        if ($object->prefix) {
            $locationsCountries->setPrefix($object->prefix);
        }

        if ($object->code) {
            $locationsCountries->setCode($object->code);
        }

        return $locationsCountries;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return (
            ($context['operation_type'] === OperationType::ITEM) &&
            ($context['item_operation_name'] === 'PATCH') &&
            ($context['input']['class'] === LocationsCountriesInputPatch::class) &&
            ($to === LocationsCountries::class)
        );
    }
}