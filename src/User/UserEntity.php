<?php
declare(strict_types=1);

namespace PhpCodingCompetition\Tdd\User;

use DateTimeInterface;
use InvalidArgumentException;
use PhpCodingCompetition\Tdd\Architecture\Entity\EntityInterface;

class UserEntity implements EntityInterface
{
    private ?int $userId = null;

    private ?string $username = null;

    private ?string $password = null;

    private bool $isActive = false;

    private ?string $email = null;

    private ?DateTimeInterface $userCreatedDatetime = null;
    
    public static function hydrate(
        array $data,
        EntityInterface $user = null,
    ): self
    {
        // InvalidArgumentException
        if ($user && !$user instanceof self) {
            throw new InvalidArgumentException('Entity must be instance of ' . self::class, 422);
        }

        $user = new self;
        $user->setUserId($data['user_id'] ?? null);
        $user->setUsername($data['username'] ?? null);
        $user->setPassword($data['password'] ?? null);
        $user->setIsActive($data['is_active'] ?? false);
        $user->setEmail($data['email'] ?? null);
        $user->setUserCreatedDatetime($data['user_created_datetime'] ?? null);

        return $user;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): void
    {
        if ($userId && $userId <= 0) {
            throw new InvalidArgumentException('UserId must be a positive integer', 422);
        }
        
        $this->userId = $userId;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        if ($username && strlen($username) > 120) {
            throw new InvalidArgumentException('Username must be at most 120 characters long', 422);
        }
        
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $passwordHash): void
    {
        if ($passwordHash && strlen($passwordHash) > 256) {
            throw new InvalidArgumentException('Password hash is too long', 422);
        }
        
        $this->password = $passwordHash;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is not valid', 422);
        }
        
        $this->email = $email;
    }

    public function getUserCreatedDatetime(): ?DateTimeInterface
    {
        return $this->userCreatedDatetime;
    }

    public function setUserCreatedDatetime(?DateTimeInterface $date): void
    {
        if ($date && $date->getTimestamp() > strtotime('now')) {
            throw new InvalidArgumentException('User Created Datetime must not be in the future', 422);
        }
        
        $this->userCreatedDatetime = $date;
    }
}
