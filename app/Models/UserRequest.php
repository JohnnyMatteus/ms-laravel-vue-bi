<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'endpoint', 'count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
