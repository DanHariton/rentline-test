<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\Customer;

final class CustomerDto
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
    ) {
    }
}
