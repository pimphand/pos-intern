<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image','name','size','stock','price','description','category_id'
    ];

    public function getCategory(){
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }

}
