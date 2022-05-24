<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\DTO\LocationsCountries\LocationsCountriesInputPatch;
use App\DTO\LocationsCountries\LocationsCountriesSearchGet;
use App\Repository\LocationsCountriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    collectionOperations: [
        'search_countries' => [
            'method' => 'GET',
            'path' => '/countries/search',
            'input' => LocationsCountriesSearchGet::class,
            'openapi_context' => [
                'summary' => 'Find countries by name or code',
                'parameters' => [
                    [
                        'in' => 'query',
                        'name' => 'name',
                        'type' => 'string',
                        'required' => false
                    ],
                    [
                        'in' => 'query',
                        'name' => 'code',
                        'type' => 'string',
                        'required' => false
                    ]
                ],
            ],
        ],
    ],
    itemOperations: [
        'get' => [
            'path' => '/countries/{id}',
        ],
        'patch' => [
            'path' => '/countries/{id}',
            'input' => LocationsCountriesInputPatch::class,
            'output' => false,
        ],
    ]
)]
#[ORM\Table(name: 'locations_countries')]
#[ORM\Entity(repositoryClass: LocationsCountriesRepository::class)]
class LocationsCountries
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: true)]
    protected ?string $name = null;

    #[ORM\Column(name: 'code', type: 'string', length: 255, nullable: true)]
    protected ?string $code = null;

    #[ORM\Column(name: 'prefix', type: 'string', length: 255, nullable: true)]
    protected ?string $prefix = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setPrefix(?string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }
}