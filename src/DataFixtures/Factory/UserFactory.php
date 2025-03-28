<?php

declare(strict_types=1);

namespace App\DataFixtures\Factory;

use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return User::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->firstName(),
            'surname' => self::faker()->lastName(),
            'userName' => self::faker()->unique()->userName(),
            'phone' => self::faker()->phoneNumber(),
        ];
    }
}
