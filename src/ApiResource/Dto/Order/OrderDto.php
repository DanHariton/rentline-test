<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\Order;

use App\ApiResource\Dto\ContractDto\ContractDto;
use App\ApiResource\Dto\Customer\CustomerDto;
use App\ApiResource\Dto\Status\StatusDto;

final class OrderDto
{
    public function __construct(
        public ?string $id = null,
        public ?string $orderNumber = null,
        public ?string $customerOrderNumber = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $closedAt = null,
        public ?StatusDto $status = null,
        public ?CustomerDto $customer = null,
        public ?ContractDto $contract = null,
        public ?\DateTimeImmutable $requestedDeliveryAt = null,
    ) {
    }
}
