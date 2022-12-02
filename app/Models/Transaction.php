<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id'
    ];


    public function getCustomer(){
        return $this->hasMany(Customer::class, 'customer_id', 'id');
    }

    public function getTransactionDetail(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'id');
    }
}
