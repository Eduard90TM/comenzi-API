<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;

class UserController extends Controller
{
    public function updateProfile(UpdateProfileRequest  $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // Adăugați aici alte câmpuri pe care doriți să le validați și să le actualizați
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user->update($request->all());
        return response()->json($user);
    }
}
