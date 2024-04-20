<?php

declare(strict_types=1);

namespace PhpCodeCompetition\Tdd\Tests\Secrets\Password;

use InvalidArgumentException;
use PhpCodeCompetition\Tdd\Secrets\Password\PasswordService;
use PHPUnit\Framework\TestCase;

class PasswordServiceTest extends TestCase
{
    /**
     * @given a password
     * @when hashing the password
     * @then the password is hashed
     *
     * @return void
     */
    public function testHashPassword(): void
    {
        $password = 'TestPassword123#@!';

        $passwordService = new PasswordService();
        $hashedPassword = $passwordService->hashPassword($password);

        $this->assertTrue(
            password_verify($password, $hashedPassword)
        );
    }

    /**
     * @given a password
     * @when the password is too short
     * @then throws an exception
     *
     * @return void
     */
    public function testPasswordChecksThrowsExceptionWhenTooShort(): void
    {
        $password = 'TooShort';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Password is too short, must be at least 12 characters'
        );
        $this->expectExceptionCode(422);

        $passwordService = new PasswordService();
        $passwordService->passwordChecks($password);
    }

    /**
     * @given a password
     * @when the password is valid
     * @then returns true
     *
     * @return void
     */
    public function testPasswordChecks(): void
    {
        $password = 'Valid#@!Password123*&^389d';

        $passwordService = new PasswordService();
        $this->assertTrue($passwordService->passwordChecks($password));
    }
}
