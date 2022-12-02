<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ResetPassword extends Model
{
    use HasFactory,Notifiable;

    protected $table = 'password_resets';
    
    public $updated_at = false;

    protected $fillable = [
        'email', 'token','created_at','deleted_at'
    ];
}
