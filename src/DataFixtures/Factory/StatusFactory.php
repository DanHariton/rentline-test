<?php

declare(strict_types=1);

namespace App\DataFixtures\Factory;

use App\Entity\Enum\StatusCode;
use App\Entity\Status;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Status>
 */
final class StatusFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Status::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'code' => StatusCode::NEW,
            'user' => UserFactory::random(),
        ];
    }
}
