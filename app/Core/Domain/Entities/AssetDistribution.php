<?php

namespace App\Core\Domain\Entities;

class AssetDistribution
{
    public function __construct(
        public int $id,
        public int $investmentTypeId,
        public string $category,
        public int $percentage,
        public ?int $actionReturnId,
        public string $details
    ) {}
}
