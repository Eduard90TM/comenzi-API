<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        // Permiteți numai utilizatorului autentificat să-și actualizeze propriul profil
        return Auth::check() && Auth::id() == $this->route('id');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            // Adăugați aici alte câmpuri pe care doriți să le validați și să le actualizați
        ];
    }
}
