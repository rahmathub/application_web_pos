<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note_buyer_detail extends Model
{
    use HasFactory;

    protected $fillable = ['note_buyer_id', 'product_id'];

    // relasi note buyerdetail dan product
    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    // relasi note buyerdetail dan notebuyer
    public function noteBuyer()
    {
        return $this->belongsTo(Note_buyer::class);
    }
}
