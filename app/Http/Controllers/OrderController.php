<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  
     */
    public function index()
 

        $orders = Order::all();


        return response()->json($orders);

    }

    public function store(Request $request)
    {
       
        $order = new Order();
        
        $order->user_id = 1; 
        $order->total_value = $request->total_value;
        
        $order->total_weight = $request->total_weight;
        $order->payment_method = $request->payment_method;

        $order->save(); 
        return response()->json($order, 201);
    }


    public function show(string $id)
 
        $order = Order::find($id); 
        if (!$order) {
            return response()->json('Not Found', 404);
        }


        return response()->json($order, 200);

    }

   
    public function update(Request $request, string $id)
  
    {

        $order = Order::find($id); 

        if (!$order) {
            return response()->json('Not found', 404);
        }

        $order->total_value = $request->total_value;
        $order->total_weight = $request->total_weight;
        $order->payment_method = $request->payment_method;

    
        $order->save();

      

        return response()->json($order, 200);
    }

    public function destroy(string $id)


        $order = Order::find($id);

   

        if (!$order) {
      
            return response()->json('Not found', 404);
        }

   

        $order->delete();
  

        return response()->json('', 204);
      
    }
}