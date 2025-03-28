<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\Status;

use App\ApiResource\Dto\User\UserDto;
use App\Serializer\SerializationGroups;
use Symfony\Component\Serializer\Attribute\Groups;

final class StatusDto
{
    public function __construct(
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?string $id = null,
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?string $name = null,
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?\DateTimeImmutable $createdAt = null,
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?UserDto $user = null,
    ) {
    }
}
