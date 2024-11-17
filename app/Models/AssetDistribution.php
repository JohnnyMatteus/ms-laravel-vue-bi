<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDistribution extends Model
{
    use HasFactory;

    protected $fillable = ['investment_type_id', 'asset', 'percentage', 'description'];

    public function investmentType()
    {
        return $this->belongsTo(InvestmentType::class);
    }
}
