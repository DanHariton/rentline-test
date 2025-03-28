<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Factory\ContractFactory;
use App\DataFixtures\Factory\CustomerFactory;
use App\DataFixtures\Factory\OrderFactory;
use App\DataFixtures\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly int $smallCount,
        private readonly int $largeCount
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        ContractFactory::createAllTextIds();
        UserFactory::createMany($this->smallCount);
        CustomerFactory::createMany($this->largeCount);
        OrderFactory::createMany($this->largeCount);

        $manager->flush();
    }
}
