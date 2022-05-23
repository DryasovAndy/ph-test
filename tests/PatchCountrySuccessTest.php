<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\LocationsCountries;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class PatchCountrySuccessTest extends ApiTestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @dataProvider getSuccessData
     */
    public function testSuccessPatch(int $id, array $search, array $expected): void
    {
        $client = static::createClient();

        $params = [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $search,
        ];

        $client->request('PATCH', '/api/countries/' . $id, $params);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $locationCountries = $this->entityManager->getRepository(LocationsCountries::class)->find($id);

        $this->assertSame($locationCountries->getName(), $expected['name']);
        $this->assertSame($locationCountries->getCode(), $expected['code']);
        $this->assertSame($locationCountries->getPrefix(), $expected['prefix']);
    }

    public function getSuccessData(): array
    {
        return [
            'Patch code' => [1, ['code' => 'RO_NEW'], ['name' => 'Romania', 'code' => 'RO_NEW', 'prefix' => '+40']],
            'Patch name' => [2, ['name' => 'France_new'], ['name' => 'France_new', 'code' => 'FR', 'prefix' => '+33']],
            'Patch prefix' => [
                3,
                ['prefix' => '+62'],
                ['name' => 'Australia', 'code' => 'AU', 'prefix' => '+62'],
            ],
        ];
    }
}