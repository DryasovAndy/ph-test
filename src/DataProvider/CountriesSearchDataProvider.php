<?php

declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DTO\SearchLocationsCountriesDto;
use App\Entity\LocationsCountries;
use App\Repository\LocationsCountriesRepository;
use Error;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CountriesSearchDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(private readonly LocationsCountriesRepository $locationsCountriesRepository)
    {
    }
    public function getCollection(
        string $resourceClass,
        string $operationName = null,
        array $context = []
    ): array {
        $code = $context['filters']['code'] ?? null;
        $name = $context['filters']['name'] ?? null;

        if (is_null($code) && is_null($name)) {
            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                'At least one parameter must be filled'
            );
        }

        $searchDTO = new SearchLocationsCountriesDto($code, $name);

        return $this->locationsCountriesRepository->searchByCodeAndName($searchDTO);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return (LocationsCountries::class === $resourceClass) && ($operationName === 'search_countries');
    }
}