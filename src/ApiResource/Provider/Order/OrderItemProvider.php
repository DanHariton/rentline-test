<?php

declare(strict_types=1);

namespace App\ApiResource\Provider\Order;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Dto\Order\OrderDto;
use App\Mapper\Order\OrderMapper;
use App\Repository\OrderRepository;

/**
 * @implements ProviderInterface<OrderDto>
 */
final readonly class OrderItemProvider implements ProviderInterface
{
    public function __construct(
        private OrderRepository $orderRepository,
        private OrderMapper $orderMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?OrderDto
    {
        $id = $uriVariables['id'] ?? null;

        if (! is_string($id)) {
            return null;
        }

        $order = $this->orderRepository->find($id);
        if (! $order) {
            return null;
        }

        return $this->orderMapper->mapEntityToDto($order);
    }
}
