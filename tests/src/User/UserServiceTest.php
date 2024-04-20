<?php

declare(strict_types=1);

namespace PhpCodingCompetition\Tdd\Tests\User;

use DateTimeImmutable;
use PhpCodingCompetition\Tdd\Secrets\Password\PasswordService;
use PhpCodingCompetition\Tdd\User\UserEntity;
use PhpCodingCompetition\Tdd\User\UserRepository;
use PhpCodingCompetition\Tdd\User\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @given new user data
     * @when inserting the user
     * @then the user is created
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        $userId = 89543;
        $username = 'unittestuser';
        $password = 'S3crEt#@!Pas5W0rd';
        $hashedPassword = 'HashedPassword-aldkjxcoivuwei32sdlkf';
        $isActive = true;
        $email = 'unittest@example.com';

        $passwordServiceMock = $this
            ->getMockBuilder(PasswordService::class)
            ->onlyMethods(['hashPassword'])
            ->getMock();
        $passwordServiceMock
            ->expects($this->once())
            ->method('hashPassword')
            ->with($password)
            ->willReturn($hashedPassword);

        $userRepositoryMock = $this
            ->getMockBuilder(UserRepository::class)
            ->onlyMethods(['insert'])
            ->getMock();
        $userRepositoryMock
            ->expects($this->once())
            ->method('insert')
            ->with($this->isInstanceOf(UserEntity::class))
            ->willReturn($userId);

        $userService = new UserService();
        $userService->userRepository = $userRepositoryMock;
        $userService->passwordService = $passwordServiceMock;

        $userEntity = $userService
            ->createUser(
                $username,
                $password,
                $isActive,
                $email
            );

        $this->assertSame($userId, $userEntity->getUserId());
        $this->assertSame($username, $userEntity->getUsername());
        $this->assertSame($hashedPassword, $userEntity->getPassword());
        $this->assertTrue($userEntity->getIsActive());
        $this->assertSame($email, $userEntity->getEmail());
        $this->assertInstanceOf(
            DateTimeImmutable::class,
            $userEntity->getUserCreatedDatetime()
        );
    }
    /**
     * @given existing user
     * @when updating the user
     * @then the user is updated
     *
     * @return void
     */
    public function testUpdateUser(): void
    {
        $userId = 102165;
        $isActive = true;
        $newIsActive = false;
        $email = 'unittest@example.com';
        $newEmail = 'updatedemail@example.com';

        $userEntity = new UserEntity();
        $userEntity
            ->setUserId($userId)
            ->setIsActive($isActive)
            ->setEmail($email);

        $userRepositoryMock = $this
            ->getMockBuilder(UserRepository::class)
            ->onlyMethods(['getById', 'update'])
            ->getMock();
        $userRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($userEntity);
        $userRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with($this->isInstanceOf(UserEntity::class))
            ->willReturn(1);

        $userService = new UserService();
        $userService->userRepository = $userRepositoryMock;

        $userEntity = $userService
            ->updateUser(
                $userId,
                $newEmail,
                $newIsActive
            );

        $this->assertSame($userId, $userEntity->getUserId());
        $this->assertSame($newIsActive, $userEntity->getIsActive());
        $this->assertSame($newEmail, $userEntity->getEmail());
    }

    /**
     * @given a user to set inactive
     * @when the user is currently active
     * @then the user record is updated
     *
     * @return void
     */
    public function testSetUserActive(): void
    {
        $userId = 23498734;
        $isActive = false;

        $userRepositoryMock = $this
            ->getMockBuilder(UserRepository::class)
            ->onlyMethods(['updateData'])
            ->getMock();
        $userRepositoryMock
            ->expects($this->once())
            ->method('updateData')
            ->with($userId, ['is_active' => $isActive])
            ->willReturn(1);

        $userService = new UserService();
        $userService->userRepository = $userRepositoryMock;

        $isUpdated = $userService->setUserActive($userId, $isActive);

        $this->assertTrue($isUpdated);
    }

    /**
     * @given a user
     * @when deleting the user
     * @then the user is deleted
     *
     * @return void
     */
    public function testDeleteUser(): void
    {
        $userId = 84870;

        $userRepositoryMock = $this
            ->getMockBuilder(UserRepository::class)
            ->onlyMethods(['delete'])
            ->getMock();
        $userRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($userId)
            ->willReturn(1);

        $userService = new UserService();
        $userService->userRepository = $userRepositoryMock;

        $isDeleted = $userService->deleteUser($userId);

        $this->assertTrue($isDeleted);
    }
}
