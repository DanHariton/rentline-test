<?php

declare(strict_types=1);

namespace App\ApiResource\Dto\Order;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\ApiResource\Dto\ContractDto\ContractDto;
use App\ApiResource\Dto\Customer\CustomerDto;
use App\ApiResource\Dto\Status\StatusDto;
use App\ApiResource\Provider\Order\OrderItemProvider;
use App\ApiResource\Provider\Order\OrderProvider;
use App\Serializer\SerializationGroups;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Order',
    description: 'Get a list of all orders',
    operations: [
        new GetCollection(
            uriTemplate: '/order/list',
            normalizationContext: [
                'groups' => [SerializationGroups::ORDER_READ],
            ],
            provider: OrderProvider::class,
        ),
        new Get(
            uriTemplate: '/order/{id}',
            requirements: [
                'id' => '[A-Za-z0-9\-_\.]+',
            ],
            normalizationContext: [
                'groups' => [SerializationGroups::ORDER_READ],
            ],
            provider: OrderItemProvider::class,
        ),
    ],
    paginationEnabled: false,
)]
final class OrderDto
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?string $id = null,
        #[Assert\NotBlank]
        #[Assert\Length(max: 20)]
        #[Assert\Regex(
            pattern: '/^[A-Z]{1,3}\d{4}-\d{3}$/',
            message: 'Order number must match pattern like ABC1234-789.'
        )]
        #[Groups([SerializationGroups::ORDER_READ, SerializationGroups::ORDER_WRITE])]
        public ?string $orderNumber = null,
        #[Groups([SerializationGroups::ORDER_READ, SerializationGroups::ORDER_WRITE])]
        public ?string $customerOrderNumber = null,
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?\DateTimeImmutable $createdAt = null,
        #[Groups([SerializationGroups::ORDER_READ])]
        public ?\DateTimeImmutable $closedAt = null,
        #[Assert\NotNull(groups: [SerializationGroups::ORDER_WRITE])]
        #[Groups([SerializationGroups::ORDER_READ, SerializationGroups::ORDER_WRITE])]
        public ?StatusDto $status = null,
        #[Assert\NotNull(groups: [SerializationGroups::ORDER_WRITE])]
        #[Groups([SerializationGroups::ORDER_READ, SerializationGroups::ORDER_WRITE])]
        public ?CustomerDto $customer = null,
        #[Assert\NotNull(groups: [SerializationGroups::ORDER_WRITE])]
        #[Groups([SerializationGroups::ORDER_READ, SerializationGroups::ORDER_WRITE])]
        public ?ContractDto $contract = null,
        #[Assert\NotNull(groups: [SerializationGroups::ORDER_WRITE])]
        #[Assert\DateTime(format: \DateTimeInterface::ATOM, groups: [SerializationGroups::ORDER_WRITE])]
        #[Groups([SerializationGroups::ORDER_READ, SerializationGroups::ORDER_WRITE])]
        public ?\DateTimeImmutable $requestedDeliveryAt = null,
    ) {
    }
}
