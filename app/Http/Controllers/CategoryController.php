<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rahmat = 'template engine';
        return view('admin.category.index', compact('rahmat'));
    }


    public function api()
    {
        $category = Category::all();
        $datatables = datatables()->of($category)->addIndexColumn();
    
        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:25'],
            'description' => ['required', 'string', 'max:50'],
        ]);
        Category::create($request->all());

        return response()->json(['message' => 'Category Create successfully'], 200);
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category )
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:25'],
            'description' => ['required', 'string', 'max:50'],
        ]);

        $category->update($request->all());

        return response()->json(['message' => 'Category update successfully'], 200);
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
