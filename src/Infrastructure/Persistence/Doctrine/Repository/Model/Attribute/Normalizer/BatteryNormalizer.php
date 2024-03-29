<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Normalizer;

use App\Domain\Model\Attribute\Battery;

class BatteryNormalizer extends BaseNormalizer
{
    public static function supports(): string
    {
        return Battery::NAME;
    }
}
