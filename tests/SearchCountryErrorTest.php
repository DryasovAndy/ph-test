<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class SearchCountryErrorTest extends ApiTestCase
{
    /**
     * @dataProvider getErrorData
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

        self::assertResponseStatusCodeSame($expected['code'], $expected['message']);
    }

    public function getErrorData(): array
    {
        return [
            'Search by null code and null name' => [
                null,
                null,
                ['code' => Response::HTTP_BAD_REQUEST, 'message' => 'At least one parameter must be filled'],
            ],
        ];
    }
}