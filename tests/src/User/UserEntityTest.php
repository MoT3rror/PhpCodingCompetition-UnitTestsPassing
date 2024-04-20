<?php

declare(strict_types=1);

namespace PhpCodeCompetition\Tdd\Tests\User;

use DateTimeImmutable;
use InvalidArgumentException;
use PhpCodeCompetition\Tdd\Architecture\Entity\EntityInterface;
use PhpCodeCompetition\Tdd\User\UserEntity;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    /**
     * @given a User Entity
     * @when instantiating the User Entity
     * @then the User Entity implements the Entity Interface
     *
     * @return void
     */
    public function testUserEntityImplementsEntityInterface(): void
    {
        $userEntity = new UserEntity();
        $this->assertInstanceOf(EntityInterface::class, $userEntity);
    }

    /**
     * @given an Entity of the wrong type
     * @when trying to hydrate the Entity
     * @then an exception is thrown
     *
     * @return void
     */
    public function testHydrateThrowsExceptionWhenEntityIsWrongType(): void
    {
        $data = [];
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

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Entity must be instance of ' . UserEntity::class);
        $this->expectExceptionCode(422);

        UserEntity::hydrate($data, $entity);
    }

    /**
     * @given empty data
     * @when hydrating a User Entity
     * @then default values are set
     *
     * @return void
     */
    public function testHydrateDefaultsValues(): void
    {
        $data = [];
        $entity = UserEntity::hydrate($data);

        $this->assertInstanceOf(UserEntity::class, $entity);
        $this->assertNull($entity->getUserId());
        $this->assertNull($entity->getUsername());
        $this->assertNull($entity->getPassword());
        $this->assertFalse($entity->getIsActive());
        $this->assertNull($entity->getEmail());
        $this->assertNull($entity->getUserCreatedDatetime());
    }

    /**
     * @given user data
     * @when setting up a User Entity
     * @then values are set on the User Entity
     *
     * @return void
     */
    public function testHydrateSetsValues(): void
    {
        $data = [
            'user_id' => 3452,
            'username' => 'unit_test_user',
            'password' => 'SuperSecretPassword',
            'is_active' => true,
            'email' => 'unittest@example.com',
            'user_created_datetime' => new DateTimeImmutable('2024-04-02 08:00:00'),
        ];

        $entity = UserEntity::hydrate($data);

        $this->assertSame($data['user_id'], $entity->getUserId());
        $this->assertSame($data['username'], $entity->getUsername());
        $this->assertSame($data['password'], $entity->getPassword());
        $this->assertSame($data['is_active'], $entity->getIsActive());
        $this->assertSame($data['email'], $entity->getEmail());
        $this->assertSame($data['user_created_datetime'], $entity->getUserCreatedDatetime());
    }

    /**
     * @given a non-negative user id
     * @when setting the non-negative user id on the User Entity
     * @then an exception is thrown
     *
     * @return void
     */
    public function testSetUserThrowsExceptionWhenNonNegativeValue(): void
    {
        $userId = -2;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('UserId must be a positive integer');
        $this->expectExceptionCode(422);

        $entity = new UserEntity();
        $entity->setUserId($userId);
    }

    /**
     * @given a username that is too long
     * @when setting the username on the User Entity
     * @then an exception is thrown
     *
     * @return void
     */
    public function testSetUsernameThrowsExceptionWhenTooLong(): void
    {
        $username = str_pad('UsernameTooLong', 121, '1');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Username must be at most 120 characters long');
        $this->expectExceptionCode(422);

        $entity = new UserEntity();
        $entity->setUsername($username);
    }

    /**
     * @given a password hash that is too long
     * @when setting the password hash on the User Entity
     * @then an exception is thrown
     *
     * @return void
     */
    public function testSetPasswordThrowsExceptionWhenTooLong(): void
    {
        $password = str_pad('PasswordHash', 257, '1');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password hash is too long');
        $this->expectExceptionCode(422);

        $entity = new UserEntity();
        $entity->setPassword($password);
    }

    /**
     * @given an invalid email
     * @when setting the email on the User Entity
     * @then an exception is thrown
     *
     * @return void
     *
     * @dataProvider dataProviderSetEmailThrowsExceptionWhenInvalidEmail
     */
    #[DataProvider('dataProviderSetEmailThrowsExceptionWhenInvalidEmail')]
    public function testSetEmailThrowsExceptionWhenInvalidEmail(
        string $invalidEmail
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email is not valid');
        $this->expectExceptionCode(422);

        $entity = new UserEntity();
        $entity->setEmail($invalidEmail);
    }

    public static function dataProviderSetEmailThrowsExceptionWhenInvalidEmail(): iterable
    {
        yield 'simple word' => ['unittest'];
        yield 'missing address' => ['@example.com'];
        yield 'missing domain' => ['unittest@'];
        yield 'missing ending' => ['unittest@example'];
        yield 'too long' => [str_pad('unittest', 325, 'a') . '@example.com'];
    }

    /**
     * @given a future created date
     * @when setting the future date on the User Entity
     * @then an exception is thrown
     *
     * @return void
     */
    public function testUserCreatedDatetimeThrowsExceptionWhenInTheFuture(): void
    {
        $futureDate = new DateTimeImmutable('+10 days');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User Created Datetime must not be in the future');
        $this->expectExceptionCode(422);

        $entity = new UserEntity();
        $entity->setUserCreatedDatetime($futureDate);
    }
}
