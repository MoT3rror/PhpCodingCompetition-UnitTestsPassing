<?php

declare(strict_types=1);

namespace PhpCodingCompetition\Tdd\Tests\Architecture\Entity;

use PhpCodingCompetition\Tdd\Architecture\Entity\EntityInterface;
use PhpCodingCompetition\Tdd\Architecture\Entity\HydratorInterface;
use PHPUnit\Framework\TestCase;

class HydratorInterfaceTest extends TestCase
{
    /**
     * @given a Hydrator Interface
     * @when instantiating a class that implements the interface
     * @then the class has a hydrate method
     *
     * @return void
     */
    public function testHydratorInterfaceHasHydrateMethod(): void
    {
        $hydrator = new class implements HydratorInterface {
            public static function hydrate(
                array $data,
                ?EntityInterface $entity = null
            ): EntityInterface {
                return $entity;
            }
        };

        $this->assertInstanceOf(HydratorInterface::class, $hydrator);
    }
}
