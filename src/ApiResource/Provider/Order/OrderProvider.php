<?php

declare(strict_types=1);

namespace App\ApiResource\Provider\Order;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Dto\Order\OrderDto;
use App\Entity\Order;
use App\Mapper\Order\OrderMapper;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements ProviderInterface<OrderDto>
 */
final readonly class OrderProvider implements ProviderInterface
{
    public function __construct(
        private OrderRepository $orderRepository,
        private OrderMapper $orderMapper,
        private RequestStack $requestStack,
    ) {
    }

    /** @return OrderDto[] */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return [];
        }

        $filters = [];
        $status = $request->query->get('status');
        if (is_string($status)) {
            $filters['status'] = $status;
        }

        $customerOrderNumber = $request->query->get('customerOrderNumber');
        if (is_string($customerOrderNumber)) {
            $filters['customerOrderNumber'] = $customerOrderNumber;
        }

        $sort = [];
        $sortBy = $request->query->get('sortBy');
        $sortDir = $request->query->get('sortDir');
        if (is_string($sortBy) && in_array($sortDir, ['ASC', 'DESC'], true)) {
            $sort[$sortBy] = $sortDir;
        }

        $orders = $this->orderRepository->findAllWithFilters($filters, $sort);

        return array_map(
            fn (Order $order) => $this->orderMapper->mapEntityToDto($order),
            $orders
        );
    }
}
