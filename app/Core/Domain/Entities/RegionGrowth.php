<?php

namespace App\Core\Domain\Entities;

class RegionGrowth
{
    public function __construct(
        public int $id,
        public int $investmentTypeId,
        public string $region,
        public int $growthRate
    ) {}
}
