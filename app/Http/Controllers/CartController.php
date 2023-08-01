<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(AddToCartRequest  $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::create($request->all());
        return response()->json($cartItem, 201);
    }

    public function updateCartItem(UpdateCartItemRequestt $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::findOrFail($id);
        $cartItem->update($request->all());
        return response()->json($cartItem);
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();
        return response()->json(null, 204);
    }

    public function getUserCart($user_id)
    {
        $cartItems = Cart::where('user_id', $user_id)->get();
        return response()->json($cartItems);
    }
    
}
