<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // protected $fillable = ['name', 'email', 'phone_number', 'address'];


    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
