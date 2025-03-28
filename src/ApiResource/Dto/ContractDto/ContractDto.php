<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\ContractDto;

use App\Serializer\SerializationGroups;
use Symfony\Component\Serializer\Attribute\Groups;

final class ContractDto
{
    public function __construct(
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?string $id = null,
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?string $name = null,
    ) {
    }
}
