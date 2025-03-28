<?php

declare(strict_types=1);

namespace App\DataFixtures\Factory;

use App\Entity\Customer;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Customer>
 */
final class CustomerFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Customer::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->firstName(),
            'surname' => self::faker()->lastName(),
            'birthDate' => \DateTimeImmutable::createFromInterface(self::faker()->dateTimeBetween('-70 years', '-18 years')),
        ];
    }
}
