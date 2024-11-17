<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function actionReturns()
    {
        return $this->hasMany(ActionReturn::class);
    }

    public function patrimonyEvolutions()
    {
        return $this->hasMany(PatrimonyEvolution::class);
    }

    public function assetDistributions()
    {
        return $this->hasMany(AssetDistribution::class);
    }

    public function sectorReturns()
    {
        return $this->hasMany(SectorReturn::class);
    }

    public function regionGrowths()
    {
        return $this->hasMany(RegionGrowth::class);
    }
}
