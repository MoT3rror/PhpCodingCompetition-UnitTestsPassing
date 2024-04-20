<?php

declare(strict_types=1);

namespace PhpCodingCompetition\Tdd\Tests\User;

use PhpCodingCompetition\Tdd\Db\Repository\RepositoryEntityAbstract;
use PhpCodingCompetition\Tdd\User\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @given a User Repository
     * @when instantiating the class
     * @then the User Repository extends the Repository Entity Abstract class
     *
     * @return void
     */
    public function testUserRepositoryExtendsAbstract(): void
    {
        $userRepository = new UserRepository();
        $this->assertInstanceOf(
            RepositoryEntityAbstract::class,
            $userRepository
        );
    }
}
