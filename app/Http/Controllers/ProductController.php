<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // folosim o variabila pentru a avea referinta catre produsul nou creat
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->color = $request->color;
        $product->save();

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json('Not found!', 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json('Not found!', 404);
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->color = $request->color;
        $product->save();

        return response()->json($product, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json('Not found!', 404);
        }

        $product->delete();

        return response()->json('', 204);
    }
}