<?php

declare(strict_types=1);

namespace PhpCodingCompetition\Tdd\Secrets\Password;

use InvalidArgumentException;

class PasswordService
{
    public const ALGO = PASSWORD_DEFAULT;

    public const MAX_LENGTH = 12;

    public const MAX_PASSWORD_LENGTH_ERROR = 'Password is too short, must be at least 12 characters';

    public const MAX_PASSWORD_ERROR_CODE = 422;
    
    public function hashPassword(string $password): string
    {
        return password_hash($password, self::ALGO);
    }

    /*
     * @throws InvalidArgumentException
     */
    public function passwordChecks(string $password): bool
    {
        if (strlen($password) < self::MAX_LENGTH) {
            throw new InvalidArgumentException(self::MAX_PASSWORD_LENGTH_ERROR, self::MAX_PASSWORD_ERROR_CODE);
        }
        
        return true;
    }
}
