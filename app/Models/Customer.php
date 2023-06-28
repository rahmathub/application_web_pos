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
}
