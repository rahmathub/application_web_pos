<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    use HasFactory;


    // Relasi antara costumer dan transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
