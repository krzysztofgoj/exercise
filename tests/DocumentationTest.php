<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class DocumentationTest extends ApiTestCase
{
    public function testDocumentationStatus(): void
    {
        static::createClient()->request('GET', '/api');
        self::assertResponseIsSuccessful();
    }
}
