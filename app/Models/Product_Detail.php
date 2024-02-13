<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Detail extends Model
{
    use HasFactory;


    // relasi product detail dan customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // relasi product detail dan categori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // relasi product detail dan product
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
