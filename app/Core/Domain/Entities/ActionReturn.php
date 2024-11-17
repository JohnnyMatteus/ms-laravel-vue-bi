<?php

namespace App\Core\Domain\Entities;

class ActionReturn
{
    public function __construct(
        public int $id,
        public int $investmentTypeId,
        public string $ticker,
        public string $name,
        public string $description,
        public int $returnPercentage,
        public string $date
    ) {}
}
