<?php

declare(strict_types=1);

namespace App\Mapper\Order;

use App\ApiResource\Dto\ContractDto\ContractDto;
use App\ApiResource\Dto\Customer\CustomerDto;
use App\ApiResource\Dto\Order\OrderDto;
use App\ApiResource\Dto\Status\StatusDto;
use App\ApiResource\Dto\User\UserDto;
use App\Entity\Contract;
use App\Entity\Customer;
use App\Entity\Enum\StatusCode;
use App\Entity\Order;
use App\Entity\Status;
use App\Entity\User;
use App\Mapper\AbstractMapper;

/**
 * @extends AbstractMapper<OrderDto, Order>
 */
final class OrderMapper extends AbstractMapper
{
    /**
     * @param OrderDto $dto
     * @param Order|null $entity
     */
    public function mapDtoToEntity(object $dto, ?object $entity = null): object
    {
        $this->ensureType($entity, Order::class);
        $this->ensureType($dto, OrderDto::class);

        $this->validate($dto);

        if (
            ! $dto->orderNumber ||
            ! $dto->contract ||
            ! $dto->status ||
            ! $dto->status->id ||
            ! $dto->requestedDeliveryAt ||
            ! $dto->customer ||
            ! $dto->status->user ||
            ! $dto->status->user->userName
        ) {
            $this->throwNotNullException('OrderNumber, Contract, Status, Status->Id, RequestedDeliveryAt, Customer, Status->User->UserName');
        }

        $contract = $this->em->getRepository(Contract::class)->find($dto->contract->id)
            ?? throw new \InvalidArgumentException("Contract with ID {$dto->contract->id} not found.");

        $customer = $this->em->getRepository(Customer::class)->find($dto->customer->id)
            ?? throw new \InvalidArgumentException("Customer with ID {$dto->customer->id} not found.");

        $user = $this->em->getRepository(User::class)->findOneBy([
            'userName' => $dto->status->user->userName,
        ])
            ?? throw new \InvalidArgumentException("User with username {$dto->status->user->userName} not found.");

        $order = $entity ?? new Order($dto->orderNumber, $customer, $contract, $dto->requestedDeliveryAt);

        $status = new Status(StatusCode::from($dto->status->id), $user);
        $this->em->persist($status);

        $order
            ->setOrderNumber($dto->orderNumber)
            ->setCustomerOrderNumber($dto->customerOrderNumber)
            ->setRequestedDeliveryAt($dto->requestedDeliveryAt)
            ->setCustomer($customer)
            ->setContract($contract)
            ->addStatus($status);

        return $order;
    }

    /** @param Order $entity */
    public function mapEntityToDto(object $entity): object
    {
        $this->ensureType($entity, Order::class);

        $status = $entity->getCurrentStatus();
        if (! $status) {
            throw new \LogicException('Order has no current status.');
        }

        $user = $status->getUser();
        $customer = $entity->getCustomer();
        $contract = $entity->getContract();

        return new OrderDto(
            id: $entity->getId(),
            orderNumber: $entity->getOrderNumber(),
            customerOrderNumber: $entity->getCustomerOrderNumber(),
            createdAt: $entity->getCreated(),
            closedAt: $entity->getClosedAt(),
            status: new StatusDto(
                id: $status->getCode()->value,
                name: $status->getCode()->trans($this->translator),
                createdAt: $status->getCreated(),
                user: new UserDto(
                    userName: $user->getUserName(),
                    fullName: $user->getFullName()
                )
            ),
            customer: new CustomerDto(
                id: $customer->getId(),
                name: $customer->getFullName()
            ),
            contract: new ContractDto(
                id: $contract->getId(),
                name: $contract->getName()
            ),
            requestedDeliveryAt: $entity->getRequestedDeliveryAt()
        );
    }
}
