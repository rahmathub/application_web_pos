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

    protected $fillable = ['name', 'category_id', 'price_start', 'price_deal', 'netto', 'stock', 'photo', 'description'];

    public static function validateData(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'category_id' => 'required',
            'price_start' => 'required',
            'price_deal' => 'required',
            'netto' => 'required',
            'stock' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:7000',
            'description' => 'required',
        ]);

        return $validator->validate();
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // relasi product dan notebuyerDetail
    public function notebuyerDetails()
    {
        return $this->hasMany(Note_buyer_detail::class);
    }

    // relasi antara product dan product detail
    public function productDetails()
    {
        return $this->hasMany(Product_Detail::class);
    }
}
