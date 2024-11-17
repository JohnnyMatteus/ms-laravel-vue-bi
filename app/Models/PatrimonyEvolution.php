<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrimonyEvolution extends Model
{
    use HasFactory;

    protected $fillable = ['investment_type_id', 'month', 'year', 'value', 'description'];

    public function investmentType()
    {
        return $this->belongsTo(InvestmentType::class);
    }
}
