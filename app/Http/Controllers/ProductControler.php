<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
       $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imgPath = "";
        if($request->hasFile('image')) {
           $imgPath = $request->file('image')->store('images','public');
        }
        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'image_path' => $imgPath,
        ]);
        return response()->json($product, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
           $product = Product::findOrfail($id);
           return response()->json($product);
        }
        catch(\Exception $err){
            return response()->json([
                "message"=> $err
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $valedtedData = $request->validate([
            "name"=> "nullable|string|min:4|max:20",
            "price"=> "nullable|decimal:50,5000|numeric",
            "image"=> "nullable|image|mimes:png,jpg,gpeg,gif"
        ]);
        $product = product::findOrFail($id);
        $product->name = $validatedData["name"];
        $product->price = $valedtedData["price"];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
