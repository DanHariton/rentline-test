<?php

declare(strict_types=1);

namespace App\DataFixtures\Factory;

use App\Entity\Enum\StatusCode;
use App\Entity\Order;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Order>
 */
final class OrderFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Order::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'orderNumber' => strtoupper(self::faker()->bothify('???####-###')),
            'customerOrderNumber' => self::faker()->optional()->word(),
            'requestedDeliveryAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-3 years', '+3 months')),
            'customer' => CustomerFactory::random(),
            'contract' => ContractFactory::random(),
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Order $order): void {
            $usedCodes = [];
            $statusesCount = random_int(1, 3);
            $hasEndStatus = false;

            for ($i = 0; $i < $statusesCount; $i++) {
                $availableCodes = array_filter(
                    StatusCode::cases(),
                    fn (StatusCode $c) => ! in_array($c->value, $usedCodes, true)
                );

                if (empty($availableCodes)) {
                    break;
                }

                /** @var StatusCode $code */
                $code = self::faker()->randomElement($availableCodes);
                $usedCodes[] = $code->value;

                if ($code === StatusCode::END) {
                    $hasEndStatus = true;
                }

                $user = UserFactory::random()->_real();
                $status = StatusFactory::createOne([
                    'code' => $code,
                    'user' => $user,
                    'order' => $order,
                ])->_real();

                $order->addStatus($status);
            }

            if ($hasEndStatus) {
                $order->setClosedAt(
                    \DateTimeImmutable::createFromMutable(
                        self::faker()->dateTimeBetween(
                            $order->getRequestedDeliveryAt()->format('Y-m-d H:i:s'),
                        )
                    )
                );
            }
        });
    }
}
