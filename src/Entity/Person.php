<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "delete"}
 * )
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 * @UniqueEntity(
 *     fields={"firstName", "lastName"},
 *     errorPath="person",
 *     message="Person with this first name and last name is already exist in database."
 * )
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @SerializedName("imie")
     */
    private ?string $firstName = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @SerializedName("nazwisko")
     */
    private ?string $lastName = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }
}
