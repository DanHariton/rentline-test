<?php

declare(strict_types=1);

namespace App\DataFixtures\Factory;

use App\Entity\Contract;
use App\Entity\Enum\ContractNameTextId;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Contract>
 */
final class ContractFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Contract::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => null,
            'textId' => ContractNameTextId::CUSTOMER_SALE->value,
        ];
    }

    public static function createAllTextIds(): void
    {
        foreach (ContractNameTextId::cases() as $case) {
            self::new([
                'textId' => $case,
                'name' => null,
            ])->create();
        }
    }
}
