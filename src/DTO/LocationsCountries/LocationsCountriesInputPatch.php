<?php

declare(strict_types=1);

namespace App\DTO\LocationsCountries;

class LocationsCountriesInputPatch
{
    public ?string $name = null;

    public ?string $prefix = null;

    public ?string $code = null;
}