<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address'];


    // Relasi antara costumer dan transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // relasi antara customer dan product detail
    public function productDetails()
    {
        return $this->hasMany(Product_Detail::class);
    }
}
