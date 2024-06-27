<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    // security
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_category = Category::all();

        return view('admin.product.index', compact('data_category'));
    }

    public function api()
    {
        $products = Product::with('category')->get();
        $datatables = datatables()->of($products)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_category = Category::all();

        return view('admin.product.create', compact('data_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'price_start' => 'required',
            'price_deal' => 'required',
            'netto' => 'required',
            'stock' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:7000', // Hanya menerima file gambar dengan ukuran maksimal 7MB
            'description' => 'required',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mendapatkan data input
        $data = $request->except('_token');

        // Upload file gambar
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'images'; // Ubah sesuai dengan lokasi folder yang diinginkan
            $file->move(public_path($path), $filename);
            $data['photo'] = $path . '/' . $filename;
        }

        // Simpan data ke database
        $product = Product::create($data);

        // Alert ketika berhasil upload
        if ($product) {
            return redirect()->route('products.index')->with('success', 'Produk berhasil diupload!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupload produk. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // id saat edit use here
        $product = Product::findOrFail($id);

        $data_category = Category::all();
        return view('admin.product.edit', compact('data_category', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'price_start' => 'required',
            'price_deal' => 'required',
            'netto' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:7000',
        ]);

        // Cek apakah pengguna ingin menghapus foto yang ada
        if ($request->has('delete_photo') && $request->delete_photo == '1') {
            if ($product->photo) {
                $imagePath = public_path($product->photo);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Hapus foto yang ada
                }
                $product->photo = null;
            }
        }

        // Simpan nama foto yang ada sebelumnya
        $existingPhoto = $product->photo;

        // Mengisi data produk dengan input yang diberikan
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->price_start = $request->input('price_start');
        $product->price_deal = $request->input('price_deal');
        $product->netto = $request->input('netto');
        $product->stock = $request->input('stock');
        $product->description = $request->input('description');

        // Upload foto baru jika ada
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Hapus foto yang ada sebelumnya
            if ($existingPhoto) {
                $imagePath = public_path($existingPhoto);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Upload foto baru
            $imageName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('images'), $imageName);
            $product->photo = 'images/' . $imageName;
        }

        // Simpan perubahan pada produk
        $product->save();

        // Jika tidak ada file foto baru diunggah dan tidak ada perubahan pada file foto, tetapkan kembali foto yang ada sebelumnya
        if (!$request->hasFile('photo') && !$request->has('delete_photo') && $existingPhoto) {
            $product->photo = $existingPhoto;
            $product->save();
        }

        return view('admin.product.index');
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Product $product)
    {
        // Hapus file foto dari direktori public/images/
        if (!empty($product->photo)) {
            $photoPath = public_path($product->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        // Hapus entitas produk
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
