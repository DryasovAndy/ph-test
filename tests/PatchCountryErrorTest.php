<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PatchCountryErrorTest extends ApiTestCase
{
    /**
     * @dataProvider getErrorData
     */
    public function testErrorPatch(int $id, array $search, array $expected): void
    {
        $client = static::createClient();

        $params = [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $search,
        ];

        $client->request('PATCH', '/api/countries/' . $id, $params);

        self::assertResponseStatusCodeSame($expected['code'], $expected['message']);
    }

    public function getErrorData(): array
    {
        return [
            'Patch code null' => [
                1,
                [
                    'code' => null,
                    'name' => null,
                    'prefix' => null,
                ],
                ['code' => Response::HTTP_BAD_REQUEST, 'message' => 'At least one parameter must be filled'],
            ],
        ];
    }
}