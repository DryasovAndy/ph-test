<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class SearchCountrySuccessTest extends ApiTestCase
{
    /**
     * @dataProvider getSuccessData
     */
    public function testSuccessSearch(?string $code, ?string $name, array $expected): void
    {
        $client = static::createClient();

        $params = [
            'query' => [
                'code' => $code,
                'name' => $name,
            ],
        ];

        $response = $client->request('GET', '/api/countries/search', $params);

        self::assertResponseIsSuccessful();
        self::assertSame(200, $response->getStatusCode());

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
            'Search by code' => ['RO', null, ['name' => 'Romania', 'code' => 'RO']],
            'Search by name' => [null, 'France', ['name' => 'France', 'code' => 'FR']],
            'Search by code and name' => ['AU', 'Australia', ['name' => 'Australia', 'code' => 'AU']],
        ];
    }
}