<?php

declare(strict_types=1);

namespace App\Domain\Model\Repository;

use App\Domain\Model\CodeTac;
use App\Domain\Model\Model;

interface CodeTacRepositoryInterface
{
    public function add(CodeTac $codeTac): CodeTac;

    public function remove(int $codeTac): void;

    public function isCodeTacUsed(int $codeTac): bool;

    public function findCodeTacs(Model $model): iterable;
}
