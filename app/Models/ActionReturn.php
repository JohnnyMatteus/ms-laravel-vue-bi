<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionReturn extends Model
{
    use HasFactory;

    protected $fillable = ['action_code', 'name', 'description',
        'return_percentage', 'investment_type_id', 'date'];

    public function investmentType()
    {
        return $this->belongsTo(InvestmentType::class);
    }
}
