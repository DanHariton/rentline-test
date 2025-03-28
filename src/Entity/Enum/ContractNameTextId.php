<?php

declare(strict_types=1);

namespace App\Entity\Enum;

use App\Entity\Interface\TextIdEnumInterface;

enum ContractNameTextId: string implements TextIdEnumInterface
{
    case CUSTOMER_SALE = 'customer-sale';
    case PARTNER_SALE = 'partner-sale';

    public function value(): string
    {
        return $this->value;
    }
}
