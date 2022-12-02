<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','stock','purchase_price','selling_price','margin','category_id'
    ];

    public function getCategory(){
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }
}
