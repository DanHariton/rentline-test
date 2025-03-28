<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\ContractNameTextId;
use App\Entity\Interface\TextIdInterface;
use App\Entity\Trait\TIdentifierTextId;
use App\Entity\Trait\TIdentifierUUID;
use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract implements TextIdInterface
{
    use TIdentifierUUID;
    use TIdentifierTextId;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'contract')]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name ?? $this->getTextId()->value();
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTextIdEnumClass(): string
    {
        return ContractNameTextId::class;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (! $this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setContract($this);
        }

        return $this;
    }
}
