<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\ContractDto;

final class ContractDto
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
    ) {
    }
}
