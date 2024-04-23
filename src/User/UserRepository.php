<?php
declare(strict_types=1);

namespace PhpCodingCompetition\Tdd\User;

use PhpCodingCompetition\Tdd\Db\Repository\RepositoryEntityAbstract;

class UserRepository implements RepositoryEntityAbstract
{
    public function insert(UserEntity $user): int
    {
        $user->setUserId(89543);
        return $user->getUserId();
    }

    public function update(UserEntity $user): int
    {
        return 1;
    }

    public function updateData(int $userId, array $data): int
    {
        return 1;
    }

    public function getById(int $userId): UserEntity
    {
        return new UserEntity;
    }

    public function delete(int $userId): int
    {
        return 1;
    }
}
