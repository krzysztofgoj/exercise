<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class ProductControllerTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreatePerson(): void
    {
        $client = static::createClient();

        $data = [
            'imie' => 'testing first name',
            'nazwisko' => 'testing last name',
        ];

        $client->request('POST', '/api/people', ['json' => $data]);
        
        self::assertResponseStatusCodeSame(201);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/Person',
                '@type' => 'Person',
                'imie' => $data['imie'],
                'nazwisko' => $data['nazwisko'],
            ]
        );
    }
}
