<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Constructor
{
    public function __construct(
        private string $uuid,
        private string $name,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
