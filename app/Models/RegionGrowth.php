<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionGrowth extends Model
{
    use HasFactory;

    protected $fillable = ['investment_type_id', 'region', 'growth_percentage', 'description'];

    public function investmentType()
    {
        return $this->belongsTo(InvestmentType::class);
    }
}
