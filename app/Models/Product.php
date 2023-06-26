<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'price_start', 'price_deal', 'stock', 'photo', 'description'];

    public static function validateData(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'category_id' => 'required',
            'price_start' => 'required',
            'price_deal' => 'required',
            'stock' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'description' => 'required',
        ]);

        return $validator->validate();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
