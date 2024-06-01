<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = ['name_store', 'number_phone', 'address_store', 'description'];


    // Relasi antara store dan note buyer
    public function noteBuyer()
    {
        return $this->hasMany(Note_buyer::class);
    }

}
