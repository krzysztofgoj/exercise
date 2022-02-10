<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Webmozart\Assert\InvalidArgumentException;
use App\Entity\Person;

class ProductControllerTest extends ApiTestCase
{
    use RecreateDatabaseTrait;

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

    public function testCreatePersonWithSameFirstName(): void
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

        $data['nazwisko'] = 'second testing last name';
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

    public function testCreatePersonWithSameLastName(): void
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

        $data['imie'] = 'second testing first name';
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

    public function testCreatePersonWithSameFirstNameAndLastName(): void
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

        $client->request('POST', '/api/people', ['json' => $data]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'hydra:description' => 'person: Osoba o takim imieniu i nazwisku już istnieje w bazie.',
            ]
        );
    }

    public function testCreatePersonWithInvalidFirstName(): void
    {
        $client = static::createClient();

        $data = [
            'imie' => 778,
            'nazwisko' => 'testing last name',
        ];

        $client->request('POST', '/api/people', ['json' => $data]);

        self::assertResponseStatusCodeSame(400);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/Error',
                '@type' => 'hydra:Error',
                'hydra:title' => 'An error occurred',
                'hydra:description' => 'The type of the "firstName" attribute must be "string", "integer" given.',
            ]
        );
    }

    public function testCreatePersonWithInvalidLastName(): void
    {
        $client = static::createClient();

        $data = [
            'imie' => 'testing first name',
            'nazwisko' => 343,
        ];

        $client->request('POST', '/api/people', ['json' => $data]);

        self::assertResponseStatusCodeSame(400);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/Error',
                '@type' => 'hydra:Error',
                'hydra:title' => 'An error occurred',
                'hydra:description' => 'The type of the "lastName" attribute must be "string", "integer" given.',
            ]
        );
    }

    public function testCreatePersonWithEmptyFirstName(): void
    {
        $client = static::createClient();

        $data = [
            'imie' => '',
            'nazwisko' => 'testing last name',
        ];

        $client->request('POST', '/api/people', ['json' => $data]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'hydra:description' => 'imie: Ta wartość nie powinna być pusta.',
                'violations' => [
                    [
                        'propertyPath' => 'imie',
                        'message' => 'Ta wartość nie powinna być pusta.',
                    ],
                ],
            ]
        );
    }

    public function testCreatePersonWithEmptyLastName(): void
    {
        $client = static::createClient();

        $data = [
            'imie' => 'testing first name',
            'nazwisko' => '',
        ];

        $client->request('POST', '/api/people', ['json' => $data]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'hydra:description' => 'nazwisko: Ta wartość nie powinna być pusta.',
                'violations' => [
                    [
                        'propertyPath' => 'nazwisko',
                        'message' => 'Ta wartość nie powinna być pusta.',
                    ],
                ],
            ]
        );
    }

    public function testCreatePersonWithEmptyFirstNameAndLastName(): void
    {
        $client = static::createClient();

        $data = [
            'imie' => '',
            'nazwisko' => '',
        ];

        $client->request('POST', '/api/people', ['json' => $data]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'violations' => [
                    [
                        'propertyPath' => 'imie',
                        'message' => 'Ta wartość nie powinna być pusta.',
                    ],
                    [
                        'propertyPath' => 'nazwisko',
                        'message' => 'Ta wartość nie powinna być pusta.',
                    ],
                ],
            ]
        );
    }

    public function testCreatePersonWithoutFirstName(): void
    {
        $client = static::createClient();

        $data = [
            'nazwisko' => 'testing last name',
        ];

        $client->request('POST', '/api/people', ['json' => $data]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'hydra:description' => 'imie: Ta wartość nie powinna być pusta.',
                'violations' => [
                    [
                        'propertyPath' => 'imie',
                        'message' => 'Ta wartość nie powinna być pusta.',
                    ],
                ],
            ]
        );
    }

    public function testCreatePersonWithoutLastName(): void
    {
        $client = static::createClient();

        $data = [
            'imie' => 'testing first name',
        ];

        $client->request('POST', '/api/people', ['json' => $data]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'hydra:description' => 'nazwisko: Ta wartość nie powinna być pusta.',
                'violations' => [
                    [
                        'propertyPath' => 'nazwisko',
                        'message' => 'Ta wartość nie powinna być pusta.',
                    ],
                ],
            ]
        );
    }

    public function testCreatePersonWithoutFirstNameAndLastName(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/people', ['json' => []]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'violations' => [
                    [
                        'propertyPath' => 'imie',
                        'message' => 'Ta wartość nie powinna być pusta.',
                    ],
                    [
                        'propertyPath' => 'nazwisko',
                        'message' => 'Ta wartość nie powinna być pusta.',
                    ],
                ],
            ]
        );
    }

    public function testGetListOfPeople(): void
    {
        static::createClient()->request('GET', '/api/people');
        self::assertResponseIsSuccessful();
        self::assertJsonContains(
            [
                '@context' => '/api/contexts/Person',
                '@id' => '/api/people',
                '@type' => 'hydra:Collection',
                'hydra:totalItems' => 10,
            ]
        );
    }

    public function testGetPerson(): void
    {
        static::createClient()->request('GET', '/api/people/1');
        self::assertResponseIsSuccessful();
        self::assertJsonContains(
            [
                'imie' => 'testFirstName',
                'nazwisko' => 'testLastName'
            ]
        );
    }

    public function testDeleteProduct(): void
    {
        $client = static::createClient();
        $personRepository = self::getContainer()->get('doctrine')->getRepository(Person::class);
        self::assertSame(10, $personRepository->count([]));
        self::assertNotNull($personRepository->findOneBy(['id' => 1]));

        $client->request('DELETE', '/api/people/1');
        self::assertResponseStatusCodeSame(204);
        self::assertNull($personRepository->findOneBy(['id' => 1]));
        self::assertSame(9, $personRepository->count([]));
    }
}
