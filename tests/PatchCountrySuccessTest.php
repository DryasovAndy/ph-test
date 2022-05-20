<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class PatchCountrySuccessTest extends ApiTestCase
{
    /**
     * @dataProvider getSuccessData
     */
    public function testSuccessPatch(int $id, ?string $code, ?string $name, ?string $prefix, array $expected): void
    {
        $client = static::createClient();

        $params = [
            'body' => [
                'code' => $code,
                'name' => $name,
            ],
        ];

        $client->request('PATCH', '/api/countries/' . $id, $params);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(204);

        $data = [
            'hydra:totalItems' => 1,
            'hydra:member' => [
                $expected,
            ],
        ];

        self::assertJsonContains($data);
    }

    public function getSuccessData(): array
    {
        return [
            'Search by code' => [1, 'RO', null, null, ['name' => 'Romania', 'code' => 'RO', 'prefix' => '+40']],
            'Search by name' => [2, null, 'France', null, ['name' => 'France', 'code' => 'FR', 'prefix' => '+33']],
            'Search by code and name' => [
                3,
                null,
                null,
                '+62',
                ['name' => 'Australia', 'code' => 'AU', 'prefix' => '+62'],
            ],
        ];
    }
}