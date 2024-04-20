<?php

declare(strict_types=1);

namespace PhpCodingCompetition\Tdd\Tests\Architecture\Entity;

use PhpCodingCompetition\Tdd\Architecture\Entity\EntityInterface;
use PhpCodingCompetition\Tdd\Architecture\Entity\HydratorInterface;
use PhpCodingCompetition\Tdd\Architecture\Entity\ToArrayInterface;
use PHPUnit\Framework\TestCase;

class EntityInterfaceTest extends TestCase
{
    /**
     * @given an Entity Interface
     * @when instantiating an Entity
     * @then the Entity Interface extends ToArrayInterface and HydratorInterface
     *
     * @return void
     */
    public function testEntityInterfaceExtendsInterfaces(): void
    {
        $entity = new class implements EntityInterface {
            public static function hydrate(
                array $data,
                EntityInterface $entity = null
            ): EntityInterface {
                return $entity;
            }

            public function toArray(): array
            {
                return [];
            }
        };

        $this->assertInstanceOf(
            ToArrayInterface::class,
            $entity
        );
        $this->assertInstanceOf(
            HydratorInterface::class,
            $entity
        );
    }
}
