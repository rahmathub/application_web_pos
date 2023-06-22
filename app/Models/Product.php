<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name_product', 'price', 'qty'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
