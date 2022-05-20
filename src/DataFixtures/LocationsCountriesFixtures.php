<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\LocationsCountries;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationsCountriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $code = ['RO', 'FR', 'AU'];
        $name = ['Romania', 'France', 'Australia'];
        $prefix = ['+40', '+33', '+61'];

        for ($i = 1; $i <= 3; $i++) {
            $locationsCounty = new LocationsCountries();
            $locationsCounty->setName($name[$i - 1]);
            $locationsCounty->setCode($code[$i - 1]);
            $locationsCounty->setPrefix($prefix[$i - 1]);

            $manager->persist($locationsCounty);
            $manager->flush();
        }
    }
}