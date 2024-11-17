<?php

namespace App\Core\Domain\Entities;

class SectorReturn
{
    public function __construct(
        public int $id,
        public int $investmentTypeId,
        public string $sector,
        public int $returnPercentage
    ) {}}
