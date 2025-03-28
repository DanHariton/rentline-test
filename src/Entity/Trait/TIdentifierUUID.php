<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait TIdentifierUUID
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true, nullable: false, options: [
        'fixed' => true,
    ])]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    protected ?string $id = null;

    public function getId(): string
    {
        if (! $this->id) {
            $this->id = Uuid::v4()->toRfc4122();
        }

        return $this->id;
    }
}
