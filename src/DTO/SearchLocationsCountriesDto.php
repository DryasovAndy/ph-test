<?php

declare(strict_types=1);

namespace App\DTO;

class SearchLocationsCountriesDto
{
    public function __construct(
        public readonly ?string $code = null,
        public readonly ?string $name = null
    ) {
    }
}