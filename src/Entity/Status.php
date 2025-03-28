<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\StatusCode;
use App\Entity\Trait\TIdentifierUUID;
use App\Entity\Trait\TTimestamp;
use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    use TIdentifierUUID;
    use TTimestamp;

    #[ORM\Column(length: 20)]
    private StatusCode $code;

    #[ORM\ManyToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(inversedBy: 'statuses')]
    #[ORM\JoinColumn(nullable: false)]
    private Order $order;

    public function __construct(StatusCode $code, User $user)
    {
        $this->code = $code;
        $this->user = $user;
    }

    public function getCode(): StatusCode
    {
        return $this->code;
    }

    public function setCode(StatusCode $code): Status
    {
        $this->code = $code;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Status
    {
        $this->user = $user;
        return $this;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }
}
