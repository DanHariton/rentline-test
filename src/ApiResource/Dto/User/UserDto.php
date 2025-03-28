<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\User;

final class UserDto
{
    public function __construct(
        public ?string $userName = null,
        public ?string $fullName = null,
    ) {
    }
}
