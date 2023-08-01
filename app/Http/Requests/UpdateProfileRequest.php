<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        // Only allow the authenticated user to update their own profile
        return Auth::check() && Auth::id() == $this->route('id');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            // Add other fields you want to validate and update here
        ];
    }
}
