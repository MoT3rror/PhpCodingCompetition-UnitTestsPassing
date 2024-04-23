<?php
declare(strict_types=1);

namespace PhpCodingCompetition\Tdd\User;

use DateTimeImmutable;
use PhpCodingCompetition\Tdd\Secrets\Password\PasswordService;

class UserService
{
    public UserRepository $userRepository;

    public PasswordService $passwordService;
    
    public function createUser(
        string $username,
        string $password,
        bool $isActive,
        string $email,
    ): UserEntity
    {
        $user = new UserEntity;
        $user->setUsername($username);
        $passwordHash = $this->passwordService->hashPassword($password);
        $user->setPassword($passwordHash);
        $user->setIsActive($isActive);
        $user->setEmail($email);
        $user->setUserCreatedDatetime(new DateTimeImmutable('now'));

        $user->setUserId(
            $this->userRepository->insert($user)
        );

        return $user;
    }

    public function updateUser(
        int $userId,
        string $newEmail,
        bool $isActive,
    ): UserEntity
    {
        $user = $this->userRepository->getById($userId);

        $user->setEmail($newEmail);
        $user->setIsActive($isActive);

        $this->userRepository->update($user);

        return $user;
    }

    public function setUserActive(
        int $userId,
        bool $isActive,
    ): bool
    {
        $this->userRepository->updateData($userId, ['is_active' => $isActive]);

        return true;
    }

    public function deleteUser(int $userId): bool
    {
        $this->userRepository->delete($userId);
        
        return true;
    }
}
