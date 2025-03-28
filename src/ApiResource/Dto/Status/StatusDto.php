<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\Status;

use App\ApiResource\Dto\User\UserDto;

final class StatusDto
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?UserDto $user = null,
    ) {
    }
}
