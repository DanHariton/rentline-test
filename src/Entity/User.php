<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\TIdentifierUUID;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['name'])]
#[ORM\Table(name: '`user`')]
class User
{
    use TIdentifierUUID;

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    private string $userName;

    #[ORM\Column(length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(length: 255, nullable: false)]
    private string $surname;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): User
    {
        $this->userName = $userName;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): User
    {
        $this->surname = $surname;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }
}
