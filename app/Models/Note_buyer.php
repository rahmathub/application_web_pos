<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note_buyer extends Model
{
    use HasFactory;


    // relasi note buyer dan store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // relasi note buyer dan product
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
