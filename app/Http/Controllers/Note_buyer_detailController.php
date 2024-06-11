<?php

namespace App\Http\Controllers;

use App\Models\Note_buyer;
use App\Models\Product;
use App\Models\Note_buyer_detail;
use App\Models\Store;
use Illuminate\Http\Request;

class Note_buyer_detailController extends Controller
{
    public function apiWithProducts($note_buyer_id)
    {
        // Ambil data dari Note_buyer_detail berdasarkan note_buyer_id
        $noteBuyerDetails = Note_buyer_detail::where('note_buyer_id', $note_buyer_id)->get();

        // Ambil semua data produk
        $products = Product::all();

        // Gabungkan data note_buyer_details dan products dalam satu array
        $data = $noteBuyerDetails->map(function ($detail) use ($products) {
            $product = $products->firstWhere('id', $detail->product_id);
            return [
                'note_buyer_detail' => $detail,
                'product' => $product
            ];
        });

        // Kembalikan data sebagai respons JSON
        return response()->json(['data' => $data]);
    }
}
