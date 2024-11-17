<?php

namespace App\Domain\Entities;

class PatrimonyEvolution
{
    public function __construct(
        public int $id,
        public int $investmentTypeId,
        public string $period,
        public int $value
    ) {}
}
