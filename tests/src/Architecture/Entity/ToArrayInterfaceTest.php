<?php

declare(strict_types=1);

namespace PhpCodeCompetition\Tdd\Tests\Architecture\Entity;

use PhpCodeCompetition\Tdd\Architecture\Entity\ToArrayInterface;
use PHPUnit\Framework\TestCase;

class ToArrayInterfaceTest extends TestCase
{
    /**
     * @given a ToArray Interface
     * @when instantiating a class that implements the interface
     * @then the class has a toArray method
     *
     * @return void
     */
    public function testToArrayInterfaceHasHydrateMethod(): void
    {
        $toArray = new class implements ToArrayInterface {
            public function toArray(): array
            {
                return [];
            }
        };

        $this->assertInstanceOf(ToArrayInterface::class, $toArray);
    }
}
