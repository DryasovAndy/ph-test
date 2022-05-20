<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\SearchLocationsCountriesDto;
use App\Entity\LocationsCountries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LocationsCountriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocationsCountries::class);
    }

    public function searchByCodeAndName(SearchLocationsCountriesDto $searchDTO): array
    {
        $queryBuilder = $this->createQueryBuilder('lc');

        if ($searchDTO->name) {
            $queryBuilder
                ->andWhere(
                    $queryBuilder->expr()->eq('lc.name', ':name')
                )
                ->setParameter('name', $searchDTO->name);
        }

        if ($searchDTO->code) {
            $queryBuilder
                ->andWhere(
                    $queryBuilder->expr()->eq('lc.code', ':code')
                )
                ->setParameter('code', $searchDTO->code);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}