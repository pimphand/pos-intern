<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Madjou extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeIsExpired($query)
    {
        return $query->where('expired_at', '<', now());
    }
}
