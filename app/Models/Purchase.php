<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','supplier_id','qty','purchase_price','total','additional_costs',
        'receipt','diskon'
    ];

    public function getSupplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
