<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        return view('products.products', ['sections' => sections::all(), 'products' => products::all()]);
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
        $request->validate([
            'product_name' => 'required',
            'section_id' => 'required|exists:sections,id',
            'description' => 'required'
        ], [
            'product_name.required' => 'يرجي اضافة اسم المنتج',
            'description.required' => 'يرجي اضافة اسم المنتج',
            "section_id.exists" => "القسم غير موجود"
        ]);
        products::create([
            'Product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, products $products)
    {
        $section_id = sections::where('section_name', $request->section_name)->first()->id;
        $product = products::findorFail($request->pro_id);
        $product->update([
            "Product_name" => $request->Product_name,
            "description" => $request->description,
            "section_id" => $section_id
        ]);
        session()->flash('Add', 'تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(products $products, Request $request)
    {
        $product = products::findorFail($request->pro_id);
        $product->delete();
        session()->flash('Add', 'تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
