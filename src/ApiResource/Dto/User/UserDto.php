<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\User;

use App\Serializer\SerializationGroups;
use Symfony\Component\Serializer\Attribute\Groups;

final class UserDto
{
    public function __construct(
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?string $userName = null,
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?string $fullName = null,
    ) {
    }
}
