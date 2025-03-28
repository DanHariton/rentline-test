<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\TIdentifierUUID;
use App\Entity\Trait\TTimestamp;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[UniqueEntity('orderNumber')]
#[ORM\Table(name: '`order`')]
class Order
{
    use TIdentifierUUID;
    use TTimestamp;

    #[Assert\Regex(
        pattern: '/^[A-Z]{1,3}\d{4}-\d{3}$/',
        message: 'Order number must match pattern like ABC1234-789.'
    )]
    #[ORM\Column(length: 20, unique: true, nullable: false)]
    private string $orderNumber;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customerOrderNumber = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $requestedDeliveryAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $closedAt = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private Customer $customer;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private Contract $contract;

    /**
     * @var Collection<int, Status>
     */
    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'order', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $statuses;

    public function __construct(string $orderNumber, Customer $customer, Contract $contract, \DateTimeImmutable $requestedDeliveryAt)
    {
        $this->orderNumber = $orderNumber;
        $this->customer = $customer;
        $this->contract = $contract;
        $this->requestedDeliveryAt = $requestedDeliveryAt;

        $this->statuses = new ArrayCollection();
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): Order
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function getCustomerOrderNumber(): ?string
    {
        return $this->customerOrderNumber;
    }

    public function setCustomerOrderNumber(?string $customerOrderNumber): Order
    {
        $this->customerOrderNumber = $customerOrderNumber;
        return $this;
    }

    public function getRequestedDeliveryAt(): \DateTimeImmutable
    {
        return $this->requestedDeliveryAt;
    }

    public function setRequestedDeliveryAt(\DateTimeImmutable $requestedDeliveryAt): Order
    {
        $this->requestedDeliveryAt = $requestedDeliveryAt;
        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): Order
    {
        $this->customer = $customer;
        return $this;
    }

    public function getContract(): Contract
    {
        return $this->contract;
    }

    public function setContract(Contract $contract): Order
    {
        $this->contract = $contract;
        return $this;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(Status $status): self
    {
        if (! $this->statuses->contains($status)) {
            $this->statuses->add($status);
            $status->setOrder($this);
        }

        return $this;
    }

    public function getCurrentStatus(): ?Status
    {
        $latest = null;

        foreach ($this->statuses as $status) {
            if ($latest === null || $status->getCreated() > $latest->getCreated()) {
                $latest = $status;
            }
        }

        return $latest;
    }

    public function getClosedAt(): ?\DateTimeImmutable
    {
        return $this->closedAt;
    }

    public function setClosedAt(?\DateTimeImmutable $closedAt): Order
    {
        $this->closedAt = $closedAt;
        return $this;
    }
}
