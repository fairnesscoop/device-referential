<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\User;

interface UserRepositoryInterface
{
    public function findOneByEmail(string $email): ?User;

    public function findByUuid(string $uuid): User;

    public function add(User $user): User;

    public function findUsers(int $page, int $pageSize): array;
}
