<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as OriginalRole;

class Role extends OriginalRole
{
    use HasFactory;

    protected $guard_name = ['web'];

    protected $fillable =[
        "name", 
        "guard_name"
    ];

    
}
